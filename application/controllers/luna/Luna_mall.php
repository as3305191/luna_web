<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Luna_mall extends MY_Base_Controller {

  /* 可調參數 */
  private const MAX_QTY_PER_ITEM   = 99;
  private const MUTEX_COOLDOWN_SEC = 5;
  private const SHOP_BAG_POSITION  = 320;
  private const BATCH_SIZE         = 500;

  /** GameDB 連線（指向 LUNA_GAMEDB_2025） */
  protected $gdb;

  public function __construct() {
    parent::__construct();

    // 重要：請在 config/database.php 設好 'gamedb' DSN 指向 LUNA_GAMEDB_2025
    $this->gdb = $this->load->database('gamedb', TRUE);

    $this->load->driver('cache', ['adapter' => 'apc', 'backup' => 'file']);

    $this->load->model('/luna/Members_dao',        'dao');
    $this->load->model('/luna/Shop_log_dao',       'shop_log_dao');
    $this->load->model('/luna/Item_dao',           'item_dao');
    $this->load->model('/luna/CHARACTER_dao',      'charDao');
    $this->load->model('/luna/Item_log_dao',       'item_log_dao');
    $this->load->model('/luna/mall_point_log_dao', 'mall_point_dao');

    // 道具 meta（封印/堆疊/時效）改走 GameDB 的 DAO
    $this->load->model('/luna/Web_item_dao',       'web_item_dao');
  }

  /* ========================== Page ========================== */

  public function index() {
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login"); return;
    }

    $pair = $this->ensure_csrf();
    $s_data     = $this->setup_user_data([]);
    $login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');

    // 從 GameDB 讀取上架清單（分頁籤 + 商品）
    [$tabs, $itemsMap] = $this->db_load_shop_tabs_and_items();

    // 展示簽章（防改價）；實際結帳仍以伺服器 DB 價為準
    $salt = $this->get_item_salt();
    foreach ($itemsMap as &$arr) {
      foreach ($arr as &$it) {
        $it['sig'] = $this->sign_item((string)$it['id'], (int)$it['price'], $salt);
      }
    }

    $data = [];
    $data['login_user']     = $login_user;
    $data['userlv']         = $login_user ? ($login_user->UserLevel ?? 0) : 0;
    $data['now']            = 'luna_mall';
    $data['checkout_nonce'] = $this->rotate_checkout_nonce();
    $data['tabs']           = $tabs;
    $data['itemsMap']       = $itemsMap;
    $data['csrf_name']      = $pair['csrf_name'];
    $data['csrf_hash']      = $pair['csrf_hash'];

    $data['content_view']   = 'luna/mall_content';
    $this->load->view('luna/luna_layout', $data);
  }

  /* ========================== DB Readers ========================== */

  /**
   * 讀 GameDB 的 web_itemshop，組成 [$tabs, $itemsMap]
   * 分頁名稱使用 category（NULL/空白 → '未分類'）
   * 價格使用 price_cash（若 <=0 或 NULL，退回 price_token）
   * 僅取 is_active=1 且時間區間內
   */
  private function db_load_shop_tabs_and_items(): array {
    $now = date('Y-m-d H:i:s');

    $this->gdb->from('web_itemshop'); // 連線已指向 LUNA_GAMEDB_2025
    $this->gdb->where('is_active', 1);
    // 時間區間：start_time <= now 或 NULL；end_time >= now 或 NULL
    $this->gdb->group_start()
                ->where('start_time <=', $now)
                ->or_where('start_time IS NULL', null, false)
              ->group_end();
    $this->gdb->group_start()
                ->where('end_time >=', $now)
                ->or_where('end_time IS NULL', null, false)
              ->group_end();

    // 取必要欄位
    $this->gdb->select('shop_id, item_id, name_cn, name_en, category, price_cash, price_token, position');
    // 排序：category, position(NULL 最後), item_id
    $this->gdb->order_by('category', 'ASC');
    $this->gdb->order_by('(CASE WHEN position IS NULL THEN 1 ELSE 0 END)', 'ASC', false);
    $this->gdb->order_by('position', 'ASC');
    $this->gdb->order_by('item_id', 'ASC');

    $rows = $this->gdb->get()->result_array();

    $tabs = [];
    $itemsMap = [];

    foreach ($rows as $r) {
      $tab = trim((string)($r['category'] ?? ''));
      if ($tab === '') $tab = '未分類';

      // 價格：優先 cash，否則 token
      $pc = isset($r['price_cash'])  ? (int)$r['price_cash']  : 0;
      $pt = isset($r['price_token']) ? (int)$r['price_token'] : 0;
      $price = ($pc > 0) ? $pc : $pt;

      if (!isset($itemsMap[$tab])) { $itemsMap[$tab] = []; $tabs[] = $tab; }

      $itemsMap[$tab][] = [
        'id'      => (string)$r['item_id'],
        'name'    => (string)$r['name_cn'],
        'name_en' => (string)($r['name_en'] ?? ''),
        'price'   => max(0, (int)$price),
      ];
    }

    if (!empty($tabs)) {
      $allTitle = '全部商品(All)';
      $all = [];
      foreach ($tabs as $tn) if (!empty($itemsMap[$tn])) $all = array_merge($all, $itemsMap[$tn]);
      array_unshift($tabs, $allTitle);
      $itemsMap[$allTitle] = $all;
    }

    return [$tabs, $itemsMap];
  }

  /** 由 GameDB 取價：item_id(int) => price(int) */
  private function get_sku_prices_db(array $itemIds): array {
    $itemIds = array_values(array_unique(array_map('intval', $itemIds)));
    if (empty($itemIds)) return [];

    $now = date('Y-m-d H:i:s');

    $this->gdb->from('web_itemshop');
    $this->gdb->where('is_active', 1);
    $this->gdb->where_in('item_id', $itemIds);
    $this->gdb->group_start()
                ->where('start_time <=', $now)
                ->or_where('start_time IS NULL', null, false)
              ->group_end();
    $this->gdb->group_start()
                ->where('end_time >=', $now)
                ->or_where('end_time IS NULL', null, false)
              ->group_end();
    $this->gdb->select('item_id, price_cash, price_token');

    $rows = $this->gdb->get()->result_array();
    $map = [];
    foreach ($rows as $r) {
      $pc = isset($r['price_cash'])  ? (int)$r['price_cash']  : 0;
      $pt = isset($r['price_token']) ? (int)$r['price_token'] : 0;
      $price = ($pc > 0) ? $pc : $pt;
      $map[(int)$r['item_id']] = max(0, (int)$price);
    }
    return $map;
  }

  /* ========================== JSON / 安全工具 ========================== */

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

  private function ensure_csrf() {
    $cookieName = $this->config->item('csrf_cookie_name') ?: 'ci_csrf_token';
    $hash = $this->security->get_csrf_hash();
    if (!$this->input->cookie($cookieName, true)) {
      $expire = (int)$this->config->item('csrf_expire'); if ($expire <= 0) $expire = 7200;
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
  private function release_checkout_mutex(): void {}

  private function get_json_body(): ?array {
    static $cached = null;
    if ($cached !== null) return $cached;
    $raw = trim($this->input->raw_input_stream ?? '');
    if ($raw === '') { $cached = null; return null; }
    $jb = json_decode($raw, true);
    $cached = is_array($jb) ? $jb : null;
    return $cached;
  }
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

  /* ============== 取得玩家第一個角色（保留一致） ============== */
  private function get_first_char_id(int $user_idx): int {
    try {
      $cands = null;
      if (method_exists($this->charDao, 'list_by_user')) {
        $cands = $this->charDao->list_by_user($user_idx, false);
      } elseif (method_exists($this->charDao, 'list_by_user_idx')) {
        $cands = $this->charDao->list_by_user_idx($user_idx);
      } elseif (method_exists($this->charDao, 'find_by_user_idx')) {
        $cands = $this->charDao->find_by_user_idx($user_idx);
      } elseif (method_exists($this->charDao, 'find_all_by_user_idx')) {
        $cands = $this->charDao->find_all_by_user_idx($user_idx);
      }
      if (empty($cands)) return 0;
      $first = is_array($cands) ? reset($cands) : $cands[0];
      if (is_array($first)) {
        return (int)($first['CharId'] ?? $first['char_id'] ?? $first['id'] ?? 0);
      } else {
        return (int)($first->CharId ?? $first->char_id ?? $first->id ?? 0);
      }
    } catch (\Throwable $e) { return 0; }
  }

  /* ========================== Checkout ========================== */

  public function checkout(){
    $this->output->set_content_type('application/json');

    if (empty($this->session->userdata('user_id')) && empty($this->session->userdata('login_user_id'))) {
      $this->ensure_csrf();
      return $this->json_fail('not login', 401);
    }

    $this->ensure_csrf();

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

    $reqNonce = $this->read_nonce_from_request();
    if ($reqNonce !== null && $reqNonce !== '') {
      $sessNonce = (string)$this->session->userdata('checkout_nonce');
      if ($sessNonce === '' || !hash_equals($sessNonce, (string)$reqNonce)) {
        $this->rotate_checkout_nonce();
        return $this->json_fail('nonce 驗證失敗', 400);
      }
      $this->rotate_checkout_nonce();
    }

    if (!$this->acquire_checkout_mutex()) {
      return $this->json_fail('操作過於頻繁，請稍後再試', 429);
    }

    $items = null;
    $ij = $this->input->post('items');
    if (is_string($ij) && $ij !== '') { $tmp = json_decode($ij, true); if (is_array($tmp)) $items = $tmp; }
    elseif (is_array($this->input->post('items'))) { $items = $this->input->post('items'); }

    if ($items === null) {
      $cj = $this->input->post('cart');
      if (is_string($cj) && $cj !== '') { $tmp = json_decode($cj, true); if (is_array($tmp)) $items = $tmp; }
      elseif (is_array($this->input->post('cart'))) { $items = $this->input->post('cart'); }
    }
    if ($items === null) {
      $raw = trim($this->input->raw_input_stream ?? '');
      if ($raw !== '') { $jb = json_decode($raw, true); if (is_array($jb)) { if (isset($jb['items']) && is_array($jb['items'])) $items = $jb['items']; elseif (isset($jb['cart']) && is_array($jb['cart'])) $items = $jb['cart']; } }
    }
    if (!is_array($items) || empty($items)) {
      $this->release_checkout_mutex();
      return $this->json_fail('items 格式錯誤或為空', 400);
    }

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

    $ids = array_map(fn($x)=>$x['item_idx'], $norm);
    $priceMap = $this->get_sku_prices_db($ids);
    foreach ($norm as $row) {
      $iid = $row['item_idx'];
      if (!isset($priceMap[$iid]) || $priceMap[$iid] <= 0) {
        $this->release_checkout_mutex();
        return $this->json_fail("商品未上架或無定價: {$iid}", 400);
      }
    }

    // GameDB 道具 meta（wSeal / max_stack / endtime）
    $metaMap = $this->web_item_dao->get_meta_map_by_ids($ids);

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

    $merged = []; $totalQty = 0;
    foreach ($norm as $row) { $iid=$row['item_idx']; $qty=$row['qty']; $merged[$iid]=($merged[$iid]??0)+$qty; $totalQty+=$qty; }
    foreach ($merged as $iid => $q) {
      if ($q > self::MAX_QTY_PER_ITEM) {
        $this->release_checkout_mutex();
        return $this->json_fail("超過單品數量上限: {$iid}", 400);
      }
    }

    $total = 0;
    foreach ($merged as $iid => $q) $total += (int)$priceMap[$iid] * (int)$q;
    if ($total <= 0) {
      $this->release_checkout_mutex();
      return $this->json_fail('total 金額錯誤', 400);
    }

    $sess_idx = $this->session->userdata('user_id');
    $sess_acc = $this->session->userdata('login_user_id');
    $q = $this->db->select('id_idx, id_loginid, mall_point')->from('dbo.chr_log_info');
    $q->group_start();
      if (ctype_digit((string)$sess_idx)) $q->or_where('id_idx', (int)$sess_idx);
      if ($sess_acc !== null && $sess_acc !== '') $q->or_where('id_loginid', (string)$sess_acc);
    $q->group_end();
    $acc = $q->limit(1)->get()->row_array();
    if (!$acc) { $this->release_checkout_mutex(); return $this->json_fail('account not found', 404); }

    $user_idx = (int)$acc['id_idx'];
    $before   = (int)$acc['mall_point'];
    $char_id  = $this->get_first_char_id($user_idx);

    $progress = ['verify'];
    $this->db->trans_begin();
    try {
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

      $ip = $this->input->ip_address();
      $mall_id = $this->mall_point_dao->insert_log(
        $user_idx, -$total, $before, $after, '商城結帳(DB 驗價)', $acc['id_loginid'], $ip
      );
      if (!is_int($mall_id) || $mall_id <= 0) throw new \RuntimeException('mall_point_log 新增失敗');

      $now = (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');
      $log_idx = $this->shop_log_dao->insert_item([
        'TYPE'=>1,'USER_IDX'=>$user_idx,'USER_ID'=>(string)$user_idx,
        'ITEM_IDX'=>0,'ITEM_DBIDX'=>0,'SIZE'=>$totalQty,'DATE'=>$now,
      ]);
      if ($log_idx === false) throw new \RuntimeException('shop_log 失敗');

      $batch = [];
      foreach ($merged as $iid => $qty) {
        $meta = $metaMap[(string)$iid] ?? ['wSeal'=>0,'max_stack'=>0];
        $seal     = (int)($meta['wSeal'] ?? 0);
        $stackMax = (int)($meta['max_stack'] ?? 0);

        if ($stackMax >= 2) {
          $remain = (int)$qty;
          while ($remain > 0) {
            $stackSize = ($remain >= $stackMax) ? $stackMax : $remain;
            $batch[] = [
              'CHARACTER_IDX'   => ($char_id > 0 ? $char_id : 0),
              'ITEM_IDX'        => (int)$iid,
              'ITEM_SHOPIDX'    => $user_idx,
              'ITEM_SHOPLOGIDX' => $log_idx,
              'mall_log_id'     => $mall_id,
              'ITEM_SEAL'       => $seal,
              'ITEM_DURABILITY' => $stackSize,
              'ITEM_POSITION'   => self::SHOP_BAG_POSITION,
            ];
            $remain -= $stackSize;
          }
        } else {
          for ($i=0; $i<$qty; $i++) {
            $batch[] = [
              'CHARACTER_IDX'   => ($char_id > 0 ? $char_id : 0),
              'ITEM_IDX'        => (int)$iid,
              'ITEM_SHOPIDX'    => $user_idx,
              'ITEM_SHOPLOGIDX' => $log_idx,
              'mall_log_id'     => $mall_id,
              'ITEM_SEAL'       => $seal,
              'ITEM_DURABILITY' => 0,
              'ITEM_POSITION'   => self::SHOP_BAG_POSITION,
            ];
          }
        }
      }

      if (!empty($batch)) {
        $aff = $this->item_dao->insert_items_batch($batch, self::BATCH_SIZE);
        if ($aff === false) throw new \RuntimeException('TB_ITEM 批次寫入失敗');
      }

      if (method_exists($this->item_dao, 'update_mall_log_id_by_shoplog')) {
        $this->item_dao->update_mall_log_id_by_shoplog($mall_id, $log_idx);
      }

      $progress[] = 'item';

      $this->db->trans_commit();
      $this->release_checkout_mutex();
      $progress[] = 'done';

      return $this->json_ok([
        'msg'          => 'checkout ok (db-priced)',
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
