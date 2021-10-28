<?php
class Swot_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('swot');

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
		$this -> db -> select('s_s.swot_name as s_style_name');
		$this -> db -> select('s_t.swot_title as s_title_name');
		$this -> db -> select('d.name as d_or_c_name');
		$this -> db -> select('d.swot_pos as swot_pos');
		$this -> db -> select('s_t.is_lock as s_t_is_lock');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		// $this -> db -> order_by('id', 'desc');
		$this -> db -> order_by('swot_pos', 'asc');

		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();
		return $query -> result();

	}

	function query_ajax_export($data) {

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('s_s.swot_name as s_style_name');
		$this -> db -> select('s_t.swot_title as s_title_name');
		$this -> db -> select('s_t.is_lock as s_t_is_lock');
		$this -> db -> select('d.swot_pos as swot_pos');

		$this -> db -> select('d.name as d_or_c_name');
		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		$this -> db -> order_by('swot_pos', 'asc');

		// limit

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("swot_style s_s", "s_s.id = _m.swot_style_id", "left");
		$this -> db -> join("swot_title s_t", "s_t.id = _m.title", "left");
		$this -> db -> join("department d", "d.id = _m.class_id", "left");

	}

	function search_always($data) {
		if(!empty($data['title'])){
			$title = $data['title'];
			$this -> db -> where("_m.title",$title);
		} 
		if(!empty($data['style'])){
			$list_style = $data['style'];
			$this -> db -> where("_m.swot_style_id",$list_style);
		}
		if(!empty($data['id'])){
			$id = $data['id'];
			$this -> db -> where("_m.id",$id);
		}
		if(!empty($data['login_user'])){
			if( $data['login_user']->role_id==6 || $data['login_user']->role_id==9 || 
				$data['login_user']->role_id==16 || $data['login_user']->role_id==17 ){
			} else{
				$login_user_array = $data['login_user_array'];
				$this -> db -> where("_m.role_id IN ($login_user_array)");
			}
		}
		if(!empty($data['list_title'])){
			$list_title = $data['list_title'];
			$this -> db -> where("_m.title",$list_title);
		}
		if(!empty($data['d_or_c'])){
			$d_or_c = $data['d_or_c'];
			$this -> db -> where("_m.role_id",$d_or_c);
			$this -> db -> or_where("_m.class_id",$d_or_c);

		}
		if(!empty($data['list_style'])){
			$list_style = $data['list_style'];
			$this -> db -> where("_m.swot_style_id",$list_style);
		}
		if(!empty($data['dep'])){
			$dep = $data['dep'];
			$this -> db -> where("_m.role_id",$dep);
		}
		if(!empty($data['unify'])&&$data['unify']==1){
			$unify = $data['unify'];
			$this -> db -> where("_m.unify<>",$unify);
		}
		
		$this -> db -> where("_m.is_delete",'0');
	}

	function find_all_by_me($user_id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> where('_m.is_use_user_id',$user_id);
		$list = $this -> db -> get() -> result();
		return $list;
	}
}
?>
