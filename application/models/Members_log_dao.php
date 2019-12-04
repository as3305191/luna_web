<?php
class Members_log_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('members_log');

		$this -> alias_map = array(
			'account' => '_m.account',
			'user_name' => '_m.user_name',
			'station_name' => 'st.name'
		);
	}

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



	function find_by_role($station_id,$role_id){
		$this -> db -> where("station_id", $station_id);
		$this -> db -> where("role_id", $role_id);
		$this -> db -> order_by("pos", "asc");
		return $this -> find_all();
	}

	function find_by_stations_and_role($all_stations,$role_id){
		$id_arr_str = implode(',', $all_stations);
		$this -> db -> where("(station_id in ({$id_arr_str}))");
		$this -> db -> where("role_id", $role_id);
		// $this -> db -> order_by("station_id", "asc");
		$this -> db -> order_by("pos", "asc");
		$this -> db -> order_by("account", "asc");
		return $this -> find_all();
	}

	function find_by_parameter($id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("station s", "s.id = _m.station_id", "left");

		$this -> db -> select('_m.*');
		$this -> db -> select('s.name as station_name, s.is_stock, s.is_machine, s.is_thaw, s.is_begin');

		if(!empty($id)){
			$this -> db -> where("_m.id", $id);
		}

		$list = $this -> find_all();
		return $list[0];
	}

 // Original Function
	function find_all_by_min_profit($profit_min, $today) {
		$this -> db -> where("profit > {$profit_min}");
		$this -> db -> where("profit_date", $today);
		return $this -> find_all();
	}

	function corp_count_all($corp_id) {
		$this -> db -> select("count(*) as samt");
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('status', 0);
		$list = $this -> find_all();
		if(count($list) > 0) {
			$itm = $list[0];
			return $itm -> samt;
		}
		return 0;
	}

	function find_all_valid_by_mobile_and_corp($corp_id, $mobile) {
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('is_valid_mobile', 1);
		$this -> db -> where('mobile', $mobile);
		$list = $this -> find_all();
		return $list;
	}

	function find_all_valid_user_by_mobile_and_corp($corp_id, $account, $mobile) {
		$this -> db -> where('corp_id', $corp_id);
		// $this -> db -> where('is_valid_mobile', 1);
		$this -> db -> where('mobile', $mobile);
		$this -> db -> where('account', $account);
		$list = $this -> find_all();
		return $list;
	}

	function find_all_valid_by_email_and_corp($corp_id, $email) {
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('is_valid_email', 1);
		$this -> db -> where('email', $email);
		$list = $this -> find_all();
		return $list;
	}

	function corp_count_time($time, $corp_id) {
		$this -> db -> select("count(*) as samt");
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('status', 0);
		$this -> db -> where("create_time like '$time%'");
		$list = $this -> find_all();
		if(count($list) > 0) {
			$itm = $list[0];
			return $itm -> samt;
		}
		return 0;
	}


	function find_me($id) {
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('mu.account as manager_account');
		$this -> db -> select('iu.account as intro_account');
		$this -> db -> select('r.role_name');
		$this -> db -> select('co.corp_name, co.corp_code, co.sys_name');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always(array());

		$this -> db -> where('_m.id', $id);

		// query results
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list[0];
	}

	function find_corp_admin($corp_id) {
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('mu.account as manager_account');
		$this -> db -> select('iu.account as intro_account');
		$this -> db -> select('r.role_name');
		$this -> db -> select('co.corp_name, co.corp_code, co.sys_name');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always(array());

		$this -> db -> where('_m.corp_id', $corp_id);
		$this -> db -> where('_m.role_id', 1); // corp admin
		$this -> db -> order_by('id', 'asc'); // first admin

		// query results
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list[0];
	}

	function find_by_group_and_account($corp_id, $account) {
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('mu.account as manager_account');
		$this -> db -> select('iu.account as intro_account');
		$this -> db -> select('r.role_name');
		$this -> db -> select('co.corp_name, co.corp_code, co.sys_name');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always(array());

		$this -> db -> where('_m.corp_id', $corp_id);
		$this -> db -> where('_m.account', $account);

		// query results
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list[0];
	}

	function find_sys_admin() {
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('mu.account as manager_account');
		$this -> db -> select('iu.account as intro_account');
		$this -> db -> select('r.role_name');

		$this -> db -> select('co.corp_name, co.corp_code, co.sys_name, co.lang, co.currency');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always(array());

		$this -> db -> where('_m.role_id', 99); // sys admin
		$this -> db -> order_by('id', 'asc'); // first admin

		// query results
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list[0];
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

	function find_by_log111($member_id,$that_day) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.id');
		$this -> db -> where('_m.member_id', $member_id); // sys admin
		$this -> db -> where("(_m.create_time >= '{$that_day}' and _m.create_time <= '{$that_day} 23:59:59' )");
		$list = $this -> db -> get() -> result();
		if(!empty($list)){
			return $list[0]->id;
		}
		return NULL;

	}

	function find_log_time($id) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.create_time');
		$this -> db -> select('m.ip as ip');

		$this -> db -> where('_m.member_id', $id); // sys admin
		$this -> db -> order_by('_m.id', 'asc'); // sys admin
		$this -> db -> join("members as m", 'm.id = _m.member_id', "left");

		$list = $this -> db -> get() -> result();
		if(!empty($list)){
			return $list[0] -> create_time;
		}
		return NULL;

	}

	function count_all_24hr() {
		$date = date("Y-m-d H:i:s");
		$the_day_before =date("Y-m-d H:i:s",strtotime("-1 day"));
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where("(_m.create_time >= '{$the_day_before}' and _m.create_time <= '{$date} 23:59:59' )");

		$list = $this -> db -> get() -> result();

		return count($list);

	}

}
?>
