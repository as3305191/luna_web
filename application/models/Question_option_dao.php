<?php
class Question_option_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('question_option');
	}



	function query_ajax($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('qs.question_style_name as question_style_name');
		$this -> db -> select('qs.for_dep as for_dep');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		// $this -> db -> order_by('id', 'desc');
		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function search_always($data) {
		$this -> db -> where('_m.is_delete', 0);
		if(!empty($data['id'])){
			$this -> db -> where("_m.id", $data['id']);
		}
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("question_style qs", "qs.id = _m.question_style_id", "left");
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
		$this -> db -> where('_m.is_stop',0);

		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		// $this -> db -> order_by('_m.id', 'desc');
		$this -> db -> order_by('_m.open_date', 'asc');
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_open_question(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> select('qs.question_style_name as qs_name');
		$this -> db -> where('qs.for_dep', 0);

		$this -> db -> where('_m.is_close', 0);
		$this -> db -> where('_m.is_delete', 0);
		$this -> db -> join("question_style qs", "qs.id = _m.question_style_id", "left");
		$list = $this -> db -> get() -> result();
		return $list;
	}
	function find_all_open_question_for_dep(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> select('qs.question_style_name as qs_name');
		$this -> db -> where('qs.for_dep', 1);

		$this -> db -> where('_m.is_close', 0);
		$this -> db -> where('_m.is_delete', 0);
		$this -> db -> join("question_style qs", "qs.id = _m.question_style_id", "left");
		$list = $this -> db -> get() -> result();
		return $list;
	}


	function find_all_open_and_stop(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.status',1);
		// $this -> db -> where('_m.is_stop',0);

		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.open_date', 'asc');
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_open_menu($id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.status',1);
		$this -> db -> where('_m.id',$id);

		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.open_date', 'asc');
		$list = $this -> db -> get() -> result();
		if(count($list)>0){
			return $list[0];
		} else{
			return null;
		}
		
	}
	function find_all_open_without_stop(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.status',1);

		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.open_date', 'asc');
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_same_menu_name($data){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$menu_name = $data['menu_name'];
		$this -> db -> where("_m.menu_name like", "%$menu_name%");
		// $this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}
	function find_by_all_p($id) {

		// select
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');
		$this -> db -> select('u.user_name as user_name');
		$this -> db -> select('qa.*');
		$this -> db -> select('qs.question_style_name as question_style_name');
		$this -> db -> select('qs.id as qs_id');

		$this -> db -> join("users u", "u.id = _m.user_id", "left");
		$this -> db -> join("question_ans qa", "qa.question_option_id = _m.id", "left");
		$this -> db -> join("question_style qs", "qs.id = qo.question_style_id", "left");

		$this -> db -> where('_m.id',$id);
		
		$query = $this -> db -> get();
		return $query -> result();

	}
	function find_by_all_item($id) {

		// select
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');
		$this -> db -> select('u.user_name as user_name');
		$this -> db -> select('qa.*');
		$this -> db -> select('qs.question_style_name as question_style_name');
		$this -> db -> select('qs.id as qs_id');
		$this -> db -> select('d.name as dep_name');

		$this -> db -> join("users u", "u.id = _m.user_id", "left");
		$this -> db -> join("department d", "d.id = u.role_id", "left");
		$this -> db -> join("question_ans qa", "qa.question_option_id = _m.id", "left");
		$this -> db -> join("question_style qs", "qs.id = qo.question_style_id", "left");

		$this -> db -> where('_m.question_option_id',$id);
		
		$query = $this -> db -> get();
		return $query -> result();

	}
	function find_by_this_id($id) {

		// select
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');
		$this -> db -> select('qs.for_dep as for_dep');

		$this -> db -> join("question_style qs", "qs.id = _m.question_style_id", "left");

		$this -> db -> where('_m.id',$id);
		
		$query = $this -> db -> get();
		return $query -> result();

	}

}
?>
