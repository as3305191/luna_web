<?php
class Sing_uuid_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('sing_uuid');
	}
	
	function query_ajax($data,$is_count = FALSE) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];
		// select
		$this -> db -> select('_m.*');
		// $this -> db -> select('s.*');

		
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
		if(!empty( $data['s_date'])){
			$s_date =$data['s_date'];
			$this -> db -> where('_m.open_date',$s_date);
		}

	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");

	}

	function find_carousel(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> select('ms.menu_style as menu_style');
		$this -> db -> where('status',1);
		$this -> db -> where('_m.news_style_id<>',7);
		$this -> db -> where('_m.news_style_id<>',8);

		$this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_order_by_menu($id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.menu_id',$id);
		$this -> db -> where('_m.is_done<',1);
		$this -> db -> select('u.user_name as user_name');

		$this -> db -> join("users u", "u.id = _m.user_id", "left");
		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_by_all_this_menu($id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.menu_id',$id);
		$this -> db -> where('_m.is_done<',1);

		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}
	function find_active_sing(){
		$date = date('Y.m.d');
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.status',0);
		$this -> db -> where('_m.open_date',$date);

		$this -> db -> order_by('_m.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	function find_not_used($uuid){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.uuid',$uuid);
	
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function delete_all(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> delete();
		$this -> db -> where('_m.id>',0);

		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$list = $this -> db -> get() -> result();
		return $list;
	}
}
?>
