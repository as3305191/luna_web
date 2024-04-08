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
			'item_id',
			's_name'
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

	public function delete_user_q_a($id) {
		$res['success'] = TRUE;
		// $u_data['is_delete'] = 1;
		// $this -> dao ->  update($u_data, $id);
		$this ->  question_ans_dao ->  delete($id);
		$this -> to_json($res);
	}

	public function export_excel($id){
		// $id = $this -> get_get('id');
		$question_ans_list = $this -> question_ans_dao -> find_by_all_p($id);
	
		$fileName = $question_ans_list[0]->question_style_name."(".$question_ans_list[0]->user_name.")-".date('Y-m-d H:i:s').'.xls';

		$objPHPExcel = new PHPExcel();
		// $objPHPExcel->setActiveSheetIndex(0);
		// $objPHPExcel->getActiveSheet()->SetCellValue('A1', '部門名稱');
		// $objPHPExcel->getActiveSheet()->SetCellValue('B1', '主功能');
		// $objPHPExcel->getActiveSheet()->SetCellValue('C1', '權限項目');
		// $objPHPExcel->getActiveSheet()->SetCellValue('D1', '其他設定');
	
	
		// $sheet = $objPHPExcel->getActiveSheet();
		$all_cell_title = ['A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1',
							'L1','M1','N1','O1','P1','Q1','R1','S1','T1','U1','V1','W1','X1','Y1','Z1','AA1','AB1','AC1','AD1','AE1','AF1','AG1'];
		$all_cell_name = ['A','B','C','D','E','F','G','H','I','J','K',
							'L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG'];

		 
		switch ($question_ans_list[0]->qs_id) {
			case 1:
				$cell_title = ['工作型態','性別','年資','平均每週工作時數','班別','曾經遭遇的暴力攻擊情境',
				'公司提供有關預防暴力攻擊之衛生教育訓練','我清楚了解如何辨識職場發生的暴力危害',
				'我清楚了解如何進行暴力危害的風險評估','我清楚了解如何避免或遠離暴力危害事件',
				'我清楚了解暴力危害事件發生時如何尋求支援管道','我具備因應暴力危害事件的事務處理與執行能力'];
				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
					$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
			  
					  $objWorkSheet->setCellValue($all_cell_title[0], $cell_title[0])
								  ->setCellValue($all_cell_title[1], $cell_title[1])
								  ->setCellValue($all_cell_title[2], $cell_title[2])
								  ->setCellValue($all_cell_title[3], $cell_title[3])
								  ->setCellValue($all_cell_title[4], $cell_title[4])
								  ->setCellValue($all_cell_title[5], $cell_title[5])
								  ->setCellValue($all_cell_title[6], $cell_title[6])
								  ->setCellValue($all_cell_title[7], $cell_title[7])
								  ->setCellValue($all_cell_title[8], $cell_title[8])
								  ->setCellValue($all_cell_title[9], $cell_title[9])
								  ->setCellValue($all_cell_title[10], $cell_title[10])
								  ->setCellValue($all_cell_title[11], $cell_title[11]);

								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue($all_cell_name[0].$k , $question_ans_list[$j]->q1)
												  ->setCellValue($all_cell_name[1].$k , $question_ans_list[$j]->q2)
												  ->setCellValue($all_cell_name[2].$k , $question_ans_list[$j]->q3)
												  ->setCellValue($all_cell_name[3].$k , $question_ans_list[$j]->q4)
												  ->setCellValue($all_cell_name[4].$k , $question_ans_list[$j]->q5)
												  ->setCellValue($all_cell_name[5].$k , $question_ans_list[$j]->q6)
												  ->setCellValue($all_cell_name[6].$k , $question_ans_list[$j]->q7)
												  ->setCellValue($all_cell_name[7].$k , $question_ans_list[$j]->q8)
												  ->setCellValue($all_cell_name[8].$k , $question_ans_list[$j]->q9)
												  ->setCellValue($all_cell_name[9].$k , $question_ans_list[$j]->q10)
												  ->setCellValue($all_cell_name[10].$k , $question_ans_list[$j]->q11)
												  ->setCellValue($all_cell_name[11].$k , $question_ans_list[$j]->q12);

								  }
		  
		  
						$objWorkSheet->setTitle($question_ans_list[$i]->question_style_name);
				}
			  
			  break;
			case 2:
				$cell_title = ['年齡','性別','身高','體重','慣用手','是否不適','頸','左肩','左手肘/左前臂','左手/左手腕','左臀/左大腿',
				'左膝','左腳踝/左腳','上背','右肩','右手肘/右前臂','下背','右手/右手腕','右臀/右大腿','右膝',
				'右腳踝/右腳','痠痛持續時間','是否工作加劇','最近3個月是否因上述不適而請假','請假幾天',
				'是否曾被醫師確診肌肉骨骼或神經系統相關疾病（需藥物、復健或手術治療)','診斷名稱','其他症狀、病史說明'];
				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
					$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
								  
								  $objWorkSheet->setCellValue($all_cell_title[0], $cell_title[0])
								  ->setCellValue($all_cell_title[1], $cell_title[1])
								  ->setCellValue($all_cell_title[2], $cell_title[2])
								  ->setCellValue($all_cell_title[3], $cell_title[3])
								  ->setCellValue($all_cell_title[4], $cell_title[4])
								  ->setCellValue($all_cell_title[5], $cell_title[5])
								  ->setCellValue($all_cell_title[6], $cell_title[6])
								  ->setCellValue($all_cell_title[7], $cell_title[7])
								  ->setCellValue($all_cell_title[8], $cell_title[8])
								  ->setCellValue($all_cell_title[9], $cell_title[9])
								  ->setCellValue($all_cell_title[10], $cell_title[10])
								  ->setCellValue($all_cell_title[11], $cell_title[11])
								  ->setCellValue($all_cell_title[12], $cell_title[12])
								  ->setCellValue($all_cell_title[13], $cell_title[13])
								  ->setCellValue($all_cell_title[14], $cell_title[14])
								  ->setCellValue($all_cell_title[15], $cell_title[15])
								  ->setCellValue($all_cell_title[16], $cell_title[16])
								  ->setCellValue($all_cell_title[17], $cell_title[17])
								  ->setCellValue($all_cell_title[18], $cell_title[18])
								  ->setCellValue($all_cell_title[19], $cell_title[19])
								  ->setCellValue($all_cell_title[20], $cell_title[20])
								  ->setCellValue($all_cell_title[21], $cell_title[21])
								  ->setCellValue($all_cell_title[22], $cell_title[22])
								  ->setCellValue($all_cell_title[23], $cell_title[23])
								  ->setCellValue($all_cell_title[24], $cell_title[24])
								  ->setCellValue($all_cell_title[25], $cell_title[25])
								  ->setCellValue($all_cell_title[26], $cell_title[26])
								  ->setCellValue($all_cell_title[27], $cell_title[27]);

								//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue($all_cell_name[0].$k , $question_ans_list[$j]->q21)
												  ->setCellValue($all_cell_name[1].$k , $question_ans_list[$j]->q5o)
												  ->setCellValue($all_cell_name[2].$k , $question_ans_list[$j]->q6o)
												  ->setCellValue($all_cell_name[3].$k , $question_ans_list[$j]->q7o)
												  ->setCellValue($all_cell_name[4].$k , $question_ans_list[$j]->q22)
												  ->setCellValue($all_cell_name[5].$k , $question_ans_list[$j]->q1)
												  ->setCellValue($all_cell_name[6].$k , $question_ans_list[$j]->q2)
												  ->setCellValue($all_cell_name[7].$k , $question_ans_list[$j]->q3)
												  ->setCellValue($all_cell_name[8].$k , $question_ans_list[$j]->q4)
												  ->setCellValue($all_cell_name[9].$k , $question_ans_list[$j]->q5)
												  ->setCellValue($all_cell_name[10].$k , $question_ans_list[$j]->q6)
												  ->setCellValue($all_cell_name[11].$k , $question_ans_list[$j]->q7)
												  ->setCellValue($all_cell_name[12].$k , $question_ans_list[$j]->q8)
												  ->setCellValue($all_cell_name[13].$k , $question_ans_list[$j]->q9)
												  ->setCellValue($all_cell_name[14].$k , $question_ans_list[$j]->q10)
												  ->setCellValue($all_cell_name[15].$k , $question_ans_list[$j]->q11)
												  ->setCellValue($all_cell_name[16].$k , $question_ans_list[$j]->q12)
												  ->setCellValue($all_cell_name[17].$k , $question_ans_list[$j]->q13)
												  ->setCellValue($all_cell_name[18].$k , $question_ans_list[$j]->q14)
												  ->setCellValue($all_cell_name[19].$k , $question_ans_list[$j]->q15)
												  ->setCellValue($all_cell_name[20].$k , $question_ans_list[$j]->q16)
												  ->setCellValue($all_cell_name[21].$k , $question_ans_list[$j]->q17)
												  ->setCellValue($all_cell_name[22].$k , $question_ans_list[$j]->q18)
												  ->setCellValue($all_cell_name[23].$k , $question_ans_list[$j]->q1o)
												  ->setCellValue($all_cell_name[24].$k , $question_ans_list[$j]->q19)
												  ->setCellValue($all_cell_name[25].$k , $question_ans_list[$j]->q2o)
												  ->setCellValue($all_cell_name[26].$k , $question_ans_list[$j]->q20)
												  ->setCellValue($all_cell_name[27].$k , $question_ans_list[$j]->q3o);
								
								  }
		  
		  
						$objWorkSheet->setTitle($question_ans_list[$i]->question_style_name);
				}
			  break;
			case 3:
				$cell_title = ['你常覺得疲勞嗎？','你常覺得身體上體力透支嗎？','你常覺得情緒上心力交瘁嗎？','你常會覺得，「我快要撐不下去了」嗎?',
				'你常覺得精疲力竭嗎？','你常常覺得虛弱，好像快要生病了嗎？',
				'個人相關疲勞分數','個人相關過勞分級','你的工作會令人情緒上心力交瘁嗎？','你的工作會讓你覺得快要累垮了嗎？','你的工作會讓你覺得挫折嗎？',
				'工作一整天之後，你覺得精疲力竭嗎？','上班之前只要想到又要工作一整天，你就覺得沒力嗎？','上班時你會覺得每一刻都很難熬嗎？',
				'不工作的時候，你有足夠的精力陪朋友或家人嗎？','工作相關疲勞分數','工作相關過勞分級'];
				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
					$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
				
								  $objWorkSheet->setCellValue($all_cell_title[0], $cell_title[0])
								  ->setCellValue($all_cell_title[1], $cell_title[1])
								  ->setCellValue($all_cell_title[2], $cell_title[2])
								  ->setCellValue($all_cell_title[3], $cell_title[3])
								  ->setCellValue($all_cell_title[4], $cell_title[4])
								  ->setCellValue($all_cell_title[5], $cell_title[5])
								  ->setCellValue($all_cell_title[6], $cell_title[6])
								  ->setCellValue($all_cell_title[7], $cell_title[7])
								  ->setCellValue($all_cell_title[8], $cell_title[8])
								  ->setCellValue($all_cell_title[9], $cell_title[9])
								  ->setCellValue($all_cell_title[10], $cell_title[10])
								  ->setCellValue($all_cell_title[11], $cell_title[11])
								  ->setCellValue($all_cell_title[12], $cell_title[12])
								  ->setCellValue($all_cell_title[13], $cell_title[13])
								  ->setCellValue($all_cell_title[14], $cell_title[14])
								  ->setCellValue($all_cell_title[15], $cell_title[15])
								  ->setCellValue($all_cell_title[16], $cell_title[16]);

								//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue($all_cell_name[0].$k , $question_ans_list[$j]->q1)
												  ->setCellValue($all_cell_name[1].$k , $question_ans_list[$j]->q2)
												  ->setCellValue($all_cell_name[2].$k , $question_ans_list[$j]->q3)
												  ->setCellValue($all_cell_name[3].$k , $question_ans_list[$j]->q4)
												  ->setCellValue($all_cell_name[4].$k , $question_ans_list[$j]->q5)
												  ->setCellValue($all_cell_name[5].$k , $question_ans_list[$j]->q6)
												  ->setCellValue($all_cell_name[6].$k , $question_ans_list[$j]->q1o)
												  ->setCellValue($all_cell_name[7].$k , $question_ans_list[$j]->q2o)
												  ->setCellValue($all_cell_name[8].$k , $question_ans_list[$j]->q7)
												  ->setCellValue($all_cell_name[9].$k , $question_ans_list[$j]->q8)
												  ->setCellValue($all_cell_name[10].$k , $question_ans_list[$j]->q9)
												  ->setCellValue($all_cell_name[11].$k , $question_ans_list[$j]->q10)
												  ->setCellValue($all_cell_name[12].$k , $question_ans_list[$j]->q11)
												  ->setCellValue($all_cell_name[13].$k , $question_ans_list[$j]->q12)
												  ->setCellValue($all_cell_name[14].$k , $question_ans_list[$j]->q13)
												  ->setCellValue($all_cell_name[15].$k , $question_ans_list[$j]->q3o)
												  ->setCellValue($all_cell_name[16].$k , $question_ans_list[$j]->q4o);

								  }
								//   $last = count($items_order)+2;
								//   $objWorkSheet->setCellValue('A'.$last , '')
								// 				  ->setCellValue('B'.$last , '')
								// 				  ->setCellValue('C'.$last, '')
								// 				  ->setCellValue('D'.$last, '')
								// 				  ->setCellValue('E'.$last, '')
								// 				  ->setCellValue('F'.$last , '總金額')
								// 				  ->setCellValue('G'.$last ,  $total);
		  
		  
						$objWorkSheet->setTitle($question_ans_list[$i]->question_style_name);
				}
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

	public function export_excel_all($id){
		// $id = $this -> get_get('id');
		$question_ans_list = $this -> question_ans_dao -> find_by_all_item($id);
	
		$fileName = $question_ans_list[0]->question_style_name.date('Y-m-d H:i:s').'.xls';

		$objPHPExcel = new PHPExcel();
		// $objPHPExcel->setActiveSheetIndex(0);
		// $objPHPExcel->getActiveSheet()->SetCellValue('A1', '部門名稱');
		// $objPHPExcel->getActiveSheet()->SetCellValue('B1', '主功能');
		// $objPHPExcel->getActiveSheet()->SetCellValue('C1', '權限項目');
		// $objPHPExcel->getActiveSheet()->SetCellValue('D1', '其他設定');
	
	
		// $sheet = $objPHPExcel->getActiveSheet();
		$all_cell_title = ['A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1',
		'L1','M1','N1','O1','P1','Q1','R1','S1','T1','U1','V1','W1','X1','Y1','Z1','AA1','AB1','AC1','AD1','AE1','AF1','AG1'];
		$all_cell_name = ['A','B','C','D','E','F','G','H','I','J','K',
				'L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG'];


		switch ($question_ans_list[0]->qs_id) {
		case 1:
		$cell_title = ['部門','姓名','工作型態','性別','年資','平均每週工作時數','班別','曾經遭遇的暴力攻擊情境',
		'公司提供有關預防暴力攻擊之衛生教育訓練','我清楚了解如何辨識職場發生的暴力危害',
		'我清楚了解如何進行暴力危害的風險評估','我清楚了解如何避免或遠離暴力危害事件',
		'我清楚了解暴力危害事件發生時如何尋求支援管道','我具備因應暴力危害事件的事務處理與執行能力'];
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating

		for ($i=0;$i<count($question_ans_list);$i++) {

		// Add new sheet

		$objWorkSheet->setCellValue($all_cell_title[0], $cell_title[0])
					->setCellValue($all_cell_title[1], $cell_title[1])
					->setCellValue($all_cell_title[2], $cell_title[2])
					->setCellValue($all_cell_title[3], $cell_title[3])
					->setCellValue($all_cell_title[4], $cell_title[4])
					->setCellValue($all_cell_title[5], $cell_title[5])
					->setCellValue($all_cell_title[6], $cell_title[6])
					->setCellValue($all_cell_title[7], $cell_title[7])
					->setCellValue($all_cell_title[8], $cell_title[8])
					->setCellValue($all_cell_title[9], $cell_title[9])
					->setCellValue($all_cell_title[10], $cell_title[10])
					->setCellValue($all_cell_title[11], $cell_title[11])
					->setCellValue($all_cell_title[12], $cell_title[12])
					->setCellValue($all_cell_title[13], $cell_title[13]);

					for ($j=0;$j<count($question_ans_list);$j++) {
						$k = $j+2;
						$objWorkSheet->setCellValue($all_cell_name[0].$k , $question_ans_list[$j]->dep_name)
									->setCellValue($all_cell_name[1].$k , $question_ans_list[$j]->user_name)
									->setCellValue($all_cell_name[2].$k , $question_ans_list[$j]->q1)
									->setCellValue($all_cell_name[3].$k , $question_ans_list[$j]->q2)
									->setCellValue($all_cell_name[4].$k , $question_ans_list[$j]->q3)
									->setCellValue($all_cell_name[5].$k , $question_ans_list[$j]->q4)
									->setCellValue($all_cell_name[6].$k , $question_ans_list[$j]->q5)
									->setCellValue($all_cell_name[7].$k , $question_ans_list[$j]->q6)
									->setCellValue($all_cell_name[8].$k , $question_ans_list[$j]->q7)
									->setCellValue($all_cell_name[9].$k , $question_ans_list[$j]->q8)
									->setCellValue($all_cell_name[10].$k , $question_ans_list[$j]->q9)
									->setCellValue($all_cell_name[11].$k , $question_ans_list[$j]->q10)
									->setCellValue($all_cell_name[12].$k , $question_ans_list[$j]->q11)
									->setCellValue($all_cell_name[13].$k , $question_ans_list[$j]->q12);

					}


				}
				$objWorkSheet->setTitle($question_ans_list[0]->question_style_name);

				break;
		case 2:
		$cell_title = ['部門','姓名','年齡','性別','身高','體重','慣用手','是否不適','頸','左肩','左手肘/左前臂','左手/左手腕','左臀/左大腿',
		'左膝','左腳踝/左腳','上背','右肩','右手肘/右前臂','下背','右手/右手腕','右臀/右大腿','右膝',
		'右腳踝/右腳','痠痛持續時間','是否工作加劇','最近3個月是否因上述不適而請假','請假幾天',
		'是否曾被醫師確診肌肉骨骼或神經系統相關疾病（需藥物、復健或手術治療)','診斷名稱','其他症狀、病史說明'];
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating

		for ($i=0;$i<count($question_ans_list);$i++) {

		// Add new sheet
					
					$objWorkSheet->setCellValue($all_cell_title[0], $cell_title[0])
					->setCellValue($all_cell_title[1], $cell_title[1])
					->setCellValue($all_cell_title[2], $cell_title[2])
					->setCellValue($all_cell_title[3], $cell_title[3])
					->setCellValue($all_cell_title[4], $cell_title[4])
					->setCellValue($all_cell_title[5], $cell_title[5])
					->setCellValue($all_cell_title[6], $cell_title[6])
					->setCellValue($all_cell_title[7], $cell_title[7])
					->setCellValue($all_cell_title[8], $cell_title[8])
					->setCellValue($all_cell_title[9], $cell_title[9])
					->setCellValue($all_cell_title[10], $cell_title[10])
					->setCellValue($all_cell_title[11], $cell_title[11])
					->setCellValue($all_cell_title[12], $cell_title[12])
					->setCellValue($all_cell_title[13], $cell_title[13])
					->setCellValue($all_cell_title[14], $cell_title[14])
					->setCellValue($all_cell_title[15], $cell_title[15])
					->setCellValue($all_cell_title[16], $cell_title[16])
					->setCellValue($all_cell_title[17], $cell_title[17])
					->setCellValue($all_cell_title[18], $cell_title[18])
					->setCellValue($all_cell_title[19], $cell_title[19])
					->setCellValue($all_cell_title[20], $cell_title[20])
					->setCellValue($all_cell_title[21], $cell_title[21])
					->setCellValue($all_cell_title[22], $cell_title[22])
					->setCellValue($all_cell_title[23], $cell_title[23])
					->setCellValue($all_cell_title[24], $cell_title[24])
					->setCellValue($all_cell_title[25], $cell_title[25])
					->setCellValue($all_cell_title[26], $cell_title[26])
					->setCellValue($all_cell_title[27], $cell_title[27])
					->setCellValue($all_cell_title[28], $cell_title[28])
					->setCellValue($all_cell_title[29], $cell_title[29]);

					//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
					for ($j=0;$j<count($question_ans_list);$j++) {
						$k = $j+2;
						$objWorkSheet->setCellValue($all_cell_name[0].$k , $question_ans_list[$j]->dep_name)
									->setCellValue($all_cell_name[1].$k , $question_ans_list[$j]->user_name)
									->setCellValue($all_cell_name[2].$k , $question_ans_list[$j]->q21)
									->setCellValue($all_cell_name[3].$k , $question_ans_list[$j]->q5o)
									->setCellValue($all_cell_name[4].$k , $question_ans_list[$j]->q6o)
									->setCellValue($all_cell_name[5].$k , $question_ans_list[$j]->q7o)
									->setCellValue($all_cell_name[6].$k , $question_ans_list[$j]->q22)
									->setCellValue($all_cell_name[7].$k , $question_ans_list[$j]->q1)
									->setCellValue($all_cell_name[8].$k , $question_ans_list[$j]->q2)
									->setCellValue($all_cell_name[9].$k , $question_ans_list[$j]->q3)
									->setCellValue($all_cell_name[10].$k , $question_ans_list[$j]->q4)
									->setCellValue($all_cell_name[11].$k , $question_ans_list[$j]->q5)
									->setCellValue($all_cell_name[12].$k , $question_ans_list[$j]->q6)
									->setCellValue($all_cell_name[13].$k , $question_ans_list[$j]->q1o)
									->setCellValue($all_cell_name[14].$k , $question_ans_list[$j]->q7)
									->setCellValue($all_cell_name[15].$k , $question_ans_list[$j]->q8)
									->setCellValue($all_cell_name[16].$k , $question_ans_list[$j]->q9)
									->setCellValue($all_cell_name[17].$k , $question_ans_list[$j]->q10)
									->setCellValue($all_cell_name[18].$k , $question_ans_list[$j]->q11)
									->setCellValue($all_cell_name[19].$k , $question_ans_list[$j]->q12)
									->setCellValue($all_cell_name[20].$k , $question_ans_list[$j]->q13)
									->setCellValue($all_cell_name[21].$k , $question_ans_list[$j]->q14)
									->setCellValue($all_cell_name[22].$k , $question_ans_list[$j]->q15)
									->setCellValue($all_cell_name[23].$k , $question_ans_list[$j]->q16)
									->setCellValue($all_cell_name[24].$k , $question_ans_list[$j]->q17)
									->setCellValue($all_cell_name[25].$k , $question_ans_list[$j]->q18)
									->setCellValue($all_cell_name[26].$k , $question_ans_list[$j]->q19)
									->setCellValue($all_cell_name[27].$k , $question_ans_list[$j]->q2o)
									->setCellValue($all_cell_name[28].$k , $question_ans_list[$j]->q20)
									->setCellValue($all_cell_name[29].$k , $question_ans_list[$j]->q3o);
					
					}


			}
			$objWorkSheet->setTitle($question_ans_list[0]->question_style_name);

			break;
		case 3:
		$cell_title = ['部門','姓名','你常覺得疲勞嗎？','你常覺得身體上體力透支嗎？','你常覺得情緒上心力交瘁嗎？','你常會覺得，「我快要撐不下去了」嗎?',
		'你常覺得精疲力竭嗎？','你常常覺得虛弱，好像快要生病了嗎？',
		'個人相關疲勞分數','個人相關過勞分級','你的工作會令人情緒上心力交瘁嗎？','你的工作會讓你覺得快要累垮了嗎？','你的工作會讓你覺得挫折嗎？',
		'工作一整天之後，你覺得精疲力竭嗎？','上班之前只要想到又要工作一整天，你就覺得沒力嗎？','上班時你會覺得每一刻都很難熬嗎？',
		'不工作的時候，你有足夠的精力陪朋友或家人嗎？','工作相關疲勞分數','工作相關過勞分級'];
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating

		for ($i=0;$i<count($question_ans_list);$i++) {

		// Add new sheet

					$objWorkSheet->setCellValue($all_cell_title[0], $cell_title[0])
					->setCellValue($all_cell_title[1], $cell_title[1])
					->setCellValue($all_cell_title[2], $cell_title[2])
					->setCellValue($all_cell_title[3], $cell_title[3])
					->setCellValue($all_cell_title[4], $cell_title[4])
					->setCellValue($all_cell_title[5], $cell_title[5])
					->setCellValue($all_cell_title[6], $cell_title[6])
					->setCellValue($all_cell_title[7], $cell_title[7])
					->setCellValue($all_cell_title[8], $cell_title[8])
					->setCellValue($all_cell_title[9], $cell_title[9])
					->setCellValue($all_cell_title[10], $cell_title[10])
					->setCellValue($all_cell_title[11], $cell_title[11])
					->setCellValue($all_cell_title[12], $cell_title[12])
					->setCellValue($all_cell_title[13], $cell_title[13])
					->setCellValue($all_cell_title[14], $cell_title[14])
					->setCellValue($all_cell_title[15], $cell_title[15])
					->setCellValue($all_cell_title[16], $cell_title[16])
					->setCellValue($all_cell_title[17], $cell_title[17])
					->setCellValue($all_cell_title[18], $cell_title[18]);

					//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
					for ($j=0;$j<count($question_ans_list);$j++) {
						$k = $j+2;
						$objWorkSheet->setCellValue($all_cell_name[0].$k , $question_ans_list[$j]->dep_name)
									->setCellValue($all_cell_name[1].$k , $question_ans_list[$j]->user_name)
									->setCellValue($all_cell_name[2].$k , $question_ans_list[$j]->q1)
									->setCellValue($all_cell_name[3].$k , $question_ans_list[$j]->q2)
									->setCellValue($all_cell_name[4].$k , $question_ans_list[$j]->q3)
									->setCellValue($all_cell_name[5].$k , $question_ans_list[$j]->q4)
									->setCellValue($all_cell_name[6].$k , $question_ans_list[$j]->q5)
									->setCellValue($all_cell_name[7].$k , $question_ans_list[$j]->q6)
									->setCellValue($all_cell_name[8].$k , $question_ans_list[$j]->q1o)
									->setCellValue($all_cell_name[9].$k , $question_ans_list[$j]->q2o)
									->setCellValue($all_cell_name[10].$k , $question_ans_list[$j]->q7)
									->setCellValue($all_cell_name[11].$k , $question_ans_list[$j]->q8)
									->setCellValue($all_cell_name[12].$k , $question_ans_list[$j]->q9)
									->setCellValue($all_cell_name[13].$k , $question_ans_list[$j]->q10)
									->setCellValue($all_cell_name[14].$k , $question_ans_list[$j]->q11)
									->setCellValue($all_cell_name[15].$k , $question_ans_list[$j]->q12)
									->setCellValue($all_cell_name[16].$k , $question_ans_list[$j]->q13)
									->setCellValue($all_cell_name[17].$k , $question_ans_list[$j]->q3o)
									->setCellValue($all_cell_name[18].$k , $question_ans_list[$j]->q4o);

					}
					//   $last = count($items_order)+2;
					//   $objWorkSheet->setCellValue('A'.$last , '')
					// 				  ->setCellValue('B'.$last , '')
					// 				  ->setCellValue('C'.$last, '')
					// 				  ->setCellValue('D'.$last, '')
					// 				  ->setCellValue('E'.$last, '')
					// 				  ->setCellValue('F'.$last , '總金額')
					// 				  ->setCellValue('G'.$last ,  $total);

		}
			$objWorkSheet->setTitle($question_ans_list[0]->question_style_name);

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
	
}
