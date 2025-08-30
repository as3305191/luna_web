<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Luna_mall extends MY_Base_Controller {

  /* --------- 可調參數 --------- */
  private const MAX_QTY_PER_ITEM = 99;          // 單品一次最多買幾個
  private const MUTEX_COOLDOWN_SEC = 5;         // 連點/重送最短間隔
  private const SHOP_BAG_POSITION = 320;        // 商城包包固定位置
  private const BATCH_INSERT_SIZE = 500;        // 批次插入 chunk size

  /* --------- 檔案路徑 --------- */
  private $excel_file;        // item_shop.xlsx（前端展示/定價）
  private $excel_itemlistcn;  // itemlistcn.xlsx（正表，封印/堆疊/時效/分類）

  function __construct() {
    parent::__construct();
    $this->load->driver('cache', ['adapter' => 'apc', 'backup' => 'file']);
    $this->excel_file       = FCPATH . 'assets/luna/item_shop.xlsx';
    $this->excel_itemlistcn = FCPATH . 'assets/luna/itemlistcn.xlsx';

    $this->load->model('/luna/Members_dao', 'dao');
    $this->load->model('/luna/Shop_log_dao', 'shop_log_dao');
    $this->load->model('/luna/Item_dao', 'item_dao');
    $this->load->model('/luna/CHARACTER_dao', 'charDao');
    $this->load->model('/luna/Item_log_dao', 'item_log_dao');
    $this->load->model('/luna/mall_point_log_dao', 'mall_point_dao');
  }

  /* ========================== Page ========================== */

  public function index() {
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login"); return;
    }

    $s_data     = $this->setup_user_data([]);
    $login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');

    $data = [];
    $data['login_user'] = $login_user;
    $data['userlv']     = $login_user ? ($login_user->UserLevel ?? 0) : 0;
    $data['now']        = 'luna_mall';
    $data['checkout_nonce'] = $this->rotate_checkout_nonce();

    list($sheetNames, $itemsMap) = $this->read_all_sheets_dynamic();
    $allTitle  = '全部商品(All)';
    $filtered  = array_values(array_filter($sheetNames, fn($n) => $n !== $allTitle));
    $all = [];
    foreach ($filtered as $nm) if (!empty($itemsMap[$nm])) $all = array_merge($all, $itemsMap[$nm]);
    $tabs = $filtered;
    array_unshift($tabs, $allTitle);
    $itemsMap[$allTitle] = $all;

    // 用 session-salt 做展示端簽章（防改價）；實際結帳仍以伺服器價錢為準
    $salt = $this->get_item_salt();
    foreach ($itemsMap as &$arr) {
      foreach ($arr as &$it) {
        $it['sig'] = $this->sign_item((string)$it['id'], (int)$it['price'], $salt);
      }
    }

    // 結帳一次性 nonce（防重送/亂 POST）
    $data['checkout_nonce'] = $this->rotate_checkout_nonce();

    $data['tabs']      = $tabs;
    $data['itemsMap']  = $itemsMap;
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();

    $this->load->view('luna/luna_mall', $data);
  }

  /* ========================== JSON Helpers ========================== */

  private function json_ok(array $extra = []) {
    $payload = array_merge(['ok'=>true], $extra, [
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
      'checkout_nonce' => $this->get_checkout_nonce(), // 回傳最新 nonce，前端下次要用
    ]);
    return $this->output->set_content_type('application/json')
      ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE));
  }
  private function json_fail(string $msg, int $status = 200) {
    $payload = [
      'ok' => false,
      'msg'=> $msg,
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
      'checkout_nonce' => $this->get_checkout_nonce(),
    ];
    $this->output->set_status_header($status);
    return $this->output->set_content_type('application/json')
      ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE));
  }

  /* ========================== 安全工具 ========================== */

  private function get_item_salt(): string {
    $salt = $this->session->userdata('item_salt');
    if (empty($salt)) {
      $salt = bin2hex(random_bytes(16));
      $this->session->set_userdata('item_salt', $salt);
    }
    return $salt;
  }
  private function sign_item(string $id, int $price, string $salt): string {
    return hash_hmac('sha256', $id.'|'.$price, $salt);
  }

  // CSRF 驗證（支援表單欄位與 X-CSRF-Token 標頭）
  private function require_csrf_or_fail(): bool {
    $tokenName = $this->security->get_csrf_token_name();
    $tokenPost = $this->input->post($tokenName, true);
    $tokenHead = $this->input->get_request_header('X-CSRF-Token', true);
    $validHash = $this->security->get_csrf_hash();
    if ($tokenPost && hash_equals($validHash, $tokenPost)) return true;
    if ($tokenHead && hash_equals($validHash, $tokenHead)) return true;
    $this->json_fail('CSRF 驗證失敗', 403);
    return false;
  }

  // 會話級 Nonce（每次 index() 會 rotate 一次；checkout 必帶，且用後會再 rotate）
  private function get_checkout_nonce(): string {
    $n = $this->session->userdata('checkout_nonce');
    if (empty($n)) $n = $this->rotate_checkout_nonce();
    return $n;
  }
  private function rotate_checkout_nonce(): string {
    $n = bin2hex(random_bytes(16));
    $this->session->set_userdata('checkout_nonce', $n);
    return $n;
  }

  // 互斥鎖（避免連點/延遲重送）
  private function acquire_checkout_mutex(): bool {
    $now = time();
    $last = (int)($this->session->userdata('checkout_lock_ts') ?? 0);
    if ($now - $last < self::MUTEX_COOLDOWN_SEC) return false;
    $this->session->set_userdata('checkout_lock_ts', $now);
    return true;
  }
  private function release_checkout_mutex(): void {
    // 保留 timestamp 即可達到冷卻效果
  }

  /* ========================== Excel Readers ========================== */

  /** item_shop.xlsx：只讀取展示必需欄（id/name/price/name_en） */
  private function read_all_sheets_dynamic(): array {
    $sheetNames = []; $itemsMap = [];
    if (!file_exists($this->excel_file)) return [$sheetNames, $itemsMap];

    $xlsx = IOFactory::load($this->excel_file);
    $sheetNames = $xlsx->getSheetNames();

    $COL_ItemIdx  = 1; // A
    $COL_ItemName = 2; // B
    $COL_Price    = 3; // C
    $COL_NameEN   = 4; // D

    foreach ($sheetNames as $sheetName) {
      $sheet = $xlsx->getSheetByName($sheetName);
      if (!$sheet) continue;

      $highestRow = $sheet->getHighestRow();

      // 自動找第一筆資料列（A/B 有字且 C 是數字）
      $startRow = 1;
      for ($r = 1; $r <= $highestRow; $r++) {
        $a = trim((string)$sheet->getCellByColumnAndRow($COL_ItemIdx,  $r)->getValue());
        $b = trim((string)$sheet->getCellByColumnAndRow($COL_ItemName, $r)->getValue());
        $c = $sheet->getCellByColumnAndRow($COL_Price,   $r)->getValue();
        if ($a !== '' && $b !== '' && is_numeric($c)) { $startRow = $r; break; }
      }

      $items = [];
      for ($r = $startRow; $r <= $highestRow; $r++) {
        $id      = trim((string)$sheet->getCellByColumnAndRow($COL_ItemIdx,  $r)->getValue());
        $name    = trim((string)$sheet->getCellByColumnAndRow($COL_ItemName, $r)->getValue());
        $cval    = $sheet->getCellByColumnAndRow($COL_Price,   $r)->getValue();
        $name_en = trim((string)$sheet->getCellByColumnAndRow($COL_NameEN,   $r)->getValue());
        if ($id==='' || $name==='' || !is_numeric($cval)) continue;
        $price = (int)$cval;
        $items[] = ['id'=>$id, 'name'=>$name, 'price'=>$price, 'name_en'=>$name_en];
      }
      $itemsMap[$sheetName] = $items;
    }
    return [$sheetNames, $itemsMap];
  }

  /** 將 item_shop.xlsx 全併為一張（只帶展示/價格），用 mtime 做快取版本 */
  private function load_all_items(): array {
    $ver = (string)@filemtime($this->excel_file) ?: '0';
    $cacheKey = 'mall_items_all_' . $ver;
    if ($data = $this->cache->get($cacheKey)) return $data;

    list($sheetNames, $itemsMap) = $this->read_all_sheets_dynamic();
    $all = [];
    foreach ($sheetNames as $sheet) {
      foreach ($itemsMap[$sheet] ?? [] as $it) {
        $all[] = [
          'product_code' => (string)$it['id'],
          'name'         => (string)$it['name'],
          'price'        => (int)$it['price'],
          'sellstatus'   => (int)$it['price'],
          'name_en'      => (string)($it['name_en'] ?? ''),
        ];
      }
    }
    $data = ['items' => $all];
    $this->cache->save($cacheKey, $data, 0); // 文件 mtime 改變即可自然失效
    return $data;
  }

  /** itemlistcn.xlsx（無表頭，第一列就是資料）— 以 ItemIdx 為 key 取正表，mtime 快取 */
  private function load_cn_catalog(): array {
    if (!file_exists($this->excel_itemlistcn)) return [];

    $ver = (string)@filemtime($this->excel_itemlistcn) ?: '0';
    $cacheKey = 'mall_cn_catalog_' . $ver;
    if ($map = $this->cache->get($cacheKey)) return $map;

    $xlsx = IOFactory::load($this->excel_itemlistcn);
    $sheet = $xlsx->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    $COL_ItemIdx      = 1;   // A
    $COL_ItemName     = 2;   // B
    $COL_Stack        = 13;  // M
    $COL_Time         = 20;  // T
    $COL_wSeal        = 57;  // BE
    $COL_dwType       = 64;  // BL
    $COL_dwTypeDetail = 65;  // BM

    $map = [];
    for ($r = 1; $r <= $highestRow; $r++) {
      $id   = trim((string)$sheet->getCellByColumnAndRow($COL_ItemIdx,  $r)->getValue());
      $name = trim((string)$sheet->getCellByColumnAndRow($COL_ItemName, $r)->getValue());
      if ($id === '' && $name === '') continue;

      $stack = (int)($sheet->getCellByColumnAndRow($COL_Stack,        $r)->getValue() ?: 0);
      $time  = (int)($sheet->getCellByColumnAndRow($COL_Time,         $r)->getValue() ?: 0);
      $seal  = (int)($sheet->getCellByColumnAndRow($COL_wSeal,        $r)->getValue() ?: 0);
      $cate  = (int)($sheet->getCellByColumnAndRow($COL_dwType,       $r)->getValue() ?: 0);
      $cdtl  = (int)($sheet->getCellByColumnAndRow($COL_dwTypeDetail, $r)->getValue() ?: 0);

      $map[$id] = [
        'name'            => $name,
        'max_stack'       => max(0, $stack),
        'time_sec'        => $time,   // -1/0=永久；>0=秒數
        'wSeal'           => $seal,
        'category_code'   => $cate,
        'category_detail' => $cdtl,
      ];
    }

    $this->cache->save($cacheKey, $map, 0);
    return $map;
  }

  /* ========================== Checkout ========================== */

  public function checkout() {
    if (!$this->require_csrf_or_fail()) return;
    $this->output->set_content_type('application/json');

    if (empty($this->session->userdata('user_id'))) {
      return $this->json_fail('尚未登入');
    }
    if (!$this->acquire_checkout_mutex()) {
      return $this->json_fail('操作過於頻繁，請稍後重試');
    }

    // 讀 cart + nonce（支援 form 與 raw JSON）
    $raw   = $this->input->post('cart', false);
    $nonce = (string)$this->input->post('nonce', true);
    if ($raw === null || $raw === '') {
      $body = $this->input->raw_input_stream;
      if ($body) {
        $asObj = json_decode($body, true);
        if (isset($asObj['cart']))  $raw   = is_string($asObj['cart'])  ? $asObj['cart']  : json_encode($asObj['cart']);
        if (isset($asObj['nonce'])) $nonce = (string)$asObj['nonce'];
      }
    }
    if ($nonce === '' || !hash_equals($this->get_checkout_nonce(), $nonce)) {
      $this->release_checkout_mutex();
      return $this->json_fail('安全驗證失敗（nonce）', 403);
    }
    // 用過就旋轉，避免重送
    $this->rotate_checkout_nonce();

    $cart = json_decode($raw, true);
    if (!is_array($cart) || empty($cart)) {
      $this->release_checkout_mutex();
      return $this->json_fail('購物車是空的');
    }

    // 使用者
    $s_data     = $this->setup_user_data([]);
    $login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');
    if (!$login_user) { $this->release_checkout_mutex(); return $this->json_fail('找不到帳號'); }

    $user_idx = (int)$login_user->id_idx;
    $login_id = (string)$login_user->id_loginid;

    // 讀商城清單（價格以這裡為準）
    $pack = $this->load_all_items();
    $itemMap = [];
    foreach ($pack['items'] as $it) $itemMap[(string)$it['product_code']] = $it;

    // 驗簽（防過期/改價），同時合併同品項
    $salt   = $this->get_item_salt();
    $merged = [];
    foreach ($cart as $row) {
      $id  = (string)($row['id']  ?? '');
      $qty = (int)   ($row['qty'] ?? 0);
      $sig = (string)($row['sig'] ?? '');
      if ($id === '' || $qty <= 0) { $this->release_checkout_mutex(); return $this->json_fail('購物車有不合法的商品/數量'); }
      if (!isset($itemMap[$id]))   { $this->release_checkout_mutex(); return $this->json_fail("找不到商品：{$id}"); }
      if ($qty > self::MAX_QTY_PER_ITEM) $qty = self::MAX_QTY_PER_ITEM;

      $price_now = (int)$itemMap[$id]['sellstatus'];
      $server_sig = $this->sign_item($id, $price_now, $salt);
      if (!hash_equals($server_sig, $sig)) {
        $this->release_checkout_mutex();
        return $this->json_fail("商品資訊已更新或驗證失敗，請刷新後再購買（{$id}）");
      }
      $merged[$id] = ($merged[$id] ?? 0) + $qty;
    }

    // 計價（完全用伺服器價）
    $total = 0;
    foreach ($merged as $id => $qty) {
      $price = (int)($itemMap[$id]['sellstatus'] ?? 0);
      if ($price <= 0) { $this->release_checkout_mutex(); return $this->json_fail("商品 {$id} 不可販售"); }
      $total += $price * $qty;
    }
    if ($total <= 0) { $this->release_checkout_mutex(); return $this->json_fail('金額計算錯誤'); }

    // 取角色（承接商城包包）
    $list = $this->charDao->list_by_user($user_idx, false);
    if (empty($list)) { $this->release_checkout_mutex(); return $this->json_fail('帳號底下沒有角色'); }
    $charIdx = (int)$list[0]->CharId;

    // 讀正表（封印/堆疊/時效）
    $cnMeta = $this->load_cn_catalog();

    $now = date('Y-m-d H:i:s');
    $ip  = $this->input->ip_address();
    $order_no = bin2hex(random_bytes(8)); // 唯一單號；memo 會帶上

    $progress = [];
    $progress[] = 'verify'; // 前置驗證/定價完成

    // 交易開始（降低隔離級別以減少鎖競爭；SNAPSHOT 可用就用，否則退回 REPEATABLE READ）
    $this->db->trans_begin();
    try {
      try {
        $this->db->query("SET TRANSACTION ISOLATION LEVEL SNAPSHOT");
      } catch (\Throwable $e) {
        $this->db->query("SET TRANSACTION ISOLATION LEVEL REPEATABLE READ");
      }

      // 扣點（用 OUTPUT 直接拿新餘額，省一次 SELECT）
      $row = $this->db->query("
        UPDATE dbo.chr_log_info
          SET mall_point = mall_point - ?
        OUTPUT inserted.mall_point AS after_point
        WHERE id_idx = ? AND mall_point >= ?
      ", [$total, $user_idx, $total])->row_array();

      if (!$row || !isset($row['after_point'])) {
        throw new \RuntimeException('點數不足或扣點失敗');
      }

      $after  = (int)$row['after_point'];
      $before = $after + $total;
      $progress[] = 'point';

      // 點數異動 log（memo 帶單號，方便稽核）
      $ok = $this->db->query("
        INSERT INTO LUNA_LOGDB_2025.dbo.mall_point_log
          (user_idx, amount, before_point, after_point, memo, admin_loginid, admin_ip, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
      ", [$user_idx, -$total, $before, $after, '線上購物#'.$order_no, $login_id, $ip, $now]);
      if ($ok === FALSE) throw new \RuntimeException('建立 mall_point_log 失敗');

      $mpl_id = (int)$this->db->insert_id();
      if ($mpl_id <= 0) {
        $rowId = $this->db->query("SELECT CAST(SCOPE_IDENTITY() AS INT) AS id")->row();
        $mpl_id = $rowId ? (int)$rowId->id : 0;
      }
      if ($mpl_id <= 0) throw new \RuntimeException('取得 mall_point_log.id 失敗');

      // 準備批次插入物品 rows
      $itemRows = [];
      foreach ($merged as $id => $qty) {
        $meta  = $cnMeta[$id] ?? null;    // 正表
        if (!$meta) throw new \RuntimeException("正表缺少商品資料：{$id}");

        $itemIdx   = (int)$id;
        $item_seal = (int)($meta['wSeal'] ?? 0);
        $max_stack = (int)($meta['max_stack'] ?? 0);
        $time_sec  = (int)($meta['time_sec'] ?? 0); // -1/0=永久；>0=秒

        // 後台 shop-web log（可保持）
        $this->db->query("
          INSERT INTO LUNA_LOGDB_2025.dbo.TB_ITEM_SHOPWEB_LOG
            (TYPE, USER_IDX, USER_ID, ITEM_IDX, ITEM_DBIDX, SIZE, DATE)
          VALUES (1, ?, ?, ?, ?, ?, ?)
        ", [$user_idx, $login_id, $itemIdx, $itemIdx, $qty, $now]);

        $remain = $qty;
        if ($max_stack > 0) {
          while ($remain > 0) {
            $stackSize = ($remain >= $max_stack) ? $max_stack : $remain;
            $row = [
              'CHARACTER_IDX'   => $charIdx,
              'ITEM_IDX'        => $itemIdx,
              'ITEM_SHOPIDX'    => $user_idx,
              'ITEM_SHOPLOGIDX' => $mpl_id,
              'mall_log_id'     => $mpl_id,
              'ITEM_SEAL'       => $item_seal,
              'ITEM_DURABILITY' => $stackSize,                // 疊加數
              'ITEM_POSITION'   => self::SHOP_BAG_POSITION,   // 固定 320
            ];
            if ($time_sec > 0) {
              $row['ITEM_LIMITTIME_SEC'] = $time_sec;
              $row['ITEM_EXPIRETIME']    = date('Y-m-d H:i:s', time() + $time_sec);
            }
            $itemRows[] = $row;
            $remain -= $stackSize;
          }
        } else {
          for ($i=0; $i<$remain; $i++) {
            $row = [
              'CHARACTER_IDX'   => $charIdx,
              'ITEM_IDX'        => $itemIdx,
              'ITEM_SHOPIDX'    => $user_idx,
              'ITEM_SHOPLOGIDX' => $mpl_id,
              'mall_log_id'     => $mpl_id,
              'ITEM_SEAL'       => $item_seal,
              'ITEM_DURABILITY' => 0,
              'ITEM_POSITION'   => self::SHOP_BAG_POSITION,
            ];
            if ($time_sec > 0) {
              $row['ITEM_LIMITTIME_SEC'] = $time_sec;
              $row['ITEM_EXPIRETIME']    = date('Y-m-d H:i:s', time() + $time_sec);
            }
            $itemRows[] = $row;
          }
        }
      }

      // 批次寫入（若 DAO 有 insert_batch 就用，否則逐筆）
      if (!empty($itemRows)) {
        if (method_exists($this->item_dao, 'insert_batch')) {
          foreach (array_chunk($itemRows, self::BATCH_INSERT_SIZE) as $chunk) {
            $this->item_dao->insert_batch($chunk);
          }
        } else {
          foreach ($itemRows as $r) { $this->item_dao->insert_item($r); }
        }
      }

      $progress[] = 'item';

      $this->db->trans_commit();

      // 回傳
      $respItems = [];
      foreach ($merged as $id => $qty) {
        $respItems[] = [
          'id'    => $id,
          'qty'   => $qty,
          'price' => (int)$itemMap[$id]['sellstatus'],
        ];
      }

      $progress[] = 'done';

      $this->release_checkout_mutex();
      return $this->json_ok([
        'msg'      => '購買成功',
        'before'   => $before,
        'after'    => $after,
        'total'    => $total,
        'items'    => $respItems,
        'order_no' => $order_no,
        'progress' => $progress,
      ]);

    } catch (\Throwable $e) {
      $this->db->trans_rollback();
      $this->release_checkout_mutex();
      log_message('error', 'Checkout失敗: '.$e->getMessage());
      return $this->json_fail('交易失敗，請稍後再試');
    }
  }
}
