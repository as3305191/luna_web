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

		switch ($question_ans_list[0]->qs_id) {
			case 1:
				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
					$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
			  
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

								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue('A'.$k , $question_ans_list[$j]->q1)
												  ->setCellValue('B'.$k , $question_ans_list[$j]->q2)
												  ->setCellValue('C'.$k , $question_ans_list[$j]->q3)
												  ->setCellValue('D'.$k , $question_ans_list[$j]->q4)
												  ->setCellValue('E'.$k , $question_ans_list[$j]->q5)
												  ->setCellValue('F'.$k , $question_ans_list[$j]->q6)
												  ->setCellValue('G'.$k , $question_ans_list[$j]->q7)
												  ->setCellValue('H'.$k , $question_ans_list[$j]->q8)
												  ->setCellValue('I'.$k , $question_ans_list[$j]->q9)
												  ->setCellValue('J'.$k , $question_ans_list[$j]->q10)
												  ->setCellValue('K'.$k , $question_ans_list[$j]->q11)
												  ->setCellValue('L'.$k , $question_ans_list[$j]->q12);

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
			case 2:
				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
					$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
			  
					//Write cells
					  $objWorkSheet->setCellValue('A1', '是否不適')
								  ->setCellValue('B1', '頸')
								  ->setCellValue('C1', '左肩')
								  ->setCellValue('D1', '左手肘/左前臂')
								  ->setCellValue('E1', '左手/左手腕')
								  ->setCellValue('F1', '左臀/左大腿')
								  ->setCellValue('G1', '左膝')
								  ->setCellValue('H1', '左腳踝/左腳')
								  ->setCellValue('I1', '上背')
								  ->setCellValue('J1', '右肩')
								  ->setCellValue('K1', '右手肘/右前臂')
								  ->setCellValue('L1', '下背')
								  ->setCellValue('M1', '右手/右手腕')
								  ->setCellValue('N1', '右臀/右大腿')
								  ->setCellValue('O1', '右膝')
								  ->setCellValue('P1', '右腳踝/右腳')
								  ->setCellValue('Q1', '痠痛持續時間')
								  ->setCellValue('R1', '是否工作加劇')
								  ->setCellValue('S1', '最近3個月是否因上述不適而請假')
								  ->setCellValue('T1', '請假幾天')
								  ->setCellValue('U1', '是否曾被醫師確診肌肉骨骼或神經系統相關疾病（需藥物、復健或手術治療)')
								  ->setCellValue('V1', '診斷名稱')
								  ->setCellValue('W1', '其他症狀、病史說明');
								  

								//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue('A'.$k , $question_ans_list[$j]->q1)
												  ->setCellValue('B'.$k , $question_ans_list[$j]->q2)
												  ->setCellValue('C'.$k , $question_ans_list[$j]->q3)
												  ->setCellValue('D'.$k , $question_ans_list[$j]->q4)
												  ->setCellValue('E'.$k , $question_ans_list[$j]->q5)
												  ->setCellValue('F'.$k , $question_ans_list[$j]->q6)
												  ->setCellValue('G'.$k , $question_ans_list[$j]->q7)
												  ->setCellValue('H'.$k , $question_ans_list[$j]->q8)
												  ->setCellValue('I'.$k , $question_ans_list[$j]->q9)
												  ->setCellValue('J'.$k , $question_ans_list[$j]->q10)
												  ->setCellValue('K'.$k , $question_ans_list[$j]->q11)
												  ->setCellValue('L'.$k , $question_ans_list[$j]->q12)
												  ->setCellValue('M'.$k , $question_ans_list[$j]->q13)
												  ->setCellValue('N'.$k , $question_ans_list[$j]->q14)
												  ->setCellValue('O'.$k , $question_ans_list[$j]->q15)
												  ->setCellValue('P'.$k , $question_ans_list[$j]->q16)
												  ->setCellValue('Q'.$k , $question_ans_list[$j]->q17)
												  ->setCellValue('R'.$k , $question_ans_list[$j]->q18)
												  ->setCellValue('S'.$k , $question_ans_list[$j]->q19)
												  ->setCellValue('T'.$k , $question_ans_list[$j]->q1o)
												  ->setCellValue('U'.$k , $question_ans_list[$j]->q20)
												  ->setCellValue('V'.$k , $question_ans_list[$j]->q2o)
												  ->setCellValue('W'.$k , $question_ans_list[$j]->q3o);
								
								  }
		  
		  
						$objWorkSheet->setTitle($question_ans_list[$i]->question_style_name);
				}
			  break;
			case 3:
				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
					$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
			  
					//Write cells
					  $objWorkSheet->setCellValue('A1', '你常覺得疲勞嗎？')
								  ->setCellValue('B1', '你常覺得身體上體力透支嗎？')
								  ->setCellValue('C1', '你常覺得情緒上心力交瘁嗎？')
								  ->setCellValue('D1', '你常會覺得，「我快要撐不下去了」嗎?')
								  ->setCellValue('E1', '你常覺得精疲力竭嗎？')
								  ->setCellValue('F1', '你常常覺得虛弱，好像快要生病了嗎？')
								  ->setCellValue('G1', '個人相關疲勞分數')
								  ->setCellValue('H1', '個人相關過勞分級')
								  ->setCellValue('I1', '你的工作會令人情緒上心力交瘁嗎？')
								  ->setCellValue('J1', '你的工作會讓你覺得快要累垮了嗎？')
								  ->setCellValue('K1', '你的工作會讓你覺得挫折嗎？')
								  ->setCellValue('L1', '工作一整天之後，你覺得精疲力竭嗎？')
								  ->setCellValue('M1', '上班之前只要想到又要工作一整天，你就覺得沒力嗎？')
								  ->setCellValue('N1', '上班時你會覺得每一刻都很難熬嗎？')
								  ->setCellValue('O1', '不工作的時候，你有足夠的精力陪朋友或家人嗎？')
								  ->setCellValue('p1', '工作相關疲勞分數')
								  ->setCellValue('Q1', '工作相關過勞分級');

								//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue('A'.$k , $question_ans_list[$j]->q1)
												  ->setCellValue('B'.$k , $question_ans_list[$j]->q2)
												  ->setCellValue('C'.$k , $question_ans_list[$j]->q3)
												  ->setCellValue('D'.$k , $question_ans_list[$j]->q4)
												  ->setCellValue('E'.$k , $question_ans_list[$j]->q5)
												  ->setCellValue('F'.$k , $question_ans_list[$j]->q6)
												  ->setCellValue('G'.$k , $question_ans_list[$j]->q1o)
												  ->setCellValue('H'.$k , $question_ans_list[$j]->q2o)
												  ->setCellValue('I'.$k , $question_ans_list[$j]->q7)
												  ->setCellValue('J'.$k , $question_ans_list[$j]->q8)
												  ->setCellValue('K'.$k , $question_ans_list[$j]->q9)
												  ->setCellValue('L'.$k , $question_ans_list[$j]->q10)
												  ->setCellValue('M'.$k , $question_ans_list[$j]->q11)
												  ->setCellValue('N'.$k , $question_ans_list[$j]->q12)
												  ->setCellValue('O'.$k , $question_ans_list[$j]->q13)
												  ->setCellValue('P'.$k , $question_ans_list[$j]->q3o)
												  ->setCellValue('Q'.$k , $question_ans_list[$j]->q4o);

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

		switch ($question_ans_list[0]->qs_id) {
			case 1:
				$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating

				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
			  
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

								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue('A'.$k , $question_ans_list[$j]->q1)
												  ->setCellValue('B'.$k , $question_ans_list[$j]->q2)
												  ->setCellValue('C'.$k , $question_ans_list[$j]->q3)
												  ->setCellValue('D'.$k , $question_ans_list[$j]->q4)
												  ->setCellValue('E'.$k , $question_ans_list[$j]->q5)
												  ->setCellValue('F'.$k , $question_ans_list[$j]->q6)
												  ->setCellValue('G'.$k , $question_ans_list[$j]->q7)
												  ->setCellValue('H'.$k , $question_ans_list[$j]->q8)
												  ->setCellValue('I'.$k , $question_ans_list[$j]->q9)
												  ->setCellValue('J'.$k , $question_ans_list[$j]->q10)
												  ->setCellValue('K'.$k , $question_ans_list[$j]->q11)
												  ->setCellValue('L'.$k , $question_ans_list[$j]->q12);

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
			case 2:
				$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating

				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
			  
					//Write cells
					  $objWorkSheet->setCellValue('A1', '是否不適')
								  ->setCellValue('B1', '頸')
								  ->setCellValue('C1', '左肩')
								  ->setCellValue('D1', '左手肘/左前臂')
								  ->setCellValue('E1', '左手/左手腕')
								  ->setCellValue('F1', '左臀/左大腿')
								  ->setCellValue('G1', '左膝')
								  ->setCellValue('H1', '左腳踝/左腳')
								  ->setCellValue('I1', '上背')
								  ->setCellValue('J1', '右肩')
								  ->setCellValue('K1', '右手肘/右前臂')
								  ->setCellValue('L1', '下背')
								  ->setCellValue('M1', '右手/右手腕')
								  ->setCellValue('N1', '右臀/右大腿')
								  ->setCellValue('O1', '右膝')
								  ->setCellValue('P1', '右腳踝/右腳')
								  ->setCellValue('Q1', '痠痛持續時間')
								  ->setCellValue('R1', '是否工作加劇')
								  ->setCellValue('S1', '最近3個月是否因上述不適而請假')
								  ->setCellValue('T1', '請假幾天')
								  ->setCellValue('U1', '是否曾被醫師確診肌肉骨骼或神經系統相關疾病（需藥物、復健或手術治療)')
								  ->setCellValue('V1', '診斷名稱')
								  ->setCellValue('W1', '其他症狀、病史說明');
								  

								//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue('A'.$k , $question_ans_list[$j]->q1)
												  ->setCellValue('B'.$k , $question_ans_list[$j]->q2)
												  ->setCellValue('C'.$k , $question_ans_list[$j]->q3)
												  ->setCellValue('D'.$k , $question_ans_list[$j]->q4)
												  ->setCellValue('E'.$k , $question_ans_list[$j]->q5)
												  ->setCellValue('F'.$k , $question_ans_list[$j]->q6)
												  ->setCellValue('G'.$k , $question_ans_list[$j]->q7)
												  ->setCellValue('H'.$k , $question_ans_list[$j]->q8)
												  ->setCellValue('I'.$k , $question_ans_list[$j]->q9)
												  ->setCellValue('J'.$k , $question_ans_list[$j]->q10)
												  ->setCellValue('K'.$k , $question_ans_list[$j]->q11)
												  ->setCellValue('L'.$k , $question_ans_list[$j]->q12)
												  ->setCellValue('M'.$k , $question_ans_list[$j]->q13)
												  ->setCellValue('N'.$k , $question_ans_list[$j]->q14)
												  ->setCellValue('O'.$k , $question_ans_list[$j]->q15)
												  ->setCellValue('P'.$k , $question_ans_list[$j]->q16)
												  ->setCellValue('Q'.$k , $question_ans_list[$j]->q17)
												  ->setCellValue('R'.$k , $question_ans_list[$j]->q18)
												  ->setCellValue('S'.$k , $question_ans_list[$j]->q19)
												  ->setCellValue('T'.$k , $question_ans_list[$j]->q1o)
												  ->setCellValue('U'.$k , $question_ans_list[$j]->q20)
												  ->setCellValue('V'.$k , $question_ans_list[$j]->q2o)
												  ->setCellValue('W'.$k , $question_ans_list[$j]->q3o);
								
								  }
		  
		  
				}
				$objWorkSheet->setTitle($question_ans_list[0]->question_style_name);

			  break;
			case 3:
				$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating

				for ($i=0;$i<count($question_ans_list);$i++) {
	
					// Add new sheet
			  
					//Write cells
					  $objWorkSheet->setCellValue('A1', '你常覺得疲勞嗎？')
								  ->setCellValue('B1', '你常覺得身體上體力透支嗎？')
								  ->setCellValue('C1', '你常覺得情緒上心力交瘁嗎？')
								  ->setCellValue('D1', '你常會覺得，「我快要撐不下去了」嗎?')
								  ->setCellValue('E1', '你常覺得精疲力竭嗎？')
								  ->setCellValue('F1', '你常常覺得虛弱，好像快要生病了嗎？')
								  ->setCellValue('G1', '個人相關疲勞分數')
								  ->setCellValue('H1', '個人相關過勞分級')
								  ->setCellValue('I1', '你的工作會令人情緒上心力交瘁嗎？')
								  ->setCellValue('J1', '你的工作會讓你覺得快要累垮了嗎？')
								  ->setCellValue('K1', '你的工作會讓你覺得挫折嗎？')
								  ->setCellValue('L1', '工作一整天之後，你覺得精疲力竭嗎？')
								  ->setCellValue('M1', '上班之前只要想到又要工作一整天，你就覺得沒力嗎？')
								  ->setCellValue('N1', '上班時你會覺得每一刻都很難熬嗎？')
								  ->setCellValue('O1', '不工作的時候，你有足夠的精力陪朋友或家人嗎？')
								  ->setCellValue('p1', '工作相關疲勞分數')
								  ->setCellValue('Q1', '工作相關過勞分級');

								//   $items_order = $this -> menu_order_dao -> find_order_by_menu($items[$i]->id);
								  for ($j=0;$j<count($question_ans_list);$j++) {
									  $k = $j+2;
									  $objWorkSheet->setCellValue('A'.$k , $question_ans_list[$j]->q1)
												  ->setCellValue('B'.$k , $question_ans_list[$j]->q2)
												  ->setCellValue('C'.$k , $question_ans_list[$j]->q3)
												  ->setCellValue('D'.$k , $question_ans_list[$j]->q4)
												  ->setCellValue('E'.$k , $question_ans_list[$j]->q5)
												  ->setCellValue('F'.$k , $question_ans_list[$j]->q6)
												  ->setCellValue('G'.$k , $question_ans_list[$j]->q1o)
												  ->setCellValue('H'.$k , $question_ans_list[$j]->q2o)
												  ->setCellValue('I'.$k , $question_ans_list[$j]->q7)
												  ->setCellValue('J'.$k , $question_ans_list[$j]->q8)
												  ->setCellValue('K'.$k , $question_ans_list[$j]->q9)
												  ->setCellValue('L'.$k , $question_ans_list[$j]->q10)
												  ->setCellValue('M'.$k , $question_ans_list[$j]->q11)
												  ->setCellValue('N'.$k , $question_ans_list[$j]->q12)
												  ->setCellValue('O'.$k , $question_ans_list[$j]->q13)
												  ->setCellValue('P'.$k , $question_ans_list[$j]->q3o)
												  ->setCellValue('Q'.$k , $question_ans_list[$j]->q4o);

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
