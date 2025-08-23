<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Luna_gm_product_set extends MY_Base_Controller {

  private $excel_file;
  private $cache_file;

  public function __construct() {
    parent::__construct();
    $this->excel_file = FCPATH . 'assets/itemlistcn.xlsx';
    $this->cache_file = APPPATH . 'cache/itemlistcn.cache.json';

    // 載入你指定的 DAO（保持精簡）
    $this->load->model('/luna/Shop_log_dao', 'shop_log_dao'); // 日誌庫
    $this->load->model('/luna/Item_dao', 'item_dao'); 
  }

  public function index() {
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login"); return;
    } else {
      if (!empty($this->session->userdata('user_id')) && $this->session->userdata('userlv') !== '2') {
        redirect("/luna/luna_home"); return;
      }
    }
    $data['now'] = 'luna_gm_product_set';
    $this->load->view('luna/luna_gm_product_set', $data);
  }

  /* ---------------- Excel 讀取（固定欄位） ---------------- */

  private function load_all_items() {
    if (!file_exists($this->excel_file)) return ['items' => [], 'mtime' => 0];

    $xlsx_mtime = filemtime($this->excel_file);

    if (file_exists($this->cache_file)) {
      $cache = json_decode(@file_get_contents($this->cache_file), true);
      if (is_array($cache) && isset($cache['mtime']) && intval($cache['mtime']) === $xlsx_mtime) {
        return ['items' => $cache['items'] ?? [], 'mtime' => $xlsx_mtime];
      }
    }

    $reader = IOFactory::createReaderForFile($this->excel_file);
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($this->excel_file);

    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray(null, true, true, true);
    $highestRow = $sheet->getHighestRow();

    $col = ['code'=>'A','name'=>'B','price'=>'D','stock'=>'F','cate'=>'G'];
    $items = [];

    for ($r = 1; $r <= $highestRow; $r++) {
      $row = $rows[$r] ?? [];
      if (!$row) continue;

      $code  = trim((string)($row[$col['code']]  ?? ''));
      $name  = trim((string)($row[$col['name']]  ?? ''));
      $priceRaw = $row[$col['price']] ?? '';
      $stockRaw = $row[$col['stock']] ?? '';
      $cateRaw  = trim((string)($row[$col['cate']] ?? ''));

      if ($code === '' && $name === '' && $priceRaw === '' && $stockRaw === '' && $cateRaw === '') continue;

      $price = (trim((string)$priceRaw) === '' ? null : (is_numeric($priceRaw) ? (float)$priceRaw : trim((string)$priceRaw)));
      $stock = (trim((string)$stockRaw) === '' ? null : (is_numeric($stockRaw) ? (int)$stockRaw   : trim((string)$stockRaw)));
      $cate  = ($cateRaw === '' || $cateRaw === '0') ? '未分類' : $cateRaw;

      $items[] = [
        'product_code' => $code,
        'name'         => $name,
        'price'        => $price,
        'stock'        => $stock,
        'category'     => $cate,
      ];
    }

    @file_put_contents($this->cache_file, json_encode(['mtime'=>$xlsx_mtime,'items'=>$items], JSON_UNESCAPED_UNICODE));
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
      if ($page > $total_page) $page = $total_page;

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

  /* ---------------- GM 發送（view 送進來） ----------------
     需求：從 view 傳「角色字串、物品字串」
     players="1001,1002"  items="12005534:2,12009999:5"
     流程：
       1) 逐個(玩家,物品) 先寫 TB_ITEM_SHOPWEB_LOG，取得 LOG_IDX
       2) 再依數量把物品塞進 TB_ITEM；並把 LOG_IDX 寫入 ITEM_SHOPIDX（照你的需求）
  --------------------------------------------------------- */
public function insert() {
  $this->output->set_content_type('application/json');

  // 用台北時間
  $now = (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');

  // 前端只要傳這三個欄位就好（支持全形逗號）
  $char_raw = str_replace('，', ',', (string)$this->input->post('character_idx'));
  $item_raw = str_replace('，', ',', (string)$this->input->post('item_idx'));
  $qty      = (int)$this->input->post('qty');

  // 解析成純數字陣列
  $chars = array_values(array_filter(array_map(function($v){
    $v = trim($v);
    return ($v !== '' && ctype_digit($v)) ? $v : null;
  }, explode(',', $char_raw))));

  $items = array_values(array_filter(array_map(function($v){
    $v = trim($v);
    return ($v !== '' && ctype_digit($v)) ? $v : null;
  }, explode(',', $item_raw))));

  if (empty($chars) || empty($items) || $qty <= 0) {
    echo json_encode(['success'=>false, 'msg'=>'參數錯誤：請確認 character_idx / item_idx / qty']); 
    return;
  }

  $results = [];
  foreach ($chars as $charIdx) {
    foreach ($items as $itemIdx) {
      // 一組「玩家 × 物品」用一個交易，乾淨
      $this->db->trans_begin();

      // 1) 寫 LOG（DAO 內用 Query Builder insert + insert_id，超穩）
      $log_data = [
        'TYPE'       => 0,
        'USER_IDX'   => (int)$charIdx,
        'USER_ID'    => (string)$charIdx,
        'ITEM_IDX'   => (int)$itemIdx,
        'ITEM_DBIDX' => (int)$itemIdx,
        'SIZE'       => (int)$qty,
        'DATE'       => $now,   // DAO 會處理 [DATE]
      ];
      $log_idx = $this->shop_log_dao->insert_item($log_data);
      if ($log_idx === false) {
        $this->db->trans_rollback();
        $results[] = ['char'=>$charIdx,'item'=>$itemIdx,'qty'=>$qty,'ok'=>0,'ng'=>$qty,'msg'=>'寫入日誌失敗'];
        continue;
      }

      // 2) 寫 TB_ITEM（逐筆 qty 次）
      $ok = 0; $ng = 0;
      for ($i=0; $i<$qty; $i++) {
        $row = [
          'CHARACTER_IDX' => (int)$charIdx,
          'ITEM_IDX'      => (int)$itemIdx,
          'ITEM_POSITION' => 320,
          'ITEM_SHOPIDX'  => (int)$charIdx,
          'ITEM_SHOPLOGIDX'  => $log_idx,
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


  public function logout() {
    $this->session->sess_destroy();
    redirect('luna/login');
  }
}
