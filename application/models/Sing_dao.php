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

		$this -> db -> select('m.menu_name as menu_name');
		$this -> db -> select('m.menu_style_id as menu_style_id');
		$this -> db -> select('u.user_name as user_name');

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
		if(!empty($data['menu_id']) && $data['menu_id']>0){
			$menu_id = $data['menu_id'];
			$this -> db -> where('_m.menu_id',$menu_id);
		}
		$this -> db -> where('_m.is_delete<',1);
		$this -> db -> where('_m.is_done<',1);
		$this -> db -> where('_m.user_id',$data['login_user_id']);
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("menu m", "m.id = _m.menu_id", "left");
		$this -> db -> join("users u", "u.id = _m.user_id", "left");
		// $this -> db -> join("roles r", "r.id = _m.role_id", "left");
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



	

}
?>
