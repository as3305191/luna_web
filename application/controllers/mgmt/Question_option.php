<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_option extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Question_option_dao', 'dao');
		$this -> load -> model('Question_style_dao', 'question_style_dao');
		$this -> load -> model('Question_ans_dao', 'question_ans_dao');
		$this -> load -> model('Users_dao', 'users_dao');

		// $this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		// $data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);
		$this -> load -> view('mgmt/question_option/list', $data);
	}

	public function get_data() {
		$res = array();
		// $s_data = $this -> setup_user_data(array());
		// $login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$items = $this -> dao -> query_ajax($data);
	
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);
		$this -> to_json($res);
	}

	public function get_data_not_finish() {
		$res = array();
		$res['items'] = array();
		
		$data = $this -> get_posts(array(
			'item_id'
		));
		$items_list = $this -> question_ans_dao -> find_all_finish($data);
		$all_user_list =  $this -> users_dao -> find_all_ktx_user();
		if(count($items_list)>0){
			foreach($all_user_list as $each_user){
				foreach($items_list as $each_item){
					if($each_user->id!==$each_item->user_id){
						$res['items'][] = $each_user;
					}
				}
			}
		} else{
			$res['items'] = $all_user_list;
		}
		
		
		$this -> to_json($res);

	}

	public function get_data_each_detail() {
		$res = array();
		// $s_data = $this -> setup_user_data(array());
		// $login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'item_id'
		));
		$items = $this -> question_ans_dao -> find_all_each_detail($data);
	
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> question_ans_dao -> find_all_each_detail($data,true);
		$res['recordsTotal'] = $this -> question_ans_dao -> find_all_each_detail($data,true);
		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
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
			
			$data['item'] = $item;
		

		}
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		
		$this->load->view('mgmt/question_option/edit', $data);
	}

	public function export($id) {
		$data = array();
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
			
			$data['item'] = $item;
		

		}
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		
		$this->load->view('mgmt/question_option/export', $data);
	}

	public function insert() {//新增
		$res = array();
		$data = array();
		$id = $this -> get_post('id');
		$question_style_id= $this -> get_post('question_style_id');
		$note= $this -> get_post('note');
		$data['question_style_id'] = $question_style_id;
		$data['note'] = $note;
		if(empty($id)) {
			// insert
			$last_id = $this -> dao -> insert($data);
		} else {
			$this -> dao -> update($data, $id);
			
		}
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function find_question_style(){
		$res = array();
		$question_style_list = $this -> question_style_dao -> find_all();
		$res['question_style'] = $question_style_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function up_lock(){
		$swot_id = $this -> get_post('id');
		$u_data = array();
		$p = $this -> dao -> find_by_id($swot_id);
		if(!empty($p)){
			if($p->is_lock==0){
				$u_data['is_lock'] = 1;
				$res['success_msg'] = '變更已鎖定成功';
			} else{
				$u_data['is_lock'] = 0;
				$res['success_msg'] = '變更可編輯成功';
			}
			$this -> dao -> update($u_data, $swot_id);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function up_lock_question_list(){
		$question_id = $this -> get_post('id');
		$u_data = array();
		$list = $this -> dao -> find_by_id($question_id);
		if(!empty($list)){
			if($list->is_close==1){
				$u_data['is_close'] = 0;
				$res['success_msg'] = '問卷開放成功';
				
			} else{
				$u_data['is_close'] = 1;
				$res['success_msg'] = '問卷變更不開放';
				
			}
			$this -> dao -> update($u_data, $question_id);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$u_data['is_delete'] = 1;
		$this -> dao ->  update($u_data, $id);
		$this -> to_json($res);
	}
	public function export_excel(){
		$id = $this -> get_get('id');
		$question_ans_list = $this -> question_ans_dao -> find_by_all_p($id);
	
		$fileName = $question_ans_list->question_style_name."(".$question_ans_list->user_name.")-".date('Y-m-d H:i:s').'.xls';

		$objPHPExcel = new PHPExcel();
		// $objPHPExcel->setActiveSheetIndex(0);
		// $objPHPExcel->getActiveSheet()->SetCellValue('A1', '部門名稱');
		// $objPHPExcel->getActiveSheet()->SetCellValue('B1', '主功能');
		// $objPHPExcel->getActiveSheet()->SetCellValue('C1', '權限項目');
		// $objPHPExcel->getActiveSheet()->SetCellValue('D1', '其他設定');
	
	
		// $sheet = $objPHPExcel->getActiveSheet();

		switch ($question_ans_list->qs_id) {
			case 1:
				// for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
					$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
			  
					//Write cells
					  $objWorkSheet->setCellValue('A1', '工作型態')
								  ->setCellValue('B1', '性別')
								  ->setCellValue('C1', '年資')
								  ->setCellValue('D1', '平均每週工作時數')
								  ->setCellValue('E1', '班別')
								  ->setCellValue('F1', '曾經遭遇的暴力攻擊情境')
								  ->setCellValue('G1', '公司提供有關預防暴力攻擊之衛生教育訓練')
								  ->setCellValue('H1', '我清楚了解如何辨識職場發生的暴力危害')
								  ->setCellValue('I1', '我清楚了解如何進行暴力危害的風險評估')
								  ->setCellValue('J1', '我清楚了解如何避免或遠離暴力危害事件')
								  ->setCellValue('K1', '我清楚了解暴力危害事件發生時如何尋求支援管道')
								  ->setCellValue('L1', '我具備因應暴力危害事件的事務處理與執行能力');

								//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
								  $total = 0;
								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue('A'.$k , $question_ans_list[$j]->user_name)
												  ->setCellValue('B'.$k , $question_ans_list[$j]->order_name)
												  ->setCellValue('C'.$k , $question_ans_list[$j]->sugar)
												  ->setCellValue('D'.$k , $question_ans_list[$j]->ice)
												  ->setCellValue('E'.$k , $question_ans_list[$j]->note)
												  ->setCellValue('F'.$k , $question_ans_list[$j]->amount)
												  ->setCellValue('G'.$k , $question_ans_list[$j]->amount)
												  ->setCellValue('H'.$k , $question_ans_list[$j]->amount)
												  ->setCellValue('I'.$k , $question_ans_list[$j]->amount)
												  ->setCellValue('J'.$k , $question_ans_list[$j]->amount)
												  ->setCellValue('K'.$k , $question_ans_list[$j]->amount)
												  ->setCellValue('L'.$k , $question_ans_list[$j]->amount);

								  }
								//   $last = count($items_order)+2;
								//   $objWorkSheet->setCellValue('A'.$last , '')
								// 				  ->setCellValue('B'.$last , '')
								// 				  ->setCellValue('C'.$last, '')
								// 				  ->setCellValue('D'.$last, '')
								// 				  ->setCellValue('E'.$last, '')
								// 				  ->setCellValue('F'.$last , '總金額')
								// 				  ->setCellValue('G'.$last ,  $total);
		  
		  
						$objWorkSheet->setTitle($question_ans_list->question_style_name);
				// }
			  
			  break;
			case 2:
			  //code block;
			  break;
			case 3:
			  //code block
			  break;
			default:
			  //code block
		  }

		
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		// download file
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		// $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	public function export_excel_all(){
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
