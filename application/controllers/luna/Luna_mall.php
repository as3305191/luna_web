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
  
  private function ensure_csrf() {
    if (method_exists($this->security, 'csrf_set_cookie')) $this->security->csrf_set_cookie();
    return [
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
    ];
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

public function checkout(){
  $this->output->set_content_type('application/json');

  if (empty($this->session->userdata('user_id'))) {
    $csrfNew = $this->ensure_csrf();
    return $this->output->set_status_header(401)
      ->set_output(json_encode(['ok'=>false,'msg'=>'not login'] + $csrfNew, JSON_UNESCAPED_UNICODE));
  }

  // CSRF
  $tokenName = $this->security->get_csrf_token_name();
  $tokenPost = $this->input->post($tokenName); // 不要 true，避免被 XSS 過濾更動
  $tokenHead = $this->input->get_request_header('X-CSRF-Token', true);
  $validHash = $this->security->get_csrf_hash();
  $csrf_ok   = ($tokenPost && hash_equals($validHash, $tokenPost)) || ($tokenHead && hash_equals($validHash, $tokenHead));
  if(!$csrf_ok){
    $csrfNew = $this->ensure_csrf();
    return $this->output->set_status_header(403)
      ->set_output(json_encode(['ok'=>false,'msg'=>'CSRF 驗證失敗'] + $csrfNew, JSON_UNESCAPED_UNICODE));
  }

  // 讀 items：不能用 XSS 過濾，否則 JSON 會被破壞
  $items_json = $this->input->post('items');              // <- 不要加 true
  if ($items_json === null || $items_json === '') {
    // 有些前端用 JSON 傳 raw body
    $items_json = $this->input->raw_input_stream;
    if (is_string($items_json)) {
      $tmp = json_decode($items_json, true);
      if (is_array($tmp) && isset($tmp['items'])) {
        $items = $tmp['items'];
      } else {
        $items = $tmp; // 直接就是 array
      }
    } else {
      $items = null;
    }
  } else {
    $items = json_decode($items_json, true);
  }

  if (!is_array($items) || empty($items)) {
    $csrfNew = $this->ensure_csrf();
    return $this->output->set_status_header(400)
      ->set_output(json_encode(['ok'=>false,'msg'=>'items 格式錯誤或為空'] + $csrfNew, JSON_UNESCAPED_UNICODE));
  }

  // 計總金額
  $total = 0; $totalQty = 0;
  foreach ($items as $it) {
    $qty   = (int)($it['qty']   ?? 0);
    $price = (int)($it['price'] ?? 0);
    if ($qty<=0 || $price<0) {
      $csrfNew = $this->ensure_csrf();
      return $this->output->set_status_header(400)
        ->set_output(json_encode(['ok'=>false,'msg'=>'qty/price 非法'] + $csrfNew, JSON_UNESCAPED_UNICODE));
    }
    $total    += $qty * $price;
    $totalQty += $qty;
  }
  if ($total<=0) {
    $csrfNew = $this->ensure_csrf();
    return $this->output->set_status_header(400)
      ->set_output(json_encode(['ok'=>false,'msg'=>'total 金額錯誤'] + $csrfNew, JSON_UNESCAPED_UNICODE));
  }

  // 取帳號（session 可能放 id_idx 或 id_loginid，兩邊都試）
  $sess_id  = $this->session->userdata('user_id');
  $accQuery = $this->db->select('id_idx, id_loginid, mall_point')->from('dbo.chr_log_info');
  if (ctype_digit((string)$sess_id)) {
    $accQuery->group_start()
             ->where('id_idx', (int)$sess_id)
             ->or_where('id_loginid', (string)$sess_id)
             ->group_end();
  } else {
    $accQuery->where('id_loginid', (string)$sess_id);
  }
  $acc = $accQuery->get()->row_array();

  if(!$acc){
    $csrfNew = $this->ensure_csrf();
    return $this->output->set_status_header(404)
      ->set_output(json_encode(['ok'=>false,'msg'=>'account not found'] + $csrfNew, JSON_UNESCAPED_UNICODE));
  }

  $user_idx = (int)$acc['id_idx'];
  $before   = (int)$acc['mall_point'];

  $this->db->trans_begin();
  try {
    // 原子扣點：確保 mall_point >= total
    $this->db->query("
      UPDATE dbo.chr_log_info
         SET mall_point = mall_point - ?
       WHERE id_idx = ?
         AND mall_point >= ?
    ", [$total, $user_idx, $total]);

    if ($this->db->affected_rows() < 1) {
      $this->db->trans_rollback();
      $csrfNew = $this->ensure_csrf();
      return $this->output->set_status_header(400)
        ->set_output(json_encode(['ok'=>false,'msg'=>'點數不足或扣點衝突'] + $csrfNew, JSON_UNESCAPED_UNICODE));
    }

    // Mall point log
    $after = $before - $total;
    $ip    = $this->input->ip_address();
    $memo  = '商城結帳';
    $this->mall_point_dao->insert_log($user_idx, -$total, $before, $after, $memo, $acc['id_loginid'], $ip);

    // shop_log（TYPE=1：商城購買）
    $now = (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');
    $log_idx = $this->shop_log_dao->insert_item([
      'TYPE'=>1,
      'USER_IDX'=>$user_idx,
      'USER_ID'=>(string)$user_idx,
      'ITEM_IDX'=>0,
      'ITEM_DBIDX'=>0,
      'SIZE'=>$totalQty,
      'DATE'=>$now,
    ]);
    if ($log_idx === false) throw new \RuntimeException('shop_log 失敗');

    // 簡化投遞（發到商城包包 ITEM_POSITION=320；SEAL=0）
    foreach ($items as $it) {
      $iid = (int)$it['item_idx'];
      $qty = (int)$it['qty'];
      for($i=0;$i<$qty;$i++){
        $ret = $this->item_dao->insert_item([
          'CHARACTER_IDX'   => 0,
          'ITEM_IDX'        => $iid,
          'ITEM_SHOPIDX'    => $user_idx,
          'ITEM_SHOPLOGIDX' => $log_idx,
          'ITEM_SEAL'       => 0,
          'ITEM_DURABILITY' => 0,
          'ITEM_POSITION'   => 320,
        ]);
        if(!$ret) throw new \RuntimeException('TB_ITEM 寫入失敗');
      }
    }

    $this->db->trans_commit();
    $csrfNew = $this->ensure_csrf();
    return $this->output->set_output(json_encode([
      'ok'=>true,
      'msg'=>'checkout ok',
      'before'=>$before,
      'after'=>$after,
    ] + $csrfNew, JSON_UNESCAPED_UNICODE));
  } catch(\Throwable $e){
    $this->db->trans_rollback();
    $csrfNew = $this->ensure_csrf();
    return $this->output->set_status_header(500)
      ->set_output(json_encode(['ok'=>false,'msg'=>$e->getMessage()] + $csrfNew, JSON_UNESCAPED_UNICODE));
  }
}

}
