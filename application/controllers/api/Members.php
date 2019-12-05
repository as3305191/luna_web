<?php
class Members extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Members_log_dao', 'log_dao');
		$this -> load -> model('Members_bonus_record_dao', 'members_bonus_record_dao');
		$this -> load -> model('Question_dao', 'question_dao');
		$this -> load -> model('Video_dao', 'video_dao');
		$this -> load -> model('Video_detail_dao', 'video_detail_dao');
		$this -> load -> model('Record_setting_dao', 'record_setting_dao');
		$this -> load -> model('Tree_record_dao', 'tree_record_dao');
		$this -> load -> model('Sentence_dao', 'sentence_dao');
		$this -> load -> model('Level_record_log_dao', 'level_record_log_dao');
		$this -> load -> model('Record_setting_dao', 'record_setting_dao');


	}

	function index() {
		echo "index";
	}

	// 登入
	public function do_login() {
		$account = $this -> get_post('account');
		$password = $this -> get_post('password');

		$f = array();
		if(!empty($account) && !empty($password)) {
				$f['account'] = $account;
				$m = $this -> dao -> find_by_value($f);
				if(!empty($m)) {
					$m1 = $m[0];
					if($m1 -> password == $password) {
						$res['success'] = TRUE;
						$res['member'] = $m1;
					} else {
						$res['error_code'][] = "wrong_password";
						$res['error_message'][] = "密碼錯誤";
					}
				} else {
					$res['error_code'][] = "account_not_found";
					$res['error_message'][] = "查無此帳號";
				}
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 註冊
	public function do_register() {
		$res = array();
		$account = $this -> get_post('account');
		$password = $this -> get_post('password');
		$user_name = $this -> get_post('user_name');
		$birth = $this -> get_post('birth');
		$gender = $this -> get_post('gender');
		$email = $this -> get_post('email');
		$height = $this -> get_post('height');


		if(!empty($account) && !empty($password) && !empty($user_name) && !empty($birth) && $gender !='' && !empty($email) && !empty($height)) {
				$lista = $this -> dao -> find_by_condition(array('account' => $account));
				$listb = $this -> dao -> find_by_condition(array('email' => $email));

				if(empty($lista) && empty($listb)){
					$date = strtotime($birth);
					$datetime1 = date('Y-m-d', $date);
					$datetime2 = date("Y-m-d");
					$diff = abs(strtotime($datetime2) - strtotime($datetime1));
					$years = floor($diff / (365*60*60*24));

					$insert_data = array('account' => $account,
										 'password' => $password,
									   'user_name' => $user_name,
									   'birth' => $birth,
									   'gender' => $gender,
										 'height' => $height,
										 'age' => $years,
									   'email' => $email
									 );

					$last_id = $this -> dao -> insert($insert_data);


					$res['success'] = TRUE;
					$res['id'] = $last_id;
				}else if(!empty($lista) && !empty($listb)){
					$res['error_code'][] = "already_registered";
					$res['error_message'][] = "帳號及信箱已註冊";
				}else{
					if(!empty($lista)){
						$res['error_code'][] = "already_registered";
						$res['error_message'][] = "帳號已註冊";
					}else if(!empty($listb)){
						$res['error_code'][] = "already_registered";
						$res['error_message'][] = "信箱已註冊";
					}
				}
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}





	public function do_again(){
		$member_id = $this -> get_post('member_id');
		$device = $this -> get_post('device');
		if(!empty($member_id) && !empty($device)) {
			$m1 = $this -> dao -> find_by_id($member_id);


		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function me(){
		$id = $this -> get_post('member_id');
		$f = array();
		if(!empty($id)) {
			$f['id'] = $id;
			$m = $this -> dao -> find_by_value($f);
			if(!empty($m)){
				$res['success'] = TRUE;
				$lastTime = $m[0] -> last_login_time;
				$nowtime = date("Y-m-d");
				$date = strtotime($lastTime);
				$lastDate = date('Y-m-d', $date);
				$diff = abs(strtotime($lastDate) - strtotime($nowtime));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$m2 = $this -> log_dao -> find_by_value(array('member_id'=> $id));
				if(!empty($m2)){
					$res['login'] = TRUE;
				}

				// if($days > 1){
				// 	$res['discontinue'] = TRUE;
				// }

				$level_status = $m[0]-> level_status;
				if($level_status >0){
					$level_data = array('level'=> $level_status);
					$setting = $this -> record_setting_dao -> find_by_id(1);
					$setting_count = 0;
					if($level_status == 1){
						$setting_count = $setting -> level_1;
					}
					if($level_status == 2){
						$setting_count = $setting -> level_2;
					}
					if($level_status == 3){
						$setting_count = $setting -> level_3;
					}
					if($level_status == 4){
						$setting_count = $setting -> level_4;
					}
					$level_data['setting_count'] = $setting_count;

					$current_count = 0;
					$log = $this -> level_record_log_dao -> find_by_value(array('member_id'=> $id ,'level'=> $level_status));
					if(!empty($log)){
						$current_count = $log-> number;
					}
					$rest = $setting_count - $current_count;
					$level_data['level_count'] = $current_count;
					$level_data['rest_count'] = $rest;

					$res['level'] = $level_data;
				}

				$last_update_index_time = $m[0]-> last_update_index_time;
				$last_update_question_time = $m[0]-> last_update_question_time;
				$last_update_hw_time = $m[0]-> last_update_hw_time;

				if (date('Y-m-d') == date('Y-m-d', strtotime($last_update_index_time))) {
					$m[0]->index_time = true;
				}else{
					$m[0]->index_time = false;
				}

				if (date('Y-m-d') == date('Y-m-d', strtotime($last_update_question_time))) {
					$m[0]->question_time = true;
				}else{
					$m[0]->question_time = false;
				}

				if (date('Y-m-d') == date('Y-m-d', strtotime($last_update_hw_time))) {
					$m[0]->hw_time = true;
				}else{
					$m[0]->hw_time = false;
				}

				$res['member'] = $m[0];
			}else{
				$res['error_code'][] = "member not found";
				$res['error_message'][] = "使用者不存在";
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function update_ip(){
		$id = $this -> get_post('member_id');
		$ip = $this -> get_post('ip');

		if(!empty($id) && !empty($ip)) {
			$this -> dao -> update(array('ip'=>$ip),$id);
			$res['success'] = TRUE;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function list_question() {
		$list = $this -> question_dao -> find_all();
		$res['list'] = $list;
		$this -> to_json($res);
	}

	public function list_video() {
		$list = $this -> video_dao -> find_all();
		foreach ($list as $each) {
			$detail = $this -> video_detail_dao -> find_by_value(array('video_id'=> $each->id));
			$each -> detail = $detail;
		}
		$res['list'] = $list;
		$this -> to_json($res);
	}

	public function member_bonus(){
		$id = $this -> get_post('member_id');
		$f = array();
		if(!empty($id)) {
			$m = $this -> dao -> find_by_id($id);
			if(!empty($m)){
				$n = $this -> members_bonus_record_dao -> sum_bouus(array('member_id'=>$id));
				$res['success'] = TRUE;
				$res['amt'] = $n -> sum;
			}else{
				$res['error_code'][] = "member not found";
				$res['error_message'][] = "使用者不存在";
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function update_setting(){
		$id = $this -> get_post('member_id');
		$time = $this -> get_post('time');
		$date = $this -> get_post('date');
		$user_doctor_id = $this -> get_post('user_doctor_id');
		$user_manager_id = $this -> get_post('user_manager_id');
		$is_remind = $this -> get_post('is_remind');

		$f = array();
		if(!empty($id)) {
			$m = $this -> dao -> find_by_id($id);
			if(!empty($m)){
				if(!empty($time)){
					$f['remind_time'] = $time;
				}

				if(!empty($date)){
					$f['next_date'] = $date;
				}

				if(!empty($is_remind)){
					$f['is_remind'] = 1;
				}else{
					$f['is_remind'] = 0;
				}

				if(!empty($user_doctor_id)){
					$f['user_doctor_id'] = $user_doctor_id;
				}

				if(!empty($user_manager_id)){
					$f['user_manager_id'] = $user_manager_id;
				}

				$this -> dao -> update($f,$id);
				$data = $this -> dao -> find_by_id($id);

				$res['memeber'] = $data;
				$res['success'] = TRUE;
			}else{
				$res['error_code'][] = "member not found";
				$res['error_message'][] = "使用者不存在";
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 每天半夜12點執行
	public function reset(){
		$res['success'] = TRUE;
		$this -> dao -> do_reset();
		$this -> to_json($res);
	}

	public function get_present(){
		$m = $this -> sentence_dao -> find_by_value();
		$res['success'] = TRUE;
		$res['data'] = $m;
		$this -> to_json($res);
	}


}
?>
