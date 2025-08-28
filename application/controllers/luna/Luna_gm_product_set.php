<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Luna_gm_product_set extends MY_Base_Controller {

  private $excel_file;
  private $cache_file;

  public function __construct() {
    parent::__construct();
    $this->excel_file = FCPATH . 'assets/luna/itemlistcn.xlsx';
    $this->cache_file = APPPATH . 'cache/itemlistcn.cache.json';

    $this->load->model('/luna/Members_dao', 'dao');  
    $this->load->model('/luna/Shop_log_dao', 'shop_log_dao');
    $this->load->model('/luna/Item_dao', 'item_dao');
    $this->load->model('/luna/CHARACTER_dao', 'charDao');
    $this->load->model('/luna/Item_log_dao', 'item_log_dao');
    $this->load->model('/luna/mall_point_log_dao', 'mall_point_dao');
  }

  /* ========================== 共用/小工具 ========================== */

  /** 以帳號或 USER_IDX 解析帳號，回傳 ['ok'=>bool, 'id_idx'=>int, 'id_loginid'=>string, 'row'=>array|null, 'msg'=>string] */
  private function resolve_account($user_id_raw, $user_idx_raw) {
    $user_id = trim((string)$user_id_raw);
    $user_idx_str = trim((string)$user_idx_raw);

    // 兩者皆空
    if ($user_id === '' && $user_idx_str === '') {
      return ['ok'=>false, 'msg'=>'請輸入帳號或 USER_IDX'];
    }

    // 若 user_idx 是純數字，優先用它
    if ($user_idx_str !== '' && ctype_digit($user_idx_str)) {
      $uid = (int)$user_idx_str;
      $row = $this->db->select('id_idx, id_loginid, UserLevel, mall_point')
                      ->from('dbo.chr_log_info')
                      ->where('id_idx', $uid)
                      ->get()->row_array();
      if (!$row) return ['ok'=>false,'msg'=>'找不到此用戶（USER_IDX）'];
      return ['ok'=>true, 'id_idx'=>(int)$row['id_idx'], 'id_loginid'=>$row['id_loginid'], 'row'=>$row];
    }

    // 否則用英數帳號 id_loginid
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

    $this->load->view('luna/luna_gm_product_set', $data);
  }

  /* ========================== Excel 讀取 ========================== */

  private function load_all_items() {
    if (!file_exists($this->excel_file)) return ['items' => [], 'mtime' => 0];

    $xlsx_mtime = filemtime($this->excel_file);
    $CACHE_VER = 5;

    if (file_exists($this->cache_file)) {
      $cache = json_decode(@file_get_contents($this->cache_file), true);
      if (is_array($cache)
        && isset($cache['mtime']) && intval($cache['mtime']) === $xlsx_mtime
        && isset($cache['ver']) && intval($cache['ver']) === $CACHE_VER) {
        return ['items' => $cache['items'] ?? [], 'mtime' => $xlsx_mtime];
      }
    }

    $reader = IOFactory::createReaderForFile($this->excel_file);
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($this->excel_file);
    $sheet = $spreadsheet->getActiveSheet();

    $colLetters = [
      'code'       => 'A',
      'name'       => 'B',
      'sellstatus' => 'O',
      'endtime'    => 'BG',
      'cate'       => 'BL',
      'max_stack'  => 'M',
    ];
    $colIndex = [];
    foreach ($colLetters as $k => $letter) {
      $colIndex[$k] = Coordinate::columnIndexFromString($letter);
    }

    $categoryMap = [
      0=>'武器', 1=>'盾牌', 2=>'衣服', 3=>'帽子', 4=>'手套', 5=>'鞋子',
      6=>'戒指1', 7=>'戒指2', 8=>'項鍊', 9=>'耳環1', 10=>'耳環2',
      11=>'腰帶', 12=>'臂章', 13=>'眼鏡', 14=>'面具', 15=>'翅膀',
      16=>'時裝頭飾', 17=>'時裝衣服', 18=>'時裝手套', 19=>'時裝鞋子'
    ];

    $highestRow = $sheet->getHighestRow();
    $items = [];
    $startRow = 1;

    for ($r = $startRow; $r <= $highestRow; $r++) {
      $code = trim((string)$sheet->getCellByColumnAndRow($colIndex['code'], $r)->getCalculatedValue());
      $name = trim((string)$sheet->getCellByColumnAndRow($colIndex['name'], $r)->getCalculatedValue());

      $cellO = $sheet->getCellByColumnAndRow($colIndex['sellstatus'], $r);
      $oVal  = $cellO ? $cellO->getValue() : null;
      if ($oVal === null || $oVal === '') $oVal = $cellO ? $cellO->getCalculatedValue() : null;
      $sellstatus = (is_null($oVal) || trim((string)$oVal) === '') ? null
                   : (is_numeric($oVal) ? (float)$oVal : trim((string)$oVal));

      $cellBG = $sheet->getCellByColumnAndRow($colIndex['endtime'], $r);
      $bgVal  = $cellBG ? $cellBG->getValue() : null;
      if ($bgVal === null || $bgVal === '') $bgVal = $cellBG ? $cellBG->getCalculatedValue() : null;
      $endtime = null;
      if ($bgVal !== null && $bgVal !== '') {
        if (is_numeric($bgVal)) {
          $endtime = (int)round($bgVal);
        } else {
          $s = trim((string)$bgVal);
          if (function_exists('mb_convert_kana')) $s = mb_convert_kana($s, 'n', 'UTF-8');
          $s = preg_replace('/[^0-9\-]/u', '', $s);
          if ($s !== '' && $s !== '-' && preg_match('/^-?\d+$/', $s)) {
            $endtime = (int)$s;
          }
        }
      }

      $cellBL = $sheet->getCellByColumnAndRow($colIndex['cate'], $r);
      $blVal  = $cellBL ? $cellBL->getValue() : null;
      if ($blVal === null || $blVal === '') $blVal = $cellBL ? $cellBL->getCalculatedValue() : null;
      $cateNum = -1;
      if ($blVal !== null && trim((string)$blVal) !== '') {
        $s = (string)$blVal;
        $s = preg_replace('/\s+/u', '', $s);
        if (function_exists('mb_convert_kana')) $s = mb_convert_kana($s, 'n', 'UTF-8');
        if (preg_match('/-?\d+/', $s, $m)) {
          $cateNum = (int)$m[0];
        }
      }
      $cateZh = $categoryMap[$cateNum] ?? '未分類';

      $cellM = $sheet->getCellByColumnAndRow($colIndex['max_stack'], $r);
      $mVal  = $cellM ? $cellM->getValue() : null;
      if ($mVal === null || $mVal === '') $mVal = $cellM ? $cellM->getCalculatedValue() : null;
      $max_stack = (is_numeric($mVal) && (int)$mVal > 0) ? (int)$mVal : 0;

      if ($code === '' && $name === '' && is_null($sellstatus) && is_null($endtime) && $cateNum === -1 && $max_stack === 0) {
        continue;
      }

      $item_seal = ($cateNum === 34 || ($endtime !== null && $endtime > 0)) ? 1 : 0;

      $items[] = [
        'product_code'  => $code,
        'name'          => $name,
        'sellstatus'    => $sellstatus,
        'endtime'       => $endtime,
        'category'      => $cateZh,
        'category_code' => $cateNum,
        'item_seal'     => $item_seal,
        'max_stack'     => $max_stack,
      ];
    }

    @file_put_contents($this->cache_file, json_encode([
      'ver'   => $CACHE_VER,
      'mtime' => $xlsx_mtime,
      'items' => $items
    ], JSON_UNESCAPED_UNICODE));

    return ['items' => $items, 'mtime' => $xlsx_mtime];
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
    } catch (Throwable $e) {
      $this->db->trans_rollback();
      echo json_encode(['success'=>false,'msg'=>'處理失敗：'.$e->getMessage(),'results'=>$results], JSON_UNESCAPED_UNICODE);
    }
  }

  public function balance() {
    $this->output->set_content_type('application/json');

    if (empty($this->session->userdata('user_id'))) {
      return $this->output->set_status_header(401)
        ->set_output(json_encode(['ok'=>false,'msg'=>'not login']));
    }

    $s_data    = $this->setup_user_data([]);
    $login_id  = $s_data['login_user_id'] ?? '';
    $sess_uid  = $this->session->userdata('user_id');

    $this->db->select('id_idx, mall_point')->from('dbo.chr_log_info');
    if ($login_id !== '') $this->db->or_where('id_loginid', $login_id);
    if (is_numeric($sess_uid)) $this->db->or_where('id_idx', (int)$sess_uid);
    $this->db->limit(1);
    $row = $this->db->get()->row_array();

    if (!$row) {
      return $this->output->set_status_header(404)
        ->set_output(json_encode(['ok'=>false,'msg'=>'account not found']));
    }

    $resp = [
      'ok'=>true,
      'user_idx'=>(int)$row['id_idx'],
      'mall_point'=>(int)$row['mall_point'],
      'ts'=>time(),
      'csrf'=>[
        'name'=>$this->security->get_csrf_token_name(),
        'hash'=>$this->security->get_csrf_hash(),
      ],
    ];
    return $this->output->set_output(json_encode($resp, JSON_UNESCAPED_UNICODE));
  }

  /* ========================== 商品列表 ========================== */

  public function get_data() {
    $this->output->set_content_type('application/json');

    $page  = max(1, (int)$this->input->post('page'));
    $q     = trim((string)$this->input->post('q'));
    $limit = 10;

    if (!file_exists($this->excel_file)) {
      echo json_encode([
        'items'=>[], 'total'=>0, 'page'=>1, 'total_page'=>1,
        'error'=>'Excel 檔案不存在：'.$this->excel_file
      ]);
      return;
    }

    try {
      $pack = $this->load_all_items();
      $items = $pack['items'];

      if ($q !== '') {
        $needle = mb_strtolower($q, 'UTF-8');
        $items = array_values(array_filter($items, function($it) use ($needle){
          $a = mb_strtolower((string)($it['product_code'] ?? ''), 'UTF-8');
          $b = mb_strtolower((string)($it['name'] ?? ''), 'UTF-8');
          $c = mb_strtolower((string)($it['category'] ?? ''), 'UTF-8');
          return (strpos($a, $needle) !== false) ||
                 (strpos($b, $needle) !== false) ||
                 (strpos($c, $needle) !== false);
        }));
      }

      $total = count($items);
      $total_page = max(1, (int)ceil($total / $limit));
      $page = min($page, $total_page);

      $offset = ($page - 1) * $limit;
      $paged_items = array_slice($items, $offset, $limit);

      echo json_encode([
        'items'=>$paged_items,
        'total'=>$total,
        'page'=>$page,
        'total_page'=>$total_page,
      ]);
    } catch (\Throwable $e) {
      echo json_encode([
        'items'=>[], 'total'=>0, 'page'=>1, 'total_page'=>1,
        'error'=>'讀取失敗：'.$e->getMessage()
      ]);
    }
  }

  /* ========================== 發送物品 ========================== */

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

      $shopIdxForMode    = (int)$user_idx;
      $logUserIdxForMode = (int)$user_idx;
    } else {
      $chars = array_values(array_filter(array_map(function($v){
        $v = trim($v);
        return ($v !== '' && ctype_digit($v)) ? $v : null;
      }, explode(',', $char_raw))));
      if (empty($chars)) { echo json_encode(['success'=>false,'msg'=>'請輸入至少 1 個角色 ID']); return; }
      $shopIdxForMode = 0;
    }

    $pack = $this->load_all_items();
    $itemMap = [];
    foreach ($pack['items'] as $it) {
      $itemMap[(string)$it['product_code']] = $it;
    }

    $results = [];
    foreach ($chars as $charIdx) {
      foreach ($items as $itemIdx) {
        $this->db->trans_begin();

        $logUserIdx = ($send_mode === 'shop_bag') ? $logUserIdxForMode : (int)$charIdx;
        $log_data = [
          'TYPE'=>0,'USER_IDX'=>$logUserIdx,'USER_ID'=>(string)$logUserIdx,
          'ITEM_IDX'=>(int)$itemIdx,'ITEM_DBIDX'=>(int)$itemIdx,'SIZE'=>(int)$qty,'DATE'=>$now,
        ];
        $log_idx = $this->shop_log_dao->insert_item($log_data);
        if ($log_idx === false) {
          $this->db->trans_rollback();
          $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'ok'=>0,'ng'=>$qty,'msg'=>'寫入日誌失敗'];
          continue;
        }

        $key = (string)$itemIdx;
        $item_seal = isset($itemMap[$key]) ? ($itemMap[$key]['item_seal'] ?? 0) : 0;
        $max_stack = isset($itemMap[$key]) ? ($itemMap[$key]['max_stack'] ?? 0) : 0;

        $ok = 0; $ng = 0; $remain = $qty;

        if ($max_stack > 0) {
          while ($remain > 0) {
            $stackSize = ($remain >= $max_stack) ? $max_stack : $remain;
            $row = [
              'CHARACTER_IDX'=>(int)$charIdx,
              'ITEM_IDX'=>(int)$itemIdx,
              'ITEM_SHOPIDX'=>$shopIdxForMode,
              'ITEM_SHOPLOGIDX'=>$log_idx,
              'ITEM_SEAL'=>$item_seal,
              'ITEM_DURABILITY'=>$stackSize,
            ];
            $ret = $this->item_dao->insert_item($row);
            if ($ret) { $ok++; } else { $ng++; }
            $remain -= $stackSize;
          }
        } else {
          for ($i=0; $i<$remain; $i++) {
            $row = [
              'CHARACTER_IDX'=>(int)$charIdx,
              'ITEM_IDX'=>(int)$itemIdx,
              'ITEM_SHOPIDX'=>$shopIdxForMode,
              'ITEM_SHOPLOGIDX'=>$log_idx,
              'ITEM_SEAL'=>$item_seal,
              'ITEM_DURABILITY'=>0,
            ];
            $ret = $this->item_dao->insert_item($row);
            if ($ret) { $ok++; } else { $ng++; }
          }
        }

        if ($ng > 0) {
          $this->db->trans_rollback();
          $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'log_idx'=>$log_idx,'ok'=>0,'ng'=>$qty,'msg'=>'TB_ITEM 寫入失敗'];
        } else {
          $this->db->trans_commit();
          $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'log_idx'=>$log_idx,'ok'=>$ok,'ng'=>0];
        }
      }
    }

    $anyFail = array_reduce($results, fn($c,$r)=>$c || ($r['ng']>0), false);
    echo json_encode([
      'success'=>!$anyFail,
      'msg'=>$anyFail ? '部分失敗，請查看 results' : '發送完成',
      'results'=>$results
    ]);
  }

  /* ========================== 帳號/角色查詢（支援帳號或USER_IDX） ========================== */

  public function characters_by_user() {
    $this->output->set_content_type('application/json');

    $key_id  = $this->input->post('user_id', true);   // 英數帳號（可空）
    $key_idx = $this->input->post('user_idx', true);  // 純數字（可空）

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
      // 取舊值
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
  // 你原本就有 /application/models/CHARACTER_dao.php，以下為參考放法
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
    $row=$this->db->query("SELECT id_idx,id_loginid,UserLevel,mall_point FROM dbo.chr_log_info WHERE id_idx=?",[intval($key)])->row_array();
  }else{
    $row=$this->db->query("SELECT id_idx,id_loginid,UserLevel,mall_point FROM dbo.chr_log_info WHERE id_loginid=?",[ $key ])->row_array();
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
