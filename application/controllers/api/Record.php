<?php
class Record extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Records_dao', 'records_dao');


		$this -> load -> model('Members_log_dao', 'log_dao');
		$this -> load -> model('Members_bonus_record_dao', 'bonus_record_dao');
		$this -> load -> model('Question_dao', 'question_dao');
		$this -> load -> model('Video_dao', 'video_dao');
		$this -> load -> model('Video_detail_dao', 'video_detail_dao');
		$this -> load -> model('Daily_record_index_dao', 'daily_record_index_dao');
		$this -> load -> model('Daily_record_question_dao', 'daily_record_question_dao');
		$this -> load -> model('Daily_record_question_detail_dao', 'daily_record_question_detail_dao');
		$this -> load -> model('Relieve_method_dao', 'relieve_method_dao');
		$this -> load -> model('Level_1_record_dao', 'level_1_record_dao');
		$this -> load -> model('Level_2_record_dao', 'level_2_record_dao');
		$this -> load -> model('Level_3_record_dao', 'level_3_record_dao');
		$this -> load -> model('Level_4_record_dao', 'level_4_record_dao');
		$this -> load -> model('Level_record_log_dao', 'level_record_log_dao');
		$this -> load -> model('Record_setting_dao', 'record_setting_dao');
		$this -> load -> model('Tree_record_dao', 'tree_record_dao');


	}

	function index() {
		echo "index";
	}


	public function add_record(){
		$member_id = $this -> get_post('member_id');
		$weight = $this -> get_post('weight');
		$body_fat = $this -> get_post('body_fat');
		$visceral_fat = $this -> get_post('visceral_fat');
		$bmr = $this -> get_post('bmr');
		$bone_mass = $this -> get_post('bone_mass');
		$physical_age = $this -> get_post('physical_age');
		$moisture = $this -> get_post('moisture');
		$protein = $this -> get_post('protein');
		$skeletal_muscle = $this -> get_post('skeletal_muscle');

		if(!empty($member_id)){
			$m = $this -> dao -> find_by_value($member_id);
			if(!empty($m)) {
				$insert_data = array('member_id' => $member_id,
									 'weight' => $weight,
									 'body_fat' => $body_fat,
									 'visceral_fat' => $visceral_fat,
									 'bmr' => $bmr,
									 'bone_mass' => $bone_mass,
									 'physical_age' => $physical_age,
									 'moisture' => $moisture,
									 'protein' => $protein,
									 'skeletal_muscle' => $skeletal_muscle
								 );
				$id = $this -> records_dao -> insert($insert_data);
				$res['success'] = TRUE;
				$res['id'] = $id;
			} else {
				$res['error_code'][] = "account_not_found";
				$res['error_message'][] = "查無此會員";
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}

		$this -> to_json($res);
	}

	public function find_last_record(){
		$member_id = $this -> get_post('member_id');
		if(!empty($member_id)){
			$m = $this -> records_dao -> find_by_value(array('member_id' => $member_id));

			$res['success'] = TRUE;
			$res['record'] = $m;

		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}






	// 新增健康日記
	public function add_daily_record_index(){
		$member_id = $this -> get_post('member_id');
		$diastolic_blood_pressure = $this -> get_post('diastolic_blood_pressure');
		$systolic_blood_pressure = $this -> get_post('systolic_blood_pressure');
		$heart_beat = $this -> get_post('heart_beat');
		$weight = $this -> get_post('weight');
		$is_weight = $this -> get_post('is_weight');

		$do_excercise = $this -> get_post('do_exercise');
		$exercise_time = $this -> get_post('exercise_time');
		$exercise_item = $this -> get_post('exercise_item');
		$walking_steps = $this -> get_post('walking_steps');
		$is_walking_steps = $this -> get_post('is_walking_steps');
		$drinking = $this -> get_post('drinking');

		$startTime = date('Y-m-d 00:00:00');
		$endTime = date('Y-m-d 23:59:59');

		if(!empty($member_id) &&!empty($diastolic_blood_pressure) &&!empty($systolic_blood_pressure) &&!empty($heart_beat)
				&&$do_excercise!='' &&!empty($drinking)) {
					$insert_data = array('diastolic_blood_pressure' => $diastolic_blood_pressure,
															 'systolic_blood_pressure' => $systolic_blood_pressure,
															 'heart_beat' => $heart_beat,
															 'weight' => $weight,
															 'exercise_time' => $exercise_time,
															 'exercise_item' => $exercise_item,
															 'walking_steps' => $walking_steps,
															 'drinking' => $drinking,
															);

					if(!empty($is_weight)){
						$insert_data['is_weight'] = $is_weight;
					}

					if(!empty($is_walking_steps)){
						$insert_data['is_walking_steps'] = $is_walking_steps;
					}

					if(!empty($do_excercise)){
						$insert_data['do_excercise'] = $do_excercise;
					}else{
						$insert_data['do_excercise'] = 0;
					}

					$now = date("Y-m-d");
					$m = $this -> daily_record_index_dao -> find_by_value(array('member_id'=>$member_id,'date'=> $now));

					$res['success'] = TRUE;



					if(!empty($m)){
						$nowtime = date("Y-m-d H:i:s");
						$insert_data['update_time'] = $nowtime;
						$this -> daily_record_index_dao -> update($insert_data, $m -> id);
						$data = $this -> daily_record_index_dao -> find_by_id($m -> id);
						$this -> dao -> update(array('last_update_index_time'=> $data-> update_time), $member_id);
					}else {
						$insert_data['member_id'] = $member_id;
						$id = $this -> daily_record_index_dao -> insert($insert_data);
						$data = $this -> daily_record_index_dao -> find_by_id($id);
						$this -> dao -> update(array('last_update_index_time'=> $data-> create_time), $member_id);

						// 送金幣
						$this -> bonus_record_dao -> insert(array('member_id'=> $member_id,'type'=>1,'amt'=>10, 'record_id'=>$id), $member_id);

						$member = $this -> dao -> find_by_id($member_id);
						$last_update_index_time = $member -> last_update_index_time;
						$last_update_question_time = $member -> last_update_question_time;

						if($last_update_index_time > $startTime && $last_update_index_time <= $endTime
								&& $last_update_question_time > $startTime && $last_update_question_time <= $endTime){
									$res['has_gift'] = TRUE;
						}

						$res['id'] = $id;
					}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 新增自我照顧紀錄
	public function add_daily_record_question(){
		$member_id = $this -> get_post('member_id');
		$question_list  = $this -> get_post('question_list');
		$question_arr = json_decode($question_list,true);

		if(!empty($member_id) && !empty($question_list) ) {
			$res['success'] = TRUE;

			$nowDate = date("Y-m-d");
			$nowtime = date("Y-m-d H:i:s");

			$startTime = date('Y-m-d 00:00:00');
			$endTime = date('Y-m-d 23:59:59');

			$m = $this -> daily_record_question_dao -> find_by_value(array('member_id'=>$member_id));
			if(!empty($m)){
				$this -> dao -> update(array('last_update_question_time'=> $nowtime), $member_id);
				$this -> daily_record_question_detail_dao -> delete_by_value(array('member_id'=> $member_id,'daily_record_question_id'=> $m->id));

				$group1 = 0;
				$group2 = 0;
				$group3 = 0;

				foreach($question_arr as $each){
					$question_id	= $each['question_id'];
					$reply = $each['reply'];

					$i_data = array();
					$i_data['member_id'] = $member_id;
					$i_data['daily_record_question_id'] = $m->id;
					$i_data['question_id'] = $question_id;
					$i_data['reply'] = $reply ;

					// 1~8
					if($question_id < 9){
						if($reply== 1){
							$group1++;
						}
					}

					// 9~11
					if($question_id > 8 && $question_id < 12){
						if($question_id == 9){
							if($reply== 0){
								$group2++;
							}
						}else{
							if($reply== 1){
								$group2++;
							}
						}
					}

					// 12~14
					if($question_id > 11){
						if($question_id == 14){
							if($reply== 0){
								$group3++;
							}
						}else{
							if($reply== 1){
								$group3++;
							}
						}
					}

					$this -> daily_record_question_detail_dao -> insert($i_data);
				}

				$this -> daily_record_question_dao -> update(array('group1'=> $group1,'group2'=> $group2,'group3'=> $group3,'update_time'=> $nowtime), $m->id);
			}else{
				$this -> dao -> update(array('last_update_question_time'=> $nowtime), $member_id);
				$id = $this -> daily_record_question_dao -> insert(array('member_id' => $member_id));

				$group1 = 0;
				$group2 = 0;
				$group3 = 0;

				foreach($question_arr as $each){
					$question_id	= $each['question_id'];
					$reply = $each['reply'];

					$i_data = array();
					$i_data['member_id'] = $member_id;
					$i_data['daily_record_question_id'] = $id;
					$i_data['question_id'] = $question_id;
					$i_data['reply'] = $reply ;

					// 1~8
					if($question_id < 9){
						if($reply== 1){
							$group1++;
						}
					}

					// 9~11
					if($question_id > 8 && $question_id < 12){
						if($question_id == 9){
							if($reply== 0){
								$group2++;
							}
						}else{
							if($reply== 1){
								$group2++;
							}
						}
					}

					// 12~14
					if($question_id > 11){
						if($question_id == 14){
							if($reply== 0){
								$group3++;
							}
						}else{
							if($reply== 1){
								$group3++;
							}
						}
					}

					$this -> daily_record_question_detail_dao -> insert($i_data);
				}

				$this -> daily_record_question_dao -> update(array('group1'=> $group1,'group2'=> $group2,'group3'=> $group3), $id);

				// 送金幣
				$this -> bonus_record_dao -> insert(array('member_id'=> $member_id,'type'=>2,'amt'=>10, 'record_id'=>$id), $member_id);

				$member = $this -> dao -> find_by_id($member_id);
				$last_update_index_time = $member -> last_update_index_time;
				$last_update_question_time = $member -> last_update_question_time;

				if($last_update_index_time > $startTime && $last_update_index_time <= $endTime
						&& $last_update_question_time > $startTime && $last_update_question_time <= $endTime){
							$res['has_gift'] = TRUE;
				}

				$res['id'] = $id;
			}

		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 新增清心方法
	public function add_relieve_method(){
		$member_id = $this -> get_post('member_id');
		$content  = $this -> get_post('content');

		if(!empty($member_id) && !empty($content)) {
			$res['success'] = TRUE;
			$m = $this -> relieve_method_dao -> find_by_value(array('member_id'=>$member_id));
			$id = $this -> relieve_method_dao -> insert(array('member_id'=> $member_id,'content'=>$content));
			if(empty($m)){
				$member = $this -> dao -> find_by_id($member_id);
				if(!empty($member)){
					// 送金幣
					$this -> bonus_record_dao -> insert(array('member_id'=> $member_id,'type'=>7,'amt'=>20, 'record_id'=>$id), $member_id);
					$this -> tree_record_dao -> insert(array('member_id'=> $member_id,'score'=> 2, 'record_id'=>$id,'type'=> 1));

					$loginCount = $member -> login_count;
					$setting = $this -> record_setting_dao -> find_by_id(1);
					$day = $setting -> login;
					// 更新 login_count
					$newCount = $loginCount + 2;
					$updateCount = 0;
					if($newCount > $day){
						$updateCount = $newCount - $day;
					}else{
						$updateCount = $newCount;
					}
					$updateData = array('login_count'=> $updateCount);
					$this -> dao -> update($updateData,$member_id);
				}
			}
			$res['id'] = $id;
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 新增關卡一
	public function add_level1(){
		$member_id = $this -> get_post('member_id');
		$type  = $this -> get_post('type');
		$score  = $this -> get_post('score');

		if(!empty($member_id) && !empty($score) && $type!='') {
			$nowtime = date("Y-m-d H:i:s");

			$m = $this -> level_1_record_dao -> find_by_value(array('member_id'=>$member_id,'type'=> $type));
			if(!empty($m)){
				$m1 = $m[0];
				$sn = $m1 -> sn +1;
				$id = $this -> level_1_record_dao -> insert(array('member_id'=> $member_id,'type'=>$type,'score'=>$score,'sn'=> $sn));
			}else{
				$id = $this -> level_1_record_dao -> insert(array('member_id'=> $member_id,'type'=>$type,'score'=>$score,'sn'=> 1));
			}

			$one = $this -> level_1_record_dao -> find_by_id($id);
			if(!empty($type)){
				// 1:壓力橡皮擦
				$another = $this -> level_1_record_dao -> find_by_value(array('member_id'=> $member_id,'type'=> 0,'sn'=> $one->sn));
			}else{
				// 0:腹式呼吸
				$another = $this -> level_1_record_dao -> find_by_value(array('member_id'=> $member_id,'type'=> 1,'sn'=> $one->sn));
			}

			// 每天完成的第一筆資料做更新 level_record_log 以及 member
			$setting = $this -> record_setting_dao -> find_by_id(1);
			$finalCount = $setting->level_1;

			if(!empty($another) && $one->sn == 1){
				$n = $this -> level_record_log_dao -> find_by_value(array('member_id'=>$member_id,'level'=> 1));
				$updateMemberData = array('last_update_hw_time'=> $nowtime);
				if(!empty($n)){
					$updateData = array('number'=> $n->number +1,'update_time'=> $nowtime);

					// 達標次數將更新完成結束時間及總共花費時間
					if($n->number +1 == $finalCount){
						$start = strtotime($n->start_time);
						$end = strtotime($nowtime);
						$timeDiff = $end - $start;
						$updateData['end_time'] = $nowtime;
						$updateData['time_diff'] = $timeDiff;

						// 判斷是否仍在第一關，若在第一關才更新成為第二關
						$memberData = $this -> dao -> find_by_id($member_id);
						if($memberData -> level_status == 1){
							$updateMemberData['level_status'] = 2;
						}
					}

					$this -> level_record_log_dao -> update($updateData ,$n -> id);
				}else{
					$this -> level_record_log_dao -> insert(array('member_id'=>$member_id,'level'=> 1,'number'=> 1,'start_time'=> $nowtime));
				}

				// 更新會員資料最後作業時間
				$this -> dao -> update($updateMemberData, $member_id);
			}

			if(!empty($another) && $one->sn < 4){
				// 第一關送金幣，一天最多送三次
				$this -> bonus_record_dao -> insert(array('member_id'=> $member_id,'type'=>3,'amt'=>20, 'record_id'=>$id), $member_id);
			}

			$res['success'] = TRUE;
			$res['id'] = $id;

		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 新增關卡二
	public function add_level2(){
		$member_id = $this -> get_post('member_id');
		$content  = $this -> get_post('content');

		if(!empty($member_id) && !empty($content)) {
			$nowtime = date("Y-m-d H:i:s");

			$m = $this -> level_2_record_dao -> find_by_value(array('member_id'=> $member_id));

			// insert data
			$id = $this -> level_2_record_dao -> insert(array('member_id'=> $member_id,'content'=>$content));
			if(empty($m)){
				// 第二關送金幣，一天一次
				$this -> bonus_record_dao -> insert(array('member_id'=> $member_id,'type'=>4,'amt'=>30, 'record_id'=>$id), $member_id);
			}

			$setting = $this -> record_setting_dao -> find_by_id(1);
			$finalCount = $setting->level_2;

			$n = $this -> level_record_log_dao -> find_by_value(array('member_id'=>$member_id,'level'=> 2));
			$updateMemberData = array('last_update_hw_time'=> $nowtime);
			// 每天只給1次金幣獎勵，領7次金幣獎勵才開啟關卡三。
			// 開心事件紀錄簿可以輸入很多次，但後台僅收第一次紀錄的data
			// 紀錄主表只記錄每天的第一次，以免影響開啟關卡三之計算
			if(empty($m)){
				if(!empty($n)){
					$updateData = array('number'=> $n->number +1,'update_time'=> $nowtime);

					// 達標次數是根據得到幾次金幣
					// 達標次數將更新完成結束時間及總共花費時間
					$bonus = $this -> bonus_record_dao -> count_bouus(array('member_id'=>$member_id,'level'=> 4));
					$bonusCount = $bonus->count;
					if($bonusCount == $finalCount){
						$start = strtotime($n->start_time);
						$end = strtotime($nowtime);
						$timeDiff = $end - $start;
						$updateData['end_time'] = $nowtime;
						$updateData['time_diff'] = $timeDiff;

						// 判斷是否仍在第二關，若在第二關才更新成為第三關
						$memberData = $this -> dao -> find_by_id($member_id);
						if($memberData -> level_status == 2){
							$updateMemberData['level_status'] = 3;
						}
					}

					$this -> level_record_log_dao -> update($updateData ,$n -> id);
				}else{
					$this -> level_record_log_dao -> insert(array('member_id'=>$member_id,'level'=> 2,'number'=> 1,'start_time'=> $nowtime));
				}
			}

			// 更新會員資料最後作業時間
			$this -> dao -> update($updateMemberData, $member_id);

			$res['success'] = TRUE;
			$res['id'] = $id;
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 新增關卡三
	public function add_level3(){
		$member_id = $this -> get_post('member_id');
		$event  = $this -> get_post('event');
		$old_idea  = $this -> get_post('old_idea');
		$new_idea  = $this -> get_post('new_idea');
		$old_mood  = $this -> get_post('old_mood');
		$new_mood  = $this -> get_post('new_mood');

		if(!empty($member_id) && !empty($event) &&!empty($old_idea) &&!empty($new_idea) &&!empty($old_mood) &&!empty($new_mood)) {

			$nowDate = date("Y-m-d");
			$nowtime = date("Y-m-d H:i:s");

			$m = $this -> level_3_record_dao -> find_by_value(array('member_id'=> $member_id));
			$i_data = array('member_id'=> $member_id,
											'event'=> $event,
											'old_idea'=> $old_idea,
											'new_idea'=> $new_idea,
											'old_mood'=> $old_mood,
											'new_mood'=> $new_mood);
			$id = $this -> level_3_record_dao -> insert($i_data);

			// 第三關送金幣，無限制次數
			$this -> bonus_record_dao -> insert(array('member_id'=> $member_id,'type'=>5,'amt'=>20, 'record_id'=>$id), $member_id);

			$setting = $this -> record_setting_dao -> find_by_id(1);
			$finalCount = $setting->level_3;

			$n = $this -> level_record_log_dao -> find_by_value(array('member_id'=>$member_id,'level'=> 3));
			$updateMemberData = array('last_update_hw_time'=> $nowtime);
			if(!empty($n)){
				$updateData = array('number'=> $n->number +1,'update_time'=> $nowtime);

				// 達標次數將更新完成結束時間及總共花費時間
				if($n->number +1 == $finalCount){
					$start = strtotime($n->start_time);
					$end = strtotime($nowtime);
					$timeDiff = $end - $start;
					$updateData['end_time'] = $nowtime;
					$updateData['time_diff'] = $timeDiff;

					// 判斷是否仍在第二關，若在第二關才更新成為第三關
					$memberData = $this -> dao -> find_by_id($member_id);
					if($memberData -> level_status == 3){
						$updateMemberData['level_status'] = 4;
					}
				}

				$this -> level_record_log_dao -> update($updateData ,$n -> id);
			}else{
				$this -> level_record_log_dao -> insert(array('member_id'=>$member_id,'level'=> 3,'number'=> 1,'start_time'=> $nowtime));
			}

			// 更新會員資料最後作業時間
			$this -> dao -> update($updateMemberData, $member_id);

			$res['success'] = TRUE;
			$res['id'] = $id;
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 新增關卡四
	public function add_level4(){
		$member_id = $this -> get_post('member_id');
		$content  = $this -> get_post('content');

		if(!empty($member_id) && !empty($content)) {
			$res['success'] = TRUE;

			$nowtime = date("Y-m-d H:i:s");

			$m = $this -> level_4_record_dao -> find_by_value(array('member_id'=> $member_id));
			$id = $this -> level_4_record_dao -> insert(array('member_id'=> $member_id,'content'=>$content));

			// 第四關送金幣，無限制次數
			$this -> bonus_record_dao -> insert(array('member_id'=> $member_id,'type'=>6,'amt'=>20, 'record_id'=>$id), $member_id);

			$setting = $this -> record_setting_dao -> find_by_id(1);
			$finalCount = $setting->level_4;

			$n = $this -> level_record_log_dao -> find_by_value(array('member_id'=>$member_id,'level'=> 4));
			$updateMemberData = array('last_update_hw_time'=> $nowtime);
			if(!empty($n)){
				$updateData = array('number'=> $n->number +1,'update_time'=> $nowtime);

				// 達標次數將更新完成結束時間及總共花費時間
				if($n->number +1 == $finalCount){
					$start = strtotime($n->start_time);
					$end = strtotime($nowtime);
					$timeDiff = $end - $start;
					$updateData['end_time'] = $nowtime;
					$updateData['time_diff'] = $timeDiff;
				}

				$this -> level_record_log_dao -> update($updateData ,$n -> id);
			}else{
				$this -> level_record_log_dao -> insert(array('member_id'=>$member_id,'level'=> 4,'number'=> 1,'start_time'=> $nowtime));
			}

			// 更新會員資料最後作業時間
			$this -> dao -> update($updateMemberData, $member_id);

			$res['success'] = TRUE;
			$res['id'] = $id;
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 健康日記記錄
	// public function list_index_record(){
	// 	$member_id = $this -> get_post('member_id');
	// 	$start_date  = $this -> get_post('start_date');
	// 	$end_date  = $this -> get_post('end_date');
	//
	// 	if(!empty($member_id)) {
	// 		$res['success'] = TRUE;
	// 		$data = array('member_id'=> $member_id);
	// 		if(!empty($start_date)){
	// 			$data['start_date'] = $start_date;
	// 		}
	// 		if(!empty($end_date)){
	// 			$data['end_date'] = $end_date;
	// 		}
	// 		$list = $this -> daily_record_index_dao -> find_use_by_record($data);
	// 		$res['list'] = $list;
	// 	} else {
	// 		$res['error_code'][] = "columns_required";
	// 		$res['error_message'][] = "缺少必填欄位";
	// 	}
	// 	$this -> to_json($res);
	// }

	// 健康日記記錄
	public function list_index_record(){
		$member_id = $this -> get_post('member_id');
		$start_date  = $this -> get_post('start_date');
		$end_date  = $this -> get_post('end_date');
		$type  = $this -> get_post('type');

		if(!empty($member_id)) {
			$res['success'] = TRUE;
			$data = array('member_id'=> $member_id);
			if(!empty($start_date)){
				$data['start_date'] = $start_date;
			}
			if(!empty($end_date)){
				$data['end_date'] = $end_date;
			}

			if(!empty($type)){
				$data['type'] =  $type;
			}
			$list = $this -> daily_record_index_dao -> find_use_by_record($data);

			if(!empty($type)){
				$min = $this -> daily_record_index_dao -> find_min($data);
				$max = $this -> daily_record_index_dao -> find_max($data);

				$res['min'] = $min-> $type;
				$res['max'] = $max-> $type;
			}

			$res['list'] = $list;

		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function list_level1_record(){
		$member_id = $this -> get_post('member_id');
		$start_date  = $this -> get_post('start_date');
		$end_date  = $this -> get_post('end_date');

		if(!empty($member_id)) {
			$res['success'] = TRUE;

			$data = array('member_id'=> $member_id);
			if(!empty($start_date)){
				$data['start_date'] = $start_date;
			}
			if(!empty($end_date)){
				$data['end_date'] = $end_date;
			}

			$data['type'] = 0;
			$list = $this -> level_1_record_dao -> find_use_by_record($data);

			$data['type'] = 1;
			$list1 = $this -> level_1_record_dao -> find_use_by_record($data);
			$res['list1'] = $list;
			$res['list2'] = $list1;

		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}

		$this -> to_json($res);
	}

	public function find_level_counts(){

		$member_id = $this -> get_post('member_id');
		$level  = $this -> get_post('level');
		if(!empty($member_id)&& !empty($level)) {
			$res['success'] = TRUE;

			$m = $this -> level_record_log_dao -> find_by_value(array('member_id'=>$member_id,'level'=> $level));
			if(!empty($m)){
				$res['number'] = $m-> number ;
			}else{
				$res['number'] = 0 ;
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 新增關卡四安心測試
	public function add_level_complete(){
		$member_id = $this -> get_post('member_id');
		$score  = $this -> get_post('score');
		$type  = '2';

		if(!empty($member_id) && !empty($score) && $type!='') {
			$nowtime = date("Y-m-d H:i:s");

			$m = $this -> level_1_record_dao -> find_by_value(array('member_id'=>$member_id,'type'=> $type));
			if(!empty($m)){
				$m1 = $m[0];
				$sn = $m1 -> sn +1;
				$id = $this -> level_1_record_dao -> insert(array('member_id'=> $member_id,'type'=>$type,'score'=>$score,'sn'=> $sn));
			}else{
				$id = $this -> level_1_record_dao -> insert(array('member_id'=> $member_id,'type'=>$type,'score'=>$score,'sn'=> 1));
			}

			$res['success'] = TRUE;
			$res['id'] = $id;

		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}







	public function goTest(){
		$member_id = $this -> get_post('member_id');
		$level  = $this -> get_post('level');
		$list1 = $this -> bonus_record_dao -> count_bouus(array('member_id'=>$member_id,'level'=> 1));
		$res['count'] = $list1->count;

		$this -> to_json($res);
	}








}
?>
