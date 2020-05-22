<?php
class Records_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('records');

		$this -> alias_map = array(

		);
	}

	function find_by_value($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}
		$this -> db -> where("_m.is_delete", 0);
		$this -> db -> order_by("id", "desc");

		if(!empty($f['date'])){
			$this -> db -> where('_m.create_date =',$f['date']);
		}

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
	}

	function find_by_parameter($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		if(!empty($f['id'])){
			$this -> db -> where('_m.id',$f['id']);
		}

		if(!empty($f['date'])){
			$date = date_create($f['date']);
			$dateS = date_format($date,"Y-m-d 00:00:00");
			$dateE = date_format($date,"Y-m-d 23:59:59");

			$this -> db -> where('_m.create_time >=',$dateS);
			$this -> db -> where('_m.create_time <=',$dateE);
		}

		$this -> db -> where('_m.is_delete', 0);
		$this -> db -> order_by("id", "desc");

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_by_page($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		//	limit
		if(empty($f['page'])) {
			$page = 0;
		} else {
			$page = intval($f['page']);
		}
		if(empty($f['limit'])) {
			// default is 10
			$limit = 10;
		} else {
			$limit = intval($f['limit']);
		}
		$start = $page * $limit;
		$this -> db -> limit($limit, $start);

		$this -> db -> where('_m.is_delete', 0);
		$this -> db -> order_by("id", "desc");

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_by_date($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$this -> db -> where("_m.is_delete", 0);
		// $this -> db -> where('_m.pos', 1 );

		$this -> db -> group_by('_m.create_date');


		if(!empty($f['desc'])){
			$this -> db -> order_by("id", "desc");
		}

		if(!empty($f['is_month'])){
			$start = 	date('Y-m-01');
			$end = 	date('Y-m-t');
			$this -> db -> where('_m.create_date>=',$start);
			$this -> db -> where('_m.create_date<=',$end);
		}

		if(!empty($f['is_week'])){
			$start = date('Y-m-d',strtotime('last Monday'));
			$end = date('Y-m-d',strtotime('next Sunday'));
			$this -> db -> where('_m.create_date>=',$start);
			$this -> db -> where('_m.create_date<=',$end);
		}

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}


	function find_by_2_dates($member_id){
		$sql = "SELECT * FROM records WHERE id IN (SELECT MAX(id) FROM records WHERE member_id = $member_id AND is_delete = 0 GROUP BY create_date) order by id desc";
		$query = $this -> db -> query($sql)-> result();
		return $query;
	}

	function find_avg($f){
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> select('_m.*');

		$this -> db -> select('_m.create_date,AVG(_m.weight) as weight, AVG(_m.body_fat) as body_fat , AVG(_m.body_fat_rate) as body_fat_rate');

		if(!empty($f['member_id'])){
			$this -> db -> where("_m.member_id", $f['member_id']);
		}

		if(!empty($f['start_date'])){
			$this -> db -> where("_m.create_date>=", $f['start_date']);
		}

		if(!empty($f['end_date'])){
			$this -> db -> where("_m.create_date<", $f['end_date']);
		}

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
  }


	function find_list_by_weight($f){
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$this -> db -> where("_m.is_delete", 0);
		$this -> db -> order_by("weight", "asc");

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}





	function find_min_weight($f){
   	$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$this -> db -> where("_m.is_delete", 0);
		$this -> db -> order_by("weight", "asc");
		// $this -> db -> order_by("id", "desc");

		$query = $this -> db -> get($this -> table_name);

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
	}

	function find_max_weight($f){
   	$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$this -> db -> where("_m.is_delete", 0);
		$this -> db -> order_by("weight", "desc");

		$query = $this -> db -> get($this -> table_name);

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
	}

	function find_newest_weight($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		if(!empty($f['new'])){
			$this -> db -> order_by("id", "desc");
		}
		$this -> db -> where("_m.is_delete", 0);

		$query = $this -> db -> get($this -> table_name);

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
	}

	function find_list_all($f) {
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$this -> db -> where("_m.is_delete", 0);

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_by_ym($member_id, $ym) {
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select("_m.id,_m.create_date,_m.weight");


		$this -> db -> where("( _m.create_date like '{$ym}-%' )");
		$this -> db -> where("_m.member_id", $member_id);
		// $this -> db -> where("_m.pos", 1);
		$this -> db -> where("_m.is_delete", 0);
		$this -> db -> group_by('_m.create_date');

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_by_ym_update($member_id, $ym) {
		$sql = "SELECT * FROM records WHERE id IN (SELECT MAX(id) FROM records WHERE member_id = $member_id AND create_date LIKE '{$ym}-%'  AND is_delete = 0 GROUP BY create_date)";
		$query = $this -> db -> query($sql)-> result();
		return $query;
		// return $query;
		// $this -> db -> from("$this->table_name as _m");
		//
		// $this -> db -> select("_m.id,_m.create_date,_m.weight");
		//
		//
		// $this -> db -> where("( _m.create_date like '{$ym}-%' )");
		// $this -> db -> where("_m.member_id", $member_id);
		// // $this -> db -> where("_m.pos", 1);
		// $this -> db -> where("_m.is_delete", 0);
		// $this -> db -> group_by('_m.create_date');
		//
		// $list = $this -> db -> get() -> result();
		// return $list;
	}



	function find_one_data($member_id, $id) {
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select("_m.id,_m.create_date,_m.weight");

		$this -> db -> where("_m.member_id", $member_id);
		$this -> db -> where("_m.is_delete", 0);
		$this -> db -> where("_m.id<", $id);
		$this -> db -> order_by('id', 'desc');
		$query = $this -> db -> get($this -> table_name);

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;

		// $list = $this -> db -> get() -> result();
		// return $list;
	}

	function find_first($member_id) {
		$this -> db -> select("_m.create_date,_m.weight");

		$this -> db -> from("$this->table_name as _m");

		$this -> db -> where("_m.member_id", $member_id);
		$this -> db -> where("_m.pos", 1);
		$this -> db -> where("_m.is_delete", 0);

		$query = $this -> db -> get($this -> table_name);

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

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('m.age as age');
		$this -> db -> select('m.height as height');

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
		return $query -> result();
	}

	function query_ajax_for_all($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('m.age as age');
		$this -> db -> select('m.height as height');
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

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function find_record($id) {


		// select
		$this -> db -> select('_m.*');

		// join
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> where('_m.member_id', $id);



		$this -> db -> order_by('id', 'desc');

		// limit
		$this -> db -> limit(3);

		$list = $this -> db -> get() -> result();
		if(count($list) > 0) {
			return $list;
		} else{
			return NULL;
		}
	}

	function search_always($data) {
		$this -> db -> select('m.user_name');
		$dt = $data['dt'];
		$e_dt = $data['e_dt'];
		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		$this -> db -> where('_m.is_delete', 0);

	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("members m", "m.id = _m.member_id", "left");

	}

	function query_all($f) {
		$this -> db -> select('id, stop_name, city, district, lat, lng, start_time, end_time');
		$this -> db -> from($this -> table_name);
		$this -> db -> where('status', 0);
		$list = $this -> db -> get() -> result();

		return $list;
	}

	function del_power_by_role_id($role_id) {
		$sql = "delete from role_power where role_id = $role_id";
		$this -> db -> query($sql);
	}

	function get_role_power($role_id, $nav_id ) {
		$list = $this -> db -> query("select * from role_power where role_id = {$role_id} and nav_id = {$nav_id}") -> result();
		if(count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}

	function update_role_power($role_id, $nav_id_arr, $nav_power_arr) {
		$this -> del_power_by_role_id($role_id);

		// add power
		for($i = 0 ; $i < count($nav_id_arr) ; $i++) {
			$nav_id = $nav_id_arr[$i];
			$power_list = $nav_power_arr[$nav_id];
			$this -> db -> insert('role_power', array(
				'role_id' => $role_id,
				'nav_id' => $nav_id,
				'power_list' => json_encode($power_list),
				// 'nav_power' => $nav_power_arr[$i]
			));
		}
	}

	// function find_last_weight($id) {
	// 	$this -> db -> from("$this->table_name as _m");
	// 	$this -> db -> select('_m.*');
	// 	$this -> db -> where('_m.member_id', $id);
	// 	$this -> db -> where("(_m.create_time >= '{$s_dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
	//
	// 	$this -> db -> order_by('_m.create_time', 'desc');
	// 	$list = $this -> db -> get() -> result();
	// 	return $list[0];
	// }

	function find_today_weight($id) {
		$date = date('Y-m-d');
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.member_id', $id);
		$this -> db -> where("(_m.create_time like '{$date} %')");

		$this -> db -> order_by('_m.create_time', 'desc');
		$list = $this -> db -> get() -> result();
		return $list[0];
	}

	function find_by_member_weight($id,$login_user) {
		$date = date('Y-m-d');
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> select('m.user_name');

		if(!empty($id) && $id!=='no_person_'){
			$this -> db -> where('_m.member_id', $id);
		}
		$this -> db -> where('m.coach_id', $login_user->code);

		$this -> db -> where("(_m.create_time like '{$date} %')");
		$this -> db -> order_by('_m.create_time', 'desc');
		$this -> db -> join("members as m", 'm.id = _m.member_id', "left");
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_last_weight($id) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.member_id', $id);
		$this -> db -> order_by('_m.create_time', 'desc');
		$list = $this -> db -> get() -> result();
		if(count($list) > 0) {
			return $list[0];
		} else{
			return NULL;
		}

	}

	function find_last_w_lose3day($id) {
		$lose_3_date = date("Y-m-d",strtotime("-3 day"));
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.member_id', $id);
		// $this -> db -> group_by('_m.member_id');
		// $this -> db -> where("(_m.create_time >'{$lose_3_date} ')");

		$this -> db -> order_by('_m.id', 'desc');
		// $this -> db -> limit(1);

		$list = $this -> db -> get() -> result();
		if(count($list)>0){
			if($list[0]-> create_date < $lose_3_date) {
				return $list[0];
			}
		}	else{
			return NULL;
		}

	}

	function find_today_body_fat($id) {
		$today= date("Y-m-d");
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.member_id', $id);
		$this -> db -> where("_m.create_date",$today);

		$this -> db -> order_by('_m.id', 'desc');
		// $this -> db -> limit(1);

		$list = $this -> db -> get() -> result();
		if(count($list)>0){
			return $list[0];
		} else{
			return NULL;
		}

	}


	function find_last_body_fat($id) {
		$today= date("Y-m-d");
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.member_id', $id);
		$this -> db -> where("_m.create_date<>",$today);

		$this -> db -> order_by('_m.id', 'desc');
		// $this -> db -> limit(1);

		$list = $this -> db -> get() -> result();

		if(count($list)>0){
			return $list[0];
		} else{
			return NULL;
		}
	}

	function find_user_weight_history($data, $is_count = FALSE) {

		$member_id= $data['member_id'];
		$start = $data['start'];
		$limit = $data['length'];

		// select
		$this -> db -> from("$this->table_name as _m");


		$this -> db -> select('_m.*');


		if(!$is_count) {
			$this -> db -> limit($limit, $start);
		}
		$this -> db -> where('_m.member_id',$member_id);

		// query results
		if(!$is_count) {
			$query = $this -> db -> get();
			return $query -> result();
		} else {
			return $this -> db -> count_all_results();
		}

	}

	function find_each_weight($id) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.member_id', $id);

		$this -> db -> order_by('_m.id', 'desc');
		// $this -> db -> limit(1);

		$list = $this -> db -> get() -> result();

		if(count($list)>0){
			return $list[0];
		} else{
			return NULL;
		}
	}

	function find_original_weight($id) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.member_id', $id);

		$this -> db -> order_by('_m.id', 'asc');
		// $this -> db -> limit(1);

		$list = $this -> db -> get() -> result();

		if(count($list)>0){
			return $list[0];
		} else{
			return NULL;
		}
	}

	function find_first_day($id) {
		// $today= date("Y-m-d");
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.create_date');
		$this -> db -> where('_m.member_id', $id);

		$this -> db -> order_by('_m.id', 'asc');
		// $this -> db -> limit(1);

		$list = $this -> db -> get() -> result();
		if(count($list)>0){
			return $list[0]->create_date;
		} else{
			return NULL;
		}

	}

	function find_last_by_member_id($member_id, $last_id) {
		$this -> db -> where("member_id", $member_id);
		$this -> db -> where("id < {$last_id}");
		$this -> db -> limit(1);
		$this -> db -> order_by("id", 'desc');
		$list = $this -> find_all();
		if(count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}

}
?>
