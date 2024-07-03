<?php
class C_s_h_join_list_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('c_s_h_join_list');

		$this -> alias_map = array(
		
		);
	}

	function find_by_condition($f){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');

		if(!empty($f['account'])){
			$this -> db -> where("_m.account", $f['account']);
		}

		if(!empty($f['email'])){
			$this -> db -> or_where('_m.email', $f['email']);
		}

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_by_value($f){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');

		if(!empty($f['account'])){
			$this -> db -> where("_m.account", $f['account']);
		}

		if(!empty($f['id'])){
			$this -> db -> where("_m.id", $f['id']);
		}

		if(!empty($f['code'])){
			$this -> db -> where("_m.code", $f['code']);
		}

		return $this -> find_all();
	}

	function find_with_token(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("app_reg_code app", "app.member_id = _m.id", "left");

		$this -> db -> select('_m.*');
		$this -> db -> select('app.token');

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}



	// function find_by_account($f){
	// 	$this -> db -> from("$this->table_name as _m");
	// 	$this -> db -> select('_m.*');
	//
	// 	if(!empty($f['account'])){
	// 		$this -> db -> where("_m.account", $f['account']);
	// 	}
	//
	// 	$query = $this -> db -> get();
	// 	if ($query -> num_rows() > 0) {
	// 		$row = $query -> row();
	// 		return $row;
	// 	}
	// 	return NULL;
	// }

	function find_by_role($station_id,$role_id){
		$this -> db -> where("station_id", $station_id);
		$this -> db -> where("role_id", $role_id);
		$this -> db -> order_by("pos", "asc");
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
		if(!empty($data['type'])){
			$type = $data['type'];
			if($type>-1){
				$this -> db -> where("_m.type", $type);
			}
		}
		if(!empty($data['id'])){
			$id = $data['id'];
			$this -> db -> where("_m.id", $id);
		}
		$this -> db -> where("_m.is_delete",0);

	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join("roles as r", 'r.id = _m.role_id', "left");
		// $this -> db -> join("hospital as h", 'h.id = _m.hospital_id', "left");
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

		$sql = "select * from role_power where role_id = $role_id";
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

	function find_all_roles() {
		$this -> db -> where('(id = 1)');

		return $this -> db -> get('roles') -> result();
	}

	function find_sys_roles() {
		$this -> db -> where('(id = 1 or id = 99 or id = 11)');
		return $this -> db -> get('roles') -> result();
	}

	function find_corp_roles() {
		$this -> db -> where('(id = 1 or id = 11)');
		return $this -> db -> get('roles') -> result();
	}

	function find_all_hospital() {
		return $this -> db -> get('hospital') -> result();
	}

	function find_group_users($id) {
		$list = array();
		$u = $this -> find_by_id($id);
		if(!empty($u) && !empty($u -> group_id)) {
			$this -> db -> where('status', 0);
			$this -> db -> where('group_id', $u -> group_id);
			$list = $this -> db -> get($this -> table_name) -> result();

		}
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

	function find_by_status1($account) {

		$this -> db -> select("*");
		$this -> db -> from("{$this->table_name}");
		$this -> db -> where("account", $account);

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function do_reset(){
		$data = array('sign' => 0);
		$this -> db -> update('members', $data);
	}

	function find_by_id11($id,$that_day) {
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');
		$this -> db -> select('ml.id as members_log_id');

		$this -> db -> where('_m.id', $id);
		$this -> db -> where("(_m.create_time >= '{$that_day}' and _m.create_time <= '{$that_day} 23:59:59' )");

		$this -> db -> join("members_log ml", "ml.member_id = _m.id", "left");

		$list = $this -> db -> get() -> result();
		return $list[0];
	}

	function count_all_level_p($level) {
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');
		if($level>0){
			$this -> db -> where('_m.level_status', $level);
		}
		$list = $this -> db -> get() -> result();
		return count($list);
	}

	function find_all_coach() {
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');
		$this -> db -> where('_m.type', 1);
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function query_ajax_by_coach($login_coach_code,$start_l) {
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.coach_id",$login_coach_code);
		$this -> db -> where("_m.status", 0);

		// join
		// $this -> db -> join("records r", "r.member_id = _m.id", "left");

		// search

		$this -> db -> order_by('_m.id', 'asc');
		if($start_l>1){
			$this -> db -> limit(10, $start_l);

		} else{
			$this -> db -> limit(10);
		}
		// limit

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function query_ajax_by_coachall($login_coach_code) {
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.coach_id",$login_coach_code);
		$this -> db -> where("_m.status", 0);

		// search

		$this -> db -> order_by('_m.id', 'asc');
		// limit

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_by_coach($coach_id) {

		// select
		$this -> db -> select('_m.*');
		$this -> db -> where("coach_id", $coach_id);

		// join
		$this -> ajax_from_join();

		// search always
		// $this -> search_always($data);
		// search

		$this -> db -> order_by('id', 'asc');
		// query results
		$query = $this -> db -> get();

		// echo $this -> db -> last_query();
		return $query -> result();
	}

	function find_all_by_id($id,$type) {

		// select
		if($type==0){
			$this -> db -> select('_m.*');
			$this -> db -> select('c_h.computer_hard_id as hard_id');
			$this -> db -> where('_m.computer_hard_id<>', 0);
			$this -> db -> where('c_h.is_delete', 0); 
			$this -> db -> where('c_h.is_ok', 1); 
			$this -> db -> where('_m.type', 0);
			$this -> db -> where("_m.computer_id", $id);

			$this -> db -> join("computer_hard c_h", "c_h.id = _m.computer_hard_id", "left");
		}else if($type==1){
			$this -> db -> select('_m.*');
			$this -> db -> select('c_s.computer_soft_id as soft_id');
			$this -> db -> where('_m.computer_soft_id<>', 0);
			$this -> db -> where('c_s.is_delete', 0); 
			$this -> db -> where('c_s.is_ok', 1); 
			$this -> db -> where('_m.type', 0);
			$this -> db -> where("_m.computer_id", $id);

			$this -> db -> join("computer_soft c_s", "c_s.id = _m.computer_soft_id", "left");
		}

		$query = $this -> db -> get();

		return $query -> result();
	}

	function find_by_member_name($name) {
		// $date = date('Y-m-d');
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.user_name ", $name);

		$this -> db -> order_by('_m.create_time', 'desc');
		// $this -> db -> limit(10);
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_usage_not_zero() {
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');

		$this -> db -> where('_m.usage_count>', 0);
		$this -> db -> where('_m.type', 0);
		$this -> db -> where('_m.is_ok', 1);
		$this -> db -> where('_m.is_delete', 0);

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_use_now_by_computer($computer_id,$type) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		if($type==0){
			$this -> db -> select('c_h.computer_hard_name as hard_name');
			$this -> db -> where('_m.computer_hard_id>', 0);
			$this -> db -> where('c_h.is_delete', 0); 
			$this -> db -> where('c_h.is_ok', 1); 
			$this -> db -> where('_m.type', 0);

			$this -> db -> join("computer_hard c_h", "c_h.id = _m.computer_hard_id", "left");

		}else if($type==1){
			$this -> db -> select('c_s.computer_soft_name as soft_name');
			$this -> db -> where('_m.computer_soft_id>', 0);
			$this -> db -> where('c_s.is_delete', 0); 
			$this -> db -> where('c_s.is_ok', 1); 
			$this -> db -> where('_m.type', 0);

			$this -> db -> join("computer_soft c_s", "c_s.id = _m.computer_soft_id", "left");

		}
		$this -> db -> where('_m.computer_id', $computer_id);
		$this -> db -> order_by('id', 'asc');

		// query results
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}

	function find_by_computer_id($computer_id) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.computer_id', $computer_id);
		$this -> db -> where('_m.type', 0);
		$this -> db -> where('_m.is_ok', 1);
		$this -> db -> where('_m.is_delete', 0);
		// query results
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}

	function find_s_h_to_update($computer_id,$s_h_id,$type) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.computer_id', $computer_id);
		if($type==0){
			$this -> db -> where('_m.computer_soft_id', $s_h_id);
		}
		if($type==1){
			$this -> db -> where('_m.computer_hard_id', $s_h_id);
		}
		$this -> db -> where('_m.is_ok', 1);
		$this -> db -> where('_m.is_delete', 0);
		$this -> db -> where('_m.type', 0);

		// query results
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}


	function find_hard_soft_list($computer_id,$s_h_id,$type) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.computer_id', $computer_id);
		if($type==0){
			$this -> db -> where('_m.computer_soft_id', $s_h_id);
		}
		if($type==1){
			$this -> db -> where('_m.computer_hard_id', $s_h_id);
		}
		$this -> db -> where('_m.is_ok', 1);
		$this -> db -> where('_m.is_delete', 0);
		$this -> db -> where('_m.type', 1);

		// query results
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}

}
?>
