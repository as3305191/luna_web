<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Luna_mall extends MY_Base_Controller {

  /* --------- 可調參數 --------- */
  private const MAX_QTY_PER_ITEM = 99;          // 單品一次最多買幾個
  private const MUTEX_COOLDOWN_SEC = 5;         // 連點/重送最短間隔(秒)
  private const SHOP_BAG_POSITION = 320;        // 商城包包固定位置
  private const BATCH_SIZE = 500;               // 批次寫入 TB_ITEM 的筆數

  /* --------- 檔案路徑 --------- */
  private $excel_file;        // item_shop.xlsx（前端展示/定價）
  private $excel_itemlistcn;  // itemlistcn.xlsx（正表：封印/堆疊/時效/分類）
  private $cache_file_meta;   // itemlistcn 快取檔（固定欄位讀法）

  function __construct() {
    parent::__construct();
    $this->load->driver('cache', ['adapter' => 'apc', 'backup' => 'file']);
    $this->excel_file       = FCPATH . 'assets/luna/item_shop.xlsx';
    $this->excel_itemlistcn = FCPATH . 'assets/luna/itemlistcn.xlsx';
    $this->cache_file_meta  = FCPATH . 'assets/luna/itemlistcn_cache.json';

    $this->load->model('/luna/Members_dao',        'dao');
    $this->load->model('/luna/Shop_log_dao',       'shop_log_dao');
    $this->load->model('/luna/Item_dao',           'item_dao');
    $this->load->model('/luna/CHARACTER_dao',      'charDao');
    $this->load->model('/luna/Item_log_dao',       'item_log_dao');
    $this->load->model('/luna/mall_point_log_dao', 'mall_point_dao');
  }

  /* ========================== Page ========================== */

  public function index() {
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login"); return;
    }

    // ★ 先確保 CSRF cookie 已種（僅當尚未存在時，不會每次輪替）
    $pair = $this->ensure_csrf();

    $s_data     = $this->setup_user_data([]);
    $login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');

    $data = [];
    $data['login_user']     = $login_user;
    $data['userlv']         = $login_user ? ($login_user->UserLevel ?? 0) : 0;
    $data['now']            = 'luna_mall';
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

    $data['tabs']      = $tabs;
    $data['itemsMap']  = $itemsMap;
    $data['csrf_name'] = $pair['csrf_name'];
    $data['csrf_hash'] = $pair['csrf_hash'];

    $this->load->view('luna/luna_mall', $data);
  }

  private function ensure_csrf() {
    $cookieName = $this->config->item('csrf_cookie_name') ?: 'ci_csrf_token';
    $hash = $this->security->get_csrf_hash();
    if (!$this->input->cookie($cookieName, true)) {
      $expire = (int)$this->config->item('csrf_expire');
      if ($expire <= 0) $expire = 7200;
      $this->input->set_cookie([
        'name'     => $cookieName,
        'value'    => $hash,
        'expire'   => $expire,
        'secure'   => (bool)$this->config->item('cookie_secure'),
        'httponly' => false,
        'path'     => $this->config->item('cookie_path') ?: '/',
        'domain'   => $this->config->item('cookie_domain') ?: '',
        'prefix'   => $this->config->item('cookie_prefix') ?: '',
        'samesite' => $this->config->item('cookie_samesite') ?: 'Lax',
      ]);
    }
    return [
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
    ];
  }

  /* ========================== JSON Helpers ========================== */

  private function json_ok(array $extra = []) {
    $payload = array_merge(['ok'=>true], $extra, [
      'csrf_name'      => $this->security->get_csrf_token_name(),
      'csrf_hash'      => $this->security->get_csrf_hash(),
      'checkout_nonce' => $this->get_checkout_nonce(),
    ]);
    return $this->output->set_content_type('application/json')
      ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE));
  }
  private function json_fail(string $msg, int $status = 200, array $extra = []) {
    $payload = array_merge([
      'ok'             => false,
      'msg'            => $msg,
      'csrf_name'      => $this->security->get_csrf_token_name(),
      'csrf_hash'      => $this->security->get_csrf_hash(),
      'checkout_nonce' => $this->get_checkout_nonce(),
    ], $extra);
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
  private function acquire_checkout_mutex(): bool {
    $now  = time();
    $last = (int)($this->session->userdata('checkout_lock_ts') ?? 0);
    if ($now - $last < self::MUTEX_COOLDOWN_SEC) return false;
    $this->session->set_userdata('checkout_lock_ts', $now);
    return true;
  }
  private function release_checkout_mutex(): void {
    // keep ts
  }

  /** 取一次 JSON body（若 Content-Type=application/json），避免重複 decode */
  private function get_json_body(): ?array {
    static $cached = null;
    if ($cached !== null) return $cached;
    $raw = trim($this->input->raw_input_stream ?? '');
    if ($raw === '') { $cached = null; return null; }
    $jb = json_decode($raw, true);
    $cached = is_array($jb) ? $jb : null;
    return $cached;
  }

  /** 從 POST / Header / JSON 取 nonce：支援 nonce/checkout_nonce 與 X-Checkout-Nonce */
  private function read_nonce_from_request(): ?string {
    $n = $this->input->post('nonce', true);
    if (!$n) $n = $this->input->post('checkout_nonce', true);
    if (!$n) $n = $this->input->get_request_header('X-Checkout-Nonce', true);
    if (!$n) {
      $jb = $this->get_json_body();
      if (is_array($jb)) $n = $jb['nonce'] ?? $jb['checkout_nonce'] ?? null;
    }
    return is_string($n) ? trim($n) : null;
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
    $this->cache->save($cacheKey, $data, 0);
    return $data;
  }

  // 以 Excel 價格為準（從 item_shop.xlsx）
  private function get_sku_prices(array $itemIds): array {
    if (empty($itemIds)) return [];
    $itemIds = array_values(array_unique(array_map('strval', $itemIds)));
    if (empty($itemIds)) return [];

    $pack = $this->load_all_items();
    $map = [];
    foreach ($pack['items'] as $it) {
      $idStr = (string)($it['product_code'] ?? '');
      if ($idStr === '') continue;
      $price = (int)($it['price'] ?? 0);
      if (in_array($idStr, $itemIds, true)) {
        $map[(int)$idStr] = max(0, $price);
      }
    }
    return $map; // key:int item_idx => price:int
  }

  /** 用「固定欄位讀法」讀 itemlistcn.xlsx：回傳道具 meta（含 wSeal / max_stack 等） */
  private function load_itemlistcn_meta(): array {
    if (!file_exists($this->excel_itemlistcn)) return ['items' => [], 'mtime' => 0];

    $xlsx_mtime = filemtime($this->excel_itemlistcn);
    $CACHE_VER = 8; // 升版本讓舊快取失效

    if (file_exists($this->cache_file_meta)) {
      $cache = json_decode(@file_get_contents($this->cache_file_meta), true);
      if (is_array($cache)
        && intval($cache['mtime']) === $xlsx_mtime
        && intval($cache['ver']) === $CACHE_VER) {
        return ['items' => $cache['items'] ?? [], 'mtime' => $xlsx_mtime];
      }
    }

    $reader = IOFactory::createReaderForFile($this->excel_itemlistcn);
    $reader->setReadDataOnly(true);
    $sheet = $reader->load($this->excel_itemlistcn)->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    // 固定欄位對照（A=1, B=2, …）
    $COL_ItemIdx        = 1;   // A
    $COL_ItemName       = 2;   // B
    $COL_Stack          = 13;  // M  ← 也拿來當 ITEM_DURABILITY
    $COL_Time           = 20;  // T
    $COL_wSeal          = 57;  // BE ← 封印
    $COL_dwType         = 64;  // BL
    $COL_dwTypeDetail   = 65;  // BM

    $items = [];
    for ($r = 1; $r <= $highestRow; $r++) {
      $code = trim((string)$sheet->getCellByColumnAndRow($COL_ItemIdx,  $r)->getValue());
      $name = trim((string)$sheet->getCellByColumnAndRow($COL_ItemName, $r)->getValue());
      if ($code === '' && $name === '') continue;

      $stack = (int)$sheet->getCellByColumnAndRow($COL_Stack, $r)->getValue();
      $time  = (int)$sheet->getCellByColumnAndRow($COL_Time,  $r)->getValue();
      $seal  = (int)$sheet->getCellByColumnAndRow($COL_wSeal, $r)->getValue();
      $cate  = (int)$sheet->getCellByColumnAndRow($COL_dwType, $r)->getValue();
      $cateDetail = (int)$sheet->getCellByColumnAndRow($COL_dwTypeDetail, $r)->getValue();

      $items[] = [
        'product_code'    => $code,
        'name'            => $name,
        'max_stack'       => max(0, $stack),
        'endtime'         => ($time > 0 ? $time : null),
        'wSeal'           => $seal,
        'category_code'   => $cate,
        'category_detail' => $cateDetail,
      ];
    }

    @file_put_contents($this->cache_file_meta, json_encode([
      'ver'   => $CACHE_VER,
      'mtime' => $xlsx_mtime,
      'items' => $items
    ], JSON_UNESCAPED_UNICODE));

    return ['items' => $items, 'mtime' => $xlsx_mtime];
  }

  /** 依 itemlistcn.xlsx mtime 快取 seal/dur 對照表（APC/File cache） */
  private function get_meta_maps_cached(): array {
    $meta = $this->load_itemlistcn_meta(); // ['items'=>[], 'mtime'=>...]
    $mtime = (int)($meta['mtime'] ?? 0);
    $ckey  = 'mall_meta_maps_' . $mtime;

    $maps = $this->cache->get($ckey);
    if (is_array($maps) && isset($maps['sealMap'], $maps['durMap'])) {
      return [$maps['sealMap'], $maps['durMap']];
    }

    $sealMap = []; // item_idx => wSeal
    $durMap  = []; // item_idx => max_stack → ITEM_DURABILITY
    foreach (($meta['items'] ?? []) as $it) {
      $pid = (int)($it['product_code'] ?? 0);
      if ($pid <= 0) continue;
      $sealMap[$pid] = (int)($it['wSeal'] ?? 0);
      $durMap[$pid]  = (int)($it['max_stack'] ?? 0);
    }

    $this->cache->save($ckey, ['sealMap'=>$sealMap, 'durMap'=>$durMap], 0);
    return [$sealMap, $durMap];
  }



  /* ========================== Checkout ========================== */

  public function checkout(){
    $this->output->set_content_type('application/json');

    // 1) 登入
    if (empty($this->session->userdata('user_id')) && empty($this->session->userdata('login_user_id'))) {
      $this->ensure_csrf();
      return $this->json_fail('not login', 401);
    }

    // 2) 確保 CSRF cookie 已存在（僅當不存在時才種）
    $this->ensure_csrf();

    // 3) CSRF 驗證（支援 form field / header / raw JSON）
    $tokenName = $this->security->get_csrf_token_name();
    $validHash = $this->security->get_csrf_hash();

    $tokenPost = $this->input->post($tokenName, false);
    $tokenHead = $this->input->get_request_header('X-CSRF-Token', true);

    $csrf_ok = false;
    if ($tokenPost && hash_equals($validHash, $tokenPost)) $csrf_ok = true;
    if ($tokenHead && hash_equals($validHash, $tokenHead)) $csrf_ok = true;

    if (!$csrf_ok) {
      $raw = trim($this->input->raw_input_stream ?? '');
      if ($raw !== '') {
        $jb = json_decode($raw, true);
        if (is_array($jb)) {
          $tok = $jb[$tokenName] ?? $jb['csrf'] ?? $jb['token'] ?? null;
          if (is_string($tok) && hash_equals($validHash, $tok)) $csrf_ok = true;
        }
      }
    }
    if (!$csrf_ok) return $this->json_fail('CSRF 驗證失敗', 403);

    // 4) Nonce（用過即旋轉）— 同時支援 form/header/json 與兩種欄位名
    $reqNonce = $this->read_nonce_from_request();
    if ($reqNonce !== null && $reqNonce !== '') {
      $sessNonce = (string)$this->session->userdata('checkout_nonce');
      if ($sessNonce === '' || !hash_equals($sessNonce, (string)$reqNonce)) {
        // 失敗時也旋轉，並把下一個可用 nonce 回給前端
        $this->rotate_checkout_nonce();
        return $this->json_fail('nonce 驗證失敗', 400);
      }
      // 使用過即旋轉，防重送
      $this->rotate_checkout_nonce();
    }

    // 5) 冷卻互斥（擋連點）
    if (!$this->acquire_checkout_mutex()) {
      return $this->json_fail('操作過於頻繁，請稍後再試', 429);
    }

    // 6) 讀入 items/cart
    $items = null;
    $ij = $this->input->post('items');
    if (is_string($ij) && $ij !== '') {
      $tmp = json_decode($ij, true);
      if (is_array($tmp)) $items = $tmp;
    } elseif (is_array($this->input->post('items'))) {
      $items = $this->input->post('items');
    }
    if ($items === null) {
      $cj = $this->input->post('cart');
      if (is_string($cj) && $cj !== '') {
        $tmp = json_decode($cj, true);
        if (is_array($tmp)) $items = $tmp;
      } elseif (is_array($this->input->post('cart'))) {
        $items = $this->input->post('cart');
      }
    }
    if ($items === null) {
      $raw = trim($this->input->raw_input_stream ?? '');
      if ($raw !== '') {
        $jb = json_decode($raw, true);
        if (is_array($jb)) {
          if (isset($jb['items']) && is_array($jb['items'])) $items = $jb['items'];
          elseif (isset($jb['cart']) && is_array($jb['cart'])) $items = $jb['cart'];
        }
      }
    }
    if (!is_array($items) || empty($items)) {
      $this->release_checkout_mutex();
      return $this->json_fail('items 格式錯誤或為空', 400);
    }

    // 7) 標準化 {item_idx, qty, sig?}
    $norm = [];
    foreach ($items as $r) {
      $iid = (int)($r['item_idx'] ?? $r['id'] ?? 0);
      $qty = (int)($r['qty'] ?? 0);
      $sig = isset($r['sig']) ? (string)$r['sig'] : null;
      if ($iid > 0 && $qty > 0) $norm[] = ['item_idx'=>$iid, 'qty'=>$qty, 'sig'=>$sig];
    }
    if (empty($norm)) {
      $this->release_checkout_mutex();
      return $this->json_fail('items 內容無效', 400);
    }

    // 8) 從 item_shop.xlsx 取價
    $ids = array_map(fn($x)=>$x['item_idx'], $norm);
    $priceMap = $this->get_sku_prices($ids);
    foreach ($norm as $row) {
      $iid = $row['item_idx'];
      if (!isset($priceMap[$iid]) || $priceMap[$iid] < 0) {
        $this->release_checkout_mutex();
        return $this->json_fail("商品未上架或無定價: {$iid}", 400);
      }
    }

    // 8.1) 從 itemlistcn.xlsx 取「固定欄位」meta → 快取 map（seal / durability）
    list($sealMap, $durMap) = $this->get_meta_maps_cached();

    // 9) （可選）驗簽章
    $salt = $this->get_item_salt();
    foreach ($norm as $row) {
      if (!empty($row['sig'])) {
        $iid   = $row['item_idx'];
        $price = (int)$priceMap[$iid];
        $expect = $this->sign_item((string)$iid, $price, $salt);
        if (!hash_equals($expect, (string)$row['sig'])) {
          $this->release_checkout_mutex();
          return $this->json_fail("簽章不符（疑似改價/改品項）: {$iid}", 400);
        }
      }
    }

    // 10) 合併數量 & 上限
    $merged = []; $totalQty = 0;
    foreach ($norm as $row) {
      $iid = $row['item_idx']; $qty = $row['qty'];
      if (!isset($merged[$iid])) $merged[$iid] = 0;
      $merged[$iid] += $qty;
      $totalQty += $qty;
    }
    foreach ($merged as $iid => $q) {
      if ($q > self::MAX_QTY_PER_ITEM) {
        $this->release_checkout_mutex();
        return $this->json_fail("超過單品數量上限: {$iid}", 400);
      }
    }

    // 11) 後端計總（只信 Excel 價）
    $total = 0;
    foreach ($merged as $iid => $q) $total += (int)$priceMap[$iid] * (int)$q;
    if ($total <= 0) {
      $this->release_checkout_mutex();
      return $this->json_fail('total 金額錯誤', 400);
    }

    // 12) 取帳號
    $sess_idx = $this->session->userdata('user_id');
    $sess_acc = $this->session->userdata('login_user_id');
    $q = $this->db->select('id_idx, id_loginid, mall_point')->from('dbo.chr_log_info');
    $q->group_start();
      if (ctype_digit((string)$sess_idx)) $q->or_where('id_idx', (int)$sess_idx);
      if ($sess_acc !== null && $sess_acc !== '') $q->or_where('id_loginid', (string)$sess_acc);
    $q->group_end();
    $acc = $q->limit(1)->get()->row_array();
    if (!$acc) {
      $this->release_checkout_mutex();
      return $this->json_fail('account not found', 404);
    }

    $user_idx = (int)$acc['id_idx'];
    $before   = (int)$acc['mall_point'];

    // 13) 扣點 + 記錄 + 投遞（批次）
    $progress = ['verify'];
    $this->db->trans_begin();
    try {
      // 扣點（原子）
      $this->db->query("
        UPDATE dbo.chr_log_info
           SET mall_point = mall_point - ?
         WHERE id_idx = ?
           AND mall_point >= ?
      ", [$total, $user_idx, $total]);

      if ($this->db->affected_rows() < 1) {
        $this->db->trans_rollback();
        $this->release_checkout_mutex();
        return $this->json_fail('點數不足或扣點衝突', 400, ['progress'=>$progress]);
      }
      $after = $before - $total;
      $progress[] = 'point';

      // log（一定要拿到 log_id）
      $ip = $this->input->ip_address();
      $mall_id = $this->mall_point_dao->insert_log(
        $user_idx, -$total, $before, $after, '商城結帳(Excel 驗價)', $acc['id_loginid'], $ip
      );
      if (!is_int($mall_id) || $mall_id <= 0) {
        throw new \RuntimeException('mall_point_log 新增失敗或回傳非ID');
      }

      // shop_log（TYPE=1）
      $now = (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');
      $log_idx = $this->shop_log_dao->insert_item([
        'TYPE'=>1,'USER_IDX'=>$user_idx,'USER_ID'=>(string)$user_idx,
        'ITEM_IDX'=>0,'ITEM_DBIDX'=>0,'SIZE'=>$totalQty,'DATE'=>$now,
      ]);
      if ($log_idx === false) throw new \RuntimeException('shop_log 失敗');

      // 投遞：批次 insert_batch；ITEM_SEAL / ITEM_DURABILITY 由 itemlistcn 固定欄位帶入
      $batch = [];
      foreach ($merged as $iid => $qty) {
        $sealVal = (int)($sealMap[$iid] ?? 0);  // from wSeal (BE)
        $durVal  = (int)($durMap[$iid]  ?? 0);  // from Stack (M)
        for ($i=0; $i<$qty; $i++) {
          $batch[] = [
            'CHARACTER_IDX'   => 0,
            'ITEM_IDX'        => (int)$iid,
            'ITEM_SHOPIDX'    => $user_idx,
            'ITEM_SHOPLOGIDX' => $log_idx,
            'mall_log_id'     => $mall_id,
            'ITEM_SEAL'       => $sealVal,
            'ITEM_DURABILITY' => $durVal,
            'ITEM_POSITION'   => self::SHOP_BAG_POSITION,
          ];
        }
      }
      if (!empty($batch)) {
        $aff = $this->item_dao->insert_items_batch($batch, self::BATCH_SIZE);
        if ($aff < count($batch)) {
          throw new \RuntimeException('TB_ITEM 批次寫入不完整');
        }
      }

      // 保險補寫：把本次訂單的 items 都補上 mall_log_id（防 DAO 白名單漏欄位）
      $this->item_dao->update_mall_log_id_by_shoplog($mall_id, $log_idx);


      $progress[] = 'item';

      $this->db->trans_commit();
      $this->release_checkout_mutex();
      $progress[] = 'done';

      return $this->json_ok([
        'msg'          => 'checkout ok (excel-priced)',
        'before'       => $before,
        'after'        => $after,
        'total'        => $total,
        'order_no'     => 'M'.date('YmdHis').$user_idx,
        'shop_log_id'  => $log_idx,
        'mall_log_id'  => $mall_id,
        'progress'     => $progress,
      ]);

    } catch (\Throwable $e) {
      $this->db->trans_rollback();
      $this->release_checkout_mutex();
      return $this->json_fail($e->getMessage(), 500, ['progress'=>$progress]);
    }
  }
}
