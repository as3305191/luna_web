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
		$subcutaneous_fat = $this -> get_post('subcutaneous_fat');
		$visceral_fat = $this -> get_post('visceral_fat');
		$bmr = $this -> get_post('bmr');
		$bone_mass = $this -> get_post('bone_mass');
		$physical_age = $this -> get_post('physical_age');
		$moisture = $this -> get_post('moisture');
		$protein = $this -> get_post('protein');
		$skeletal_muscle = $this -> get_post('skeletal_muscle');
		$bmi = $this -> get_post('bmi');
		if(!empty($member_id)){
			$m = $this -> dao -> find_by_value($member_id);
			if(!empty($m)) {
				$today = date("Y-m-d");

				$insert_data = array('member_id' => $member_id,
									 'weight' => $weight,
									 'body_fat' => $body_fat,
									 'subcutaneous_fat' => $subcutaneous_fat,
									 'visceral_fat' => $visceral_fat,
									 'bmr' => $bmr,
									 'bone_mass' => $bone_mass,
									 'physical_age' => $physical_age,
									 'moisture' => $moisture,
									 'protein' => $protein,
									 'skeletal_muscle' => $skeletal_muscle,
									 'bmi' => $bmi,
									 'create_date'=> $today
								 );
				$data = $this -> records_dao -> find_by_value(array('member_id'=>$member_id,'date'=>$today));
				if(empty($data)){
					$insert_data['pos'] = 1;
				}

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
			if(!empty($m)){
				$weight_kg = $m->weight/1000;
				$body_fat =  $m->weight/1000 * $m->body_fat/100;
				$visceral_fat =  $m->weight/1000 * $m->visceral_fat/100;
				$protein =  $m->weight/1000 * $m->protein/100;
				$moisture =  $m->weight/1000 * $m->moisture/100;
				$muscle =  $m->weight/1000 * $m->muscle/100;
				$bone_mass =  $m->weight/1000 * $m->bone_mass/100;
				$skeletal_muscle =  $m->weight/1000 * $m->skeletal_muscle/100;

				// $m->weight =sprintf("%.2f",$weight_kg);
				$m -> weight = number_format($weight_kg,1);
				$m -> body_fat_weight = number_format($body_fat,1);
				$m -> visceral_fat_weight = number_format($visceral_fat,1);
				$m -> protein_weight = number_format($protein,1);
				$m -> moisture_weight = number_format($moisture,1);
				$m -> muscle_weight = number_format($muscle,1);
				$m -> bone_mass_weight = number_format($bone_mass,1);
				$m -> skeletal_muscle_weight = number_format($skeletal_muscle,1);

				$res['record'] = $m;
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function list_all_record(){
		$member_id = $this -> get_post('member_id');
		$date = $this -> get_post('date');

		if(!empty($member_id)){
			$f = array('member_id' => $member_id);
			if(!empty($date)){
				$f['date'] = $date;
			}

			$list = $this -> records_dao -> find_by_parameter($f);

			$res['success'] = TRUE;
			foreach ($list as $each) {
				$weight_kg = $each->weight/1000;
				$body_fat = $each->weight/1000 * $each->body_fat/100;
				$visceral_fat = $each->weight/1000 * $each->visceral_fat/100;
				$protein = $each->weight/1000 * $each->protein/100;
				$moisture = $each->weight/1000 * $each->moisture/100;
				$muscle = $each->weight/1000 * $each->muscle/100;
				$bone_mass = $each->weight/1000 * $each->bone_mass/100;
				$skeletal_muscle =  $each->weight/1000 * $each->skeletal_muscle/100;

				$each -> weight = number_format($weight_kg,1);
				$each -> body_fat_weight = number_format($body_fat,1);
				$each -> visceral_fat_weight = number_format($visceral_fat,1);
				$each -> protein_weight = number_format($protein,1);
				$each -> moisture_weight = number_format($moisture,1);
				$each -> muscle_weight = number_format($muscle,1);
				$each -> bone_mass_weight = number_format($bone_mass,1);
				$each -> skeletal_muscle_weight = number_format($skeletal_muscle,1);
			}

			$res['list'] = $list;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function list_all_record_by_date(){
		$member_id = $this -> get_post('member_id');
		$date = $this -> get_post('date');

		if(!empty($member_id)){
			$f = array('member_id' => $member_id);
			if(!empty($date)){
				$f['date'] = $date;
			}

			$list = $this -> records_dao -> find_by_date($f);

			$res['success'] = TRUE;
			foreach ($list as $each) {
				$weight_kg = $each->weight/1000;
				$body_fat = $each->weight/1000 * $each->body_fat/100;
				$visceral_fat = $each->weight/1000 * $each->visceral_fat/100;
				$protein = $each->weight/1000 * $each->protein/100;
				$moisture = $each->weight/1000 * $each->moisture/100;
				$muscle = $each->weight/1000 * $each->muscle/100;
				$bone_mass = $each->weight/1000 * $each->bone_mass/100;
				$skeletal_muscle =  $each->weight/1000 * $each->skeletal_muscle/100;

				$each -> weight = number_format($weight_kg,1);
				$each -> body_fat_weight = number_format($body_fat,1);
				$each -> visceral_fat_weight = number_format($visceral_fat,1);
				$each -> protein_weight = number_format($protein,1);
				$each -> moisture_weight = number_format($moisture,1);
				$each -> muscle_weight = number_format($muscle,1);
				$each -> bone_mass_weight = number_format($bone_mass,1);
				$each -> skeletal_muscle_weight = number_format($skeletal_muscle,1);
			}

			$res['list'] = $list;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function diff_record(){
		$member_id = $this -> get_post('member_id');
		$type = $this -> get_post('type');
		$id1 = $this -> get_post('id1');
		$id2 = $this -> get_post('id2');

		if(!empty($member_id)){
			$f = array('member_id' => $member_id);
			if(!empty($date)){
				$f['date'] = $date;
			}

			$res['success'] = TRUE;
			$data1 = NULL;
			$data2 = NULL;
			$weight_kg = 0;
			$body_diff = 0;

			if(empty($type)){
				$data1 = $this -> records_dao -> find_max_weight($f);
				$data2 = $this -> records_dao -> find_min_weight($f);
			}

			if($type == '1'){ //最近兩日
				$f['desc'] = TRUE;

				$list = $this -> records_dao -> find_by_date($f);
				if(!empty($list)){
					$data2 = $list[0];
					if(count($list) > 1){
						$data1 = $list[1];
					}
				}
			}

			if($type == '2'){ //自選資料
				$data2 = $this -> records_dao -> find_by_id($id2);
				$data1 = $this -> records_dao -> find_by_id($id1);
			}

			if($data1 != NULL && $data2 != NULL){
				$weight_kg = ($data2->weight - $data1->weight)/1000;
				$body_fat_d1 = $data1->body_fat * $data1->weight/100;
				$body_fat_d2 = $data2->body_fat * $data2->weight/100;
				$body_diff = ($body_fat_d2 - $body_fat_d1)/1000;
			}else if($data1 == NULL && $data2 == NULL){

			}else if($data1 == NULL){
				$weight_kg = ($data2->weight)/1000;
				$body_fat_d1 = 0;
				$body_fat_d2 = $data2->body_fat * $data2->weight/100;
				$body_diff = ($body_fat_d2 - $body_fat_d1)/1000;
			}else if($data2 == NULL){
				$weight_kg = (0 - $data1->weight)/1000;
				$body_fat_d1 = $data1->body_fat * $data1->weight/100;
				$body_fat_d2 = 0;
				$body_diff = ($body_fat_d2 - $body_fat_d1)/1000;
			}


			$res['weight_diff'] = number_format($weight_kg,1);
			$res['body_fat_diff'] = number_format($body_diff,1);
			if(!empty($data1)){
				$res['data1'] = $data1;
			}
			if(!empty($data2)){
				$res['data2'] = $data2;
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function diff_record_by_id(){


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
