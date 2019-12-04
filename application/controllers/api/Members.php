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

	// 2019/01/08
	// 登入
	// public function login() {
	// 	$account = $this -> get_post('account');
	// 	$password = $this -> get_post('password');
	// 	$device = $this -> get_post('device');
	//
	// 	$f = array();
	// 	if(!empty($account) && !empty($password) && !empty($device)) {
	// 			$f['account'] = $account;
	// 			$m = $this -> dao -> find_by_value($f);
	// 			if(!empty($m)) {
	// 				$m1 = $m[0];
	// 				if($m1 -> password == $password) {
	// 					$lastTime = $m1 -> last_login_time;
	// 					$loginCount = $m1 -> login_count;
	//
	// 					$nowtime = date("Y-m-d H:i:s");
	// 					$nowdate = date("Y-m-d");
	//
	// 					$m2 = $this -> log_dao -> find_by_value(array('member_id'=> $m1-> id));
	// 					if(!empty($m2)){
	// 						$this -> log_dao -> update(array('member_id'=> $m1 -> id,'update_time'=> $nowtime), $m2-> id);
	// 					}else {
	// 						// 新增登入log紀錄
	// 						$id = $this -> log_dao -> insert(array('member_id'=> $m1 -> id,'device'=> $device,'create_time'=> $nowtime));
	//
	// 						// 最後登入時間
	// 						$start = strtotime($lastTime);
	// 						$lastDate = date('Y-m-d', $start);
	//
	// 						$diff = abs(strtotime($lastDate) - strtotime($nowdate));
	// 						$years = floor($diff / (365*60*60*24));
	// 						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	// 						$timeDiff = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	//
	// 						if($timeDiff == 1){
	// 							$setting = $this -> record_setting_dao -> find_by_id(1);
	// 							$day = $setting -> login;
	//
	// 							// 更新登入狀況
	//
	// 							$updateData = array('last_login_time'=> $nowtime);
	//
	// 							$newCount = $loginCount + 1;
	// 							$updateCount = 0;
	// 							$res['newCount'] = $newCount;
	//
	// 							if($newCount > $day - 1){
	// 								$updateCount = $newCount - $day;
	// 								if($seed == 3){
	// 									$updateData['seed'] = 1;
	// 								}else{
	// 									$updateData['seed'] = $seed+1;
	// 								}
	// 							}else{
	// 								$updateCount = $newCount;
	// 							}
	// 							$updateData['login_count'] = $updateCount;
	//
	// 							//連續登入七天開啟第一關
	// 							if($m1->level_status == 0 && $newCount == $day -1 ){
	// 								$updateData['level_status'] = 1;
	// 							}
	// 							$this -> dao -> update($updateData,$m1-> id);
	// 						}else{
	// 							// 中斷一天中重新計算
	// 							$this -> dao -> update(array('last_login_time'=> $nowtime,'login_count'=> 1),$m1-> id);
	// 							$res['is_break'] = TRUE;
	// 						}
	// 						$this -> tree_record_dao -> insert(array('member_id'=> $m1-> id,'score'=> 1,'record_id'=>$id));
	// 					}
	//
	// 					$res['success'] = TRUE;
	// 					$res['member'] = $m1;
	// 				} else {
	// 					$res['error_code'][] = "wrong_password";
	// 					$res['error_message'][] = "密碼錯誤";
	// 				}
	// 			} else {
	// 				$res['error_code'][] = "account_not_found";
	// 				$res['error_message'][] = "查無此帳號";
	// 			}
	// 	} else {
	// 		$res['error_code'][] = "columns_required";
	// 		$res['error_message'][] = "缺少必填欄位";
	// 	}
	// 	$this -> to_json($res);
	// }

	// 登入更新
	public function login() {
		$account = $this -> get_post('account');
		$password = $this -> get_post('password');
		$device = $this -> get_post('device');

		$f = array();
		if(!empty($account) && !empty($password) && !empty($device)) {
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

	public function login_log() {
		$member_id = $this -> get_post('member_id');
		$device = $this -> get_post('device');
		$ip = $this -> get_post('ip');

		$f = array();
		if(!empty($member_id) && !empty($device)) {

			$m1 = $this -> dao -> find_by_id($member_id);
			if(!empty($m1)) {


				$lastTime = $m1 -> last_login_time;
				$loginCount = $m1 -> login_count;
				$seed = $m1 -> seed;

				$nowtime = date("Y-m-d H:i:s");
				$nowdate = date("Y-m-d");

				$m2 = $this -> log_dao -> find_by_value(array('member_id'=> $m1-> id));
				if(!empty($m2)){
					$this -> log_dao -> update(array('member_id'=> $m1 -> id,'update_time'=> $nowtime), $m2-> id);
					if(!empty($ip)){
						$this -> dao -> update(array('ip'=>$ip),$m1-> id);
					}
				}else {
					// 新增登入log紀錄
					$id = $this -> log_dao -> insert(array('member_id'=> $m1 -> id,'device'=> $device,'create_time'=> $nowtime));

					// 最後登入時間
					$start = strtotime($lastTime);
					$lastDate = date('Y-m-d', $start);

					$diff = abs(strtotime($lastDate) - strtotime($nowdate));
					$years = floor($diff / (365*60*60*24));
					$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
					$timeDiff = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

					// if($timeDiff == 1){
					$setting = $this -> record_setting_dao -> find_by_id(1);
					$day = $setting -> login;

					// 更新登入狀況

					$updateData = array('last_login_time'=> $nowtime);

					$newCount = $loginCount + 1;
					$updateCount = 0;
					$res['newCount'] = $newCount;

					if($newCount > $day - 1){
						$updateCount = $newCount - $day;
						if($seed == 3){
							$updateData['seed'] = 1;
						}else{
							$updateData['seed'] = $seed+1;
						}
					}else{
						$updateCount = $newCount;
					}
					$updateData['login_count'] = $updateCount;

					// 連續登入七天開啟第一關
					// if($m1->level_status == 0 && $newCount == $day -1 ){
					// 	$updateData['level_status'] = 1;
					// }

					if(!empty($ip)){
						$updateData['ip'] = $ip;
					}
					$this -> dao -> update($updateData,$m1-> id);

					// }else{
					// 	// 中斷一天中重新計算
					// 	$this -> dao -> update(array('last_login_time'=> $nowtime,'login_count'=> 1),$m1-> id);
					// 	$res['is_break'] = TRUE;
					// }

					$this -> tree_record_dao -> insert(array('member_id'=> $member_id,'score'=> 1,'record_id'=>$id,'type'=> 0));
				}

				$res['success'] = TRUE;
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
