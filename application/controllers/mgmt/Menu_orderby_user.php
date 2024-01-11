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
		$this -> load -> model('Users_dao', 'users_dao');

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
		$menu_id = $this -> get_post('menu_id');
		$data['menu_id'] = $menu_id;
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);		
		$login_user_dep=explode('#',ltrim(rtrim($login_user->in_department,'#'),'#'));
		$items = $this -> menu_order_dao -> find_all_order_list($data);
		$weekarray=array("日","一","二","三","四","五","六");
		$map_list= array();
		$total=0;
		// 将时间戳转换为星期几的英文表示
	
			foreach($items as $each){
				if($each->open_date!=='0000-00-00'){
					$weekday = $weekarray[date("w",strtotime($each->open_date))];
					$each->timestamp = date('m.d',strtotime($each->open_date)).' ('.$weekday.')';
					// $each->timestamp = $each->open_date.' ('.$weekday_cn.')';

				} else{
					$each->timestamp= '';
				}
				if($each->open_dep==0){
					$map_list[]= $each;
				} else{
					$each_open_dep=explode(',',$each->open_dep);
					foreach($each_open_dep as $each_o_dep){
						if(in_array($each_o_dep, $login_user_dep)){
							$map_list[]= $each;
						}
					}
					
				}
				
				$total += intval($each->amount);
			}
			
		$res['total'] = $total;
		if($login_user->id=='205'||$login_user->id=='114'){
			$res['items'] = $items;
		} else{
			$res['items'] = $map_list;
		}
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

	public function find_all_menu(){
		$res = array();
		$id = $this -> get_post('id');
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);		
		$login_user_dep=explode('#',ltrim(rtrim($login_user->in_department,'#'),'#'));
		$list = $this -> menu_dao -> find_all_open_and_stop();
		$weekarray=array("日","一","二","三","四","五","六");
		$map_list= array();
		// 将时间戳转换为星期几的英文表示
	
			foreach($list as $each){
				if($each->open_date!=='0000-00-00'){
					$weekday = $weekarray[date("w",strtotime($each->open_date))];
					$each->timestamp = date('m.d',strtotime($each->open_date)).' ('.$weekday.')';
					// $each->timestamp = $each->open_date.' ('.$weekday_cn.')';

				} else{
					$each->timestamp= '';
				}
				if($each->open_dep==0){
					$map_list[]= $each;
				} else{
					$each_open_dep=explode(',',$each->open_dep);
					foreach($each_open_dep as $each_o_dep){
						if(in_array($each_o_dep, $login_user_dep)){
							$map_list[]= $each;
						}
					}
					
				}
				
				
			}
		if($login_user->id=='205'||$login_user->id=='114'){
			$res['list'] = $items;
		} else{
			$res['list'] = $map_list;
		}
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

	public function export_excel(){
		$fileName = '點餐表'.date('Y-m-d H:i:s').'.xls';

		$objPHPExcel = new PHPExcel();
		// $objPHPExcel->setActiveSheetIndex(0);
		// $objPHPExcel->getActiveSheet()->SetCellValue('A1', '部門名稱');
		// $objPHPExcel->getActiveSheet()->SetCellValue('B1', '主功能');
		// $objPHPExcel->getActiveSheet()->SetCellValue('C1', '權限項目');
		// $objPHPExcel->getActiveSheet()->SetCellValue('D1', '其他設定');
	
	
		$sheet = $objPHPExcel->getActiveSheet();

		$items = $this -> menu_dao -> find_all_open_without_stop();
		//Start adding next sheets
		
		for ($i=0;$i<count($items);$i++) {
	
		  // Add new sheet
		  $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
	
		  //Write cells
		  if($items[$i]->menu_style_id==4){
			$objWorkSheet->setCellValue('A1', '名字')
						->setCellValue('B1', '品項')
						->setCellValue('C1', '糖')
						->setCellValue('D1', '冰')
						->setCellValue('E1', '備註')
						->setCellValue('F1', '金額');

						$items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
						$total = 0;
						for ($j=0;$j<count($items_order);$j++) {
							$k = $j+2;
							$total+=intval($items_order[$j]->amount);
							$objWorkSheet->setCellValue('A'.$k , $items_order[$j]->user_name)
										->setCellValue('B'.$k , $items_order[$j]->order_name)
										->setCellValue('C'.$k , $items_order[$j]->sugar)
										->setCellValue('D'.$k , $items_order[$j]->ice)
										->setCellValue('E'.$k , $items_order[$j]->note)
										->setCellValue('F'.$k , $items_order[$j]->amount);
						}
						$last = count($items_order)+2;
						$objWorkSheet->setCellValue('A'.$last , '')
										->setCellValue('B'.$last , '')
										->setCellValue('C'.$last, '')
										->setCellValue('D'.$last, '')
										->setCellValue('E'.$last, '')
										->setCellValue('F'.$last , '總金額')
										->setCellValue('G'.$last ,  $total);



		  } else{
			$objWorkSheet->setCellValue('A1', '名字')
					   ->setCellValue('B1', '品項')
					   ->setCellValue('C1', '備註')
					   ->setCellValue('D1', '金額');
			$items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
			$total = 0;
			for ($j=0;$j<count($items_order);$j++) {
				$k = $j+2;
				$total+=intval($items_order[$j]->amount);
				$objWorkSheet->setCellValue('A'.$k , $items_order[$j]->user_name)
							->setCellValue('B'.$k , $items_order[$j]->order_name)
							->setCellValue('C'.$k , $items_order[$j]->note)
							->setCellValue('D'.$k , $items_order[$j]->amount);
			}
			$last = count($items_order)+2;
			$objWorkSheet->setCellValue('A'.$last , '')
							->setCellValue('B'.$last , '')
							->setCellValue('C'.$last, '')
							->setCellValue('D'.$last , '總金額')
							->setCellValue('E'.$last ,  $total);
		  }
		  
		  // Rename sheet
		  $objWorkSheet->setTitle($items[$i]->menu_name);
		}
	
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		// download file
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		// $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}
