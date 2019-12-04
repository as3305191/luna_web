<?php
class Daily_record_index_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('daily_record_index');

		$this -> alias_map = array(

		);

	}

	// // join
	// function ajax_from_join() {
	// 	$this -> db -> from("$this->table_name as _m");
	// 	$this -> db -> join("orders o", "o.id = _m.order_id", "left");
	//
	// }

	function find_by_value($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$startTime = date('Y-m-d 00:00:00');
		$endTime = date('Y-m-d 23:59:59');
		$this -> db -> where('_m.create_time >=', $startTime);
		$this -> db -> where('_m.create_time <=', $endTime);

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;

	}

	function find_use_by_record($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.diastolic_blood_pressure, _m.systolic_blood_pressure, _m.heart_beat, _m.weight, _m.drinking, _m.walking_steps,_m.create_time');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		if(!empty($f['start_date'])){
			$startDate = $f['start_date'];
			$this -> db -> where('_m.create_time>=',"$startDate 00:00:00");
		}

		if(!empty($f['end_date'])){
			$endDate = $f['end_date'];
			$this -> db -> where('_m.create_time<=',"$endDate 23:59:59");
		}

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_min($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select_min($f['type']);

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		if(!empty($f['start_date'])){
			$startDate = $f['start_date'];
			$this -> db -> where('_m.create_time>=',"$startDate 00:00:00");
		}

		if(!empty($f['end_date'])){
			$endDate = $f['end_date'];
			$this -> db -> where('_m.create_time<=',"$endDate 23:59:59");
		}

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
	}

	function find_max($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select_max($f['type']);

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		if(!empty($f['start_date'])){
			$startDate = $f['start_date'];
			$this -> db -> where('_m.create_time>=',"$startDate 00:00:00");
		}

		if(!empty($f['end_date'])){
			$endDate = $f['end_date'];
			$this -> db -> where('_m.create_time<=',"$endDate 23:59:59");
		}

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
	}

	function find_all_case($data){
		$dt = $data['dt'];
		$e_dt = $data['e_dt'];
		$member_id = $data['member_id'];
		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select('_m.*');
		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		$this -> db -> where('_m.member_id',$member_id);
		$this -> db -> order_by("_m.create_time","asc");

		$list = $this -> db -> get() -> result();
    return $list;
	}

	function find_all_case1($date,$name){

		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.create_time like '{$date} %'");
		if($name==1){
			$this -> db -> where("_m.diastolic_blood_pressure >0");
		}
		if($name==2){
			$this -> db -> where("_m.systolic_blood_pressure >0");
		}
		if($name==3){
			$this -> db -> where("_m.heart_beat >0");
		}
		if($name==4){
			$this -> db -> where("_m.weight >0");
		}
		if($name==5){
			$this -> db -> where("_m.walking_steps >0");
		}
		if($name==6){
			$this -> db -> where("_m.drinking >0");
		}

		$list = $this -> db -> get() -> result();
		$count= count($list);
		return $count;
	}

	function find_all_case_all($data){
		$this -> load -> model('Daily_record_index_dao', 'd_r_index_dao');

		$dt = $data['dt'];
		$e_dt = $data['e_dt'];

		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select("sum(_m.diastolic_blood_pressure) as diastolic_blood_pressure1");
		$this -> db -> select("sum(_m.systolic_blood_pressure) as systolic_blood_pressure1");

		$this -> db -> select("sum(_m.heart_beat) as heart_beat1");
		$this -> db -> select("sum(_m.weight) as weight1");
		$this -> db -> select("sum(_m.walking_steps) as walking_steps1");
		$this -> db -> select("sum(_m.drinking) as drinking1");
		$this -> db -> select("DATE(_m.create_time) as date1");
		$this -> db -> join("members mm", "mm.id = _m.member_id", "left");

		if($data['doctor']> -1){
			$doctor = $data['doctor'];
			$this -> db -> where('mm.user_doctor_id',$doctor);
		}
		if($data['manager']> -1){
			$manager= $data['manager'];
			$this -> db -> where('mm.user_manager_id',$manager);
		}
		if($data['hospital']> -1){
			$hospital = $data['hospital'];
			$this -> db -> where('mm.hospital_id',$hospital);
		}

		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		$this -> db -> group_by("DATE(_m.create_time)");
		$this -> db -> order_by("_m.create_time","asc");

		$list = $this -> db -> get() -> result();
		if(count($list)>0){
			foreach($list as $each){
				$count_diastolic = $this -> d_r_index_dao -> find_all_case1($each->date1,1);
				$count_systolic = $this -> d_r_index_dao -> find_all_case1($each->date1,2);
				$count_heart_beat = $this -> d_r_index_dao -> find_all_case1($each->date1,3);
				$count_weight = $this -> d_r_index_dao -> find_all_case1($each->date1,4);
				$count_walking_steps = $this -> d_r_index_dao -> find_all_case1($each->date1,5);
				$count_drinking = $this -> d_r_index_dao -> find_all_case1($each->date1,6);
				if($count_diastolic>0){
					$each -> diastolic_blood_pressure = intval($each -> diastolic_blood_pressure1)/intval($count_diastolic);
				} else{
					$each -> diastolic_blood_pressure = 0;
				}
				if($count_systolic>0){
					$each -> systolic_blood_pressure = intval($each -> systolic_blood_pressure1)/intval($count_systolic);
				} else{
					$each -> systolic_blood_pressure = 0;
				}
				if($count_heart_beat>0){
					$each -> heart_beat = intval($each -> heart_beat1)/intval($count_heart_beat);
				} else{
					$each -> heart_beat = 0;
				}
				if($count_weight>0){
					$each -> weight = intval($each -> weight1)/intval($count_weight);
				} else{
					$each -> weight = 0;
				}
				if($count_walking_steps >0){
					$each -> walking_steps = intval($each -> walking_steps1)/intval($count_walking_steps);
				} else{
					$each -> walking_steps = 0;
				}
				if($count_drinking >0){
					$each -> drinking = intval($each -> drinking1)/intval($count_drinking);
				} else{
					$each -> drinking = 0;
				}
				$each -> date = date('m-d',strtotime($each -> date1));

			}
		}

    return $list;
	}

	function find_all_for_mid($data){

		$dt = $data['dt'];
		$e_dt = $data['e_dt'];
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select("DATE(_m.create_time) as date1");
		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		$this -> db -> order_by("_m.create_time","asc");
		$this -> db -> group_by("DATE(_m.create_time)");

		$list = $this -> db -> get() -> result();
		return $list;

	}

	function find_all_mid_by_date($date,$data){

		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select("_m.diastolic_blood_pressure as diastolic_blood_pressure1");
		$this -> db -> select("_m.systolic_blood_pressure as systolic_blood_pressure1");
		$this -> db -> select("_m.heart_beat as heart_beat1");
		$this -> db -> select("_m.weight as weight1");
		$this -> db -> select("_m.walking_steps as walking_steps1");
		$this -> db -> select("_m.drinking as drinking1");
		$this -> db -> select("DATE(_m.create_time) as date1");
		$this -> db -> where("_m.create_time like '{$date} %'");
		$this -> db -> join("members mm", "mm.id = _m.member_id", "left");

		if($data['doctor']> -1){
			$doctor = $data['doctor'];
			$this -> db -> where('mm.user_doctor_id',$doctor);
		}
		if($data['manager']> -1){
			$manager= $data['manager'];
			$this -> db -> where('mm.user_manager_id',$manager);
		}
		if($data['hospital']> -1){
			$hospital = $data['hospital'];
			$this -> db -> where('mm.hospital_id',$hospital);
		}
		$list = $this -> db -> get() -> result();
		$diastolic= array();
		$systolic= array();
		$heart_beat= array();
		$weight= array();
		$walking_steps= array();
		$drinking= array();
		foreach ($list as $each) {

			if($each->diastolic_blood_pressure1>0){

				$diastolic[] = $each->diastolic_blood_pressure1;
			}
			if($each->systolic_blood_pressure1>0){
				$systolic[] = $each->systolic_blood_pressure1;
			}
			if($each->heart_beat1>0){
				$heart_beat[] = $each->heart_beat1;
			}
			if($each->weight1>0){
				$weight[] = $each->weight1;
			}
			if(isset($each->walking_steps1)){
				$walking_steps[] = $each->walking_steps1;
			}
			if($each->drinking1>0){
				$drinking[] = $each->drinking1;
			}
		}

		$count_diastolic = count($diastolic);
		$count_systolic = count($systolic);
		$count_heart_beat = count($heart_beat);
		$count_weight = count($weight);
		$count_walking_steps = count($walking_steps);
		$count_drinking = count($drinking);
		if($count_diastolic>=2){
			sort($diastolic);
			if($count_diastolic%2==0){
				$mid_diastolic[] = ($diastolic[$count_diastolic/2-1]+$diastolic[$count_diastolic/2+1-1])/2;
			} else{
				$mid_diastolic[] = $diastolic[($count_diastolic-1)/2];
			}
		} else{
			$mid_diastolic[] = $diastolic;
		}

		if($count_systolic>=2){
			sort($systolic);

			if($count_systolic%2==0){
				$mid_systolic[] = ($systolic[$count_systolic/2-1]+$systolic[$count_systolic/2+1-1])/2;
			} else{
				$mid_systolic[] = $systolic[($count_systolic-1)/2];
			}
		}else{
			$mid_systolic[] = $systolic;
		}

		if($count_heart_beat>=2){
			sort($heart_beat);

			if($count_heart_beat%2==0){
				$mid_heart_beat[] = ($heart_beat[$count_heart_beat/2-1]+$heart_beat[$count_heart_beat/2+1-1])/2;
			} else{
				$mid_heart_beat[] = $heart_beat[($count_heart_beat-1)/2];
			}
		} else{
			$mid_heart_beat[] = $heart_beat;

		}

		if($count_weight>=2){
			sort($weight);

			if($count_weight%2==0){
				$mid_weight[] = ($weight[$count_weight/2-1]+$weight[$count_weight/2+1-1])/2;
			} else{
				$mid_weight[] = $weight[($count_weight-1)/2];
			}
		} else{
			$mid_weight[] = $weight;
		}

		if($count_walking_steps>=2){
			sort($walking_steps);

			if($count_walking_steps%2==0){
				$mid_walking_steps[] = ($walking_steps[$count_walking_steps/2-1]+$walking_steps[$count_walking_steps/2+1-1])/2;
			} else{
				$mid_walking_steps[] = $walking_steps[($count_walking_steps-1)/2];
			}
		} else{
			$mid_walking_steps[] = $walking_steps;
		}

		if($count_drinking>=2){
			sort($drinking);
			if($count_drinking%2==0){
				$mid_drinking[] = ($drinking[$count_drinking/2-1]+$drinking[$count_drinking/2+1-1])/2;
			} else{
				$mid_drinking[] = $drinking[($count_drinking-1)/2];
			}
		} else{
			$mid_drinking[] = $drinking;
		}
		$mid = array();
		$mid['mid_diastolic'] = $mid_diastolic;
		$mid['mid_systolic'] = $mid_systolic;
		$mid['mid_heart_beat'] = $mid_heart_beat;
		$mid['mid_weight'] = $mid_weight;
		$mid['mid_walking_steps'] = $mid_walking_steps;
		$mid['mid_drinking'] = $mid_drinking;
		return $mid;
	}

	function find_s_d_by_date($date,$data){
		$this -> load -> model('Daily_record_index_dao', 'd_r_index_dao');

		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select("_m.diastolic_blood_pressure as diastolic_blood_pressure1");
		$this -> db -> select("_m.systolic_blood_pressure as systolic_blood_pressure1");
		$this -> db -> select("_m.heart_beat as heart_beat1");
		$this -> db -> select("_m.weight as weight1");
		$this -> db -> select("_m.walking_steps as walking_steps1");
		$this -> db -> select("_m.drinking as drinking1");
		$this -> db -> select("DATE(_m.create_time) as date1");
		$this -> db -> where("_m.create_time like '{$date} %'");
		$this -> db -> join("members mm", "mm.id = _m.member_id", "left");

		if($data['doctor']> -1){
			$doctor = $data['doctor'];
			$this -> db -> where('mm.user_doctor_id',$doctor);
		}
		if($data['manager']> -1){
			$manager= $data['manager'];
			$this -> db -> where('mm.user_manager_id',$manager);
		}
		if($data['hospital']> -1){
			$hospital = $data['hospital'];
			$this -> db -> where('mm.hospital_id',$hospital);
		}
		$list = $this -> db -> get() -> result();
		$diastolic= array();
		$systolic= array();
		$heart_beat= array();
		$weight= array();
		$walking_steps= array();
		$drinking= array();
		foreach ($list as $each) {

			if($each->diastolic_blood_pressure1>0){

				$diastolic[] = $each->diastolic_blood_pressure1;
			}
			if($each->systolic_blood_pressure1>0){
				$systolic[] = $each->systolic_blood_pressure1;
			}
			if($each->heart_beat1>0){
				$heart_beat[] = $each->heart_beat1;
			}
			if($each->weight1>0){
				$weight[] = $each->weight1;
			}
			if(isset($each->walking_steps1)){
				$walking_steps[] = $each->walking_steps1;
			}
			if($each->drinking1>0){
				$drinking[] = $each->drinking1;
			}
		}
		$count_diastolic = count($diastolic);
		$count_systolic = count($systolic);
		$count_heart_beat = count($heart_beat);
		$count_weight = count($weight);
		$count_walking_steps = count($walking_steps);
		$count_drinking = count($drinking);
		if($count_diastolic>1){
			$s_d_diastolic = $this -> d_r_index_dao ->stats_standard_deviation($diastolic,true);
		} else{
			$s_d_diastolic =false;
		}
		if($count_systolic>1){
			$s_d_systolic = $this -> d_r_index_dao ->stats_standard_deviation($systolic,true);
		}else{
			$s_d_systolic =false;
		}
		if($count_heart_beat>1){
			$s_d_heart_beat = $this -> d_r_index_dao ->stats_standard_deviation($heart_beat,true);
		}else{
			$s_d_heart_beat =false;
		}
		if($count_weight>1){
			$s_d_weight = $this -> d_r_index_dao ->stats_standard_deviation($weight,true);
		}else{
			$s_d_weight =false;
		}
		if($count_walking_steps>1){
			$s_d_walking_steps = $this -> d_r_index_dao ->stats_standard_deviation($walking_steps,true);
		}else{
			$s_d_walking_steps =false;
		}
		if($count_drinking>1){
			$s_d_drinking = $this -> d_r_index_dao ->stats_standard_deviation($drinking,true);
		}else{
			$s_d_drinking =false;
		}

		$s_d= array();
		if($s_d_diastolic ==false){
			$s_d['s_d_diastolic'] = '';
		} else{
			$s_d['s_d_diastolic'] = $s_d_diastolic;
		}
		if($s_d_systolic ==false){
			$s_d['s_d_systolic'] = '';
		} else{
			$s_d['s_d_systolic'] = $s_d_systolic;
		}
		if($s_d_heart_beat ==false){
			$s_d['s_d_heart_beat'] = '';
		} else{
			$s_d['s_d_heart_beat'] = $s_d_heart_beat;
		}
		if($s_d_weight ==false){
			$s_d['s_d_weight'] = '';
		} else{
			$s_d['s_d_weight'] = $s_d_weight;
		}
		if($s_d_walking_steps ==false){
			$s_d['s_d_walking_steps'] = '';
		} else{
			$s_d['s_d_walking_steps'] = $s_d_walking_steps;
		}
		if($s_d_drinking ==false){
			$s_d['s_d_drinking'] = '';
		} else{
			$s_d['s_d_drinking'] = $s_d_drinking;
		}
		return $s_d;
	}

	function stats_standard_deviation(array $a, $sample = false) {//標準差公式
				 $n = count($a);
				 if ($n === 0) {
						 trigger_error("The array has zero elements", E_USER_WARNING);
						 return false;
				 }
				 if ($sample && $n === 1) {
						 trigger_error("The array has only 1 element", E_USER_WARNING);
						 return false;
				 }
				 $mean = array_sum($a) / $n;
				 $carry = 0.0;
				 foreach ($a as $val) {
						 $d = ((double) $val) - $mean;
						 $carry += $d * $d;
				 };
				 if ($sample) {
						--$n;
				 }
				 return sqrt($carry / $n);
		 }

}
?>
