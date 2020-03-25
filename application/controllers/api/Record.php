<?php
class Record extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Records_dao', 'records_dao');
		$this -> load -> model('Ketone_dao', 'ketone_dao');
		$this -> load -> model('Ketone_record_dao', 'ketone_record_dao');
		$this -> load -> model('Disease_dao', 'disease_dao');
		$this -> load -> model('Members_disease_dao', 'members_disease_dao');
		$this -> load -> model('Members_disease_detail_dao', 'members_disease_detail_dao');
		$this -> load -> model('Recipes_dao', 'recipes_dao');

	}

	function index() {
		echo "index";
		$msg = parse_ini_file("msg.properties", true, INI_SCANNER_RAW);
		echo $msg['tip.weight'];
	}


	// 新增秤重紀錄
	public function add_record(){
		$member_id = $this -> get_post('member_id');
		$weight = $this -> get_post('weight');
		$body_fat_rate = $this -> get_post('body_fat_rate');
		$body_fat_rate = floatval($body_fat_rate);

		$subcutaneous_fat_rate = $this -> get_post('subcutaneous_fat_rate');
		$visceral_fat_rate = $this -> get_post('visceral_fat_rate');
		$bmr = $this -> get_post('bmr');
		$bone_mass_rate = $this -> get_post('bone_mass_rate');
		$physical_age = $this -> get_post('physical_age');
		$moisture_rate = $this -> get_post('moisture_rate');
		$muscle_rate = $this -> get_post('muscle_rate');
		$protein_rate = $this -> get_post('protein_rate');
		$skeletal_muscle_rate = $this -> get_post('skeletal_muscle_rate');
		$bmi = $this -> get_post('bmi');
		$adc1 = $this -> get_post('adc1');

		$bmi = floatval($bmi);

		if(!empty($member_id)){
			if(empty($adc1)){
				$res['success'] = TRUE;
			}else{
				$m = $this -> dao -> find_by_id($member_id);
				if(!empty($m)) {
					$today = date("Y-m-d");

					$body_fat = $weight * $body_fat_rate/100;

					$m2 = floatval($m -> height) * floatval($m -> height) / 10000.0; // 身高公尺平方
					$weight_best = 0;
					if($m -> gender == 1) { // 男生
						$weight_best = $m2 * 22;
					}
					if($m -> gender == 0) { // 女生
						$weight_best = $m2 * 20.6;
					}

					$bmi_best = 22; // always 22
					$fat_info = get_fat_info($bmi, $body_fat_rate, $m -> gender);

					$fat_rate_best = 18.0;
					$fat_best =	$weight_best * $fat_rate_best / 100.0;

					$insert_data = array('member_id' => $member_id,
										 'weight' => $weight,
										 'body_fat' => $body_fat,
										 'body_fat_rate' => $body_fat_rate,
										 'subcutaneous_fat_rate' => $subcutaneous_fat_rate,
										 'visceral_fat_rate' => $visceral_fat_rate,
										 'bmr' => $bmr,
										 'bone_mass_rate' => $bone_mass_rate,
										 'physical_age' => $physical_age,
										 'moisture_rate' => $moisture_rate,
										 'protein_rate' => $protein_rate,
										 'muscle_rate' => $muscle_rate,
										 'skeletal_muscle_rate' => $skeletal_muscle_rate,
										 'bmi' => $bmi,
										 'bmi_best' => $bmi_best,
										 'weight_best' => $weight_best,
										 'fat_rate_best' => $fat_rate_best,
										 'fat_best' => $fat_best,
										 'fat_info' => $fat_info,
										 'adc1' => $adc1,
										 'create_date'=> $today
									 );
					$data = $this -> records_dao -> find_by_value(array('member_id'=>$member_id,'date'=>$today));

					$can_insert = TRUE;
					if(empty($data)){
						$insert_data['pos'] = 1;
					} else {
						// contains old data
						$diff = abs(time() - strtotime($data->create_time));
						$res['diff'] = $diff;
						if($diff < 10) {
							$res['too_often'] = TRUE;
							$can_insert = FALSE;
						}
					}
					if($can_insert) {
						$id = $this -> records_dao -> insert($insert_data);
						$res['id'] = $id;
					}
					$res['success'] = TRUE;
				} else {
					$res['error_code'][] = "account_not_found";
					$res['error_message'][] = "查無此會員";
				}
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
			$ketone = $this -> ketone_record_dao -> find_by_one(array('member_id' => $member_id));

			$res['success'] = TRUE;
			if(!empty($m)){
				$weight_kg = $m->weight/1000;
				$body_fat =  $m->weight/1000 * $m->body_fat_rate/100;
				$visceral_fat =  $m->weight/1000 * $m->visceral_fat_rate/100;
				$protein =  $m->weight/1000 * $m->protein_rate/100;
				$moisture =  $m->weight/1000 * $m->moisture_rate/100;
				$muscle =  $m->weight/1000 * $m->muscle_rate/100;
				$bone_mass =  $m->bone_mass_rate;
				$skeletal_muscle =  $m->weight/1000 * $m->skeletal_muscle_rate/100;
				// $fat_best =  $m->weight/1000 * $m->body_fat_best/100;
				$rest_weight = $weight_kg - $body_fat;

				// $m->weight =sprintf("%.2f",$weight_kg);
				$m -> weight = number_format($weight_kg,1);
				$m -> body_fat = number_format($body_fat,1);
				$m -> visceral_fat = number_format($visceral_fat,1);
				$m -> protein = number_format($protein,1);
				$m -> moisture = number_format($moisture,1);
				$m -> muscle = number_format($muscle,1);
				$m -> skeletal_muscle = number_format($skeletal_muscle,1);
				$m -> bone_mass = number_format($bone_mass,1);
				// $m -> fat_best = number_format($fat_best,1);
				$m -> rest_weight = number_format($rest_weight,1);

				$res['record'] = $m;
				if(!empty($ketone)){
					$res['ketone'] = $ketone;
				}
				// 獲得suggestion
				$res['td'] = $this -> get_suggestions($member_id,0);
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 秤重單筆紀錄
	public function find_one_record(){
		$id = $this -> get_post('id');
		$member_id = $this -> get_post('member_id');

		if(!empty($id && !empty($member_id))){
			$m = $this -> records_dao -> find_by_id($id);
			$ketone = $this -> ketone_record_dao -> find_by_one(array('member_id' => $member_id,'date' => $m->create_date));

			$res['success'] = TRUE;
			if(!empty($m)){
				$weight_kg = $m->weight/1000;
				$body_fat =  $m->weight/1000 * $m->body_fat_rate/100;
				$visceral_fat =  $m->weight/1000 * $m->visceral_fat_rate/100;
				$protein =  $m->weight/1000 * $m->protein_rate/100;
				$moisture =  $m->weight/1000 * $m->moisture_rate/100;
				$muscle =  $m->weight/1000 * $m->muscle_rate/100;
				$bone_mass =  $m->bone_mass_rate;
				$skeletal_muscle =  $m->weight/1000 * $m->skeletal_muscle_rate/100;
				// $fat_best =  $m->weight/1000 * $m->body_fat_best/100;
				$rest_weight = $weight_kg - $body_fat;

				// $m->weight =sprintf("%.2f",$weight_kg);
				$m -> weight = number_format($weight_kg,1);
				$m -> body_fat = number_format($body_fat,1);
				$m -> visceral_fat = number_format($visceral_fat,1);
				$m -> protein = number_format($protein,1);
				$m -> moisture = number_format($moisture,1);
				$m -> muscle = number_format($muscle,1);
				$m -> skeletal_muscle = number_format($skeletal_muscle,1);
				$m -> bone_mass = number_format($bone_mass,1);
				// $m -> fat_best = number_format($fat_best,1);
				$m -> rest_weight = number_format($rest_weight,1);

				$res['record'] = $m;
				if(!empty($ketone)){
					$res['ketone'] = $ketone;
				}
				// 獲得suggestion
				$res['td'] = $this -> get_suggestions($member_id,$id);
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function check_record() {
		$list = $this -> records_dao -> db -> query("select r.*, m.gender from records r inner join members m on m.id = r.member_id ") -> result();
		foreach($list as $each) {
			$fat_info = get_fat_info($each -> bmi, $each -> body_fat_rate, $each -> gender);
			$this -> records_dao -> update(array(
				'fat_info' => $fat_info
			), $each -> id);
			echo "$fat_info \n";
		}
		echo "count: " . count($list). " \n";
		echo "ok...\n";
	}

	public function get_suggestions($member_id, $id) {
		$m = $this -> dao -> find_by_id($member_id);
		$rec;
		if(empty($id)){
			$rec = $this -> records_dao -> find_by_value(array('member_id' => $member_id));
		}else{
			$rec = $this -> records_dao -> find_by_id($id);
		}

		if($rec -> weight == 0) {
			$rec -> weight = 1;
		}

		// thev body object
		$td = new stdClass; // body 資料

		// new formula
		$bmi = floatval($rec -> bmi * 4 + $rec -> body_fat_rate * 6) / 10.0 * 2.0; // 要相加
		$msg = parse_ini_file("msg.properties", true, INI_SCANNER_RAW);

		// fat info
		$td -> fat_info = new stdClass;

		if($m -> gender == 1) {
			if($bmi<=34.5) {
				$td -> fat_info -> idx_str = $msg["tip.fat1"];
				$td -> fat_info -> bg = "yellow";
				$td -> fat_info -> idx = 0;
				$td -> fat_info -> advise = $msg["tip.fat1v"];
			}
			else if($bmi>34.5 && $bmi<=43) {
				$td -> fat_info -> idx_str = $msg["tip.fat2"];
				$td -> fat_info -> bg = "green";
				$td -> fat_info -> idx = 1;
				$td -> fat_info -> advise = $msg["tip.fat2v"];
			}
			else if($bmi>43 && $bmi<=49) {
				$td -> fat_info -> idx_str = $msg["tip.fat3"];
				$td -> fat_info -> bg = "violet";
				$td -> fat_info -> idx = 2;
				$td -> fat_info -> advise = $msg["tip.fat3v"];
			}
			else if($bmi>49 && $bmi<=58) {
				$td -> fat_info -> idx_str = $msg["tip.fat4"];
				$td -> fat_info -> bg = "purplish";
				$td -> fat_info -> idx = 3;
				$td -> fat_info -> advise = $msg["tip.fat4v"];
			}
			else if($bmi>58 && $bmi<61) {
				$td -> fat_info -> idx_str = $msg["tip.fat5"];
				$td -> fat_info -> bg = "chocolate";
				$td -> fat_info -> idx = 4;
				$td -> fat_info -> advise = $msg["tip.fat5v"];
			}
			else if($bmi>=61){
				$td -> fat_info -> idx_str = $msg["tip.fat6"];
				$td -> fat_info -> bg = "red";
				$td -> fat_info -> idx = 5;
				$td -> fat_info -> advise = $msg["tip.fat6v"];
			}
		}

		if($m -> gender == 0) {
			if($bmi<=36.5) {
				$td -> fat_info -> idx_str = $msg["tip.fat1"];
				$td -> fat_info -> bg = "yellow";
				$td -> fat_info -> idx = 0;
				$td -> fat_info -> advise = $msg["tip.fat1v"];
			}
			else if($bmi>36.5 && $bmi<45) {
				$td -> fat_info -> idx_str = $msg["tip.fat2"];
				$td -> fat_info -> bg = "green";
				$td -> fat_info -> idx = 1;
				$td -> fat_info -> advise = $msg["tip.fat2v"];
			}
			else if($bmi>45 && $bmi<=51) {
				$td -> fat_info -> idx_str = $msg["tip.fat3"];
				$td -> fat_info -> bg = "violet";
				$td -> fat_info -> idx = 2;
				$td -> fat_info -> advise = $msg["tip.fat3v"];
			}
			else if($bmi>51 && $bmi<=59) {
				$td -> fat_info -> idx_str = $msg["tip.fat4"];
				$td -> fat_info -> bg = "purplish";
				$td -> fat_info -> idx = 3;
				$td -> fat_info -> advise = $msg["tip.fat4v"];
			}
			else if($bmi>59 && $bmi<66) {
				$td -> fat_info -> idx_str = $msg["tip.fat5"];
				$td -> fat_info -> bg = "chocolate";
				$td -> fat_info -> idx = 4;
				$td -> fat_info -> advise = $msg["tip.fat5v"];
			}
			else if($bmi>=66){
				$td -> fat_info -> idx_str = $msg["tip.fat6"];
				$td -> fat_info -> bg = "red";
				$td -> fat_info -> idx = 5;
				$td -> fat_info -> advise = $msg["tip.fat6v"];
			}
		}

		$td -> fat_info -> title = $msg["tip.fatlevel"];
		$td -> fat_info -> value = $td -> fat_info -> idx_str;
		$td -> fat_info -> explain = $msg["tip.fatleveln"];
		$td -> fat_info -> level = array("yellow","green","violet","purplish","chocolate","red");
		$td -> fat_info -> level_data = array(
			$msg["tip.fat1"],
			$msg["tip.fat2"],
			$msg["tip.fat3"],
			$msg["tip.fat4"],
			$msg["tip.fat5"],
			$msg["tip.fat6"],
		);

		// weight
		$lowweight = $m -> height * $m -> height * 18.5 / 10000.0;
		$hightweight = $m -> height * $m -> height * 24 / 10000.0;

		$td -> weight = new stdClass;

		if($rec -> bmi < 18) {
			$td -> weight -> idx_str = $msg["tip.low"];
			$td -> weight -> bg = "yellow";
			$td -> weight -> idx = 0;
			$td -> weight -> advise = $msg["tip.weight1"];
		} elseif($rec -> bmi >= 18 && $rec -> bmi <= 24) {
			$td -> weight -> idx_str = $msg["tip.fat2"];
			$td -> weight -> bg = "green";
			$td -> weight -> idx = 1;
			$td -> weight -> advise = $msg["tip.weight2"];
		} else {
			$td -> weight -> idx_str = $msg["tip.hight"];
			$td -> weight -> bg = "red";
			$td -> weight -> idx = 2;
			$td -> weight -> advise = $msg["tip.weight3"];
		}

		$td -> weight -> title = $msg["tip.weight"];
		$td -> weight -> value = number_format($rec->weight/1000, 2) . " kg";
		$td -> weight -> explain = $msg["tip.weightv"];
		$td -> weight -> level = array("yellow","green","red");
		$td -> weight -> level_data = array(
			$msg["tip.low"],
			number_format($lowweight, 2),
			number_format($hightweight, 2),
			$msg["tip.hight"],
		);


		// bodyFatRate, fat
		$td -> body_fat_rate = new stdClass;
		$td -> fat = new stdClass;
		$td -> water = new stdClass;
		$td -> muscle = new stdClass;
		$td -> ske_muscle = new stdClass;

		$wrate = $rec -> moisture_rate / 100.0; // 水
		$mrate = $rec -> muscle_rate / $rec -> weight * 1000; // 肌肉
		$srate = $rec -> skeletal_muscle_rate / 100.0; // 骨骼肌肉

		$fat_0 = 0.16;
		$fat_1 = 0.2;

		$body_fat_rate_0 = 16;
		$body_fat_rate_1 = 20;

		$water_0 = 0.54;
		$water_1 = 0.66;

		$muscle_0 = 4.7;
		$muscle_1 = 6.34;
		$muscle_2 = 5.84;
		$muscle_3 = 7.7;

		$ske_0 = 0.47;
		$ske_1 = 0.57;
		if($m -> gender == 1) {
		}
		if($m -> gender == 0) {
			$fat_0 = 0.18;
			$fat_1 = 0.22;

			$body_fat_rate_0 = 18;
			$body_fat_rate_1 = 22;

			$water_0 = 0.52;
			$water_1 = 0.64;

			$muscle_0 = 3.55;
			$muscle_1 = 6.2;
			$muscle_2 = 4.3;
			$muscle_3 = 7.6;

			$ske_0 = 0.43;
			$ske_1 = 0.53;
		}

		$lowfat = $rec -> weight / 1000 * $fat_0;
		$hightfat = $rec -> weight / 1000 * $fat_1;

		if($rec -> body_fat_rate < $body_fat_rate_0) {
			$td -> body_fat_rate -> idx_str = $msg["tip.low"];
			$td -> body_fat_rate -> bg = "yellow";
			$td -> body_fat_rate -> idx = 0;
			$td -> body_fat_rate -> advise = $msg["tip.weight1"];
		} elseif($rec -> body_fat_rate >= $body_fat_rate_0 && $rec -> body_fat_rate < $body_fat_rate_1) {
			$td -> body_fat_rate -> idx_str = $msg["tip.fat2"];
			$td -> body_fat_rate -> bg = "green";
			$td -> body_fat_rate -> idx = 1;
			$td -> body_fat_rate -> advise = $msg["tip.bdfat1v"];
		} else { // >= 20
			$td -> body_fat_rate -> idx_str = $msg["tip.hight"];
			$td -> body_fat_rate -> bg = "red";
			$td -> body_fat_rate -> idx = 2;
			$td -> body_fat_rate -> advise = $msg["tip.bdfat2v"];
		}

		$td -> body_fat_rate -> title = $msg["tip.bodyfate"];
		$td -> body_fat_rate -> value = number_format($rec->body_fat_rate, 0) . " %";
		$td -> body_fat_rate -> explain = $msg["tip.bdfatv"];
		$td -> body_fat_rate -> level = array("yellow","green","red");
		$td -> body_fat_rate -> level_data = array(
			$msg["tip.low"],
			"$body_fat_rate_0",
			"$body_fat_rate_1",
			$msg["tip.hight"],
		);

		$td -> fat = clone $td -> body_fat_rate; // 複製體脂率
		$td -> fat -> title = $msg["tip.fat"];
		$td -> fat -> value = number_format($rec->body_fat / 100000, 0) . " %";
		$td -> fat -> explain = $msg["tip.fatv"];
		$td -> fat -> level = array("yellow","green","red");
		$td -> fat -> level_data = array(
			$msg["tip.low"],
			number_format($lowfat, 2),
			number_format($hightfat, 2),
			$msg["tip.hight"],
		);

		// water
		if($wrate <= $water_0) {
			$td -> water -> idx_str = $msg["tip.low"];
			$td -> water -> bg = "yellow";
			$td -> water -> idx = 0;
			$td -> water -> advise = $msg["tip.water1v"];
		} elseif($wrate>$water_0 && $wrate<$water_1) {
			$td -> water -> idx_str = $msg["tip.fat2"];
			$td -> water -> bg = "green";
			$td -> water -> idx = 1;
			$td -> water -> advise = $msg["tip.water2v"];
		} else {
			$td -> water -> idx_str = $msg["tip.hight"];
			$td -> water -> bg = "red";
			$td -> water -> idx = 2;
			$td -> water -> advise = $msg["tip.water3v"];
		}
		$lowWater = $rec -> weight / 1000 * $water_0;
		$hightWater = $rec -> weight / 1000 * $water_1;
		$w_weight = $rec -> weight / 1000 * $wrate;
		$td -> water -> title = $msg["tip.water"];
		$td -> water -> value = number_format($w_weight, 2) . " kg";
		$td -> water -> explain = $msg["tip.waterv"];
		$td -> water -> level = array("yellow","green","red");
		$td -> water -> level_data = array(
			$msg["tip.low"],
			number_format($lowWater, 2),
			number_format($hightWater, 2),
			$msg["tip.hight"],
		);

		// muscle
		$mrateLow = $m -> height *  $m -> height / 10000 * ($muscle_0 + ($muscle_1 * $m -> height / 100));
		$mrateHigh = $m -> height *  $m -> height / 10000 * ($muscle_2 + ($muscle_3 * $m -> height / 100));

		$muscle_weight = $rec -> muscle_rate * $rec -> weight / 1000.0 / 100.0;
		if($muscle_weight < $mrateLow) {
			$td -> muscle -> idx_str = $msg["tip.low"];
			$td -> muscle -> bg = "yellow";
			$td -> muscle -> idx = 0;
			$td -> muscle -> advise = $msg["tip.muscle1v"];
		} elseif($muscle_weight >= $mrateLow && $muscle_weight <= $mrateHigh) {
			$td -> muscle -> idx_str = $msg["tip.fat2"];
			$td -> muscle -> bg = "green";
			$td -> muscle -> idx = 1;
			$td -> muscle -> advise = $msg["tip.muscle2v"];
		} else {
			$td -> muscle -> idx_str = $msg["tip.hight"];
			$td -> muscle -> bg = "green";
			$td -> muscle -> idx = 2;
			$td -> muscle -> advise = $msg["tip.muscle3v"];
		}
		$td -> muscle -> title = $msg["tip.muscle"];
		$td -> muscle -> value = number_format($muscle_weight, 2) . " kg";
		$td -> muscle -> explain = $msg["tip.musclev"];
		$td -> muscle -> level = array("yellow","green","green");
		$td -> muscle -> level_data = array(
			$msg["tip.low"],
			number_format($mrateLow, 1),
			number_format($mrateHigh, 1),
			$msg["tip.hight"],
		);


		if($srate <= $ske_0) {
			$td -> ske_muscle -> idx_str = $msg["tip.low"];
			$td -> ske_muscle -> bg = "yellow";
			$td -> ske_muscle -> idx = 0;
			$td -> ske_muscle -> advise = $msg["tip.skeMuscle1v"];
		} elseif($srate > $ske_0 && $srate <= $ske_1) {
			$td -> ske_muscle -> idx_str = $msg["tip.fat2"];
			$td -> ske_muscle -> bg = "green";
			$td -> ske_muscle -> idx = 1;
			$td -> ske_muscle -> advise = $msg["tip.skeMuscle2v"];
		} else {
			$td -> ske_muscle -> idx_str = $msg["tip.hight"];
			$td -> ske_muscle -> bg = "green";
			$td -> ske_muscle -> idx = 2;
			$td -> ske_muscle -> advise = $msg["tip.skeMuscle3v"];
		}

		$ske_low = $rec -> weight / 1000 * $ske_0;
		$ske_high = $rec -> weight / 1000 * $ske_1;

		$td -> ske_muscle -> title = $msg["tip.skeMuscle"];
		$td -> ske_muscle -> value = number_format($rec -> weight / 1000 * $rec->skeletal_muscle_rate / 100.0, 2) . " kg";
		$td -> ske_muscle -> explain = $msg["tip.skeMusclev"];
		$td -> ske_muscle -> level = array("yellow","green","green");
		$td -> ske_muscle -> level_data = array(
			$msg["tip.low"],
			number_format($ske_low, 1),
			number_format($ske_high, 1),
			$msg["tip.hight"],
		);

		// vis_fat 內臟脂肪
		$td -> vis_fat = new stdClass;

		if($rec -> visceral_fat_rate < 10) {
			$td -> vis_fat -> idx_str = $msg["tip.fat2"];
			$td -> vis_fat -> bg = "green";
			$td -> vis_fat -> idx = 0;
			$td -> vis_fat -> advise = $msg["tip.visFat1v"];
		} elseif($rec -> visceral_fat_rate >= 10 && $rec -> visceral_fat_rate <= 14) {
			$td -> vis_fat -> idx_str = $msg["tip.exstand"];
			$td -> vis_fat -> bg = "chocolate";
			$td -> vis_fat -> idx = 1;
			$td -> vis_fat -> advise = $msg["tip.visFat2v"];
		} else {
			$td -> vis_fat -> idx_str = $msg["tip.hight"];
			$td -> vis_fat -> bg = "red";
			$td -> vis_fat -> idx = 2;
			$td -> vis_fat -> advise = $msg["tip.visFat2v"];
		}

		$td -> vis_fat -> title = $msg["tip.visFat"];
		$td -> vis_fat -> value = number_format($rec->visceral_fat_rate, 2);
		$td -> vis_fat -> explain = $msg["tip.visFatv"];
		$td -> vis_fat -> level = array("green","chocolate","red");
		$td -> vis_fat -> level_data = array(
			$msg["tip.low"],
			number_format(10, 0),
			$msg["tip.exstand"],
			number_format(14, 0),
			$msg["tip.hight"],
		);

		// protein 蛋白質
		$td -> protein = new stdClass;

		$pkg = ($rec -> protein_rate * $rec -> weight / 1000.0 / 100.0);
		$prate = ($rec -> protein_rate * $rec -> weight / 1000.0 / 100.0) / $rec -> weight * 1000.0;
		if($prate <= 0.14) {
			$td -> protein -> idx_str = $msg["tip.low"];
			$td -> protein -> bg = "yellow";
			$td -> protein -> idx = 0;
			$td -> protein -> advise = $msg["tip.weight1"];
		} elseif($prate > 0.14 && $prate <= 0.17) {
			$td -> protein -> idx_str = $msg["tip.fat2"];
			$td -> protein -> bg = "green";
			$td -> protein -> idx = 1;
			$td -> protein -> advise = $msg["tip.protein1v"];
		} else {
			$td -> protein -> idx_str = $msg["tip.hight"];
			$td -> protein -> bg = "green";
			$td -> protein -> idx = 2;
			$td -> protein -> advise = $msg["tip.protein2v"];
		}

		$td -> protein -> title = $msg["tip.protein"];
		$td -> protein -> value = number_format($pkg, 2);
		$td -> protein -> explain = $msg["tip.proteinv"];
		$td -> protein -> level = array("yellow","green","green");

		$lowsP = $rec -> weight / 1000 * 0.14;
		$hightsP = $rec -> weight / 1000 * 0.17;
		$td -> protein -> level_data = array(
			$msg["tip.low"],
			number_format($lowsP, 1),
			number_format($hightsP, 1),
			$msg["tip.hight"],
		);

		// bone 蛋白質
		$td -> bone = new stdClass;

		$brate = $rec -> bone_mass_rate / $rec -> weight * 1000.0;
		if($brate <= 0.045) {
			$td -> bone -> idx_str = $msg["tip.low"];
			$td -> bone -> bg = "yellow";
			$td -> bone -> idx = 0;
			$td -> bone -> advise = $msg["tip.bone1v"];
		} elseif($brate > 0.045 && $brate <= 0.055) {
			$td -> bone -> idx_str = $msg["tip.fat2"];
			$td -> bone -> bg = "green";
			$td -> bone -> idx = 1;
			$td -> bone -> advise = $msg["tip.bone2v"];
		} else {
			$td -> bone -> idx_str = $msg["tip.hight"];
			$td -> bone -> bg = "red";
			$td -> bone -> idx = 2;
			$td -> bone -> advise = $msg["tip.bone3v"];
		}

		$td -> bone -> title = $msg["tip.bone"];
		$td -> bone -> value = number_format($rec->bone_mass_rate, 2);
		$td -> bone -> explain = $msg["tip.bonev"];
		$td -> bone -> level = array("yellow","green","red");

		$lowsP = $rec -> weight / 1000 * 0.045;
		$hightsP = $rec -> weight / 1000 * 0.055;
		$td -> bone -> level_data = array(
			$msg["tip.low"],
			number_format($lowsP, 1),
			$msg["tip.fat2"],
			number_format($hightsP, 1),
			$msg["tip.hight"],
		);

		// print_r(array(
		// 	"td" => $td,
		// 	"bmi" => $bmi,
		// ));
		return $td;
	}

	// 秤重所有紀錄
	public function list_all_record(){
		$member_id = $this -> get_post('member_id');
		$date = $this -> get_post('date');
		$id = $this -> get_post('id');

		if(!empty($member_id)){
			$f = array('member_id' => $member_id);
			if(!empty($date)){
				$f['date'] = $date;
			}

			$list = $this -> records_dao -> find_by_parameter($f);

			$res['success'] = TRUE;
			foreach ($list as $each) {
				$weight_kg = $each->weight/1000;
				$body_fat =  $each->weight/1000 * $each->body_fat_rate/100;
				$visceral_fat = $each->weight/1000 * $each->visceral_fat_rate/100;
				$protein = $each->weight/1000 * $each->protein_rate/100;
				$moisture = $each->weight/1000 * $each->moisture_rate/100;
				$muscle = $each->weight/1000 * $each->muscle_rate/100;
				$bone_mass = $each->weight/1000 * $each->bone_mass_rate/100;
				$skeletal_muscle =  $each->weight/1000 * $each->skeletal_muscle_rate/100;

				$each -> weight = number_format($weight_kg,1);
				$each -> body_fat = number_format($body_fat,1);
				$each -> visceral = number_format($visceral_fat,1);
				$each -> protein = number_format($protein,1);
				$each -> moisture = number_format($moisture,1);
				$each -> muscle = number_format($muscle,1);
				$each -> skeletal_muscle = number_format($skeletal_muscle,1);
				$each -> bone_mass = number_format($bone_mass,1);
			}

			$res['list'] = $list;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 秤重所有紀錄
	public function list_record(){
		$member_id = $this -> get_post('member_id');
		$page = $this -> get_post('page');

		if(!empty($member_id)){
			$f = array('member_id' => $member_id);

			$list = $this -> records_dao -> find_by_page($f);

			$res['success'] = TRUE;
			foreach ($list as $each) {
				$weight_kg = $each->weight/1000;
				$body_fat =  $each->weight/1000 * $each->body_fat_rate/100;
				$visceral_fat = $each->weight/1000 * $each->visceral_fat_rate/100;
				$protein = $each->weight/1000 * $each->protein_rate/100;
				$moisture = $each->weight/1000 * $each->moisture_rate/100;
				$muscle = $each->weight/1000 * $each->muscle_rate/100;
				$bone_mass = $each->weight/1000 * $each->bone_mass_rate/100;
				$skeletal_muscle =  $each->weight/1000 * $each->skeletal_muscle_rate/100;

				$each -> weight = number_format($weight_kg,1);
				$each -> body_fat = number_format($body_fat,1);
				$each -> visceral = number_format($visceral_fat,1);
				$each -> protein = number_format($protein,1);
				$each -> moisture = number_format($moisture,1);
				$each -> muscle = number_format($muscle,1);
				$each -> skeletal_muscle = number_format($skeletal_muscle,1);
				$each -> bone_mass = number_format($bone_mass,1);
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
		$is_month = $this -> get_post('is_month');
		$is_week = $this -> get_post('is_week');

		if(!empty($member_id)){
			$f = array('member_id' => $member_id);
			if(!empty($date)){
				$f['date'] = $date;
			}
			if(!empty($is_month)){
				$f['is_month'] = $is_month;
			}

			if(!empty($is_week)){
				$f['is_week'] = $is_week;
			}

			$list = $this -> records_dao -> find_by_date($f);

			$res['success'] = TRUE;
			foreach ($list as $each) {
				$weight_kg = $each->weight/1000;
				$body_fat =  $each->weight/1000 * $each->body_fat_rate/100;
				$visceral_fat = $each->weight/1000 * $each->visceral_fat_rate/100;
				$protein = $each->weight/1000 * $each->protein_rate/100;
				$moisture = $each->weight/1000 * $each->moisture_rate/100;
				$muscle = $each->weight/1000 * $each->muscle_rate/100;
				$bone_mass = $each->weight/1000 * $each->bone_mass_rate/100;
				$skeletal_muscle =  $each->weight/1000 * $each->skeletal_muscle_rate/100;

				$each -> weight = number_format($weight_kg,1);
				$each -> body_fat = number_format($body_fat,1);
				$each -> visceral = number_format($visceral_fat,1);
				$each -> protein = number_format($protein,1);
				$each -> moisture = number_format($moisture,1);
				$each -> muscle = number_format($muscle,1);
				$each -> skeletal_muscle = number_format($skeletal_muscle,1);
				$each -> bone_mass = number_format($bone_mass,1);
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

		if(!empty($member_id) && !empty($ym)) {
			$m = $this -> records_dao -> find_first($member_id);
			if(!empty($m)){
				// $base = $m->weight;

				$list = $this -> records_dao -> find_all_by_ym($member_id, $ym);
				if(!empty($list)){
					$data1 = $list[0];
					$f_data1 = $this -> records_dao -> find_one_data($member_id, $data1->id);
					$base = 0;
					if(!empty($f_data1)){
						$base = number_format($f_data1->weight/1000,1);
					}

					foreach ($list as $each) {
						$compare = number_format($each-> weight/1000,1);
						if($compare > $base){
							$each -> exceed = 1;
						}else if($compare == $base){
							$each -> exceed = 2;
						}else{
							$each -> exceed = 0;
						}
						$base = $compare;
					}
				}

				// $res['f'] = $f_data1;
				$res['list'] = $list;
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
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
			$data = array();
			$m = $this -> dao -> find_by_id($member_id);
			// $res['member'] = $m;

			// $list1 = $this -> records_dao -> find_by_date($f);
			// $res['days'] = count($list1);

			$data1 = NULL;
			$data2 = NULL;
			$weight_kg = 0;
			$body_diff = 0;

			if(empty($type)){
				$data1 = $this -> records_dao -> find_newest_weight($f);
				$f['new'] = true;
				$data2 = $this -> records_dao -> find_newest_weight($f);
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
				$weight_diff = number_format($data2->weight/1000,1) - number_format($data1->weight/1000,1);
				$body_fat_d1 = $data1->weight/1000 * $data1->body_fat_rate/100;
				$body_fat_d2 = $data2->weight/1000 * $data2->body_fat_rate/100;
				$body_diff = number_format($body_fat_d2,1)- number_format($body_fat_d1,1);
			}else if($data1 == NULL && $data2 == NULL){

			}else if($data1 == NULL){
				$weight_diff = number_format($data2->weight/1000,1);
				$body_fat_d1 = 0;
				$body_fat_d2 = $data2->weight/1000 * $data2->body_fat_rate/100;
				$body_diff = number_format($body_fat_d2,1)- number_format($body_fat_d1,1);
			}else if($data2 == NULL){
				$weight_diff = 0 - number_format($data1->weight/1000,1);
				$body_fat_d1 = $data1->weight/1000 * $data1->body_fat_rate/100;
				$body_fat_d2 = 0;
				$body_diff = number_format($body_fat_d2,1)- number_format($body_fat_d1,1);
			}

			// $res['weight_diff'] = number_format($weight_kg,1);
			// $res['body_fat_diff'] = number_format($body_diff,1);

			if(!empty($data1)){
				$weight_kg = $data1->weight/1000;
				$body_fat = $data1->weight/1000 * $data1->body_fat_rate/100;
				$visceral_fat = $data1->weight/1000 * $data1->visceral_fat_rate/100;
				$protein = $data1->weight/1000 * $data1->protein_rate/100;
				$moisture = $data1->weight/1000 * $data1->moisture_rate/100;
				$muscle = $data1->weight/1000 * $data1->muscle_rate/100;
				$bone_mass = $data1->weight/1000 * $data1->bone_mass_rate/100;
				$skeletal_muscle =  $data1->weight/1000 * $data1->skeletal_muscle_rate/100;

				$data1 -> weight = number_format($weight_kg,1);
				$data1 -> body_fat = number_format($body_fat,1);
				$data1 -> visceral_fat = number_format($visceral_fat,1);
				$data1 -> protein = number_format($protein,1);
				$data1 -> moisture = number_format($moisture,1);
				$data1 -> muscle = number_format($muscle,1);
				$data1 -> bone_mass = number_format($bone_mass,1);
				$data1 -> skeletal_muscle = number_format($skeletal_muscle,1);
			}

			if(!empty($data2)){
				$weight_kg = $data2->weight/1000;
				$body_fat = $data2->weight/1000 * $data2->body_fat_rate/100;
				$visceral_fat = $data2->weight/1000 * $data2->visceral_fat_rate/100;
				$protein = $data2->weight/1000 * $data2->protein_rate/100;
				$moisture = $data2->weight/1000 * $data2->moisture_rate/100;
				$muscle = $data2->weight/1000 * $data2->muscle_rate/100;
				$bone_mass = $data2->weight/1000 * $data2->bone_mass_rate/100;
				$skeletal_muscle =  $data2->weight/1000 * $data2->skeletal_muscle_rate/100;

				$data2 -> weight = number_format($weight_kg,1);
				$data2 -> body_fat = number_format($body_fat,1);
				$data2 -> visceral_fat = number_format($visceral_fat,1);
				$data2 -> protein = number_format($protein,1);
				$data2 -> moisture = number_format($moisture,1);
				$data2 -> muscle = number_format($muscle,1);
				$data2 -> skeletal_muscle = number_format($skeletal_muscle,1);
				$data2 -> bone_mass = number_format($bone_mass,1);
			}

			$diff = abs(strtotime($data2->create_date) - strtotime($data1->create_date));
			$day = floor($diff / (60*60*24));
			// $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

			$data['days'] = $day;
			if($weight_diff > 0){
				$data['weight_diff'] = '+'.number_format($weight_diff,1);
			}else{
				$data['weight_diff'] = number_format($weight_diff,1);
			}
			if($body_diff > 0){
				$data['body_fat_diff'] = '+'.number_format($body_diff,1);
			}else{
				$data['body_fat_diff'] = number_format($body_diff,1);
			}
			$data['member'] = $m;

			if(!empty($data1)){
				$data['data1'] = $data1;
				// $res['data1_id'] = $data1->id;
				$data['td1'] = $this -> get_suggestions($member_id,$data1->id);
				$ketone1 = $this -> ketone_record_dao -> find_by_date(array('member_id' => $member_id,'date'=> $data1->create_date));
				if(!empty($ketone1)){
					$data['kt1'] = $ketone1;
				}
			}

			if(!empty($data2)){
				$data['data2'] = $data2;
				$data['td2'] = $this -> get_suggestions($member_id,$data2->id);
				$ketone2 = $this -> ketone_record_dao -> find_by_date(array('member_id' => $member_id,'date'=> $data2->create_date));
				if(!empty($ketone2)){
					$data['kt2'] = $ketone2;
				}
			}

			$res['data'] = $data;
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

	public function list_disease(){
		$f = array();
		$list = $this -> disease_dao -> find_by_parameter($f);

		$res['success'] = TRUE;
		$res['list'] = $list;

		$this -> to_json($res);
	}

	// 會員食譜紀錄
	public function load_member_disease(){
		$member_id = $this -> get_post('member_id');

		if(!empty($member_id)) {
			$m = $this -> members_disease_dao -> find_by_parameter(array('member_id' => $member_id));
			if(!empty($m)){
				$list = $this -> members_disease_detail_dao -> find_by_parameter(array('member_disease_id' => $m->id));
				$m->detail = $list;
				$receipes = $this -> recipes_dao -> find_by_parameter(array('level' => $m->level));
				$m->receipe = $receipes;
			}
			$res['success'] = TRUE;
			if(!empty($m)){
				$res['data'] = $m;
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 會員疾病記錄
	public function add_member_disease_record(){
		$member_id = $this -> get_post('member_id');
		$reply_list  = $this -> get_post('reply_list');

		if(!empty($member_id) && !empty($reply_list)) {
			$f = array('member_id' => $member_id);
			$m = $this -> dao -> find_by_id($member_id);
			if(!empty($m)){

				$m = $this -> members_disease_dao -> find_by_parameter(array('member_id' => $member_id));
				$disease_id;
				if(empty($m)){
					$disease_id  = $this -> members_disease_dao -> insert(array('member_id' => $member_id));
				}else{
					$disease_id = $m ->id;
				}
				$this -> members_disease_detail_dao -> delete_by_id($disease_id);
				$reply_arr = json_decode($reply_list,true);
				$level1_count = 0;
				$level2_count = 0;
				$level3_count = 0;
				foreach($reply_arr as $each){
					if($each['level']=='1'){
						$level1_count++;
					}
					if($each['level']=='2'){
						$level2_count++;
					}
					if($each['level']=='3'){
						$level3_count++;
					}
					$insert_data = array('member_disease_id' => $disease_id,'disease_id'=> $each['disease_id']);
					$id = $this -> members_disease_detail_dao -> insert($insert_data);
				}
				$res['success'] = TRUE;
				if($level1_count == 0){
					if($level2_count == 0){
						$this -> members_disease_dao -> update(array('level' => 3),$disease_id);
					}else{
						$this -> members_disease_dao -> update(array('level' => 2),$disease_id);
					}
				}else{
					$this -> members_disease_dao -> update(array('level' => 1),$disease_id);
				}
			}else{
				$res['error_code'][] = "account_not_found";
				$res['error_message'][] = "無此使用者";
			}
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}

		$this -> to_json($res);
	}








}
?>
