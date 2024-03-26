<?php
class Question_ans_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('question_ans');

		$this -> alias_map = array(

		);
	}

	function find_by_parameter($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		//	limit
		if(empty($f['page'])) {
			$page = 0;
		} else {
			$page = intval($f['page']);
		}
		if(empty($f['limit'])) {
			// default is 10
			$limit = 10;
		} else {
			$limit = intval($f['limit']);
		}
		$start = $page * $limit;
		$this -> db -> limit($limit, $start);

		$query = $this -> db -> get();
		$list = $query -> result();

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
		$this -> db -> select('ns.news_style as news_style');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('sort', 'desc');

		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function search_always($data) {
		if(isset($data['s_news_style']) && $data['s_news_style'] > 0) {
			$this -> db -> where('ns.id', $data['s_news_style']);
		}
		if(isset($data['id']) && $data['id'] > 0) {
			$this -> db -> where('_m.id', $data['id']);
		}
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		// $this -> db -> join("users iu", "iu.id = _m.intro_id", "left");
		// $this -> db -> join("roles r", "r.id = _m.role_id", "left");
	}

	function find_carousel(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> select('ns.news_style as news_style_name');
		$this -> db -> where('status',1);
		$this -> db -> where('_m.news_style_id<>',7);
		$this -> db -> where('_m.news_style_id<>',8);

		$this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_carousel_sales(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> select('ns.news_style as news_style_name');
		$this -> db -> where('status',1);
		$this -> db -> where('_m.news_style_id',7);
		$this -> db -> or_where('_m.news_style_id',8);
		$this -> db -> join("news_style ns", "ns.id = _m.news_style_id", "left");
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_not_write($user_id,$question_option_id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('user_id',$user_id);
		$this -> db -> where('question_option_id',$question_option_id);
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_last_cost(){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('news_style_id',1);
		$this -> db -> order_by('_m.id', 'desc');
		$list = $this -> db -> get() -> result();
		return $list;
	}
	
	function query_news($data,$is_count = FALSE) {
		$start = $data['start'];
		$limit = $data['length'];

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('ns.news_style as news_style');

		$this -> ajax_from_join();

		$this -> search_always($data);
		// $this -> db -> join("users u", "u.id = _m.fix_user_id", "left");
		$this -> db -> where("_m.news_style_id <>","1");
		$this -> db -> where("_m.news_style_id <>","7");
		$this -> db -> where("_m.news_style_id <>","8");
		if(!$is_count) {
			$this -> db -> limit($limit, $start);
		}
		// query results
		if(!$is_count) {
			$query = $this -> db -> get();
			return $query -> result();
		} else {
			return $this -> db -> count_all_results();
		}
	}

	function find_all_not_finish($data, $is_count = FALSE) {

		$start = $data['start'];
		$limit = $data['length'];
		$item_id = $data['item_id'];
		// select
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');
		$this -> db -> select('u.user_name as user_name');
		// $this -> db -> select('u.user_name as user_name');
		// $this -> db -> select('m.menu_name as menu_name');
		// $this -> db -> select('m.menu_style_id as menu_style_id');
		// $this -> db -> where('_m.user_id <>',$data['login_user_id']);
		$this -> db -> join("users u", "u.id = _m.user_id", "left");
		// $this -> db -> join("menu m", "m.id = _m.menu_id", "left");
		
		
		if(!$is_count) {
			$this -> db -> limit($limit, $start);
		}
		
		$this -> db -> where('_m.question_option_id',$item_id);
		
		// $this -> db -> order_by('_m.id','desc');

		// query results
		if(!$is_count) {
			$query = $this -> db -> get();
			return $query -> result();
		} else {
			return $this -> db -> count_all_results();
		}

	}
}
?>
