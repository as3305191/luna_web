<?php
class Record extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Records_dao', 'records_dao');
		$this -> load -> model('Ketone_dao', 'ketone_dao');
		$this -> load -> model('Ketone_record_dao', 'ketone_record_dao');



	}

	function index() {
		echo "index";
	}


	// 新增秤重紀錄
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

	// 秤重最新紀錄
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

	// 秤重所有紀錄
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

	// 刪除秤重所有紀錄
	public function delete_record(){
		$id = $this -> get_post('id');
		if(!empty($id)) {
			$this -> records_dao -> update(array('is_delete'=> 1),$id);
			$res['success'] = TRUE;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 秤重所有紀錄(一天一筆)
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

	//列出月份日期
	public function list_record_dates() {
		$res = array('success' => TRUE);

		$ym = $this -> get_post("ym");
		$member_id = $this -> get_post("member_id");

		if(!empty($member_id) && !empty($ym)) { //
			$list = $this -> records_dao -> find_all_by_ym($member_id, $ym);
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}

		$res['list'] = $list;
		$this -> to_json($res);
	}

  // 兩筆差異紀錄
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

			$m = $this -> dao -> find_by_id($member_id);
			$res['member'] = $m;

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
				$weight_kg = $data1->weight/1000;
				$body_fat = $data1->weight/1000 * $data1->body_fat/100;
				$visceral_fat = $data1->weight/1000 * $data1->visceral_fat/100;
				$protein = $data1->weight/1000 * $data1->protein/100;
				$moisture = $data1->weight/1000 * $data1->moisture/100;
				$muscle = $data1->weight/1000 * $data1->muscle/100;
				$bone_mass = $data1->weight/1000 * $data1->bone_mass/100;
				$skeletal_muscle =  $data1->weight/1000 * $data1->skeletal_muscle/100;

				$data1 -> weight = number_format($weight_kg,1);
				$data1 -> body_fat_weight = number_format($body_fat,1);
				$data1 -> visceral_fat_weight = number_format($visceral_fat,1);
				$data1 -> protein_weight = number_format($protein,1);
				$data1 -> moisture_weight = number_format($moisture,1);
				$data1 -> muscle_weight = number_format($muscle,1);
				$data1 -> bone_mass_weight = number_format($bone_mass,1);
				$data1 -> skeletal_muscle_weight = number_format($skeletal_muscle,1);
			}

			if(!empty($data2)){
				$weight_kg = $data2->weight/1000;
				$body_fat = $data2->weight/1000 * $data2->body_fat/100;
				$visceral_fat = $data2->weight/1000 * $data2->visceral_fat/100;
				$protein = $data2->weight/1000 * $data2->protein/100;
				$moisture = $data2->weight/1000 * $data2->moisture/100;
				$muscle = $data2->weight/1000 * $data2->muscle/100;
				$bone_mass = $data2->weight/1000 * $data2->bone_mass/100;
				$skeletal_muscle =  $data2->weight/1000 * $data2->skeletal_muscle/100;

				$data2 -> weight = number_format($weight_kg,1);
				$data2 -> body_fat_weight = number_format($body_fat,1);
				$data2 -> visceral_fat_weight = number_format($visceral_fat,1);
				$data2 -> protein_weight = number_format($protein,1);
				$data2 -> moisture_weight = number_format($moisture,1);
				$data2 -> muscle_weight = number_format($muscle,1);
				$data2 -> bon_mass_weight = number_format($bone_mass,1);
				$data2 -> skeletal_muscle_weight = number_format($skeletal_muscle,1);
			}

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

	// 尿酮值列表
	public function list_ketone(){
		$list = $this -> ketone_dao -> find_all();
		$res['success'] = TRUE;
		$res['list'] = $list;
		$this -> to_json($res);
	}

	// 新增尿酮紀錄
	public function add_ketone_record(){
		$member_id = $this -> get_post('member_id');
		$ketone_id = $this -> get_post('ketone_id');
		$date = $this -> get_post('date');
		$time = $this -> get_post('time');

		if(!empty($member_id) && !empty($ketone_id) && !empty($date) && !empty($time)) {
			$insert_data = array('member_id'=> $member_id,
											'ketone_id' => $ketone_id,
											'date' => $date,
											'time' => $time
										);

			$id = $this -> ketone_record_dao -> insert($insert_data);
			$res['success'] = TRUE;
			$res['id'] = $id;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 編輯尿酮紀錄
	public function edit_ketone_record(){
		$id = $this -> get_post('id');
		$ketone_id = $this -> get_post('ketone_id');
		$date = $this -> get_post('date');
		$time = $this -> get_post('time');

		if(!empty($id) && !empty($ketone_id) && !empty($date) && !empty($time)) {
			$insert_data = array(
											'ketone_id' => $ketone_id,
											'date' => $date,
											'time' => $time
										);

			$this -> ketone_record_dao -> update($insert_data, $id);
			$res['success'] = TRUE;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 尿酮紀錄列表
	public function list_ketone_record(){
		$member_id = $this -> get_post('member_id');
		$page = $this -> get_post('page');

		if(!empty($member_id)) {
			$f = array('member_id' => $member_id);
			if(!empty($page)){
				$f['page'] = $page;
			}
			$list = $this -> ketone_record_dao -> find_by_parameter($f);
			$res['success'] = TRUE;
			$res['list'] = $list;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}

		$this -> to_json($res);
	}

	public function delete_ketone_record(){
		$id = $this -> get_post('id');
		if(!empty($id)) {
			$this -> ketone_record_dao -> update(array('is_delete'=> 1),$id);
			$res['success'] = TRUE;
		}else{
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
