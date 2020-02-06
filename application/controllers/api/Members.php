<?php
class Members extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Members_log_dao', 'log_dao');
		$this -> load -> model('Record_setting_dao', 'record_setting_dao');
		$this -> load -> model('Sentence_dao', 'sentence_dao');
		$this -> load -> model('Level_record_log_dao', 'level_record_log_dao');
		$this -> load -> model('Record_setting_dao', 'record_setting_dao');
		$this -> load -> model('Ketone_record_dao', 'ketone_record_dao');

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

					$value = str_pad($last_id,6,'0',STR_PAD_LEFT);
					$this -> dao -> update(array('code'=>$value),$last_id);

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

	// 訪客登入
	public function do_visitor_login() {
		$res = array();
		$user_name = $this -> get_post('user_name');
		$birth = $this -> get_post('birth');
		$gender = $this -> get_post('gender');
		$height = $this -> get_post('height');
		$image_id = $this -> get_post('image_id');
		$account = date("YmdHis");

		if(!empty($user_name) && !empty($birth) && $gender!='' && !empty($height)) {
			$date = strtotime($birth);
			$datetime1 = date('Y-m-d', $date);
			$datetime2 = date("Y-m-d");
			$diff = abs(strtotime($datetime2) - strtotime($datetime1));
			$years = floor($diff / (365*60*60*24));

			$insert_data = array('account' => $account,
								 'password' => '123456',
								 'user_name' => $user_name,
								 'birth' => $birth,
								 'gender' => $gender,
								 'height' => $height,
								 'type' => 2,
								 'age' => $years
							 );

			$last_id = $this -> dao -> insert($insert_data);

			$value = str_pad($last_id,6,'0',STR_PAD_LEFT);
			$this -> dao -> update(array('code'=>$value),$last_id);

			$res['success'] = TRUE;
			$res['id'] = $last_id;
			$res['member'] = $this -> dao -> find_by_id($last_id);
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function me(){
		$res = array();
		$id = $this -> get_post('member_id');
		if(!empty($id)) {
			$m = $this -> dao -> find_by_id($id);
			if(!empty($m)){
				$list = $this -> ketone_record_dao -> find_by_today(array('member_id'=>$id));

				$res['success'] = TRUE;
				if(empty($m->update_time)){
					$m -> update = false;
				}else{
					$m -> update = true;
				}
				if(empty($list)){
					$m -> has_ketone = false;
				}else{
					$m -> has_ketone = true;
				}
				$res['member'] = $m;
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

	public function edit(){
		$res = array();
		$member_id = $this -> get_post('member_id');
		$user_name = $this -> get_post('user_name');
		$birth = $this -> get_post('birth');
		$height = $this -> get_post('height');
		$coach_id = $this -> get_post('coach_id');
		$gender = $this -> get_post('gender');
		$is_share = $this -> get_post('is_share');
		$image_id = $this -> get_post('image_id');
		$today = date('Y-m-d H:i:s');

		if(!empty($member_id)) {
			$m = $this -> dao -> find_by_id($member_id);
			if(!empty($m)){
				$share;
				if(!empty($is_share)){
					$share = 1;
				}else{
					$share = 0;
				}

				$years = 0;
				if(!empty($birth)){
					$date = strtotime($birth);
					$datetime1 = date('Y-m-d', $date);
					$datetime2 = date("Y-m-d");
					$diff = abs(strtotime($datetime2) - strtotime($datetime1));
					$years = floor($diff / (365*60*60*24));
				}

				$update_data = array(
												'user_name' => $user_name,
												'birth' => $birth,
												'height'=>$height,
												'age'=>$years,
												'coach_id' => $coach_id,
												'gender' => $gender,
												'is_share' => $share,
												'image_id' => $image_id,
												'update_time' => $today
											);
				$m = $this -> dao -> update($update_data,$m->id);
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

	public function push_msg_test(){
		$res = array();
		$res['test'] = true;
		$res['tt'] = send_gcm_simple('dX03w3DclFU:APA91bHqBNjqnDGQpW3I0YmOkQjcoCmutlYcOFZvRUFNOXAErcAxvm5wZAN8WYI8cNXWmXF_2GUT09Kqpsx2ucUgWhW0-Y1JgYNUrGJ6PajpaHywbz6LQva4XstEQwT1H8uDCi-i8aS8','123',array(''),'#123');
		// $res['result'] = $this -> push_msg('55', array("broadcast",'55'), 'test', '1234567');
		$this -> to_json($res);
	}


}
?>
