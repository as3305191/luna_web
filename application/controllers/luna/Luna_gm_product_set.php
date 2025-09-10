<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Luna_gm_product_set extends MY_Base_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->model('/luna/Members_dao', 'dao');
    $this->load->model('/luna/Shop_log_dao', 'shop_log_dao');
    $this->load->model('/luna/Item_dao', 'item_dao');
    $this->load->model('/luna/CHARACTER_dao', 'charDao');
    $this->load->model('/luna/Item_log_dao', 'item_log_dao');
    $this->load->model('/luna/Mall_point_log_dao', 'mall_point_dao');

    // 重要：所有商品清單與 meta 都走這兩個 DAO（它們內部各自處理該用哪個 DB 連線）
    $this->load->model('/luna/Web_itemshop_dao', 'web_itemshop_dao');
    $this->load->model('/luna/Web_item_dao', 'web_item_dao');
  }

  /* ========================== 共用/小工具 ========================== */

  /** 以帳號或 USER_IDX 解析帳號 */
  private function resolve_account($user_id_raw, $user_idx_raw) {
    $user_id = trim((string)$user_id_raw);
    $user_idx_str = trim((string)$user_idx_raw);

    if ($user_id === '' && $user_idx_str === '') {
      return ['ok'=>false, 'msg'=>'請輸入帳號或 USER_IDX'];
    }

    if ($user_idx_str !== '' && ctype_digit($user_idx_str)) {
      $uid = (int)$user_idx_str;
      $row = $this->db->select('id_idx, id_loginid, UserLevel, mall_point')
                      ->from('dbo.chr_log_info')
                      ->where('id_idx', $uid)
                      ->get()->row_array();
      if (!$row) return ['ok'=>false,'msg'=>'找不到此用戶（USER_IDX）'];
      return ['ok'=>true, 'id_idx'=>(int)$row['id_idx'], 'id_loginid'=>$row['id_loginid'], 'row'=>$row];
    }

    if ($user_id !== '' && preg_match('/^[A-Za-z0-9]+$/', $user_id)) {
      $row = $this->db->select('id_idx, id_loginid, UserLevel, mall_point')
                      ->from('dbo.chr_log_info')
                      ->where('id_loginid', $user_id)
                      ->get()->row_array();
      if (!$row) return ['ok'=>false,'msg'=>'找不到此帳號（id_loginid）'];
      return ['ok'=>true, 'id_idx'=>(int)$row['id_idx'], 'id_loginid'=>$row['id_loginid'], 'row'=>$row];
    }

    return ['ok'=>false,'msg'=>'帳號需為英數，或提供純數字的 USER_IDX'];
  }

  /** 僅 GM 可用 */
  private function require_gm() {
    if (empty($this->session->userdata('user_id'))) {
      $this->output->set_status_header(401)->set_content_type('application/json')
        ->set_output(json_encode(['ok'=>false,'msg'=>'尚未登入'], JSON_UNESCAPED_UNICODE));
      return false;
    }
    if ($this->session->userdata('userlv') !== '2') {
      $this->output->set_status_header(403)->set_content_type('application/json')
        ->set_output(json_encode(['ok'=>false,'msg'=>'權限不足'], JSON_UNESCAPED_UNICODE));
      return false;
    }
    return true;
  }

  /** 確保 CSRF cookie 與 token 已產生 */
  private function ensure_csrf() {
    $cookie = method_exists($this->security,'get_csrf_cookie_name')
      ? $this->security->get_csrf_cookie_name()
      : $this->config->item('csrf_cookie_name');

    if (!$this->input->cookie($cookie)) {
      if (method_exists($this->security, 'csrf_set_cookie')) {
        $this->security->csrf_set_cookie();
      }
    }
    return [
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
    ];
  }

  /* ========================== Page ========================== */

  public function index() {
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login"); return;
    }
    if ($this->session->userdata('userlv') !== '2') {
      redirect("/luna/luna_home"); return;
    }
    $s_data = $this->setup_user_data([]);
    $login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');

    $data = [];
    $data['login_user'] = $login_user;
    $data['userlv']     = $login_user ? ($login_user->UserLevel ?? 0) : 0;
    $data['now']        = 'luna_gm_product_set';
    $data['csrf_name']  = $this->security->get_csrf_token_name();
    $data['csrf_hash']  = $this->security->get_csrf_hash();
    $data['content_view'] = 'luna/gm_product_set_content'; // 中間內容 view
    $this->load->view('luna/luna_layout', $data);
  }

  /* ========================== 建立/點數 ========================== */

  public function create_user() {
    $this->output->set_content_type('application/json');
    if (!$this->require_gm()) return;

    $login     = trim((string)$this->input->post('login', true));
    $password  = trim((string)$this->input->post('password', true));
    $userLevel = (int)$this->input->post('userLevel', true);
    if (!in_array($userLevel, [2,6], true)) $userLevel = 6;

    if (!preg_match('/^[A-Za-z0-9]{6,}$/', $login)) {
      return $this->output->set_output(json_encode(['ok'=>false,'msg'=>'帳號需為英數且至少 6 碼']));
    }
    if (!preg_match('/^[A-Za-z0-9]{6,}$/', $password)) {
      return $this->output->set_output(json_encode(['ok'=>false,'msg'=>'密碼需為英數且至少 6 碼']));
    }

    $dup = $this->db->query("
      SELECT 1 FROM LUNA_MEMBERDB_2025.dbo.chr_log_info WITH (NOLOCK)
      WHERE id_loginid = ?
    ", [$login])->row_array();
    if ($dup) return $this->output->set_output(json_encode(['ok'=>false,'msg'=>'帳號已存在']));

    $this->db->trans_begin();
    try {
      $row = $this->db->query("
        SELECT ISNULL(MAX(id_idx), 0) + 1 AS next_id
        FROM LUNA_MEMBERDB_2025.dbo.chr_log_info WITH (TABLOCKX, HOLDLOCK)
      ")->row();
      $nextId = $row ? (int)$row->next_id : 0;
      if ($nextId <= 0) throw new \RuntimeException('取得新 id 失敗');

      $ok = $this->db->query("
        INSERT INTO LUNA_MEMBERDB_2025.dbo.chr_log_info
          (id_idx, propid, id_loginid, id_passwd, UserLevel)
        VALUES (?, ?, ?, ?, ?)
      ", [$nextId, $nextId, $login, $password, $userLevel]);

      if (!$ok) {
        $err = $this->db->error();
        throw new \RuntimeException('建立失敗：'.$err['code'].' '.$err['message']);
      }

      $this->db->trans_commit();
      return $this->output->set_output(json_encode([
        'ok'=>true,'msg'=>'建立成功','id_idx'=>$nextId,'propid'=>$nextId,'login'=>$login,'userLevel'=>$userLevel
      ]));
    } catch (\Throwable $e) {
      $this->db->trans_rollback();
      return $this->output->set_output(json_encode(['ok'=>false,'msg'=>$e->getMessage()]));
    }
  }

  /** 發點數（以 id_loginid 英數帳號） */
  public function grant_points() {
    $this->output->set_content_type('application/json');

    $login_ids_raw = $this->input->post('user_ids', true);
    $amount        = (int)$this->input->post('amount', true);
    $memo          = trim((string)$this->input->post('memo', true));

    if ($amount === 0 || abs($amount) > 100000000) {
      echo json_encode(['success'=>false,'msg'=>'點數必須在 -100000000 ~ 100000000，且不可為 0']); return;
    }
    if (empty($login_ids_raw)) {
      echo json_encode(['success'=>false,'msg'=>'請輸入至少一個有效的帳號（id_loginid）']); return;
    }

    $parts = preg_split('/[\s,，\r\n]+/u', $login_ids_raw, -1, PREG_SPLIT_NO_EMPTY);
    $idlogins = [];
    foreach ($parts as $p) {
      $p = trim($p);
      if (preg_match('/^[A-Za-z0-9]+$/', $p)) $idlogins[$p] = true;
    }
    $idlogins = array_keys($idlogins);
    if (empty($idlogins)) {
      echo json_encode(['success'=>false,'msg'=>'沒有有效的英數帳號（id_loginid）']); return;
    }

    $s_data        = $this->setup_user_data([]);
    $admin_loginid = $s_data['login_user_id'] ?? '';
    $admin_ip      = $this->input->ip_address();

    $results = [];
    $this->db->trans_begin();
    try {
      foreach ($idlogins as $login) {
        $row = $this->db->query("
          SELECT id_idx, mall_point FROM dbo.chr_log_info WITH (UPDLOCK, ROWLOCK)
          WHERE id_loginid = ?
        ", [$login])->row_array();

        if (!$row) { $results[] = ['user_id'=>$login, 'ok'=>false, 'msg'=>'帳號不存在(id_loginid)']; continue; }

        $uid    = (int)$row['id_idx'];
        $before = (int)$row['mall_point'];
        $after  = $before + $amount;
        if ($after < 0) { $results[] = ['user_id'=>$login, 'ok'=>false, 'before'=>$before, 'after_try'=>$after, 'msg'=>'扣點後會變負數']; continue; }
        if ($after > 2147483647) { $results[] = ['user_id'=>$login, 'ok'=>false, 'before'=>$before, 'after_try'=>$after, 'msg'=>'超過 INT 上限']; continue; }

        $this->db->query("
          UPDATE dbo.chr_log_info
          SET mall_point = mall_point + ?
          WHERE id_loginid = ?
            AND mall_point + ? >= 0
            AND mall_point + ? <= 2147483647
        ", [$amount, $login, $amount, $amount]);

        if ($this->db->affected_rows() < 1) {
          $results[] = ['user_id'=>$login, 'ok'=>false, 'before'=>$before, 'msg'=>'點數變動衝突或不符限制']; continue;
        }

        $okLog = $this->mall_point_dao->insert_log($uid, $amount, $before, $after, $memo, $admin_loginid, $admin_ip);

        $results[] = [
          'user_id'=>$login,'user_idx'=>$uid,'ok'=>true,
          'before'=>$before,'after'=>$after,'log_ok'=>(bool)$okLog,
          'action'=> ($amount>0?'加點':'扣點'),'amount'=>$amount
        ];
      }

      $any_ok = array_reduce($results, fn($acc,$r)=> $acc || !empty($r['ok']), false);
      if (!$any_ok) throw new Exception('全部失敗，已回滾。');

      $this->db->trans_commit();
      echo json_encode(['success'=>true,'msg'=>'發送點數完成（以 id_loginid 比對）','results'=>$results], JSON_UNESCAPED_UNICODE);
    } catch (\Throwable $e) {
      $this->db->trans_rollback();
      echo json_encode(['success'=>false,'msg'=>'處理失敗：'.$e->getMessage(),'results'=>$results], JSON_UNESCAPED_UNICODE);
    }
  }

  /** 查餘額 */
  public function balance() {
    $this->output->set_content_type('application/json');

    $csrf_cookie = method_exists($this->security, 'get_csrf_cookie_name')
      ? $this->security->get_csrf_cookie_name()
      : $this->config->item('csrf_cookie_name');

    if (!$this->input->cookie($csrf_cookie)) {
      if (method_exists($this->security, 'csrf_set_cookie')) {
        $this->security->csrf_set_cookie();
      }
    }

    $method = strtoupper($this->input->method(TRUE));

    if (empty($this->session->userdata('user_id'))) {
      return $this->output->set_status_header(401)
        ->set_output(json_encode([
          'ok' => false,
          'msg'=> 'not login',
          'csrf_name' => $this->security->get_csrf_token_name(),
          'csrf_hash' => $this->security->get_csrf_hash(),
        ], JSON_UNESCAPED_UNICODE));
    }

    if ($method === 'POST') {
      $tokenName = $this->security->get_csrf_token_name();
      $tokenPost = $this->input->post($tokenName, false);
      $tokenHead = $this->input->get_request_header('X-CSRF-Token', true);
      $validHash = $this->security->get_csrf_hash();

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

      if (!$csrf_ok) {
        return $this->output->set_status_header(403)
          ->set_output(json_encode([
            'ok' => false,
            'msg'=> 'CSRF 驗證失敗',
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
          ], JSON_UNESCAPED_UNICODE));
      }
    } else if ($method !== 'GET' && $method !== 'OPTIONS') {
      return $this->output->set_status_header(405)
        ->set_output(json_encode([
          'ok' => false,
          'msg'=> 'method not allowed',
          'csrf_name' => $this->security->get_csrf_token_name(),
          'csrf_hash' => $this->security->get_csrf_hash(),
        ], JSON_UNESCAPED_UNICODE));
    }

    $s_data    = $this->setup_user_data([]);
    $login_id  = $s_data['login_user_id'] ?? '';
    $sess_uid  = $this->session->userdata('user_id');

    $this->db->select('id_idx, mall_point')
            ->from('dbo.chr_log_info')
            ->group_start();

    $added = false;
    if ($login_id !== '') {
      $this->db->where('id_loginid', (string)$login_id);
      $added = true;
    }
    if (is_numeric($sess_uid)) {
      if ($added) $this->db->or_where('id_idx', (int)$sess_uid);
      else        $this->db->where('id_idx', (int)$sess_uid);
    }
    $this->db->group_end()->limit(1);

    $row = $this->db->get()->row_array();

    if (!$row) {
      return $this->output->set_status_header(404)
        ->set_output(json_encode([
          'ok' => false,
          'msg'=> 'account not found',
          'csrf_name' => $this->security->get_csrf_token_name(),
          'csrf_hash' => $this->security->get_csrf_hash(),
        ], JSON_UNESCAPED_UNICODE));
    }

    return $this->output->set_output(json_encode([
      'ok' => true,
      'user_idx'   => (int)$row['id_idx'],
      'mall_point' => (int)$row['mall_point'],
      'ts'         => time(),
      'csrf_name'  => $this->security->get_csrf_token_name(),
      'csrf_hash'  => $this->security->get_csrf_hash(),
    ], JSON_UNESCAPED_UNICODE));
  }

  /* ========================== 商品列表（改用 DAO，不綁 Controller 的 DB） ========================== */

  public function get_data() {
    $this->output->set_content_type('application/json');

    $page  = max(1, (int)$this->input->post('page'));
    $q     = trim((string)$this->input->post('q'));
    $limit = 10;

    // 直接用 Web_item_dao，內部會走對的連線與表名
    $pack = $this->web_item_dao->search_paginated($q, $limit, $page);

    echo json_encode([
      'items'      => $pack['items'],
      'total'      => $pack['total'],
      'page'       => $pack['page'],
      'total_page' => $pack['total_page'],
    ], JSON_UNESCAPED_UNICODE);
  }

  /* ========================== 發送物品（固定 ITEM_POSITION=320） ========================== */

  public function insert() {
    $this->output->set_content_type('application/json');

    $now = (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');

    $send_mode = trim((string)$this->input->post('send_mode')) ?: 'char_bag';
    $user_idx  = (int)$this->input->post('user_idx');
    $char_raw  = str_replace('，', ',', (string)$this->input->post('character_idx'));
    $item_raw  = str_replace('，', ',', (string)$this->input->post('item_idx'));
    $qty       = (int)$this->input->post('qty');

    $items = array_values(array_filter(array_map(function($v){
      $v = trim($v);
      return ($v !== '' && ctype_digit($v)) ? $v : null;
    }, explode(',', $item_raw))));

    if (empty($items) || $qty <= 0) {
      echo json_encode(['success'=>false,'msg'=>'參數錯誤：請確認 item_idx / qty']); return;
    }

    $chars = [];
    $shopIdxForMode = 0;
    $logUserIdxForMode = null;

    if ($send_mode === 'shop_bag') {
      if ($user_idx <= 0) { echo json_encode(['success'=>false,'msg'=>'shop_bag 需提供 user_idx']); return; }
      $list = $this->charDao->list_by_user($user_idx, false);
      if (empty($list)) { echo json_encode(['success'=>false,'msg'=>'此帳號底下沒有角色']); return; }
      $firstCharId = (int)$list[0]->CharId;
      $chars = [$firstCharId];

      $shopIdxForMode    = (int)$user_idx; // 商城包包 → 設為帳號的 USER_IDX
      $logUserIdxForMode = (int)$user_idx;
    } else {
      $chars = array_values(array_filter(array_map(function($v){
        $v = trim($v);
        return ($v !== '' && ctype_digit($v)) ? $v : null;
      }, explode(',', $char_raw))));
      if (empty($chars)) { echo json_encode(['success'=>false,'msg'=>'請輸入至少 1 個角色 ID']); return; }
      $shopIdxForMode = 0;
    }

    // 用 DAO 取 meta（不綁 Controller 的 DB）
    $metaMap = $this->web_item_dao->get_meta_map_by_ids(array_map('intval', $items));

    $results = [];
    foreach ($chars as $charIdx) {
      foreach ($items as $itemIdx) {

        $logUserIdx = ($send_mode === 'shop_bag') ? $logUserIdxForMode : (int)$charIdx;
        $log_data = [
          'TYPE'=>0,'USER_IDX'=>$logUserIdx,'USER_ID'=>(string)$logUserIdx,
          'ITEM_IDX'=>(int)$itemIdx,'ITEM_DBIDX'=>(int)$itemIdx,'SIZE'=>(int)$qty,'DATE'=>$now,
        ];
        $log_idx = $this->shop_log_dao->insert_item($log_data);
        if ($log_idx === false) {
          $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'ok'=>0,'ng'=>$qty,'msg'=>'寫入日誌失敗'];
          continue;
        }

        $meta = $metaMap[(string)$itemIdx] ?? ['wSeal'=>0,'max_stack'=>0];
        $wSeal = (int)$meta['wSeal'];
        $max_stack = max(0, (int)$meta['max_stack']);

        $ok = 0; $ng = 0; $remain = $qty;

        $this->db->trans_begin();
        try {
          if ($max_stack > 0) {
            while ($remain > 0) {
              $stackSize = ($remain >= $max_stack) ? $max_stack : $remain;
              $row = [
                'CHARACTER_IDX'   => (int)$charIdx,
                'ITEM_IDX'        => (int)$itemIdx,
                'ITEM_SHOPIDX'    => $shopIdxForMode,
                'ITEM_SHOPLOGIDX' => $log_idx,
                'ITEM_SEAL'       => $wSeal,
                'ITEM_DURABILITY' => $stackSize,
                'ITEM_POSITION'   => 320,
              ];
              $ret = $this->item_dao->insert_item($row);
              $ret ? $ok++ : $ng++;
              $remain -= $stackSize;
            }
          } else {
            for ($i=0; $i<$remain; $i++) {
              $row = [
                'CHARACTER_IDX'   => (int)$charIdx,
                'ITEM_IDX'        => (int)$itemIdx,
                'ITEM_SHOPIDX'    => $shopIdxForMode,
                'ITEM_SHOPLOGIDX' => $log_idx,
                'ITEM_SEAL'       => $wSeal,
                'ITEM_DURABILITY' => 0,
                'ITEM_POSITION'   => 320,
              ];
              $ret = $this->item_dao->insert_item($row);
              $ret ? $ok++ : $ng++;
            }
          }

          if ($ng > 0) {
            $this->db->trans_rollback();
            $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'log_idx'=>$log_idx,'ok'=>0,'ng'=>$qty,'msg'=>'TB_ITEM 寫入失敗'];
          } else {
            $this->db->trans_commit();
            $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'log_idx'=>$log_idx,'ok'=>$ok,'ng'=>0];
          }
        } catch (\Throwable $e) {
          $this->db->trans_rollback();
          $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'log_idx'=>$log_idx,'ok'=>0,'ng'=>$qty,'msg'=>$e->getMessage()];
        }
      }
    }

    $anyFail = array_reduce($results, fn($c,$r)=>$c || ($r['ng']>0), false);
    echo json_encode([
      'success'=>!$anyFail,
      'msg'=>$anyFail ? '部分失敗，請查看 results' : '發送完成',
      'results'=>$results
    ], JSON_UNESCAPED_UNICODE);
  }

  /** 專用：發送到商城包包（固定 ITEM_POSITION=320，處理 wSeal 與 Stack） */
  public function send_shop_bag() {
    $this->output->set_content_type('application/json');
    if (!$this->require_gm()) return;

    $user_idx = (int)$this->input->post('user_idx');
    $item_idx = trim((string)$this->input->post('item_idx'));
    $qty      = (int)$this->input->post('qty');

    if ($user_idx <= 0 || $item_idx === '' || $qty <= 0) {
      echo json_encode(['ok'=>false,'msg'=>'參數錯誤：請提供 user_idx / item_idx / qty']); return;
    }

    $list = $this->charDao->list_by_user($user_idx, false);
    if (empty($list)) { echo json_encode(['ok'=>false,'msg'=>'此帳號沒有任何角色，無法投遞商城包包']); return; }
    $char_id = (int)$list[0]->CharId;

    $now = (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');

    $items = array_values(array_filter(array_map(function($v){
      $v = trim($v);
      return ($v !== '' && ctype_digit($v)) ? $v : null;
    }, preg_split('/[,\s]+/', str_replace('，', ',', $item_idx), -1, PREG_SPLIT_NO_EMPTY))));

    // 用 DAO 取 meta
    $metaMap = $this->web_item_dao->get_meta_map_by_ids(array_map('intval', $items));

    $results = [];

    foreach ($items as $iid) {
      $meta = $metaMap[(string)$iid] ?? ['wSeal'=>0,'max_stack'=>0];
      $wSeal     = (int)$meta['wSeal'];
      $max_stack = (int)$meta['max_stack'];

      $log_data = [
        'TYPE' => 0,
        'USER_IDX' => (int)$user_idx,
        'USER_ID'  => (string)$user_idx,
        'ITEM_IDX' => (int)$iid,
        'ITEM_DBIDX' => (int)$iid,
        'SIZE' => (int)$qty,
        'DATE' => $now,
      ];
      $log_idx = $this->shop_log_dao->insert_item($log_data);
      if ($log_idx === false) {
        $results[] = ['item'=>$iid, 'ok'=>false, 'msg'=>'寫入日誌失敗'];
        continue;
      }

      $remain = $qty; $ok=0; $ng=0;

      $this->db->trans_begin();
      try {
        if ($max_stack > 0) {
          while ($remain > 0) {
            $stackSize = ($remain >= $max_stack) ? $max_stack : $remain;
            $row = [
              'CHARACTER_IDX'   => $char_id,
              'ITEM_IDX'        => (int)$iid,
              'ITEM_SHOPIDX'    => (int)$user_idx,
              'ITEM_SHOPLOGIDX' => (int)$log_idx,
              'ITEM_SEAL'       => $wSeal,
              'ITEM_DURABILITY' => $stackSize,
              'ITEM_POSITION'   => 320,
            ];
            $ret = $this->item_dao->insert_item($row);
            $ret ? $ok++ : $ng++;
            $remain -= $stackSize;
          }
        } else {
          for ($i=0; $i<$remain; $i++) {
            $row = [
              'CHARACTER_IDX'   => $char_id,
              'ITEM_IDX'        => (int)$iid,
              'ITEM_SHOPIDX'    => (int)$user_idx,
              'ITEM_SHOPLOGIDX' => (int)$log_idx,
              'ITEM_SEAL'       => $wSeal,
              'ITEM_DURABILITY' => 0,
              'ITEM_POSITION'   => 320,
            ];
            $ret = $this->item_dao->insert_item($row);
            $ret ? $ok++ : $ng++;
          }
        }

        if ($ng > 0) {
          $this->db->trans_rollback();
          $results[] = ['item'=>$iid, 'ok'=>false, 'msg'=>'TB_ITEM 寫入失敗（部分/全部）'];
        } else {
          $this->db->trans_commit();
          $results[] = ['item'=>$iid, 'ok'=>true, 'count'=>$ok, 'seal'=>$wSeal, 'stack_max'=>$max_stack];
        }
      } catch (\Throwable $e) {
        $this->db->trans_rollback();
        $results[] = ['item'=>$iid, 'ok'=>false, 'msg'=>$e->getMessage()];
      }
    }

    $any_ok = array_reduce($results, fn($c,$r)=> $c || !empty($r['ok']), false);
    echo json_encode(['ok'=>$any_ok,'results'=>$results], JSON_UNESCAPED_UNICODE);
  }

  /** 多帳號英數、可多道具：固定 ITEM_POSITION=320 */
  public function send_shop_bag_multi() {
    $this->output->set_content_type('application/json');
    // if (!$this->require_gm()) return;

    $user_ids_raw = trim((string)$this->input->post('user_ids'));
    $item_raw     = trim((string)$this->input->post('item_idx'));
    $qty          = (int)$this->input->post('qty');

    if ($qty <= 0) { echo json_encode(['ok'=>false,'msg'=>'qty 需 > 0']); return; }

    $users = array_values(array_filter(array_map(function($s){
      $s = trim($s);
      return (preg_match('/^[A-Za-z0-9]+$/', $s)) ? $s : null;
    }, preg_split('/[\s,，]+/u', $user_ids_raw, -1, PREG_SPLIT_NO_EMPTY))));

    $items = array_values(array_filter(array_map(function($s){
      $s = trim($s);
      return (ctype_digit($s)) ? $s : null;
    }, preg_split('/[\s,，]+/u', $item_raw, -1, PREG_SPLIT_NO_EMPTY))));

    if (empty($users)) { echo json_encode(['ok'=>false,'msg'=>'請輸入至少 1 個有效英數帳號']); return; }
    if (empty($items)) { echo json_encode(['ok'=>false,'msg'=>'請輸入至少 1 個有效商品編號']); return; }

    // 用 DAO 批次撈 meta
    $metaMap = $this->web_item_dao->get_meta_map_by_ids(array_map('intval', $items));

    $now = (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');
    $results = [];

    foreach ($users as $login) {
      $acc = $this->db->select('id_idx')
        ->from('dbo.chr_log_info')->where('id_loginid', $login)->get()->row_array();
      if (!$acc) {
        $results[] = ['user_id'=>$login, 'ok'=>false, 'msg'=>'帳號不存在', 'items'=>[]];
        continue;
      }
      $user_idx = (int)$acc['id_idx'];

      $char = $this->charDao->list_by_user($user_idx, false);
      if (empty($char)) {
        $results[] = ['user_id'=>$login, 'user_idx'=>$user_idx, 'ok'=>false, 'msg'=>'此帳號沒有角色', 'items'=>[]];
        continue;
      }
      $char_idx = (int)$char[0]->CharId;

      $userItemResults = [];
      $all_ok = true;

      foreach ($items as $itemIdx) {
        $meta     = $metaMap[(string)$itemIdx] ?? ['wSeal'=>0,'max_stack'=>0];
        $seal     = (int)$meta['wSeal'];
        $stackMax = (int)$meta['max_stack'];

        $log_data = [
          'TYPE'=>0,'USER_IDX'=>$user_idx,'USER_ID'=>(string)$user_idx,
          'ITEM_IDX'=>(int)$itemIdx,'ITEM_DBIDX'=>(int)$itemIdx,'SIZE'=>$qty,'DATE'=>$now,
        ];
        $log_idx = $this->shop_log_dao->insert_item($log_data);
        if ($log_idx === false) {
          $userItemResults[] = ['item'=>(int)$itemIdx,'ok'=>false,'msg'=>'寫入日誌失敗'];
          $all_ok = false;
          continue;
        }

        $okCount = 0; $need = $qty;

        $this->db->trans_begin();
        try {
          if ($stackMax > 0) {
            while ($need > 0) {
              $stackSize = ($need >= $stackMax) ? $stackMax : $need;
              $row = [
                'CHARACTER_IDX'   => $char_idx,
                'ITEM_IDX'        => (int)$itemIdx,
                'ITEM_SHOPIDX'    => $user_idx,
                'ITEM_SHOPLOGIDX' => $log_idx,
                'ITEM_SEAL'       => $seal,
                'ITEM_DURABILITY' => $stackSize,
                'ITEM_POSITION'   => 320,
              ];
              $ret = $this->item_dao->insert_item($row);
              if (!$ret) throw new \RuntimeException('TB_ITEM 寫入失敗');
              $okCount++;
              $need -= $stackSize;
            }
          } else {
            for ($i=0; $i<$need; $i++) {
              $row = [
                'CHARACTER_IDX'   => $char_idx,
                'ITEM_IDX'        => (int)$itemIdx,
                'ITEM_SHOPIDX'    => $user_idx,
                'ITEM_SHOPLOGIDX' => $log_idx,
                'ITEM_SEAL'       => $seal,
                'ITEM_DURABILITY' => 0,
                'ITEM_POSITION'   => 320,
              ];
              $ret = $this->item_dao->insert_item($row);
              if (!$ret) throw new \RuntimeException('TB_ITEM 寫入失敗');
              $okCount++;
            }
          }

          $this->db->trans_commit();
          $userItemResults[] = [
            'item'=>(int)$itemIdx,'ok'=>true,'count'=>$okCount,
            'seal'=>$seal,'stack_max'=>$stackMax
          ];
        } catch (\Throwable $e) {
          $this->db->trans_rollback();
          $userItemResults[] = [
            'item'=>(int)$itemIdx,'ok'=>false,'msg'=>$e->getMessage()
          ];
          $all_ok = false;
        }
      } // each item

      $results[] = [
        'user_id'=>$login,'user_idx'=>$user_idx,
        'ok'=>$all_ok,'items'=>$userItemResults
      ];
    } // each user

    $any_ok = array_reduce($results, fn($c,$u)=> $c || $u['ok'], false);
    echo json_encode(['ok'=>$any_ok, 'results'=>$results], JSON_UNESCAPED_UNICODE);
  }

  /* ========================== 帳號/角色查詢（支援帳號或USER_IDX） ========================== */

  public function characters_by_user() {
    $this->output->set_content_type('application/json');

    $key_id  = $this->input->post('user_id', true);
    $key_idx = $this->input->post('user_idx', true);

    $res = $this->resolve_account($key_id, $key_idx);
    if (!$res['ok']) {
      return $this->output->set_status_header(400)
        ->set_output(json_encode(['error'=>$res['msg']], JSON_UNESCAPED_UNICODE));
    }

    $user_idx = (int)$res['id_idx'];
    $list = $this->charDao->list_by_user($user_idx);
    $resp = [
      'input'      => ['user_id'=>$key_id, 'user_idx'=>$key_idx],
      'user_idx'   => $user_idx,
      'account'    => $res['id_loginid'],
      'count'      => is_array($list) ? count($list) : 0,
      'characters' => $list,
    ];
    return $this->output->set_output(json_encode($resp, JSON_UNESCAPED_UNICODE));
  }

  /* ========================== 帳號資訊 / 封鎖/解鎖/升權 ========================== */

  /** 查帳號資訊（id_idx, id_loginid, UserLevel, mall_point） */
  public function account_info() {
    $this->output->set_content_type('application/json');
    if (!$this->require_gm()) return;

    $key_id  = $this->input->post('user_id', true);
    $key_idx = $this->input->post('user_idx', true);

    $res = $this->resolve_account($key_id, $key_idx);
    if (!$res['ok']) {
      return $this->output->set_status_header(400)
        ->set_output(json_encode(['ok'=>false, 'msg'=>$res['msg']], JSON_UNESCAPED_UNICODE));
    }

    return $this->output->set_output(json_encode([
      'ok'=>true,
      'id_idx'=>$res['row']['id_idx'],
      'id_loginid'=>$res['row']['id_loginid'],
      'UserLevel'=>$res['row']['UserLevel'],
      'mall_point'=>$res['row']['mall_point'],
    ], JSON_UNESCAPED_UNICODE));
  }

  /**
   * 設定帳號等級（2=GM／4=封鎖／6=一般）
   * 傳入：user_id（英數帳號）或 user_idx（數字），target（2/4/6）
   */
  public function set_user_level() {
    $this->output->set_content_type('application/json');
    if (!$this->require_gm()) return;

    $key_id  = $this->input->post('user_id', true);
    $key_idx = $this->input->post('user_idx', true);
    $target  = (int)$this->input->post('target', true);

    if (!in_array($target, [2,4,6], true)) {
      return $this->output->set_status_header(400)
        ->set_output(json_encode(['ok'=>false,'msg'=>'target 僅能是 2(GM)/4(封鎖)/6(一般)'], JSON_UNESCAPED_UNICODE));
    }

    $res = $this->resolve_account($key_id, $key_idx);
    if (!$res['ok']) {
      return $this->output->set_status_header(404)
        ->set_output(json_encode(['ok'=>false, 'msg'=>$res['msg']], JSON_UNESCAPED_UNICODE));
    }

    $uid = (int)$res['id_idx'];

    $this->db->trans_begin();
    try {
      $old = $this->db->select('UserLevel')->from('dbo.chr_log_info')->where('id_idx', $uid)->get()->row_array();
      if (!$old) throw new \RuntimeException('帳號不存在');

      $this->db->where('id_idx', $uid)->update('dbo.chr_log_info', ['UserLevel'=>$target]);

      if ($this->db->affected_rows() < 1 && (int)$old['UserLevel'] !== $target) {
        throw new \RuntimeException('更新失敗');
      }

      $this->db->trans_commit();
      return $this->output->set_output(json_encode([
        'ok'=>true,
        'id_idx'=>$uid,
        'id_loginid'=>$res['id_loginid'],
        'before'=>(int)$old['UserLevel'],
        'after'=>$target,
        'msg'=> ($target===4?'已封鎖':($target===6?'已設定為一般玩家(6)':'已設定為GM(2)'))
      ], JSON_UNESCAPED_UNICODE));
    } catch (\Throwable $e) {
      $this->db->trans_rollback();
      return $this->output->set_status_header(500)
        ->set_output(json_encode(['ok'=>false,'msg'=>$e->getMessage()], JSON_UNESCAPED_UNICODE));
    }
  }

  /* ========================== 角色 DAO（示意） ========================== */
  public function list_by_user($user_idx) {
    $activeStates = [0];
    return $this->db->select('
            CHARACTER_IDX   AS CharId,
            USER_IDX        AS UserId,
            CHARACTER_NAME  AS CharName,
            CHARACTER_GRADE AS Level,
            CHARACTER_JOB   AS Job,
            CHARACTER_CURRENTMAP AS MapId,
            CHARACTER_STATE AS State,
            CHARACTER_LASTMODIFIED AS LastModified
        ')
        ->from('TB_CHARACTER')
        ->where('USER_IDX', (int)$user_idx)
        ->where_in('CHARACTER_STATE', $activeStates)
        ->order_by('CHARACTER_GRADE', 'DESC')
        ->order_by('CHARACTER_IDX',   'ASC')
        ->get()->result();
  }

  public function account_search(){
    $this->output->set_content_type('application/json');
    $key=trim((string)$this->input->post('key'));
    if($key===''){echo json_encode(['ok'=>false,'msg'=>'請輸入帳號或 USER_IDX']);return;}
    if(ctype_digit($key)){
      $row=$this->db->query("SELECT id_idx,id_loginid,UserLevel,mall_point FROM dbo.chr_log_info WHERE id_idx=?", [intval($key)])->row_array();
    }else{
      $row=$this->db->query("SELECT id_idx,id_loginid,UserLevel,mall_point FROM dbo.chr_log_info WHERE id_loginid=?", [$key])->row_array();
    }
    if(!$row){echo json_encode(['ok'=>false,'msg'=>'查無帳號']);return;}
    echo json_encode(['ok'=>true,'data'=>$row],JSON_UNESCAPED_UNICODE);
  }

  public function account_update(){
    $this->output->set_content_type('application/json');
    $id_idx=(int)$this->input->post('id_idx');
    $level=(int)$this->input->post('level');
    if(!$id_idx || !in_array($level,[2,4,6])){echo json_encode(['ok'=>false,'msg'=>'參數錯誤']);return;}
    $this->db->query("UPDATE dbo.chr_log_info SET UserLevel=? WHERE id_idx=?",[$level,$id_idx]);
    if($this->db->affected_rows()>0){echo json_encode(['ok'=>true]);}
    else{echo json_encode(['ok'=>false,'msg'=>'更新失敗']);}
  }
}
