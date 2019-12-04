<?php
class Daily_record_question_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('daily_record_question');

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
		$this -> db -> where('_m.create_time >', $startTime);
		$this -> db -> where('_m.create_time <=', $endTime);

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
	}

	function query_ajax($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];
		if(!empty($data['dt'])&&!empty($data['e_dt'])){
			$dt = $data['dt'];
			$e_dt = $data['e_dt'];
		}

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('m.user_name');
		if(!empty($dt)&&!empty($e_dt)){
			$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		}


		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('id', 'asc');

		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function search_always($data) {

	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("members m", " m.id = _m.member_id", "left");

	}

	function find_all_question_g($data){
		$dt = $data['dt'];
		$e_dt = $data['e_dt'];
		$member_id = $data['member_id'];
		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select("DATE(_m.create_time) as date");

		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		$this -> db -> where('_m.member_id',$member_id);

		$this -> db -> order_by("_m.create_time","asc");

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_question_group($data){
		$this -> load -> model('Daily_record_question_dao', 'daily_r_q_dao');

		$dt = $data['dt'];
		$e_dt = $data['e_dt'];

		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select("sum(_m.group1) as group11");
		$this -> db -> select("sum(_m.group2) as group22");
		$this -> db -> select("sum(_m.group3) as group33");

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
				$count_group11 = $this -> daily_r_q_dao -> find_all_case111($each->date1,1);
				$count_group22 = $this -> daily_r_q_dao -> find_all_case111($each->date1,2);
				$count_group33 = $this -> daily_r_q_dao -> find_all_case111($each->date1,3);

				if($count_group11>0){
					$each -> group1 = intval($each -> group11)/intval($count_group11);
				} else{
					$each -> group1 = 0;
				}
				if($count_group22>0){
					$each -> group2 = intval($each -> group22)/intval($count_group22);
				} else{
					$each -> group2 = 0;
				}
				if($count_group33>0){
					$each -> group3 = intval($each -> group33)/intval($count_group33);
				} else{
					$each -> group3 = 0;
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
		if($name ==1){
			$this -> db -> where('_m.group1>0');
		}
		if($name ==2){
			$this -> db -> where('_m.group2>0');
		}
		if($name ==3){
			$this -> db -> where('_m.group3>0');
		}

		$list = $this -> db -> get() -> result();
		$count= count($list);
		return $count;
	}

	function find_all_question_date($data){

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

	function find_mid_by_date($date,$data){

		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select("_m.group1 as group11");
		$this -> db -> select("_m.group2 as group22");
		$this -> db -> select("_m.group3 as group33");

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
		$group1= array();
		$group2= array();
		$group3= array();

		foreach ($list as $each) {

			if($each->group11>0){

				$group1[] = $each->group11;
			}
			if($each->group22>0){
				$group2[] = $each->group22;
			}
			if($each->group33>0){
				$group3[] = $each->group22;
			}

		}

		$count_group1 = count($group1);
		$count_group2 = count($group2);
		$count_group3 = count($group3);

		if($count_group1>=2){
			sort($group1);
			if($count_group1%2==0){
				$mid_group1[] = ($group1[$count_group1/2-1]+$group1[$count_group1/2+1-1])/2;
			} else{
				$mid_group1[] = $group1[($count_group1-1)/2];
			}
		} else{
			$mid_group1[] = $group1;
		}

		if($count_group2>=2){
			sort($group2);
			if($count_group2%2==0){
				$mid_group2[] = ($group2[$count_group2/2-1]+$group2[$count_group2/2+1-1])/2;
			} else{
				$mid_group2[] = $group2[($count_group2-1)/2];
			}
		} else{
			$mid_group2[] = $group2;
		}

		if($count_group3>=2){
			sort($group3);
			if($count_group3%2==0){
				$mid_group3[] = ($group3[$count_group3/2-1]+$group3[$count_group3/2+1-1])/2;
			} else{
				$mid_group3[] = $group3[($count_group3-1)/2];
			}
		} else{
			$mid_group3[] = $group3;
		}

		$mid = array();
		$mid['mid_group1'] = $mid_group1;
		$mid['mid_group2'] = $mid_group2;
		$mid['mid_group3'] = $mid_group3;

		return $mid;
	}

	function find_s_d_by_date($date,$data){

		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select("_m.group1 as group11");
		$this -> db -> select("_m.group2 as group22");
		$this -> db -> select("_m.group3 as group33");

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
		$group1= array();
		$group2= array();
		$group3= array();

		foreach ($list as $each) {

			if($each->group11>0){

				$group1[] = $each->group11;
			}
			if($each->group22>0){
				$group2[] = $each->group22;
			}
			if($each->group33>0){
				$group3[] = $each->group22;
			}

		}

		$count_group1 = count($group1);
		$count_group2 = count($group2);
		$count_group3 = count($group3);

		if($count_group1>1){
			$s_d_group1 = $this -> d_r_index_dao ->stats_standard_deviation($group1,true);
		} else{
			$s_d_group1 =false;
		}

		if($count_group2>1){
			$s_d_group2 = $this -> d_r_index_dao ->stats_standard_deviation($group2,true);
		} else{
			$s_d_group2 =false;
		}

		if($count_group3>1){
			$s_d_group3 = $this -> d_r_index_dao ->stats_standard_deviation($group3,true);
		} else{
			$s_d_group3 =false;
		}

		$s_d= array();
		$s_d['s_d_group1'] = $s_d_group1;
		$s_d['s_d_group2'] = $s_d_group2;
		$s_d['s_d_group3'] = $s_d_group3;

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
