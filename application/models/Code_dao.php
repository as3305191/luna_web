<?php
class Code_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('code');

		$this -> alias_map = array(

 		);
	}

	function query_ajax($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];

		// // select
		// $this -> db -> select('_m.*');
		// $this -> db -> select('st.type_name');

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
		// $this -> where_isset($data, "type_id", "_m.type");
		// $this -> where_isset($data, "id", "_m.id");
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join("station_type as st", 'st.id = _m.type', "inner");
	}


	function get_val($key) {
		$item = $this -> find_by_id(1);
		return $item -> $key;
	}

	function get_val_by_corp($key, $corp) {
		$item = $this -> get_item_by_corp($corp);
		return $item -> $key;
	}

	function get_item() {
		$item = $this -> find_by_id(1);
		return $item;
	}


}
?>
