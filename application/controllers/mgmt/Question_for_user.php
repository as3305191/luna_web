<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_for_user extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Question_option_dao', 'question_option_dao');
		$this -> load -> model('Question_style_dao', 'question_style_dao');
		$this -> load -> model('Question_ans_dao', 'question_ans_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Department_dao','d_dao');
		// $this -> load -> model('Swot_dao', 'swot_dao');

		// $this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$s_data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		if($login_user->role_id=='9'||$login_user->role_id=='16'){
			$under_role_list = $this -> d_dao -> find_under_roles(6);
		}
		if($login_user->role_id=='53'){//孟利權限轉管理部
			$under_role_list = $this -> d_dao -> find_under_roles(6);
		} else{
			if($login_user->role_id=='71'){//特別權限：採購(訂飲料更改權限)
				$under_role_list = $this -> d_dao -> find_under_roles(26);
			} else{
				$under_role_list = $this -> d_dao -> find_under_roles($login_user->role_id);
			}
		}
		if(empty($under_role_list)){
			$under_role_list= $this -> d_dao -> find_by_this_id($login_user->role_id);
		}
		$question_option_open_list = $this -> question_option_dao -> find_all_open_question();

		foreach ($question_option_open_list as $each){
			$question_option_open_list_user = $this -> question_ans_dao -> find_all_not_write($data['login_user_id'],$each->id);

			if(count($question_option_open_list_user)<1){
				if($each->note==''){
					$title=$each->qs_name;
				} else{
					$title=$each->qs_name.'-'.$each->note;
				}
				if($each->question_style_id!==5){
					$data['question_option_id_list'][] = array (
						"id" => $each->id,
						"question_style_id" => $each->question_style_id,
						"question_title" => $title,
					);
				}
				
				
			}
		}
		if($login_user->lang=='cht'){
			$question_option_open_list_for_dep_1 = $this -> question_option_dao -> find_all_open_question_for_dep_1();

			foreach ($question_option_open_list_for_dep_1 as $each){

				$question_option_open_list_dep = $this -> question_ans_dao -> find_all_with_dep($each->id);
				if(empty($question_option_open_list_dep)){
					if(!empty($under_role_list)){
						foreach ($under_role_list as $each_by_dep){
							if($each->note==''){
								$title_dep=$each->qs_name.'-'.$each_by_dep->name;
							} else{
								$title_dep=$each->qs_name.'('.$each_by_dep->name.')-'.$each->note;
							}
							$data['question_option_id_list_by_dep'][] = array (
								"id" => $each->id,
								"question_ans_id" => 0,
								"role_id" => $each_by_dep->id,
								"question_style_id" => 5,
								"question_title" => $title_dep,
							);
						}
					} 
				} else{
					if(!empty($under_role_list)){
						foreach ($under_role_list as $each_by_dep){
							$question_option_open_list_dep = $this -> question_ans_dao -> find_all_not_write_dep($each_by_dep->id,$each->id);

							if(!empty($question_option_open_list_dep)){
								if($each->note==''){
									$title_dep=$each->qs_name.'-'.$each_by_dep->name;
								} else{
									$title_dep=$each->qs_name.'('.$each_by_dep->name.')-'.$each->note;
								}
								$data['question_option_id_list_by_dep'][] = array (
									"id" => $each->id,
									"question_ans_id" => $question_option_open_list_dep->id,
									"role_id" => $each_by_dep->id,
									"question_style_id" => 5,
									"question_title" => $title_dep,
								);
							} else{
								if($each->note==''){
									$title_dep=$each->qs_name.'-'.$each_by_dep->name;
								} else{
									$title_dep=$each->qs_name.'('.$each_by_dep->name.')-'.$each->note;
								}
								$data['question_option_id_list_by_dep'][] = array (
									"id" => $each->id,
									"question_ans_id" => 0,
									"role_id" => $each_by_dep->id,
									"question_style_id" => 5,
									"question_title" => $title_dep,
								);
							}
						}
					}
				}
			}
			$question_option_open_list_for_dep_2 = $this -> question_option_dao -> find_all_open_question_for_dep_2();

			foreach ($question_option_open_list_for_dep_2 as $each){
				$find_dep = $this -> d_dao -> find_by_id($login_user->role_id);
				if($find_dep->parent_id==5){
					$find_dep_list = $find_dep;
				} else{
					$find_dep_list = $this -> d_dao -> find_by("id",$find_dep->parent_id);

				}
				$question_option_open_list_dep_2 = $this -> question_ans_dao -> find_all_with_dep_2($each->id);

				if(empty($question_option_open_list_dep_2)){

					if($each->note==''){
						$title_dep=$each->qs_name.'-'.$find_dep_list->name;
					} else{
						$title_dep=$each->qs_name.'('.$find_dep_list->name.')-'.$each->note;
					}
					$data['question_option_id_list_by_dep'][] = array (
						"id" => $each->id,
						"question_ans_id" => 0,
						"role_id" => $login_user->role_id,
						"question_style_id" => 6,
						"question_title" => $title_dep,
					);
				} else{
					$question_option_open_list_dep_2 = $this -> question_ans_dao -> find_all_not_write_dep_2($find_dep_list->id,$each->id);

					if(!empty($question_option_open_list_dep_2)){
						if($each->note==''){
							$title_dep=$each->qs_name.'-'.$find_dep_list->name;
						} else{
							$title_dep=$each->qs_name.'('.$find_dep_list->name.')-'.$each->note;
						}
						$data['question_option_id_list_by_dep'][] = array (
							"id" => $each->id,
							"question_ans_id" => $question_option_open_list_dep_2->id,
							"role_id" => $login_user->role_id,
							"question_style_id" => 6,
							"question_title" => $title_dep,
						);
					} else{
						if($each->note==''){
							$title_dep=$each->qs_name.'-'.$find_dep_list->name;
						} else{
							$title_dep=$each->qs_name.'('.$find_dep_list->name.')-'.$each->note;
						}
						$data['question_option_id_list_by_dep'][] = array (
							"id" => $each->id,
							"question_ans_id" => 0,
							"role_id" => $login_user->role_id,
							"question_style_id" => 6,
							"question_title" => $title_dep,
						);
					}
				}
			}
		}
		
		
		$data['question_option_open_list']=$question_option_open_list;
		// $this -> to_json($question_option_open_list_dep_2);
		$this -> load -> view('mgmt/question_for_user/list', $data);
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

	public function edit($id) {
		$data = array();
		$data['swot_title_id'] =$id;
 
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/question_for_user/edit', $data);
	}

	public function swot_title_get_data() {
		$res = array();
		$swot_title_id =$this -> get_post('swot_title_id');
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$data = array();
		$items= $this -> swot_style_dao -> find_all_style();

		foreach($items as $each){
			$list = $this -> dao -> find_by_id($swot_title_id);
			// if(!empty($list)){
			// 	if($list->is_lock==1){
			// 		$each->now_is_lock =  1;
			// 	} else{
			// 		$each->now_is_lock =  0;
			// 	}
			// } else {
			// 	$each->now_is_lock= 0;
			// } 
			$column = "iso_id_".$each ->id;
			$each->now_is_lock =  $list->$column;
			
		} 

		$res['items'] = $items;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function show_que1(){
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['lang'] = $login_user->lang;

		$qid =$this -> get_get('id');
		$data['qid'] = $qid;
		$this -> load -> view('layout/show_que1',$data);
	}
	public function show_que2(){
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['lang'] = $login_user->lang;
		$qid =$this -> get_get('id');
		$data['qid'] = $qid;
		$this -> load -> view('layout/show_que2',$data);
	}
	public function show_que3(){
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['lang'] = $login_user->lang;
		$qid =$this -> get_get('id');
		$data['qid'] = $qid;
		$this -> load -> view('layout/show_que3',$data);
	}
	public function show_que4(){
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['lang'] = $login_user->lang;
		$qid =$this -> get_get('id');
		$data['qid'] = $qid;
		$this -> load -> view('layout/show_que4',$data);
	}
	public function show_que5(){
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['lang'] = $login_user->lang;
		$qid =$this -> get_get('id');
		$role_id =$this -> get_get('role_id');
		$question_ans_id =$this -> get_get('question_ans_id');

		$data['qid'] = $qid;
		if($role_id==53){
			$data['role_id'] = 18;
		} else{
			$data['role_id'] = $role_id;
		}
		$data['question_ans_id'] = $question_ans_id;

		$data['question_list'] = ['是否有組織外之人員(承攬商、客戶、服務對象或親友等)因其行為無法預知，可能成為該區工作者不法侵害來源',
								'是否有已知工作會接觸有暴力史客戶','勞工工作性質是否為執行公共安全業務',
								'勞工工作是否為單獨作業','勞工是否需於深夜或凌晨工作','勞工是否需於較陌生環境工作','勞工工作是否涉及現金交易、運送或處理貴重物品',
								'勞工工作是否為直接面對群眾之第一線服務工作','勞工工作是否會與酗酒、毒癮或精神疾病患者接觸','勞工工作是否需接觸絕望或恐懼或極需被關懷照顧者',
								'勞工當中是否有自行通報因私人關係遭受不法侵害威脅者或為家庭暴力受害者','新進勞工是否有尚未接受職場不法侵害預防教育訓練者',
								'工作場所是否位於交通不便，偏遠地區','工作環境中是否有讓施暴者隱藏的地方','離開工作場所後，是否可能遭遇因執行職務所致之不法侵害行為',
								'組織內是否曾發生主管或勞工遭受同事(含上司)不當言行對待','是否有無法接受不同性別、年齡、國籍或宗教信仰工作者',
								'是否有同仁離職或請求調職原因源於職場不法侵害事件之發生','是否有被同仁排擠或工作適應不良者','內部是否有酗酒、毒癮之工作者',
								'內部是否有處於情緒低落、絕望或恐懼，極需被關懷照顧工作者','是否有超時工作，反應工作壓力大工作者','工作環境是否有空間擁擠，照明設備不足問題，工作場所出入是否未有相當管制措施'];

		// for($i=1;$i<=count($data['question_list']);$i++){
		// 	for($j=0;$j<7;$j++){
		// 		$num=$i*7+$j+1;
		// 		echo '<script type="text/javascript"> var q'.$num.'=null;</script>';
		// 	}
		// }
		$data['question_list_count'] = count($data['question_list']);
		$this -> load -> view('layout/show_que5',$data);
	}
	public function show_que6(){
		$data = array();
		$data['items']= array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['lang'] = $login_user->lang;
		$qid =$this -> get_get('id');
		$role_id =$this -> get_get('role_id');
		$question_ans_id =$this -> get_get('question_ans_id');
		$total = 0;
		$i=0;
		if($question_ans_id>0){
			$items = $this -> question_ans_dao -> find_by_id($question_ans_id);
			
			foreach($items as $key => $value){
				if(substr($key, 0, 1)=='q'&&substr($key, 1, 1)!=='u'&&$value!==null){
					$data['items'][] = $value;
					if($i<10){
						$total +=intval($value);
					}
					$i++;
				}
			}

		}
		$data['items'][] = $total;
		$data['role_id'] = $role_id;
		$data['question_ans_id'] = $question_ans_id;
		$data['qid'] = $qid;
		$data['items_count'] = count($data['items'])-1;
		// $this -> to_json($data['items']);

		$this -> load -> view('layout/show_que6',$data);
	}
	public function save_q1(){
		$s_data = array();
		$data = array();
		$s_data = $this -> setup_user_data($s_data);
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$qid =$this -> get_post('qid');
		$q1 =$this -> get_post('q1');
		$q2 =$this -> get_post('q2');
		$q3 =$this -> get_post('q3');
		$q4 =$this -> get_post('q4');
		$q5 =$this -> get_post('q5');
		$q6 =$this -> get_post('q6');
		$q7 =$this -> get_post('q7');
		$q8 =$this -> get_post('q8');
		$q9 =$this -> get_post('q9');
		$q10 =$this -> get_post('q10');
		$q11 =$this -> get_post('q11');
		$q12 =$this -> get_post('q12');
		$q1o =$this -> get_post('q1o');
		$q2o =$this -> get_post('q2o');
		$q3o =$this -> get_post('q3o');

		$data['user_id'] = $login_user->id;
		// $data['qid'] = $qid;
		$data['q1'] = $q1;
		$data['q2'] = $q2;
		$data['q3'] = $q3;
		$data['q4'] = $q4;
		$data['q5'] = $q5;
		$data['q6'] = $q6;
		$data['q7'] = $q7;
		$data['q8'] = $q8;
		$data['q9'] = $q9;
		$data['q10'] = $q10;
		$data['q11'] = $q11;
		$data['q12'] = $q12;
		$data['q1o'] = $q1o;
		$data['q2o'] = $q2o;
		$data['q3o'] = $q3o;
		$data['role_id'] = $login_user->role_id;
		$data['question_option_id'] = $qid;

		$this -> question_ans_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function save_q2(){
		$s_data = array();
		$data = array();
		$s_data = $this -> setup_user_data($s_data);
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$qid =$this -> get_post('qid');
		$q1 =$this -> get_post('q1');
		$q2 =$this -> get_post('q2');
		$q3 =$this -> get_post('q3');
		$q4 =$this -> get_post('q4');
		$q5 =$this -> get_post('q5');
		$q6 =$this -> get_post('q6');
		$q7 =$this -> get_post('q7');
		$q8 =$this -> get_post('q8');
		$q9 =$this -> get_post('q9');
		$q10 =$this -> get_post('q10');
		$q11 =$this -> get_post('q11');
		$q12 =$this -> get_post('q12');
		$q13 =$this -> get_post('q13');
		$q14 =$this -> get_post('q14');
		$q15 =$this -> get_post('q15');
		$q16 =$this -> get_post('q16');
		$q17 =$this -> get_post('q17');
		$q18 =$this -> get_post('q18');
		$q19 =$this -> get_post('q19');
		$q20 =$this -> get_post('q20');
		$q21 =$this -> get_post('q21');
		$q22 =$this -> get_post('q22');
		$q1o =$this -> get_post('q1o');
		$q2o =$this -> get_post('q2o');
		$q3o =$this -> get_post('q3o');
		$q4o =$this -> get_post('q4o');
		$q5o =$this -> get_post('q5o');
		$q6o =$this -> get_post('q6o');
		$q7o =$this -> get_post('q7o');
		$data['user_id'] = $login_user->id;
		// $data['qid'] = $qid;
		$data['q1'] = $q1;
		$data['q2'] = $q2;
		$data['q3'] = $q3;
		$data['q4'] = $q4;
		$data['q5'] = $q5;
		$data['q6'] = $q6;
		$data['q7'] = $q7;
		$data['q8'] = $q8;
		$data['q9'] = $q9;
		$data['q10'] = $q10;
		$data['q11'] = $q11;
		$data['q12'] = $q12;
		$data['q13'] = $q13;
		$data['q14'] = $q14;
		$data['q15'] = $q15;
		$data['q16'] = $q16;
		$data['q17'] = $q17;
		$data['q18'] = $q18;
		$data['q19'] = $q19;
		$data['q20'] = $q20;
		$data['q21'] = $q21;
		$data['q22'] = $q22;

		$data['q1o'] = $q1o;
		$data['q2o'] = $q2o;
		$data['q3o'] = $q3o;
		$data['q4o'] = $q4o;
		$data['q5o'] = $q5o;
		$data['q6o'] = $q6o;
		$data['q7o'] = $q7o;
		$data['role_id'] = $login_user->role_id;

		$data['question_option_id'] = $qid;

		$this -> question_ans_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function save_q3(){
		$s_data = array();
		$data = array();
		$s_data = $this -> setup_user_data($s_data);
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$qid =$this -> get_post('qid');
		$q1 =$this -> get_post('q1');
		$q2 =$this -> get_post('q2');
		$q3 =$this -> get_post('q3');
		$q4 =$this -> get_post('q4');
		$q5 =$this -> get_post('q5');
		$q6 =$this -> get_post('q6');
		$q7 =$this -> get_post('q7');
		$q8 =$this -> get_post('q8');
		$q9 =$this -> get_post('q9');
		$q10 =$this -> get_post('q10');
		$q11 =$this -> get_post('q11');
		$q12 =$this -> get_post('q12');
		$q13 =$this -> get_post('q13');
		$q1o =$this -> get_post('q1o');
		$q2o =$this -> get_post('q2o');
		$q3o =$this -> get_post('q3o');
		$q4o =$this -> get_post('q4o');
		$data['user_id'] = $login_user->id;
		// $data['qid'] = $qid;
		$data['q1'] = $q1;
		$data['q2'] = $q2;
		$data['q3'] = $q3;
		$data['q4'] = $q4;
		$data['q5'] = $q5;
		$data['q6'] = $q6;
		$data['q7'] = $q7;
		$data['q8'] = $q8;
		$data['q9'] = $q9;
		$data['q10'] = $q10;
		$data['q11'] = $q11;
		$data['q12'] = $q12;
		$data['q13'] = $q13;
		$data['q1o'] = $q1o;
		$data['q2o'] = $q2o;
		$data['q3o'] = $q3o;
		$data['q4o'] = $q4o;
		$data['question_option_id'] = $qid;
		$data['role_id'] = $login_user->role_id;
		$this -> question_ans_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function save_q5(){
		$s_data = array();
		$data = array();
		$s_data = $this -> setup_user_data($s_data);
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['question_option_id']  =$this -> get_post('qid');
		$id =$this -> get_post('question_ans_id');
		$role_id =$this -> get_post('role_id');

		$data['user_id'] = $login_user->id;
		$data['role_id'] = $role_id;

		for($i=1;$i<=161;$i++){
			$data['q'.$i] = $this -> get_post('q'.$i);
		}
		for($j=1;$j<=23;$j++){
			$data['q'.$j.'o'] = $this -> get_post('q'.$j.'o');
		}
		if($id>0){
			$this -> question_ans_dao -> update($data, $id);

		} else{
			$this -> question_ans_dao -> insert($data);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function save_q6(){
		$s_data = array();
		$data = array();
		$s_data = $this -> setup_user_data($s_data);
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$find_dep = $this -> d_dao -> find_by_id($login_user->role_id);
		if($find_dep->parent_id==5){
			$find_dep_list = $find_dep;
		} else{
			$find_dep_list = $this -> d_dao -> find_by("id",$find_dep->parent_id);

		}
		$qid =$this -> get_post('qid');
		$q1 =$this -> get_post('q1');
		$q2 =$this -> get_post('q2');
		$q3 =$this -> get_post('q3');
		$q4 =$this -> get_post('q4');
		$q5 =$this -> get_post('q5');
		$q6 =$this -> get_post('q6');
		$q7 =$this -> get_post('q7');
		$q8 =$this -> get_post('q8');
		$q9 =$this -> get_post('q9');
		$q10 =$this -> get_post('q10');
	
		$q1o =$this -> get_post('q1o');
		$role_id =$this -> get_post('role_id');



		$data['user_id'] = $login_user->id;
		// $data['qid'] = $qid;
		$data['q1'] = $q1;
		$data['q2'] = $q2;
		$data['q3'] = $q3;
		$data['q4'] = $q4;
		$data['q5'] = $q5;
		$data['q6'] = $q6;
		$data['q7'] = $q7;
		$data['q8'] = $q8;
		$data['q9'] = $q9;
		$data['q10'] = $q10;

		$data['q1o'] = $q1o;

		$data['role_id'] = $role_id;
		$data['question_option_id'] = $qid;

		$this -> question_ans_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
	public function load_ans() {
		$res = array();
		
		$id =$this -> get_post('id');

		$items = $this -> question_ans_dao -> find_by_id($id);
	
		$res['items'] = $items;
		
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

	public function up_lock_swot_style(){
		$swot_title_id = $this -> get_post('swot_title_id');
		$swot_style_id = $this -> get_post('swot_style_id');

		$u_data = array();
		$column = "iso_id_".$swot_style_id;
		$find_each_id_is_lock = $this -> dao -> find_each_is_lock($swot_title_id);

		if($find_each_id_is_lock[0]->$column<1){
			$u_data['iso_id_'.$swot_style_id] = 1;
			$res['success_msg'] = '變更已鎖定成功';
		} else{
			$u_data['iso_id_'.$swot_style_id] = 0;
			$res['success_msg'] = '變更可編輯成功';
		}
			$this -> dao -> update($u_data, $swot_title_id);

		
		$res['success'] = TRUE;
		// $res['123'] = $find_each_id_is_lock[0]->$column;
		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	public function re_sql() {
		$data = array();
		$list = $this -> question_ans_dao -> find_by_question_option_id();
		foreach($list as $each){
			if(intval($each->q1o)<=50){
				$data['q2o'] = '輕微';
			}
			if(intval($each->q1o)<69 && intval($each->q1o)>50){
				$data['q2o'] = '中度';
			}
			if(intval($each->q1o)>=70){
				$data['q2o'] = '嚴重';
			}
			if(intval($each->q3o)<=45){
				$data['q4o'] = '輕微';
			}
			if(45<intval($each->q3o) && intval($each->q3o)<60){
				$data['q4o'] = '中度';
			}
			if(intval($each->q3o)>=60){
				$data['q4o'] = '嚴重';
			}
			$this -> question_ans_dao -> update($data, $each->id);

		}
		$this -> to_json($list);
	}
}
