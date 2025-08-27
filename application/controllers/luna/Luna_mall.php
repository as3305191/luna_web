<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Luna_mall extends MY_Base_Controller {

  private $excel_file;

  function __construct() {
    parent::__construct();
    $this->excel_file = FCPATH . 'assets/luna/item_shop.xlsx';

    $this->load->model('/luna/Members_dao', 'dao');
    $this->load->model('/luna/Shop_log_dao', 'shop_log_dao');
    $this->load->model('/luna/Item_dao', 'item_dao');
    $this->load->model('/luna/CHARACTER_dao', 'charDao');
    $this->load->model('/luna/Item_log_dao', 'item_log_dao');
    $this->load->model('/luna/mall_point_log_dao', 'mall_point_dao');
  }

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

    list($sheetNames, $itemsMap) = $this->read_all_sheets_dynamic();
    $allTitle = '全部商品(All)';
    $filtered = array_values(array_filter($sheetNames, fn($n) => $n !== $allTitle));

    $all = [];
    foreach ($filtered as $nm) if (!empty($itemsMap[$nm])) $all = array_merge($all, $itemsMap[$nm]);
    $tabs = $filtered;
    array_unshift($tabs, $allTitle);
    $itemsMap[$allTitle] = $all;

    $salt = $this->get_item_salt();
    foreach ($itemsMap as &$arr) {
      foreach ($arr as &$it) {
        $it['sig'] = $this->sign_item((string)$it['id'], (int)$it['price'], $salt);
      }
    }

    $data['tabs']     = $tabs;
    $data['itemsMap'] = $itemsMap;
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();

    $this->load->view('luna/luna_mall', $data);
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

  private function read_all_sheets_dynamic(): array {
    $sheetNames = []; $itemsMap = [];
    if (!file_exists($this->excel_file)) return [$sheetNames, $itemsMap];

    $xlsx = IOFactory::load($this->excel_file);
    $sheetNames = $xlsx->getSheetNames();

    foreach ($sheetNames as $sheetName) {
      $sheet = $xlsx->getSheetByName($sheetName);
      if (!$sheet) continue;
      $highestRow = $sheet->getHighestRow();
      $startRow = 1;
      for ($r = 1; $r <= $highestRow; $r++) {
        $a = trim((string)$sheet->getCell("A{$r}")->getValue());
        $b = trim((string)$sheet->getCell("B{$r}")->getValue());
        $c = $sheet->getCell("C{$r}")->getValue();
        if ($a !== '' && $b !== '' && is_numeric($c)) { $startRow = $r; break; }
      }
      $items = [];
      for ($r = $startRow; $r <= $highestRow; $r++) {
        $id   = trim((string)$sheet->getCell("A{$r}")->getValue());
        $name = trim((string)$sheet->getCell("B{$r}")->getValue());
        $cval = $sheet->getCell("C{$r}")->getValue();
        $name_en = trim((string)$sheet->getCell("D{$r}")->getValue());
        if ($id==='' || $name==='' || !is_numeric($cval)) continue;
        $price = (int)$cval;
        $items[] = ['id'=>$id,'name'=>$name,'price'=>$price,'name_en'=>$name_en];
      }
      $itemsMap[$sheetName] = $items;
    }
    return [$sheetNames, $itemsMap];
  }

  private function load_all_items(): array {
    list($sheetNames, $itemsMap) = $this->read_all_sheets_dynamic();
    $all = [];
    foreach ($sheetNames as $sheet) {
      foreach ($itemsMap[$sheet] ?? [] as $it) {
        $all[] = [
          'product_code' => (string)$it['id'],
          'name'         => $it['name'],
          'price'        => (int)$it['price'],
          'sellstatus'   => (int)$it['price'],
          'name_en'      => $it['name_en'] ?? '',
          'item_seal'    => $it['item_seal'] ?? 0,
          'max_stack'    => $it['max_stack'] ?? 0,
        ];
      }
    }
    return ['items' => $all];
  }

  /** === Checkout === */
  public function checkout() {
    $this->output->set_content_type('application/json');
    if (empty($this->session->userdata('user_id'))) {
      return $this->json_fail('尚未登入');
    }

    // 讀 cart (FormData 或 raw JSON)
    $raw = $this->input->post('cart', false);
    if ($raw === null || $raw === '') {
      $body = $this->input->raw_input_stream;
      if ($body) {
        $asObj = json_decode($body, true);
        if (isset($asObj['cart'])) {
          $raw = is_string($asObj['cart']) ? $asObj['cart'] : json_encode($asObj['cart']);
        }
      }
    }
    $cart = json_decode($raw, true);
    if (!is_array($cart) || empty($cart)) {
      return $this->json_fail('購物車是空的');
    }

    $progress = ["verify"];
    $s_data     = $this->setup_user_data([]);
    $login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');
    if (!$login_user) return $this->json_fail('找不到帳號');

    $user_idx = (int)$login_user->id_idx;
    $login_id = (string)$login_user->id_loginid;

    $pack = $this->load_all_items();
    $itemMap = [];
    foreach ($pack['items'] as $it) $itemMap[(string)$it['product_code']] = $it;

    // 驗簽
    $salt = $this->get_item_salt();
    $merged = [];
    foreach ($cart as $row) {
      $id  = (string)($row['id'] ?? '');
      $qty = (int)($row['qty'] ?? 0);
      $sig = (string)($row['sig'] ?? '');
      if ($id==='' || $qty<=0) return $this->json_fail('購物車有不合法的商品/數量');
      if (!isset($itemMap[$id])) return $this->json_fail("找不到商品：{$id}");
      $price_now = (int)$itemMap[$id]['sellstatus'];
      $server_sig = $this->sign_item($id, $price_now, $salt);
      if (!hash_equals($server_sig, $sig)) {
        return $this->json_fail("商品資訊已更新，請重新整理再購買（{$id}）");
      }
      $merged[$id] = ($merged[$id] ?? 0) + $qty;
    }

    $total = 0;
    foreach ($merged as $id => $qty) {
      $price = (int)($itemMap[$id]['sellstatus'] ?? 0);
      if ($price <= 0) return $this->json_fail("商品 {$id} 不可販售");
      $total += $price * $qty;
    }
    if ($total <= 0) return $this->json_fail('金額計算錯誤');

    $progress[] = "point";
    $list = $this->charDao->list_by_user($user_idx, false);
    if (empty($list)) return $this->json_fail('帳號底下沒有角色');
    $charIdx = (int)$list[0]->CharId;

    $now = date('Y-m-d H:i:s');
    $ip  = $this->input->ip_address();
    $order_no = bin2hex(random_bytes(8)); // 唯一單號

    $this->db->trans_begin();
    try {
      // 扣點 (原子條件更新)
      $ok = $this->db->query("
        UPDATE dbo.chr_log_info
        SET mall_point = mall_point - ?
        WHERE id_idx = ? AND mall_point >= ?
      ", [$total, $user_idx, $total]);
      if ($ok === FALSE || $this->db->affected_rows() !== 1) {
        throw new \RuntimeException('點數不足或扣點失敗');
      }

      $row = $this->db->query("SELECT mall_point FROM dbo.chr_log_info WHERE id_idx=?", [$user_idx])->row_array();
      $after = (int)($row['mall_point'] ?? 0);
      $before = $after + $total;

      // 寫 log
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

      // 發物品
      foreach ($merged as $id => $qty) {
        $info      = $itemMap[$id];
        $itemIdx   = (int)$id;
        $item_seal = (int)($info['item_seal'] ?? 0);
        $max_stack = (int)($info['max_stack'] ?? 0);

        $this->db->query("
          INSERT INTO LUNA_LOGDB_2025.dbo.TB_ITEM_SHOPWEB_LOG
            (TYPE, USER_IDX, USER_ID, ITEM_IDX, ITEM_DBIDX, SIZE, DATE)
          VALUES (1, ?, ?, ?, ?, ?, ?)
        ", [$user_idx, $login_id, $itemIdx, $itemIdx, $qty, $now]);

        $remain = $qty;
        if ($max_stack > 0) {
          while ($remain > 0) {
            $stackSize = ($remain >= $max_stack) ? $max_stack : $remain;
            $this->item_dao->insert_item([
              'CHARACTER_IDX'   => $charIdx,
              'ITEM_IDX'        => $itemIdx,
              'ITEM_SHOPIDX'    => $user_idx,
              'ITEM_SHOPLOGIDX' => $mpl_id,
              'mall_log_id'     => $mpl_id,
              'ITEM_SEAL'       => $item_seal,
              'ITEM_DURABILITY' => $stackSize,
              'ITEM_POSITION'   => 320
            ]);
            $remain -= $stackSize;
          }
        } else {
          for ($i=0; $i<$remain; $i++) {
            $this->item_dao->insert_item([
              'CHARACTER_IDX'   => $charIdx,
              'ITEM_IDX'        => $itemIdx,
              'ITEM_SHOPIDX'    => $user_idx,
              'ITEM_SHOPLOGIDX' => $mpl_id,
              'mall_log_id'     => $mpl_id,
              'ITEM_SEAL'       => $item_seal,
              'ITEM_DURABILITY' => 0,
              'ITEM_POSITION'   => 320
            ]);
          }
        }
      }

      $this->db->trans_commit();
      $progress[] = "done";

      $respItems = [];
      foreach ($merged as $id => $qty) {
        $respItems[] = [
          'id'    => $id,
          'qty'   => $qty,
          'price' => (int)$itemMap[$id]['sellstatus'],
        ];
      }

      return $this->json_ok([
        'msg'      => '購買成功',
        'before'   => $before,
        'after'    => $after,
        'total'    => $total,
        'progress' => $progress,
        'items'    => $respItems,
        'order_no' => $order_no
      ]);

    } catch (\Throwable $e) {
      $this->db->trans_rollback();
      log_message('error', 'Checkout失敗: '.$e->getMessage());
      return $this->json_fail('交易失敗，請稍後再試');
    }
  }

}
