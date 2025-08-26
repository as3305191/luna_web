<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Luna_mall extends MY_Base_Controller {

  private $excel_file;

  function __construct() {
    parent::__construct();
    $this->excel_file = FCPATH . 'assets/luna/item_shop.xlsx'; // A:編號 B:中文 C:售價 D:英文(可空)

    $this->load->model('/luna/Members_dao', 'dao');
    $this->load->model('/luna/Shop_log_dao', 'shop_log_dao');
    $this->load->model('/luna/Item_dao', 'item_dao');
    $this->load->model('/luna/CHARACTER_dao', 'charDao'); // ✅ 新增
    $this->load->model('/luna/Item_log_dao', 'item_log_dao'); // ★ 新增：道具日誌（LOGDB）
    $this->load->model('/luna/mall_point_log_dao', 'mall_point_dao'); // ★ 新增：點數日誌（LOGDB）
  }

  public function index() {
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login");
      return;
    }

    $s_data     = $this->setup_user_data([]);
    $login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');

    $data = [];
    $data['login_user'] = $login_user;
    $data['userlv']     = $login_user ? ($login_user->UserLevel ?? 0) : 0;
    $data['now']        = 'luna_mall';

    // 讀取所有工作表（自動偵測資料起始列）
    list($sheetNames, $itemsMap) = $this->read_all_sheets_dynamic();

    // 產生「全部商品(All)」= 合併所有工作表（保持原順序；不去重）
    $allTitle = '全部商品(All)';
    $filtered = array_values(array_filter($sheetNames, function($n) use ($allTitle){ return $n !== $allTitle; }));

    $all = [];
    foreach ($filtered as $nm) {
      if (!empty($itemsMap[$nm])) {
        $all = array_merge($all, $itemsMap[$nm]);
      }
    }
    $tabs = $filtered;
    array_unshift($tabs, $allTitle);
    $itemsMap[$allTitle] = $all;

    // 簽章：防前端竄改（對 id|price 以 session salt 做 HMAC）
    $salt = $this->get_item_salt();
    foreach ($itemsMap as $sheet => &$arr) {
      foreach ($arr as &$it) {
        $it['sig'] = $this->sign_item((string)$it['id'], (int)$it['price'], $salt);
      }
    }
    unset($arr, $it);

    $data['tabs']     = $tabs;
    $data['itemsMap'] = $itemsMap;

    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();

    $this->load->view('luna/luna_mall', $data);
  }

  /** 單品購買：確認簽章 + 重新驗價（來源 Excel） */
  public function purchase() {
    if (empty($this->session->userdata('user_id'))) {
      return $this->json_fail('尚未登入');
    }

    $id  = $this->input->post('id', true);
    $qty = (int)$this->input->post('qty', true);
    $sig = $this->input->post('sig', true);

    if (empty($id) || $qty <= 0 || $qty > 9999) {
      return $this->json_fail('參數不合法');
    }
    if (empty($sig)) {
      return $this->json_fail('資料驗證失敗（缺少簽章）');
    }

    // 建立價格索引（忽略 Excel 內的 All 表）
    list($sheetNames, $itemsMap) = $this->read_all_sheets_dynamic();
    $allTitle = '全部商品(All)';
    $price_index = [];
    foreach ($sheetNames as $nm) {
      if ($nm === $allTitle) continue;
      foreach ($itemsMap[$nm] ?? [] as $it) {
        $price_index[(string)$it['id']] = (int)$it['price'];
      }
    }

    if (!isset($price_index[(string)$id])) {
      return $this->json_fail('找不到商品');
    }

    // 簽章驗證（用最新價組簽章，與前端送來 sig 比對）
    $salt = $this->get_item_salt();
    $server_sig = $this->sign_item((string)$id, (int)$price_index[(string)$id], $salt);
    if (!hash_equals($server_sig, $sig)) {
      return $this->json_fail('商品資訊已更新，請重新整理後再試');
    }

    $price = (int)$price_index[(string)$id];
    $total = $price * $qty;

    // TODO：寫入訂單（無庫存機制，直接記錄 DB）
    return $this->json_ok(['msg'=>'下單成功','total'=>$total]);
  }

  /** JSON Helper */
  private function json_ok(array $extra = []) {
    $payload = array_merge(['ok'=>true], $extra, [
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
    ]);
    return $this->output->set_content_type('application/json')->set_output(json_encode($payload));
  }
  private function json_fail(string $msg) {
    $payload = [
      'ok' => false,
      'msg'=> $msg,
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
    ];
    return $this->output->set_content_type('application/json')->set_output(json_encode($payload));
  }

  /** session salt */
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

  /**
   * 動態讀所有工作表；自動偵測資料起始列（第1列就是資料也OK）
   * 回傳 [$sheetNames, $itemsMap]
   *  - $sheetNames = ['表名1','表名2', ...]（依 Excel 順序）
   *  - $itemsMap['表名'] = [ ['id'=>..,'name'=>..,'price'=>..,'name_en'=>..], ... ]
   */
  private function read_all_sheets_dynamic(): array {
    $sheetNames = [];
    $itemsMap   = [];

    if (!file_exists($this->excel_file)) return [$sheetNames, $itemsMap];

    $xlsx = IOFactory::load($this->excel_file);
    $sheetNames = $xlsx->getSheetNames();

    foreach ($sheetNames as $sheetName) {
      $sheet = $xlsx->getSheetByName($sheetName);
      if (!$sheet) continue;

      $highestRow = $sheet->getHighestRow();

      // 找第一個像資料的列（A、B 有值且 C 為數字）
      $startRow = 1;
      for ($r = 1; $r <= $highestRow; $r++) {
        $a = trim((string)$sheet->getCell("A{$r}")->getValue());
        $b = trim((string)$sheet->getCell("B{$r}")->getValue());
        $c = $sheet->getCell("C{$r}")->getValue();
        if ($a !== '' && $b !== '' && is_numeric($c)) { $startRow = $r; break; }
      }

      $items = [];
      for ($r = $startRow; $r <= $highestRow; $r++) {
        $id      = trim((string)$sheet->getCell("A{$r}")->getValue());
        $name    = trim((string)$sheet->getCell("B{$r}")->getValue());
        $cval    = $sheet->getCell("C{$r}")->getValue();
        $name_en = trim((string)$sheet->getCell("D{$r}")->getValue()); // 允許空白
        if ($id === '' || $name === '') continue;
        if (!is_numeric($cval)) continue; // 非數字售價就略過
        $price = (int)$cval;
        $items[] = ['id'=>$id,'name'=>$name,'price'=>$price,'name_en'=>$name_en];
      }

      $itemsMap[$sheetName] = $items;
    }

    return [$sheetNames, $itemsMap];
  }

  public function checkout() {
  $this->output->set_content_type('application/json');

  if (empty($this->session->userdata('user_id'))) {
    return $this->json_fail('尚未登入');
  }

  // 目前登入者
  $s_data     = $this->setup_user_data([]);
  $login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');
  if (!$login_user) return $this->json_fail('找不到帳號');
  $user_idx = (int)$login_user->id_idx;
  $login_id = (string)$login_user->id_loginid;

  // 前端傳入購物車（只允許 item_idx + qty）
  $raw = $this->input->post('cart', true);
  $cart = json_decode($raw, true);
  if (!is_array($cart) || empty($cart)) return $this->json_fail('購物車是空的');

  // 從 Excel 重建商品索引
  $pack = $this->load_all_items(); // 這個方法會給完整 itemMap
  $itemMap = [];
  foreach ($pack['items'] as $it) {
    $itemMap[(string)$it['product_code']] = $it;
  }

  // 整理購物車，只比對 item_idx 是否存在 Excel
  $merged = [];
  foreach ($cart as $row) {
    $id  = isset($row['id'])  ? (string)$row['id']  : '';
    $qty = isset($row['qty']) ? (int)$row['qty']    : 0;
    if ($id === '' || $qty <= 0) {
      return $this->json_fail('購物車有不合法的商品/數量');
    }
    if (!isset($itemMap[$id])) {
      return $this->json_fail("找不到商品：{$id}");
    }
    if (!isset($merged[$id])) $merged[$id] = 0;
    $merged[$id] += $qty;
  }

  // 計算總金額（完全依 Excel 的 price）
  $total = 0;
  foreach ($merged as $id => $qty) {
    $price = (int)($itemMap[$id]['sellstatus'] ?? 0); 
    // ⚠️ 如果你 Excel 有獨立價格欄位，這裡改成那個
    if ($price <= 0) return $this->json_fail("商品 {$id} 不可販售");
    $total += $price * $qty;
  }
  if ($total <= 0) return $this->json_fail('金額計算錯誤');

  // 鎖定並檢查點數
  $row = $this->db->query("
    SELECT mall_point FROM dbo.chr_log_info WITH (UPDLOCK, ROWLOCK)
    WHERE id_idx = ?
  ", [$user_idx])->row_array();
  if (!$row) return $this->json_fail('帳號不存在');

  $before = (int)$row['mall_point'];
  if ($before < $total) return $this->json_fail('點數不足');
  $after = $before - $total;

  // 找商城包包角色（帳號第一個角色）
  $list = $this->charDao->list_by_user($user_idx, false);
  if (empty($list)) return $this->json_fail('帳號底下沒有角色');
  $charIdx = (int)$list[0]->CharId;

  $now = date('Y-m-d H:i:s');
  $ip  = $this->input->ip_address();

  // 交易開始
  $this->db->trans_begin();
  try {
    // 扣點
    $this->db->query("
      UPDATE dbo.chr_log_info
      SET mall_point = mall_point - ?
      WHERE id_idx = ?
    ", [$total, $user_idx]);

    // 發物品
    foreach ($merged as $id => $qty) {
      $info      = $itemMap[$id];
      $itemIdx   = (int)$id;
      $item_seal = (int)($info['item_seal'] ?? 0);
      $max_stack = (int)($info['max_stack'] ?? 0);

      // 建立商城 log
      $this->db->query("
        INSERT INTO LUNA_LOGDB_2025.dbo.TB_ITEM_SHOPWEB_LOG
        (TYPE, USER_IDX, USER_ID, ITEM_IDX, ITEM_DBIDX, SIZE, DATE)
        VALUES (1, ?, ?, ?, ?, ?, ?)
      ", [$user_idx, $login_id, $itemIdx, $itemIdx, $qty, $now]);
      $mall_log_id = $this->db->query("SELECT SCOPE_IDENTITY() AS id")->row()->id;

      // 發送 TB_ITEM
      $remain = $qty;
      if ($max_stack > 0) {
        while ($remain > 0) {
          $stackSize = ($remain >= $max_stack) ? $max_stack : $remain;
          $this->item_dao->insert_item([
            'CHARACTER_IDX'   => $charIdx,
            'ITEM_IDX'        => $itemIdx,
            'ITEM_SHOPIDX'    => $user_idx,
            'ITEM_SHOPLOGIDX' => $mall_log_id,
            'mall_log_id'     => $mall_log_id,
            'ITEM_SEAL'       => $item_seal,
            'ITEM_DURABILITY' => $stackSize
          ]);
          $remain -= $stackSize;
        }
      } else {
        for ($i=0; $i<$remain; $i++) {
          $this->item_dao->insert_item([
            'CHARACTER_IDX'   => $charIdx,
            'ITEM_IDX'        => $itemIdx,
            'ITEM_SHOPIDX'    => $user_idx,
            'ITEM_SHOPLOGIDX' => $mall_log_id,
            'mall_log_id'     => $mall_log_id,
            'ITEM_SEAL'       => $item_seal,
            'ITEM_DURABILITY' => 0
          ]);
        }
      }
    }

    // 點數異動 log
    if ($this->mall_point_dao && method_exists($this->mall_point_dao, 'insert_log')) {
      @$this->mall_point_dao->insert_log(
        $user_idx, -$total, $before, $after, '線上購物', $login_id, $ip
      );
    }

    $this->db->trans_commit();
    return $this->json_ok([
      'msg'    => '購買成功',
      'before' => $before,
      'after'  => $after,
      'total'  => $total,
      'items'  => array_map(function($id,$qty,$info){
        return ['id'=>$id,'qty'=>$qty,'price'=>(int)$info['sellstatus']];
      }, array_keys($merged), $merged, array_intersect_key($itemMap, $merged))
    ]);
  } catch (\Throwable $e) {
    $this->db->trans_rollback();
    return $this->json_fail('交易失敗：'.$e->getMessage());
  }
}


}
