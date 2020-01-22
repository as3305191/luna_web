<?php
class Push_msg_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('push_msg');

		$this -> alias_map = array(
			"company_name" => 'c.company_name',
			"fleet_name" => 'f.fleet_name'
		);
	}

	function find_all_by_member_id($member_id) {
		$this -> db -> where("member_id", $member_id);
		$this -> db -> order_by("id", "desc");
		$list = $this -> find_all();
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

	function search_always($data) {
		// $this -> db -> where('_m.status', 0);
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join("company c", "c.id = _m.company_id", "left");
		// $this -> db -> join("fleet f", "f.id = _m.fleet_id", "left");
	}


	function find_by_account($account) {
		$this -> db -> where('account', $account);
		$query = $this -> db -> get($this -> table_name);
		foreach ($query->result() as $row){
		    return $row;
		}
		return NULL;
	}

	function nav_list() {
		$this -> load -> model('Nav_dao', 'nav_dao');
		$lv1_list = $this -> nav_dao -> find_all_by_parent_id(0);
		$sub_list = $this -> nav_dao -> find_all_not_lv1();

		$map = array();
		foreach($lv1_list as $each) {
			$map[$each->id] = $each;
			$each -> sub_list = array();
		}

		// add sublist
		foreach($sub_list as $each) {
			if(isset($map[$each -> parent_id])) {
				$lv1 = $map[$each -> parent_id];
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


	function find_all_msg_by_member_id($member_id) {
		$this -> db -> select('_m.*,pl.title as pl_title,pl.message as pl_message');
		$this -> db -> where("_m.member_id", $member_id);
		$this -> db -> order_by("_m.id", "desc");
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join('push_log as pl','pl.id = _m.push_log_id','left');

		$list = $this -> db -> get() -> result();

		return $list;
	}
}
?>
