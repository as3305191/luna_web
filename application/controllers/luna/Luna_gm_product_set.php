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
    $this->excel_file = FCPATH . 'assets/itemlistcn.xlsx';
    $this->cache_file = APPPATH . 'cache/itemlistcn.cache.json';

    // DAO
    $this->load->model('/luna/Shop_log_dao', 'shop_log_dao');
    $this->load->model('/luna/Item_dao', 'item_dao');
    $this->load->model('/luna/CHARACTER_dao', 'charDao'); // ✅ 新增
    $this->load->model('/luna/Item_log_dao', 'item_log_dao'); // ★ 新增：道具日誌（LOGDB）
  }

  public function index() {
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login"); return;
    }
    if ($this->session->userdata('userlv') !== '2') {
      redirect("/luna/luna_home"); return;
    }
    $data['now'] = 'luna_gm_product_set';
    $this->load->view('luna/luna_gm_product_set', $data);
  }

/* ---------------- Excel 讀取（A/B/O/BG/BL） ---------------- */
private function load_all_items() {
  if (!file_exists($this->excel_file)) return ['items' => [], 'mtime' => 0];

  $xlsx_mtime = filemtime($this->excel_file);
  $CACHE_VER = 3; // ← 解析邏輯改動就 +1，確保不吃舊快取

  // 命中快取（含版本）
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

  // 如需指定工作表，可改用：$sheet = $spreadsheet->getSheetByName('Sheet1');
  $sheet = $spreadsheet->getActiveSheet();

  // 欄位字母 → 索引（1-based）
  $colLetters = [
    'code'       => 'A',   // ITEM_IDX
    'name'       => 'B',   // 名稱
    'sellstatus' => 'O',   // O 欄：販售狀態（寫入 ITEM_SEAL）
    'endtime'    => 'BG',  // BG 欄：剩餘/限時秒數
    'cate'       => 'BL',  // BL 欄：分類代碼
  ];
  $colIndex = [];
  foreach ($colLetters as $k => $letter) {
    $colIndex[$k] = Coordinate::columnIndexFromString($letter);
  }

  // BL 分類代碼 → 中文
  $categoryMap = [
    0=>'武器', 1=>'盾牌', 2=>'衣服', 3=>'帽子', 4=>'手套', 5=>'鞋子',
    6=>'戒指1', 7=>'戒指2', 8=>'項鍊', 9=>'耳環1', 10=>'耳環2',
    11=>'腰帶', 12=>'臂章', 13=>'眼鏡', 14=>'面具', 15=>'翅膀',
    16=>'時裝頭飾', 17=>'時裝衣服', 18=>'時裝手套', 19=>'時裝鞋子'
  ];

  $highestRow = $sheet->getHighestRow();
  $items = [];

  // 如果第 1 列是表頭，這裡改成 2
  $startRow = 1;

  for ($r = $startRow; $r <= $highestRow; $r++) {
    // ---- A/B 直接取字串
    $code = trim((string)$sheet->getCellByColumnAndRow($colIndex['code'], $r)->getCalculatedValue());
    $name = trim((string)$sheet->getCellByColumnAndRow($colIndex['name'], $r)->getCalculatedValue());

    // ---- O：販售狀態（保留字串/數字；空→null）
    $cellO = $sheet->getCellByColumnAndRow($colIndex['sellstatus'], $r);
    $oVal  = $cellO ? $cellO->getValue() : null;
    if ($oVal === null || $oVal === '') $oVal = $cellO ? $cellO->getCalculatedValue() : null;
    $sellstatus = (is_null($oVal) || trim((string)$oVal) === '')
      ? null
      : (is_numeric($oVal) ? (float)$oVal : trim((string)$oVal));

    // ---- BG：秒數（吃 1209600、"1,209,600"、"１２０９６００"、"1209600秒" 等）
    $cellBG = $sheet->getCellByColumnAndRow($colIndex['endtime'], $r);
    $bgVal  = $cellBG ? $cellBG->getValue() : null;
    if ($bgVal === null || $bgVal === '') $bgVal = $cellBG ? $cellBG->getCalculatedValue() : null;

    $endtime = null;
    if ($bgVal !== null && $bgVal !== '') {
      if (is_numeric($bgVal)) {
        $endtime = (int)round($bgVal);
      } else {
        $s = trim((string)$bgVal);
        if (function_exists('mb_convert_kana')) $s = mb_convert_kana($s, 'n', 'UTF-8'); // 全形→半形
        $s = preg_replace('/[^0-9\-]/u', '', $s); // 去非數字
        if ($s !== '' && $s !== '-' && preg_match('/^-?\d+$/', $s)) {
          $endtime = (int)$s;
        }
      }
    }

    // ---- BL：分類（強制清洗，抓第一段數字）
    $cellBL = $sheet->getCellByColumnAndRow($colIndex['cate'], $r);
    $blVal  = $cellBL ? $cellBL->getValue() : null;
    if ($blVal === null || $blVal === '') $blVal = $cellBL ? $cellBL->getCalculatedValue() : null;

    $cateNum = -1;
    if ($blVal !== null && trim((string)$blVal) !== '') {
      $s = (string)$blVal;
      $s = preg_replace('/\s+/u', '', $s);                 // 去空白
      if (function_exists('mb_convert_kana')) $s = mb_convert_kana($s, 'n', 'UTF-8'); // 全形→半形
      if (preg_match('/-?\d+/', $s, $m)) {                 // 抓第一段數字
        $cateNum = (int)$m[0];
      }
    }
    $cateZh = $categoryMap[$cateNum] ?? '未分類';

    // ---- 空行檢查
    if ($code === '' && $name === '' && is_null($sellstatus) && is_null($endtime) && $cateNum === -1) {
      continue;
    }

    $items[] = [
      'product_code'  => $code,
      'name'          => $name,
      'sellstatus'    => $sellstatus,  // O
      'endtime'       => $endtime,     // BG（秒）
      'category'      => $cateZh,      // 中文
      'category_code' => $cateNum,     // 原始代碼（如不需可移除）
    ];
  }

  // 寫入快取（含版本）
  @file_put_contents($this->cache_file, json_encode([
    'ver'   => $CACHE_VER,
    'mtime' => $xlsx_mtime,
    'items' => $items
  ], JSON_UNESCAPED_UNICODE));

  return ['items' => $items, 'mtime' => $xlsx_mtime];
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

  // 參數
  $send_mode = trim((string)$this->input->post('send_mode')) ?: 'char_bag'; // char_bag | shop_bag
  $user_idx  = (int)$this->input->post('user_idx'); // 僅 shop_bag 需要
  $char_raw  = str_replace('，', ',', (string)$this->input->post('character_idx'));
  $item_raw  = str_replace('，', ',', (string)$this->input->post('item_idx'));
  $qty       = (int)$this->input->post('qty');

  // 物品清單
  $items = array_values(array_filter(array_map(function($v){
    $v = trim($v);
    return ($v !== '' && ctype_digit($v)) ? $v : null;
  }, explode(',', $item_raw))));

  if (empty($items) || $qty <= 0) {
    echo json_encode(['success'=>false,'msg'=>'參數錯誤：請確認 item_idx / qty']);
    return;
  }

  // 角色清單（依模式決定）
  $chars = [];
  $shopIdxForMode = 0; // 預設角色包包
  $logUserIdxForMode = null;

  if ($send_mode === 'shop_bag') {
    if ($user_idx <= 0) {
      echo json_encode(['success'=>false,'msg'=>'shop_bag 需提供 user_idx']);
      return;
    }
    // 取第一隻角色
    $list = $this->charDao->list_by_user($user_idx, false);
    if (empty($list)) {
      echo json_encode(['success'=>false,'msg'=>'此帳號底下沒有角色']);
      return;
    }
    $firstCharId = (int)$list[0]->CharId;
    $chars = [$firstCharId];

    $shopIdxForMode    = (int)$user_idx; // 商城包包：ITEM_SHOPIDX = 帳號
    $logUserIdxForMode = (int)$user_idx; // Log 用帳號
  } else { // char_bag
    $chars = array_values(array_filter(array_map(function($v){
      $v = trim($v);
      return ($v !== '' && ctype_digit($v)) ? $v : null;
    }, explode(',', $char_raw))));
    if (empty($chars)) {
      echo json_encode(['success'=>false,'msg'=>'請輸入至少 1 個角色 ID']);
      return;
    }
    $shopIdxForMode = 0;  // 角色包包：ITEM_SHOPIDX = 0
    // Log 用角色ID（逐筆在迴圈內覆寫）
  }

  // ★ 需求更正：ITEM_SEAL 一律指定為 1（不再讀 Excel O 欄）
  $item_seal = 1;

  $results = [];
  foreach ($chars as $charIdx) {
    foreach ($items as $itemIdx) {
      $this->db->trans_begin();

      // Log：shop_bag 用帳號；char_bag 用角色
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

      // 插入 TB_ITEM
      $ok = 0; $ng = 0;
      for ($i=0; $i<$qty; $i++) {
        $row = [
          'CHARACTER_IDX'   => (int)$charIdx,     // ★ 角色ID（兩種模式都要）
          'ITEM_IDX'        => (int)$itemIdx,
          // 'ITEM_POSITION' 不填（NULL）★
          'ITEM_SHOPIDX'    => $shopIdxForMode,   // ★ char_bag=0；shop_bag=user_idx
          'ITEM_SHOPLOGIDX' => $log_idx,
          'ITEM_SEAL'       => $item_seal,        // ★ 固定為 1
        ];
        $ret = $this->item_dao->insert_item($row);
        if ($ret) $ok++; else $ng++;
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
