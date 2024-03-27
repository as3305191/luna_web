<?php
class Users_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('users');

		$this -> alias_map = array(
			'account' => '_m.account',
			'user_name' => '_m.user_name',
			'station_name' => 'st.name'
		);
	}

	function find_by_value($f){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("roles r", "r.id = _m.role_id", "left");

		$this -> db -> select('_m.*');
		$this -> db -> select('r.role_name');

		if(!empty($f['role_id'])){
			$this -> db -> where("_m.role_id", $f['role_id']);
		}

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
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
		$this -> db -> select('d.name as d_name');
		$this -> db -> select('d.id as d_id');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		// $this -> db -> order_by('id', 'desc');
		$this -> db -> order_by('d_id', 'asc');

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
		if(isset($data['id']) && $data['id'] > -1){
			$this -> db -> where('_m.id', $data['id']);
		}

		if(isset($data['role_id']) && $data['role_id'] > -1) {
			$this -> db -> where('_m.role_id', $data['role_id']);
		}

	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("department as d", 'd.id = _m.role_id', "left");
	}

	function find_by_account($account) {
		$this -> db -> where('account', $account);
		$query = $this -> db -> get($this -> table_name);
		foreach ($query->result() as $row){
		    return $row;
		}
		return NULL;
	}

	function find_by_corp_and_account($corp_id, $account) {
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('account', $account);
		$query = $this -> db -> get($this -> table_name);
		foreach ($query->result() as $row){
		    return $row;
		}
		return NULL;
	}

	function nav_list() {
		$this -> load -> model('Nav_dao', 'nav_dao');
		$this -> load -> model('Nav_power_dao', 'nav_power_dao');

		$lv1_list = $this -> nav_dao -> find_all_by_parent_id(0);
		$sub_list = $this -> nav_dao -> find_all_not_lv1();

		$map = array();

		foreach($lv1_list as $each) {
			$map[$each->id] = $each;
			$each -> nav_power_list = $this -> nav_power_dao -> find_all_by_nav_id($each -> id);
			// find nav
			$each -> sub_list = array(); // init sub list
		}

		// add sublist
		foreach($sub_list as $each) {
			if(isset($map[$each -> parent_id])) {
				$each -> nav_power_list = $this -> nav_power_dao -> find_all_by_nav_id($each -> id);
				$lv1 = $map[$each -> parent_id];
				array_push($lv1 -> sub_list, $each); // add to sublist
			}
		}

		foreach($map as $key => $each) {
			if(count($each -> sub_list) == 0 && empty($each -> base_path)) {
				unset($map[$key]);
			}
		}

		return $map;
	}

	function nav_list_with_role_role_id($role_id) {
		$this -> load -> model('Nav_dao', 'nav_dao');
		$this -> load -> model('Nav_power_dao', 'nav_power_dao');
		$lv1_list = $this -> nav_dao -> find_all_by_parent_id(0);
		$sub_list = $this -> nav_dao -> find_all_not_lv1();

		$sql = "select * from role_power where role_id = $role_id";
		$rp_list = $this -> db -> query($sql) -> result();

		$map = array();

		// traverse lv1
		foreach($lv1_list as $each) {
			$map[$each->id] = $each;
			$each -> nav_power_list = $this -> nav_power_dao -> find_all_by_nav_id($each -> id);

			foreach($rp_list as $rp) {
				if($rp -> nav_id == $each -> id) {
					$each -> rp = $rp;
				}
			}
			$each -> sub_list = array();
		}

		// traverse lv2
		foreach($sub_list as $each) {
			if(isset($map[$each -> parent_id])) {
				$each -> nav_power_list = $this -> nav_power_dao -> find_all_by_nav_id($each -> id);

				$lv1 = $map[$each -> parent_id];
				foreach($rp_list as $rp) {
					if($rp -> nav_id == $each -> id) {
						$each -> rp = $rp;
					}
				}
				array_push($lv1 -> sub_list, $each);
			}
		}

		foreach($map as $key => $each) {
			if(count($each -> sub_list) == 0 && empty($each -> base_path)) {
				unset($map[$key]);
			}
		}

		return $map;
	}

	function nav_list_with_role_id($role_id) {
		$this -> load -> model('Nav_dao', 'nav_dao');
		$this -> load -> model('Nav_power_dao', 'nav_power_dao');
		$lv1_list = $this -> nav_dao -> find_all_by_parent_id(0);
		$sub_list = $this -> nav_dao -> find_all_not_lv1();

		$sql = "select * from role_power where role_id = $role_id";
		$rp_list = $this -> db -> query($sql) -> result();

		$map = array();

		// traverse lv1
		foreach($lv1_list as $each) {
			$map[$each->id] = $each;
			$each -> nav_power_list = $this -> nav_power_dao -> find_all_by_nav_id($each -> id);

			foreach($rp_list as $rp) {
				if($rp -> nav_id == $each -> id) {
					$each -> rp = $rp;
				}
			}
			$each -> sub_list = array();
		}

		// traverse lv2
		foreach($sub_list as $each) {
			if(isset($map[$each -> parent_id])) {
				$each -> nav_power_list = $this -> nav_power_dao -> find_all_by_nav_id($each -> id);

				$lv1 = $map[$each -> parent_id];
				foreach($rp_list as $rp) {
					if($rp -> nav_id == $each -> id) {
						$each -> rp = $rp;
					}
				}
				array_push($lv1 -> sub_list, $each);
			}
		}

		foreach($map as $key => $each) {
			if(count($each -> sub_list) == 0 && empty($each -> base_path)) {
				unset($map[$key]);
			}
		}
		return $map;
	}

	function nav_list_by_role_id($role_id) {
		$this -> load -> model('Nav_dao', 'nav_dao');
		$lv1_list = $this -> nav_dao -> find_all_by_parent_id(0);
		$sub_list = $this -> nav_dao -> find_all_not_lv1();

		$sql = "select * from role_power where role_id = {$role_id}";
		$rp_list = $this -> db -> query($sql) -> result();

		$map = array();
		foreach($lv1_list as $each) {
			foreach($rp_list as $rp) {
				if($rp -> nav_id == $each -> id) {
					$each -> rp = $rp;
					$map[$each->id] = $each;
				}
			}
			$each -> sub_list = array();
		}

		// add sublist
		foreach($sub_list as $each) {
			if(isset($map[$each -> parent_id])) {
				$lv1 = $map[$each -> parent_id];
				foreach($rp_list as $rp) {
					if($rp -> nav_id == $each -> id) {
						$each -> rp = $rp;
						array_push($lv1 -> sub_list, $each);
					}
				}
			}
		}

		foreach($map as $key => $each) {
			if(count($each -> sub_list) == 0 && empty($each -> base_path)) {
				unset($map[$key]);
			}
		}

		return $map;
	}

	function find_menu_list() {
		$sql = " SELECT m.id as main_id, m.nav_name as main_name, m.icon as main_icon, m.key as main_key, s.* "
				. " FROM nav_main as m  "
				. " left join nav_sub as s on m.id = s.nav_main_id "
				. " order by m.pos, s.pos ";
		$res = $this -> query_for_list($sql);

		$data = array();
		foreach ($res as $row) {
			$main_id = $row -> main_id;
			$nav_sub_id = $row -> id;
			if (!empty($nav_sub_id)) {
				if (empty($data[$main_id])) {
					$main_obj['nav_name'] = $row -> main_name;
					$main_obj['icon'] = $row -> main_icon;
					$main_obj['key'] = $row -> main_key;
					$m['main'] = $main_obj;
					$m['sub_list'] = array();
					$data[$main_id] = $m;
				}
				unset($row -> main_id);
				unset($row -> main_name);
				unset($row -> main_icon);
				array_push($data[$main_id]['sub_list'], $row);
			}
		}
		return $data;
	}

	function session_user() {
		$user_id = $this -> session -> userdata('user_id');
		return $this -> find_by_id($user_id);
	}

	function find_all_user_roles() {
		return $this -> db -> get('user_role') -> result();
	}

	function find_all_department() {
		$this -> db -> where('parent_id',5);
		return $this -> db -> get('department') -> result();
	}
	function find_all_department_bfl() {
		$this -> db -> where('parent_id',2);
		return $this -> db -> get('department') -> result();
	}

	function find_all_div($parent_id) {
		$this -> db -> where('parent_id',$parent_id);
		return $this -> db -> get('department') -> result();
	}

	function find_all_hospital() {
		return $this -> db -> get('hospital') -> result();
	}

	function find_all_doctor() {
		$this -> db -> where('(role_id = 2)');

		return $this -> db -> get('users') -> result();
	}

	function find_all_manager() {
		$this -> db -> where('(role_id = 3)');

		return $this -> db -> get('users') -> result();
	}

	function find_sys_roles() {
		$this -> db -> where('(id = 1 or id = 99 or id = 11)');
		return $this -> db -> get('roles') -> result();
	}

	function find_corp_roles() {
		$this -> db -> where('(id = 1 or id = 11)');
		return $this -> db -> get('roles') -> result();
	}

	function find_group_users($id) {
		$list = array();
		$u = $this -> find_by_id($id);
		$this -> db -> from("department as d");
		$this -> db -> select('d.*');
		$this -> db -> where('d.id', $u -> role_id);
		// $this -> db -> where('group_id', $u -> group_id);

		$query = $this -> db -> get();
		return $query -> result();
	}

	function find_doctor_by_hospital($hospital_id) {
		$this -> db -> where('(role_id = 2 )');
		if($hospital_id>0){
			$this -> db -> where('hospital_id=',$hospital_id);
		}
		$list = $this -> db -> get($this -> table_name) -> result();
		return $list;
	}

	function find_manager_by_hospital($hospital_id) {
		$this -> db -> where('(role_id = 3 )');
		if($hospital_id>0){
			$this -> db -> where('hospital_id=',$hospital_id);
		}
		$list = $this -> db -> get($this -> table_name) -> result();
		return $list;
	}

	function find_by_account_and_corp($corp_id, $account) {
		$list = array();
		$this -> db -> where('status', 0);
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('account', $account);
		$list = $this -> db -> get($this -> table_name) -> result();
		if(count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}

	function find_by_code($code) {
		$list = array();
		$this -> db -> where('status', 0);
		$this -> db -> where('code', $code);
		$list = $this -> db -> get($this -> table_name) -> result();
		if(count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}

	function find_by_email_and_corp($corp_id, $email) {
		$list = array();
		$this -> db -> where('status', 0);
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('email', $email);
		$list = $this -> db -> get($this -> table_name) -> result();
		if(count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}

	function find_by_valid_email_and_corp($corp_id, $email) {
		$list = array();
		$this -> db -> where('status', 0);
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('email', $email);
		$this -> db -> where('is_valid_email', 1);
		$list = $this -> db -> get($this -> table_name) -> result();
		if(count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}

	function find_by_user_name_and_corp($corp_id, $user_name) {
		$list = array();
		$this -> db -> where('status', 0);
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('user_name', $user_name);
		$list = $this -> db -> get($this -> table_name) -> result();
		if(count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}

	function find_by_nick_name_and_corp($corp_id, $nick_name) {
		$list = array();
		$this -> db -> where('status', 0);
		$this -> db -> where('corp_id', $corp_id);
		$this -> db -> where('nick_name', $nick_name);
		$list = $this -> db -> get($this -> table_name) -> result();
		if(count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}

	function find_all_user_by_me($data) {
		$s_date = $data['s_date'];
		$e_date = $data['e_date'];
		$user_id = $data['user_id'];
		$sql = "select u.* from users u
		where u.create_time >= '$s_date 00:00:00' and u.create_time <= '$e_date 23:59:59'
		and (u.intro_id = $user_id or u.manager_id = $user_id)
		";

		$list = $this -> db -> query($sql) -> result();
		return $list;
	}

	// function find_all_by_station($station_id) {
	// 	$this -> db -> select("id");
	// 	$this -> db -> select("user_name");
	// 	$this -> db -> select("account");
	// 	$this -> db -> from("{$this->table_name}");
	// 	$this -> db -> where("station_id", $station_id);
	// 	$list = $this -> db -> get() -> result();
	// 	return $list;
	// }

	function find_by_status1($account) {

		$this -> db -> select("*");
		$this -> db -> from("{$this->table_name}");
		$this -> db -> where("account", $account);

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_engineer(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("roles r", "r.id = _m.role_id", "left");

		$this -> db -> select('_m.*');
		$this -> db -> select('r.role_name');
		$this -> db -> where('_m.role_id',9);


		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}

	function find_all_user(){
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join("roles r", "r.id = _m.role_id", "left");

		$this -> db -> select('_m.id');
		$this -> db -> select('_m.user_name');
		$this -> db -> select('_m.status');

		// $this -> db -> select('r.role_name');
		// $this -> db -> where('_m.role_id',7);
		$this -> db -> where('_m.status',0);


		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}
	function find_all_ktx_user_id(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("department d", "d.id = _m.role_id", "left");

		$this -> db -> select('_m.id');
		
		
		// $this -> db -> select('_m.user_name');


		$this -> db -> group_start();
		$this -> db -> where('_m.role_id>',3);
		$this -> db -> where('_m.role_id<=',27);
		$this -> db -> or_group_start();
		$this -> db -> where('_m.role_id>=',69);
		$this -> db -> where('_m.role_id<=',74);
		$this -> db -> group_end();
		$this -> db -> group_end();
	
		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}
	function find_all_ktx_user(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("department d", "d.id = _m.role_id", "left");

		$this -> db -> select('_m.id');
		
		$this -> db -> select('_m.user_name');
		$this -> db -> select('_m.depname');
		$this -> db -> select('_m.role_id');


		$this -> db -> group_start();
		$this -> db -> where('_m.role_id>',3);
		$this -> db -> where('_m.role_id<=',27);
		$this -> db -> or_group_start();
		$this -> db -> where('_m.role_id>=',69);
		$this -> db -> where('_m.role_id<=',74);
		$this -> db -> group_end();
		$this -> db -> group_end();
	
		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_all_user_by_message(){
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join("roles r", "r.id = _m.role_id", "left");

		$this -> db -> select('_m.*');
	

		// $this -> db -> select('r.role_name');
		$this -> db -> where('_m.status',0);

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_all_offline_users($id) {
		$this -> db -> from("{$this->table_name}");
		$this -> db -> select("id");
		$this -> db -> select("user_name");
		$this -> db -> where("id", $id);
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_k_b_i_department_div() {
		$this -> db -> where('parent_id',5);
		$this -> db -> or_where('parent_id',2);
		$this -> db -> or_where('id',52);
		$this -> db -> or_where('id',2);
		$this -> db -> or_where('id',54);
		return $this -> db -> get('department') -> result();
	}
	function find_all_k_b_i_department() {
		$this -> db -> where('id',2);
		$this -> db -> or_where('parent_id',5);
		$this -> db -> or_where('id',52);
		$this -> db -> or_where('id',54);

		return $this -> db -> get('department') -> result();
	}
}
?>
