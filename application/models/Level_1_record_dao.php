<?php
class Level_1_record_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('level_1_record');

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

		$this -> db -> where('_m.type',$f['type']);

		if(!empty($f['sn'])){
			$this -> db -> where('_m.sn',$f['sn']);
		}

		$this -> db -> order_by("sn", "desc");

		$startTime = date('Y-m-d 00:00:00');
		$endTime = date('Y-m-d 23:59:59');
		$this -> db -> where('_m.create_time >', $startTime);
		$this -> db -> where('_m.create_time <=', $endTime);

		$query = $this -> db -> get();
		$list = $query -> result();

		// if ($query -> num_rows() > 0) {
		// 	$row = $query -> row();
		// 	return $row;
		// }
		return $list;
	}

	function count_by_value($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if($f['member_id']){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		if($f['date']){
			$this -> db -> where('_m.create_time<>',$f['date']);
		}

		$query = $this -> db -> get();
		$list = $query -> result();

		return count($list);
	}

	function find_use_by_record($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.score, _m.create_time');

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

		$this -> db -> where('_m.sn', 1);
		$this -> db -> where('_m.type',$f['type']);

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function query_ajax($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('m.user_name as user_name');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('id', 'desc');

		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();

		// echo $this -> db -> last_query();
		return $query -> result();
	}

	function export_all() {

	}

	function search_always($data) {
		$dt = $data['dt'];
		$e_dt = $data['e_dt'];
		$user_name = $data['user_name'];

		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		if(strlen($user_name)>0){
			$this -> db -> where("m.user_name like'{$user_name}'");
		}

	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("members as m", 'm.id = _m.member_id', "left");
	}

	function find_all_case_0($data){
		$dt = $data['dt'];
		$e_dt = $data['e_dt'];
		$member_id = $data['member_id'];
		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select("DATE(_m.create_time) as date");

		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		$this -> db -> where('_m.member_id',$member_id);
		$this -> db -> where('_m.sn',1);
		$this -> db -> where('_m.type',0);

		$this -> db -> order_by("_m.create_time","asc");

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_case_1($data){
		$dt = $data['dt'];
		$e_dt = $data['e_dt'];
		$member_id = $data['member_id'];
		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select("DATE(_m.create_time) as date");

		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		$this -> db -> where('_m.member_id',$member_id);
		$this -> db -> where('_m.sn',1);
		$this -> db -> where('_m.type',1);

		$this -> db -> order_by("_m.create_time","asc");

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_type_0($data){
		$this -> load -> model('Level_1_record_dao', 'level_1_record_dao');

		$dt = $data['dt'];
		$e_dt = $data['e_dt'];

		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select("sum(_m.score) as score1");
		$this -> db -> select("DATE(_m.create_time) as date1");
		$this -> db -> where('_m.sn',	1);
		$this -> db -> where('_m.type',0);
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
				$count_type_0 = $this -> level_1_record_dao -> find_all_case111($each->date1,0);

				if($count_type_0>0){
					$each -> type_0 = intval($each -> score1)/intval($count_type_0);
				} else{
					$each -> type_0 = 0;
				}
				$each -> date = date('m-d',strtotime($each -> date1));
			}
		}

    return $list;
	}

	function find_all_type_1($data){
		$this -> load -> model('Level_1_record_dao', 'level_1_record_dao');

		$dt = $data['dt'];
		$e_dt = $data['e_dt'];

		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select("sum(_m.score) as score1");
		$this -> db -> select("DATE(_m.create_time) as date1");
		$this -> db -> where('_m.sn',	1);
		$this -> db -> where('_m.type',1);
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
				$count_type_1 = $this -> level_1_record_dao -> find_all_case111($each->date1,1);

				if($count_type_1>0){
					$each -> type_1 = intval($each -> score1)/intval($count_type_1);
				} else{
					$each -> type_1 = 0;
				}
				$each -> date = date('m-d',strtotime($each -> date1));
			}
		}

    return $list;
	}

	function find_all_case111($date,$name){

		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.create_time like '{$date} %'");
		if($name ==0){
			$this -> db -> where('_m.sn',	1);
			$this -> db -> where('_m.type',0);
		}
		if($name ==1){
			$this -> db -> where('_m.sn',	1);
			$this -> db -> where('_m.type',1);
		}
		$list = $this -> db -> get() -> result();
		$count= count($list);
		return $count;
	}

	function find_mid_date_type1212($data,$name){

		$dt = $data['dt'];
		$e_dt = $data['e_dt'];
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select("DATE(_m.create_time) as date1");
		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		if($name ==0){
			$this -> db -> where('_m.sn',	1);
			$this -> db -> where('_m.type',0);
		}
		if($name ==1){
			$this -> db -> where('_m.sn',	1);
			$this -> db -> where('_m.type',1);
		}
		$this -> db -> order_by("_m.create_time","asc");
		$this -> db -> group_by("DATE(_m.create_time)");

		$list = $this -> db -> get() -> result();
		return $list;

	}

	function find_mid_by_date($date,$data,$name){

		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select("_m.score as score1");
		if($name ==0){
			$this -> db -> where('_m.sn',	1);
			$this -> db -> where('_m.type',0);
		}
		if($name ==1){
			$this -> db -> where('_m.sn',	1);
			$this -> db -> where('_m.type',1);
		}
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
		$score = array();

		foreach ($list as $each) {
			if(isset($each->score1)){
				$score[] = $each->score1;
			}
		}
		$count_score = count($score);
		if($count_score>=2){
			sort($score);
			if($count_score%2==0){
				$mid_score[] = ($score[$count_score/2-1]+$score[$count_score/2+1-1])/2;
			} else{
				$mid_score[] = $score[($count_score-1)/2];
			}
		} else{
			$mid_score[] = $score;
		}
		$mid = array();
		$mid['mid_score'] = $mid_score;
		return $mid;
	}

	function find_s_d_by_date($date,$data,$name){

		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select("_m.score as score1");
		if($name ==0){
			$this -> db -> where('_m.sn',	1);
			$this -> db -> where('_m.type',0);
		}
		if($name ==1){
			$this -> db -> where('_m.sn',	1);
			$this -> db -> where('_m.type',1);
		}
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
		$score = array();

		foreach ($list as $each) {
			if(isset($each->score1)){
				$score[] = $each->score1;
			}
		}
		$count_score = count($score);
		if($count_score>1){
			$s_d_score = $this -> d_r_index_dao ->stats_standard_deviation($score,true);

		} else{
			$s_d_score =false;
		}
		$s_d= array();
		if($s_d_score ==false){
			$s_d['s_d_score'] = '';
		} else{
			$s_d['s_d_score'] = $s_d_score;
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
