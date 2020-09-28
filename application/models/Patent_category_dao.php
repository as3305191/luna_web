<?php
class Patent_category_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('patent_category');

		$this -> alias_map = array(

		);
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
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
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
}
?>
