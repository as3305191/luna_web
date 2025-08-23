<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Luna_gm_product_set extends CI_Controller {

  private $excel_file;
  private $cache_file;

  function __construct() {
    parent::__construct();
    $this->excel_file = FCPATH . 'assets/itemlistcn.xlsx';
    $this->cache_file = APPPATH . 'cache/itemlistcn.cache.json';
  }

  public function index() {
	
	if(empty($this->session->userdata('user_id'))) {
		redirect("/luna/login");
		return;
    } else{
		if(!empty($this->session->userdata('user_id')) && $this->session->userdata('userlv')!=='2') {
			redirect("/luna/luna_home");
			return;
		}
	}
    $data['now'] = 'luna_gm_product_set';
    $this->load->view('luna/luna_gm_product_set', $data);
  }

  // 讀取全部商品（無標題列、固定欄位）
  // A:商品編號  B:名稱  D:價格  F:庫存  G:分類(0或空→未分類)
  private function load_all_items() {
    if (!file_exists($this->excel_file)) return ['items' => [], 'mtime' => 0];

    $xlsx_mtime = filemtime($this->excel_file);

    // 快取：Excel 未變更就直接回傳
    if (file_exists($this->cache_file)) {
      $cache = json_decode(@file_get_contents($this->cache_file), true);
      if (is_array($cache) && isset($cache['mtime']) && intval($cache['mtime']) === $xlsx_mtime) {
        return ['items' => $cache['items'] ?? [], 'mtime' => $xlsx_mtime];
      }
    }

    // 讀 Excel（只讀值）
    $reader = IOFactory::createReaderForFile($this->excel_file);
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($this->excel_file);

    // 使用第一個工作表
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray(null, true, true, true); // A,B,C...
    $highestRow = $sheet->getHighestRow();

    // 固定欄位對應
    $col = [
      'code'  => 'A',
      'name'  => 'B',
      'price' => 'D',
      'stock' => 'F',
      'cate'  => 'G',
    ];
    $startRow = 1; // 沒有標題，從第1列就是資料

    $items = [];
    for ($r = $startRow; $r <= $highestRow; $r++) {
      $row = $rows[$r] ?? [];
      if (!$row) continue;

      $code  = trim((string)($row[$col['code']]  ?? ''));
      $name  = trim((string)($row[$col['name']]  ?? ''));
      $priceRaw = $row[$col['price']] ?? '';
      $stockRaw = $row[$col['stock']] ?? '';
      $cateRaw  = trim((string)($row[$col['cate']] ?? ''));

      // 全空列略過
      if ($code === '' && $name === '' && $priceRaw === '' && $stockRaw === '' && $cateRaw === '') continue;

      $price = (trim((string)$priceRaw) === '' ? null : (is_numeric($priceRaw) ? (float)$priceRaw : trim((string)$priceRaw)));
      $stock = (trim((string)$stockRaw) === '' ? null : (is_numeric($stockRaw) ? (int)$stockRaw   : trim((string)$stockRaw)));
      $cate  = ($cateRaw === '' || $cateRaw === '0') ? '未分類' : $cateRaw;

      $items[] = [
        'product_code' => $code,
        'name'         => $name,   // 中文 OK
        'price'        => $price,
        'stock'        => $stock,
        'category'     => $cate,
      ];
    }

    // 寫入快取
    @file_put_contents(
      $this->cache_file,
      json_encode(['mtime' => $xlsx_mtime, 'items' => $items], JSON_UNESCAPED_UNICODE)
    );

    return ['items' => $items, 'mtime' => $xlsx_mtime];
  }

  // 取得資料（搜尋 + 分頁）
  public function get_data() {
    $this->output->set_content_type('application/json');

    $page  = max(1, (int)$this->input->post('page'));
    $q     = trim((string)$this->input->post('q'));
    $limit = 10;                          // 每頁 10 筆
    $offset = ($page - 1) * $limit;

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

      // 搜尋：商品編號 / 名稱 / 分類（不分大小寫）
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
      if ($page > $total_page) { $page = $total_page; $offset = ($page - 1) * $limit; }

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

  public function logout() {
    $this->session->sess_destroy();
    redirect('luna/login');
  }
}
