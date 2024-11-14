<?php
class Sing_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('sing');
	}
	
	function query_ajax($data,$is_count = FALSE) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('s_s.*');

		
		// $this -> db -> select('ss.');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('_m.id', 'desc');

		// limit
		// $this -> db -> limit($limit, $start);
		if(!$is_count) {
			$this -> db -> limit($limit, $start);
		}
		
		if(!$is_count) {
			$query = $this -> db -> get();
			return $query -> result();
		} else {
			return $this -> db -> count_all_results();
		}
	}

	function search_always($data) {
		
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("sing_status s_s", "s_s.sing_id = _m.id", "left");
	}

	function find_gave($data){
		$uuid = $data['uuid'];
		$sing_status_id = $data['sing_status_id'];
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.uuid',$uuid);
		$this -> db -> where('_m.sing_status_id',$sing_status_id);

		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}

}
?>
