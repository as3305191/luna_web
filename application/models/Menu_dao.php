<?php
class Menu_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('menu');

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
		$this -> db -> select('ms.menu_style as style_name');

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

		if(!empty($data['s_menu_style'])){
			$this -> db -> where("_m.menu_style_id", $data['s_menu_style']);
		}

		if(!empty($data['s_menu_name'])){
			$this -> db -> where("_m.menu_style_id", $data['s_menu_name']);
		}
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("menu_style ms", "ms.id = _m.menu_style_id", "left");
		// $this -> db -> join("images img", "img.id = _m.img_id", "left");
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

	function find_all_open(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.status',1);
		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}
	function find_all_open_menu($id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.status',1);
		$this -> db -> where('_m.id',$id);

		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list[0];
	}


	
}
?>
