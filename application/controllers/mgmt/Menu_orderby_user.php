<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Menu_orderby_user extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Menu_orderby_user_dao', 'dao');
		$this -> load -> model('Menu_dao', 'menu_dao');
		$this -> load -> model('Menu_order_dao', 'menu_order_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Menu_style_dao', 'menu_style_dao');
		$this->load->library('excel');
	
	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);
		$this -> load -> view('mgmt/menu_orderby_user/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			// 's_menu_style',
		));
		// set corp id
		$s_data = $this -> setup_user_data(array());
		$items = $this -> menu_order_dao -> find_all_order_list($data);
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> menu_order_dao -> find_all_order_list($data,true);
		$res['recordsTotal'] = $this -> menu_order_dao -> find_all_order_list($data,true);
		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$data['id'] = $id;
		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order'
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			if(!empty($item -> image_id)) {
				$item -> img = $this -> img_dao -> find_by_id($item -> image_id);
			}
			$data['item'] = $item;
		}
		$this->load->view('mgmt/menu_orderby_user/edit', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$title = $this -> get_post('title');
		$m_content = $this -> get_post('m_content');
		$menu_style = $this -> get_post('menu_style');
		$cost = $this -> get_post('cost');
		$sort = $this -> get_post('sort');
		$data['title'] = $title;
		$data['content'] = $m_content;
		$data['menu_style_id'] = $menu_style;
		$data['cost'] = $cost;
		$data['sort'] = $sort;
		if(empty($id)) {
			// insert
			$this -> dao -> insert($data);
		} else {
			// update
			$this -> dao -> update($data, $id);
		}
		$s_data = $this -> setup_user_data(array());
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete_img($id) {
		$res = array();
		$res['success'] = TRUE;
		$this -> img_dao -> delete($id);
		$this -> to_json($res);
	}

	public function find_img_style(){
		$res = array();
		$img_style_list = $this -> img_style_dao -> find_all();
		$res['img_style'] = $img_style_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function new_menu_style(){
		$data = array();
		$this -> load -> view('layout/show_new_menu_style',$data);
	}

	public function add_menu_style(){
		$data = array();
		$res = array();
		$menu_style = $this -> get_post('menu_style');
		$data['menu_style'] = $menu_style;
		$this -> menu_style_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_menu_style(){
		$res = array();
		$menu_style_list = $this -> menu_style_dao -> find_all();
		$res['menu_style'] = $menu_style_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function update_menu_style() {
		$res = array();
		$last_id = $this -> get_post('last_id');
		$img_style = $this -> get_post('menu_style');
		$this -> img_dao -> update(array(
			'img_style' => $img_style
		), $last_id);

		$this -> to_json($res);
	}

	public function up_carousel(){
		$news_id = $this -> get_post('news_id');
		$u_data = array();
		$i_data = array();
		$p = $this -> dao -> find_by_id($news_id);
		if(!empty($p)){
			if($p->status==0){
				$u_data['status'] = 1;
				$res['success_msg'] = '變更輪播成功';
				if($p->news_style_id==9){
					$content_array=explode("</p>",$p->content);
					foreach($content_array as $each){
						$img_id = $this->get_between($each, "get/", '/thumb');
						$img_id_array[] = $img_id;
						foreach($img_id_array as $img_id_key=>$each_img_id){
							if(!is_numeric($each_img_id))
							unset($img_id_array[$img_id_key]);
						}
					}
					$new_img_array = $img_id_array;
					$res['new_img_array'] = $new_img_array;
					$this -> img_month_use_dao -> empty_table();
					foreach($new_img_array as $each){
						$i_data['img_id'] = $each;
						$this -> img_month_use_dao -> insert($i_data);
						$this -> img_month_use_record_dao -> insert($i_data);
					}
				}
			} else{
				$u_data['status'] = 0;
				$res['success_msg'] = '變更非輪播成功';
			}
			$this -> dao -> update($u_data, $news_id);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function export_excel1(){
	  $this->load->dbutil();
	  $this->load->helper('file');
	  $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
	  $date = date('YmdHis');
      $filename = $date."-點餐表.csv";

			// $id = $this -> session -> userdata("daily_report_data_by_id");
			
    		$f = fopen('php://memory', 'w');
	
			
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'工單編號SAP'),
				"",
				"",
				isset($item) ? $item -> sn_sap : '',
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'工單執行日期'),
				"",
				"",
				isset($item) ? $item -> start_time : '',
			);
			fputcsv($f, $fields, $delimiter);

			
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'原料列表'),
				"",
				"",
				"",
			);
			fputcsv($f, $fields, $delimiter);
				

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'料號'),
				iconv("UTF-8","Big5//IGNORE",'品名'),
				iconv("UTF-8","Big5//IGNORE",'櫃號'),
				iconv("UTF-8","Big5//IGNORE",'批號'),
				iconv("UTF-8","Big5//IGNORE",'需求重量'),
				iconv("UTF-8","Big5//IGNORE",'實際重量'),

			);
			fputcsv($f, $fields, $delimiter);

			
    		fseek($f, 0);
			//  create_sheet('工作表3') ;
		  header('Content-Type: text/csv');
		  header('Content-Disposition: attachment; filename="' . $filename . '";');

		fpassthru($f);
	}


	public function export_excel(){
		$fileName = '點餐表'.date('Y-m-d H:i:s').'.xls';

		$objPHPExcel = new PHPExcel();
		

		$i=0;

		while ($i < 2) {
		
		// Add new sheet
		$objWorkSheet = $objPHPExcel->createSheet();
		
		//  Attach the newly-cloned sheet to the $objPHPExcel workbook
		$objPHPExcel->addSheet($objWorkSheet);
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex($i);
		
		$sheet = $objPHPExcel->getActiveSheet();
		
		$sheet->setCellValue('A1', 'Hello'.$i)
				->setCellValue('B2', 'world!')
				->setCellValue('C1', 'Hello')
				->setCellValue('D2', 'world!');
		
		// Rename sheet
		$sheet->setTitle($i);
		
		$i++;
		}

	
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		// download file
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		// $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}
