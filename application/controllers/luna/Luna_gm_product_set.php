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
    $this->load->model('/luna/CHARACTER_dao', 'charDao'); // ✅ 新增
    $this->load->model('/luna/Item_log_dao', 'item_log_dao'); // ★ 新增：道具日誌（LOGDB）
    $this->load->model('/luna/mall_point_log_dao', 'mall_point_dao'); // ★ 新增：點數日誌（LOGDB）
  }

  public function index() {
    
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login"); return;
    }
    if ($this->session->userdata('userlv') !== '2') {
      redirect("/luna/luna_home"); return;
    }
    $s_data = $this->setup_user_data([]); // 你自訂的基底方法
		$login_user = $this->dao->find_by('id_loginid', $s_data['login_user_id'] ?? '');

		// 先建立 $data，再逐項增加，避免被覆蓋
		$data = [];
		$data['login_user'] = $login_user;
		$data['userlv']     = $login_user ? ($login_user->UserLevel ?? 0) : 0;
    $data['now'] = 'luna_gm_product_set';
    $this->load->view('luna/luna_gm_product_set', $data);
  }

/* ---------------- Excel 讀取（含 M 欄 max_stack） ---------------- */
private function load_all_items() {
  if (!file_exists($this->excel_file)) return ['items' => [], 'mtime' => 0];

  $xlsx_mtime = filemtime($this->excel_file);
  $CACHE_VER = 5; // ★ 升版避免吃舊 cache

  // 讀快取
  if (file_exists($this->cache_file)) {
    $cache = json_decode(@file_get_contents($this->cache_file), true);
    if (is_array($cache)
      && isset($cache['mtime']) && intval($cache['mtime']) === $xlsx_mtime
      && isset($cache['ver']) && intval($cache['ver']) === $CACHE_VER) {
      return ['items' => $cache['items'] ?? [], 'mtime' => $xlsx_mtime];
    }
  }

  // 讀 Excel
  $reader = IOFactory::createReaderForFile($this->excel_file);
  $reader->setReadDataOnly(true);
  $spreadsheet = $reader->load($this->excel_file);
  $sheet = $spreadsheet->getActiveSheet();

  // 欄位對應
  $colLetters = [
    'code'       => 'A',   // 物品代碼
    'name'       => 'B',   // 物品名稱
    'sellstatus' => 'O',   // 銷售狀態
    'endtime'    => 'BG',  // 到期/封印用數值
    'cate'       => 'BL',  // 類別（數字）
    'max_stack'  => 'M',   // ★ 可疊加上限
  ];
  $colIndex = [];
  foreach ($colLetters as $k => $letter) {
    $colIndex[$k] = Coordinate::columnIndexFromString($letter);
  }

  // 類別映射
  $categoryMap = [
    0=>'武器', 1=>'盾牌', 2=>'衣服', 3=>'帽子', 4=>'手套', 5=>'鞋子',
    6=>'戒指1', 7=>'戒指2', 8=>'項鍊', 9=>'耳環1', 10=>'耳環2',
    11=>'腰帶', 12=>'臂章', 13=>'眼鏡', 14=>'面具', 15=>'翅膀',
    16=>'時裝頭飾', 17=>'時裝衣服', 18=>'時裝手套', 19=>'時裝鞋子'
  ];

  $highestRow = $sheet->getHighestRow();
  $items = [];
  $startRow = 1; // 有表頭就改 2

  for ($r = $startRow; $r <= $highestRow; $r++) {
    // A: code
    $code = trim((string)$sheet->getCellByColumnAndRow($colIndex['code'], $r)->getCalculatedValue());
    // B: name
    $name = trim((string)$sheet->getCellByColumnAndRow($colIndex['name'], $r)->getCalculatedValue());

    // O: sellstatus
    $cellO = $sheet->getCellByColumnAndRow($colIndex['sellstatus'], $r);
    $oVal  = $cellO ? $cellO->getValue() : null;
    if ($oVal === null || $oVal === '') $oVal = $cellO ? $cellO->getCalculatedValue() : null;
    $sellstatus = (is_null($oVal) || trim((string)$oVal) === '') ? null
                 : (is_numeric($oVal) ? (float)$oVal : trim((string)$oVal));

    // BG: endtime
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

    // BL: cate
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

    // M: max_stack
    $cellM = $sheet->getCellByColumnAndRow($colIndex['max_stack'], $r);
    $mVal  = $cellM ? $cellM->getValue() : null;
    if ($mVal === null || $mVal === '') $mVal = $cellM ? $cellM->getCalculatedValue() : null;
    $max_stack = (is_numeric($mVal) && (int)$mVal > 0) ? (int)$mVal : 0;

    // 空列略過
    if ($code === '' && $name === '' && is_null($sellstatus) && is_null($endtime) && $cateNum === -1 && $max_stack === 0) {
      continue;
    }

    // ITEM_SEAL：BL=34 或 BG>0
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

  // 寫快取
  @file_put_contents($this->cache_file, json_encode([
    'ver'   => $CACHE_VER,
    'mtime' => $xlsx_mtime,
    'items' => $items
  ], JSON_UNESCAPED_UNICODE));

  return ['items' => $items, 'mtime' => $xlsx_mtime];
}


public function grant_points() {
  $this->output->set_content_type('application/json');

  // 取得傳入的資料
  $user_idx_raw = $this->input->post('user_idx', true);      // 逗號/換行分隔
  $amount       = (int)$this->input->post('amount', true);   // 點數，可正可負
  $memo         = trim((string)$this->input->post('memo', true)); // 備註

  // ✅ 驗證：允許負數（扣點），但不能是 0；限制幅度（避免誤操作）
  if ($amount === 0 || abs($amount) > 100000000) {
    echo json_encode(['success'=>false,'msg'=>'點數必須在 -100000000 ~ 100000000，且不可為 0']); return;
  }
  if (empty($user_idx_raw)) {
    echo json_encode(['success'=>false,'msg'=>'請輸入至少一個有效的 USER_IDX']); return;
  }

  // 解析帳號列表（僅保留純數字、去重）
  $parts = preg_split('/[\s,，\r\n]+/u', $user_idx_raw, -1, PREG_SPLIT_NO_EMPTY);
  $uids  = [];
  foreach ($parts as $p) if (preg_match('/^\d+$/', $p)) $uids[(int)$p] = true;
  $uids = array_keys($uids);
  if (empty($uids)) {
    echo json_encode(['success'=>false,'msg'=>'沒有有效的 USER_IDX']); return;
  }

  // 操作者資訊
  $s_data        = $this->setup_user_data([]);
  $admin_loginid = $s_data['login_user_id'] ?? '';
  $admin_ip      = $this->input->ip_address();

  $results = [];
  $this->db->trans_begin();
  try {
    foreach ($uids as $uid) {
      // 先鎖住該使用者行，避免併發（同交易期間有效）
      $row = $this->db->query("
        SELECT mall_point FROM dbo.chr_log_info WITH (UPDLOCK, ROWLOCK)
        WHERE id_idx = ?
      ", [$uid])->row_array();

      if (!$row) {
        $results[] = ['user_idx'=>$uid, 'ok'=>false, 'msg'=>'帳號不存在'];
        continue;
      }

      $before = (int)$row['mall_point'];
      $after  = $before + $amount;

      // ✅ 邏輯檢查：扣完不可 < 0；加完不可超過 int 上限
      if ($after < 0) {
        $results[] = ['user_idx'=>$uid, 'ok'=>false, 'before'=>$before, 'after_try'=>$after, 'msg'=>'扣點後會變負數，已跳過'];
        continue;
      }
      if ($after > 2147483647) {
        $results[] = ['user_idx'=>$uid, 'ok'=>false, 'before'=>$before, 'after_try'=>$after, 'msg'=>'加點超過 INT 上限'];
        continue;
      }

      // ✅ 原子更新（含守門條件，防止併發把餘額變負）
      $this->db->query("
        UPDATE dbo.chr_log_info
        SET mall_point = mall_point + ?
        WHERE id_idx = ?
          AND mall_point + ? >= 0
          AND mall_point + ? <= 2147483647
      ", [$amount, $uid, $amount, $amount]);

      if ($this->db->affected_rows() < 1) {
        // 可能併發被改過或條件不符
        $results[] = ['user_idx'=>$uid, 'ok'=>false, 'before'=>$before, 'msg'=>'點數變動衝突或不符合限制（可能被同時修改），已跳過'];
        continue;
      }

      // 記 log（允許負數）
      $okLog = $this->mall_point_dao->insert_log(
        $uid, $amount, $before, $after, $memo, $admin_loginid, $admin_ip
      );

      $results[] = [
        'user_idx'=>$uid, 'ok'=>true,
        'before'=>$before, 'after'=>$after,
        'log_ok'=>(bool)$okLog,
        'action'=> ($amount > 0 ? '加點' : '扣點'),
        'amount'=>$amount
      ];
    }

    $any_ok = array_reduce($results, fn($acc,$r)=> $acc || !empty($r['ok']), false);
    if (!$any_ok) throw new Exception('全部失敗，已回滾。');

    $this->db->trans_commit();
    echo json_encode([
      'success'=>true,
      'msg'    =>'發送點數處理完成（允許負數扣點；已確保扣完不為負）',
      'results'=>$results
    ], JSON_UNESCAPED_UNICODE);
  } catch (Throwable $e) {
    $this->db->trans_rollback();
    echo json_encode([
      'success'=>false,
      'msg'    =>'處理失敗：' . $e->getMessage(),
      'results'=>$results
    ], JSON_UNESCAPED_UNICODE);
  }
}


public function balance() {
  $this->output->set_content_type('application/json');

  // 未登入
  if (empty($this->session->userdata('user_id'))) {
    return $this->output->set_status_header(401)
      ->set_output(json_encode(['ok'=>false,'msg'=>'not login']));
  }

  // 你們的共用方法拿登入帳號（通常是 id_loginid）
  $s_data    = $this->setup_user_data([]);
  $login_id  = $s_data['login_user_id'] ?? '';
  $sess_uid  = $this->session->userdata('user_id'); // 可能是 id_idx 或帳號字串

  // 以 id_loginid 或 id_idx 任一命中即可
  $this->db->select('id_idx, mall_point')
           ->from('dbo.chr_log_info');
  if ($login_id !== '') $this->db->or_where('id_loginid', $login_id);
  if (is_numeric($sess_uid)) $this->db->or_where('id_idx', (int)$sess_uid);
  $this->db->limit(1);
  $row = $this->db->get()->row_array();

  if (!$row) {
    return $this->output->set_status_header(404)
      ->set_output(json_encode(['ok'=>false,'msg'=>'account not found']));
  }

  // 回傳並順便帶 CSRF（給前端更新 token）
  $resp = [
    'ok'         => true,
    'user_idx'   => (int)$row['id_idx'],
    'mall_point' => (int)$row['mall_point'],
    'ts'         => time(),
    'csrf'       => [
      'name' => $this->security->get_csrf_token_name(),
      'hash' => $this->security->get_csrf_hash(),
    ],
  ];
  return $this->output->set_output(json_encode($resp, JSON_UNESCAPED_UNICODE));
}

  public function get_data() {
    $this->output->set_content_type('application/json');

    $page  = max(1, (int)$this->input->post('page'));
    $q     = trim((string)$this->input->post('q'));
    $limit = 10;

    if (!file_exists($this->excel_file)) {
      echo json_encode([
        'items' => [], 'total' => 0, 'page' => 1, 'total_page' => 1,
        'error' => 'Excel 檔案不存在：' . $this->excel_file
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
        'items' => $paged_items,
        'total' => $total,
        'page' => $page,
        'total_page' => $total_page,
      ]);
    } catch (\Throwable $e) {
      echo json_encode([
        'items' => [], 'total' => 0, 'page' => 1, 'total_page' => 1,
        'error' => '讀取失敗：' . $e->getMessage()
      ]);
    }
  }

public function insert() {
  $this->output->set_content_type('application/json');

  $now = (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');

  $send_mode = trim((string)$this->input->post('send_mode')) ?: 'char_bag';
  $user_idx  = (int)$this->input->post('user_idx');
  $char_raw  = str_replace('，', ',', (string)$this->input->post('character_idx'));
  $item_raw  = str_replace('，', ',', (string)$this->input->post('item_idx'));
  $qty       = (int)$this->input->post('qty');

  // 解析 item_idx 清單（僅數字）
  $items = array_values(array_filter(array_map(function($v){
    $v = trim($v);
    return ($v !== '' && ctype_digit($v)) ? $v : null;
  }, explode(',', $item_raw))));

  if (empty($items) || $qty <= 0) {
    echo json_encode(['success'=>false,'msg'=>'參數錯誤：請確認 item_idx / qty']);
    return;
  }

  // 解析角色 or 以帳號第一個角色為主（shop_bag）
  $chars = [];
  $shopIdxForMode = 0;
  $logUserIdxForMode = null;

  if ($send_mode === 'shop_bag') {
    if ($user_idx <= 0) {
      echo json_encode(['success'=>false,'msg'=>'shop_bag 需提供 user_idx']);
      return;
    }
    $list = $this->charDao->list_by_user($user_idx, false);
    if (empty($list)) {
      echo json_encode(['success'=>false,'msg'=>'此帳號底下沒有角色']);
      return;
    }
    $firstCharId = (int)$list[0]->CharId;
    $chars = [$firstCharId];

    $shopIdxForMode    = (int)$user_idx; // 記在 ITEM_SHOPIDX
    $logUserIdxForMode = (int)$user_idx; // 記在 LOG 的 USER_IDX/USER_ID
  } else {
    $chars = array_values(array_filter(array_map(function($v){
      $v = trim($v);
      return ($v !== '' && ctype_digit($v)) ? $v : null;
    }, explode(',', $char_raw))));
    if (empty($chars)) {
      echo json_encode(['success'=>false,'msg'=>'請輸入至少 1 個角色 ID']);
      return;
    }
    $shopIdxForMode = 0;
  }

  // ★ 從 Excel Cache 載入：item_seal、max_stack
  $pack = $this->load_all_items();
  $itemMap = [];
  foreach ($pack['items'] as $it) {
    // key 請視你的 Excel A 欄是否等於 item_idx：必要時做 (string) 或 (int) 正規化
    $itemMap[(string)$it['product_code']] = $it;
  }

  $results = [];
  foreach ($chars as $charIdx) {
    foreach ($items as $itemIdx) {

      // 先寫入 SHOP LOG（每個角色*每種物品 建一筆）
      $this->db->trans_begin();

      $logUserIdx = ($send_mode === 'shop_bag') ? $logUserIdxForMode : (int)$charIdx;
      $log_data = [
        'TYPE'       => 0,
        'USER_IDX'   => $logUserIdx,
        'USER_ID'    => (string)$logUserIdx,
        'ITEM_IDX'   => (int)$itemIdx,
        'ITEM_DBIDX' => (int)$itemIdx,
        'SIZE'       => (int)$qty,
        'DATE'       => $now,
      ];
      $log_idx = $this->shop_log_dao->insert_item($log_data);
      if ($log_idx === false) {
        $this->db->trans_rollback();
        $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'ok'=>0,'ng'=>$qty,'msg'=>'寫入日誌失敗'];
        continue;
      }

      // Excel 屬性
      $key = (string)$itemIdx;
      $item_seal = isset($itemMap[$key]) ? ($itemMap[$key]['item_seal'] ?? 0) : 0;
      $max_stack = isset($itemMap[$key]) ? ($itemMap[$key]['max_stack'] ?? 0) : 0;

      $ok = 0; $ng = 0;
      $remain = $qty;

      if ($max_stack > 0) {
        // 可疊加：依 max_stack 拆批，durability = 當批數量
        while ($remain > 0) {
          $stackSize = ($remain >= $max_stack) ? $max_stack : $remain;
          $row = [
            'CHARACTER_IDX'   => (int)$charIdx,
            'ITEM_IDX'        => (int)$itemIdx,
            'ITEM_SHOPIDX'    => $shopIdxForMode,
            'ITEM_SHOPLOGIDX' => $log_idx,
            'ITEM_SEAL'       => $item_seal,
            'ITEM_DURABILITY' => $stackSize, // ★ 堆疊數放這裡
          ];
          $ret = $this->item_dao->insert_item($row);
          if ($ret) { $ok++; } else { $ng++; }
          $remain -= $stackSize;
        }
      } else {
        // 不可疊加：durability = 0
        for ($i=0; $i<$remain; $i++) {
          $row = [
            'CHARACTER_IDX'   => (int)$charIdx,
            'ITEM_IDX'        => (int)$itemIdx,
            'ITEM_SHOPIDX'    => $shopIdxForMode,
            'ITEM_SHOPLOGIDX' => $log_idx,
            'ITEM_SEAL'       => $item_seal,
            'ITEM_DURABILITY' => 0,
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
    'msg'    =>$anyFail ? '部分失敗，請查看 results' : '發送完成',
    'results'=>$results
  ]);
}



public function characters_by_user() {
    $user_idx = (int)$this->input->post('user_idx');
    if ($user_idx <= 0) {
        return $this->output->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode(['error' => 'user_idx 必填且需為正整數'], JSON_UNESCAPED_UNICODE));
    }

    $list = $this->charDao->list_by_user($user_idx); // 參照下方 DAO
    $resp = [
        'user_idx'   => $user_idx,
        'count'      => is_array($list) ? count($list) : 0,
        'characters' => $list,
    ];
    return $this->output->set_content_type('application/json')
        ->set_output(json_encode($resp, JSON_UNESCAPED_UNICODE));
}

// application/models/CHARACTER_dao.php
public function list_by_user($user_idx) {
    // 允許顯示的角色狀態（未刪除）
    $activeStates = [0]; // ← 若你們正常=1或其他，改這裡即可

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
        ->where_in('CHARACTER_STATE', $activeStates)   // ★ 只取未刪除
        ->order_by('CHARACTER_GRADE', 'DESC')
        ->order_by('CHARACTER_IDX',   'ASC')
        ->get()->result();
}



  public function logout() {
    $this->session->sess_destroy();
    redirect('luna/login');
  }
}
