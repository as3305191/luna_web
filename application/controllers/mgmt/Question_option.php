<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_option extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Question_option_dao', 'dao');
		$this -> load -> model('Question_style_dao', 'question_style_dao');
		$this -> load -> model('Question_ans_dao', 'question_ans_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Department_dao','d_dao');

		$this -> load-> library('word');
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
		// $res['items'] = array();
		$finish_list = array();
		$item_id = $this -> get_post('item_id');
		$q_option_list = $this -> dao -> find_by_id($item_id);
		$q_style_list = $this -> question_style_dao -> find_by_id($q_option_list->question_style_id);

		if($q_style_list->for_dep==0){
			$items_list = $this -> question_ans_dao -> find_all_finish($item_id);
			$all_user_list =  $this -> users_dao -> find_all_ktx_user();
			$items_new_list[] = $all_user_list;
			if(count($items_list)>0){
				foreach($items_list as $each_item){
					foreach($all_user_list as $each_user){
						if($each_item->user_id==$each_user->id){
							$finish_list[] = $each_user;
						}
					}
				}
				foreach($finish_list as $each_f){
					$key = array_search($each_f,$all_user_list);
					unset($all_user_list[$key]);
				}
				$res['items'] = $all_user_list;

			} else{
				$res['items'] = $all_user_list;
			}

		} else{
			if($q_style_list->for_dep==1){
				$items_list_for_dep= array();
				$q_ans_is_finish = $this -> question_ans_dao -> find_all_finish_role($item_id);
				$new_q_ans_is_finish = array();
				foreach($q_ans_is_finish as $each){
					$new_q_ans_is_finish[] = $each->role_id;
				}
				$items_list = $this -> d_dao -> find_all_ktx_dep();
				foreach($items_list as $each){
					if(!in_array($each->id,$new_q_ans_is_finish)){
						$all_div_list = $this -> d_dao -> find_under_roles($each->id);
						if(!empty($all_div_list)){
							foreach($all_div_list as $each_div){
								if(!in_array($each_div->id,$new_q_ans_is_finish)){
									$items_list_for_dep[]= $each_div;
								}
							}
						} else{
							$items_list_for_dep[]= $each;
						}
					}
					
				}
				$res['items'] = $items_list_for_dep;
				$res['q_ans_is_finish'] = $new_q_ans_is_finish;

			} else{
				if($q_style_list->for_dep==2){
					$items_list_for_dep= array();
					$q_ans_is_finish = $this -> question_ans_dao -> find_all_finish_role($item_id);
					$new_q_ans_is_finish = array();
					foreach($q_ans_is_finish as $each){
						$new_q_ans_is_finish[] = $each->role_id;
					}
					$items_list = $this -> d_dao -> find_all_ktx_dep();
					foreach($items_list as $each){
						if(!in_array($each->id,$new_q_ans_is_finish)){
							$items_list_for_dep[]= $each;
						}
					}
					$res['items'] = $items_list_for_dep;
					$res['q_ans_is_finish'] = $new_q_ans_is_finish;
	
				}
			}
		}
		
		$res['for_dep'] = $q_style_list->for_dep;

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
		$id= $this -> get_post('item_id');
		$items = $this -> question_ans_dao -> find_all_each_detail($data);
		$q_o_list = $this -> dao -> find_by_this_id($id);
		if(count($items)>0){
			
			foreach($items as $each){
				$each->for_dep = $q_o_list[0]->for_dep;
			}
			$res['items'] = $items;
		} else{
			$res['items'] = $items;
			$res['items']['for_dep'] = $q_o_list[0]->for_dep;

		}
	
	
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
		// $this -> to_json($data);

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
		$note='';
		if(!empty($question_ans_list[0]->note) && $question_ans_list[0]->note!==''){
			$note.='-'.$question_ans_list[0]->note;
		}
		$fileName = $question_ans_list[0]->question_style_name.$note."(".$question_ans_list[0]->user_name.")-".date('Y-m-d H:i:s').'.xls';

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
		  
		  
						$objWorkSheet->setTitle($question_ans_list[$i]->question_style_name.$note);
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
		  
		  
						$objWorkSheet->setTitle($question_ans_list[$i]->question_style_name.$note);
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
								
		  
						$objWorkSheet->setTitle($question_ans_list[$i]->question_style_name.$note);
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
		$question_option= $this -> dao -> find_by_id($id);
		$question_style= $this -> question_style_dao -> find_by_id($question_option->question_style_id);
		$note='';
		if(!empty($question_option->note) && $question_option->note!==''){
			$note.='-'.$question_option->note;
		}
		
		$fileName = $question_style->question_style_name.$note.'-'.date('Y-m-d H:i:s').'.xls';

		$objPHPExcel = new PHPExcel();
	
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
				$objWorkSheet->setTitle($question_style->question_style_name.$note);

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
			$objWorkSheet->setTitle($question_style->question_style_name.$note);

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
				

		}
			$objWorkSheet->setTitle($question_style->question_style_name.$note);

			break;
			case 5:
				$cell_title = ['是否有組織外之人員(承攬商、客戶、服務對象或親友等)因其行為無法預知，可能成為該區工作者不法侵害來源',
				'是否有已知工作會接觸有暴力史客戶','勞工工作性質是否為執行公共安全業務',
				'勞工工作是否為單獨作業','勞工是否需於深夜或凌晨工作','勞工是否需於較陌生環境工作','勞工工作是否涉及現金交易、運送或處理貴重物品',
				'勞工工作是否為直接面對群眾之第一線服務工作','勞工工作是否會與酗酒、毒癮或精神疾病患者接觸','勞工工作是否需接觸絕望或恐懼或極需被關懷照顧者',
				'勞工當中是否有自行通報因私人關係遭受不法侵害威脅者或為家庭暴力受害者','新進勞工是否有尚未接受職場不法侵害預防教育訓練者',
				'工作場所是否位於交通不便，偏遠地區','工作環境中是否有讓施暴者隱藏的地方','離開工作場所後，是否可能遭遇因執行職務所致之不法侵害行為',
				'組織內是否曾發生主管或勞工遭受同事(含上司)不當言行對待','是否有無法接受不同性別、年齡、國籍或宗教信仰工作者',
				'是否有同仁離職或請求調職原因源於職場不法侵害事件之發生','是否有被同仁排擠或工作適應不良者','內部是否有酗酒、毒癮之工作者',
				'內部是否有處於情緒低落、絕望或恐懼，極需被關懷照顧工作者','是否有超時工作，反應工作壓力大工作者','工作環境是否有空間擁擠，照明設備不足問題，工作場所出入是否未有相當管制措施'];
				$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
				for ($i=0;$i<count($cell_title);$i++){
					$new_num = $i+2;
					$objWorkSheet->setCellValue($all_cell_name[0].$new_num, $cell_title[$i]); 
			    }
				for ($j=0;$j<count($question_ans_list);$j++){//每7 option為1題
					$new_num = $j+1;
					$new_num_2 = $i+2;
					$objWorkSheet->setCellValue($all_cell_name[$new_num].$new_num_2, $question_ans_list[$j]->dep_name);

				}
				$objWorkSheet->setTitle($question_style->question_style_name.$note);
	
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

	function export_all_word($id) {
		$question_ans_list = $this -> question_ans_dao -> find_by_all_item_6($id);
		$list = $question_ans_list[0];
		$new_q1o = preg_replace('/\s(?=)/', '/n', $list->q1o);
		$stringArr=explode("/n", $new_q1o);
		$count_q1o = count($stringArr);

		$total=0;
		$find_dep = $this -> d_dao -> find_by_id($list->role_id);
		if($find_dep->parent_id==5){
			$find_dep_list = $find_dep;
		} else{
			$find_dep_list = $this -> d_dao -> find_by("id",$find_dep->parent_id);

		}
		foreach($list as $key => $value){
			if(substr($key, 0, 1)=='q'&&substr($key, 1, 1)!=='u'&&$value!==null){
				switch ($value) {
					case 6:
						$items[] = 'E';
						$num[] = $value;
					break;
					case 7:
						$items[] = 'D';
						$num[] = $value;
					break;
					case 8:
						$items[] = 'C';
						$num[] = $value;
					break;
					case 9:
						$items[] = 'B';
						$num[] = $value;
					break;
					case 10:
						$items[] = 'A';
						$num[] = $value;
					break;

				}
			}
		}
		for($i=0;$i<10;$i++){
			$total += intval($num[$i]);
		}
		$PHPWord = new PHPWord();
		$PHPWord->setDefaultFontName('華康仿宋體W4'); 
		// $section = $PHPWord->createSection();
		$sectionStyle = array('orientation' => null,  'marginLeft' => 1000,  'marginRight' => 1000); //頁面設定
		$section = $PHPWord->createSection($sectionStyle); //建立一個頁面
		
		$tableStyle = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80);
		$whitetableStyle = array('borderSize'=>6, 'borderColor'=>'ffffff', 'cellMargin'=>80);
		$footer_style = array('borderSize'=>6, 'borderColor'=>'ffffff', 'cellMargin'=>80);

		$PHPWord->addTableStyle('white_tableStyle',$whitetableStyle,null);
		$PHPWord->addTableStyle('tableStyle',$tableStyle,null);
		$PHPWord->addTableStyle('footer_tableStyle',$footer_style,null);

		$white_table = $section->addTable('white_tableStyle');
		$table = $section->addTable('tableStyle');
		$footer_table = $section->addTable('footer_tableStyle');
		$white_table->addRow();
		$white_table->addCell(10000,null,8)->addText('寬仕工業股份有限公司',array('bold' => true, 'size'=>25),array('align'=>'center'));
		$white_table->addRow();
		$white_table->addCell(10000,null,8)->addText('滿意度雙向調查-'.$list->note,array('bold' => true, 'size'=>20),array('align'=>'center'));
		$white_table->addRow();
		$white_table->addCell(10000,null,8)->addText($find_dep_list->name,array('size'=>20),array('align'=>'right'));
		
		$table->addRow(2500);
		$table_score = $table->addCell(10000,null,8);
		$table_score->addText('員工滿意度(A：10分; B：9分; C：8分; D：7分; E：6分):',array('size'=>13),array('align'=>'left'));
		$table_score->addText('系統:'.$items[0].','.'制度:'.$items[1].','.'成本:'.$items[2].','.'協助:'.$items[3].','.'彈性:'.$items[4],array('size'=>13),array('align'=>'left'));
		$table_score->addText('分工:'.$items[5].','.'訓練:'.$items[6].','.'福利:'.$items[7].','.'分享:'.$items[8].','.'公平:'.$items[9],array('size'=>13),array('align'=>'left'));
		$table_score->addText('總分: '.$total,array('size'=>15),array('align'=>'left'));

		$table->addRow(3500);
		$table_note = $table->addCell(10000,null,8);
		$table_note->addText('其他意見有問有答：',array('size'=>13),array('align'=>'left'));
		for($i=0;$i<$count_q1o;$i++){
			$table_note->addText($stringArr[$i],array('size'=>13),array('align'=>'left'));
		}

		$table->addRow(4000);
		$table->addCell(10000,null,8)->addText('公司回覆：',array('size'=>13),array('align'=>'left'));

		$date = date('YmdHis');
		$filename = $list->dep_name."-".$list->note."-滿意度雙向調查".$date.".docx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save('php://output');
	}

	function countString($string, $substring) {
		$count = 0;
		$pos = stripos($string, $substring);
		while ($pos !== false) {
			$count++;
			$pos = stripos($string, $substring, $pos + 1);
		}
		return $count;
	}
}
