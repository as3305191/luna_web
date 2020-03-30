<?php
class News_private_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('news_private');

		$this -> alias_map = array(

		);
	}

	function find_by_parameter($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])) {
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$this -> db -> where('_m.is_delete', 0);
		$this -> db ->order_by("_m.create_time", "desc");

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

	function find_unread($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		// $this -> db -> select('_m.*');
		$this -> db -> select('count(_m.id) as count');

		if(!empty($f['member_id'])) {
			$this -> db -> where('_m.member_id',$f['member_id']);
		}
		$this -> db -> where('_m.is_delete', 0);
		$this -> db -> where('_m.is_read',0);

		$query = $this -> db -> get();
		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;

		// $query = $this -> db -> get();
		// $list = $query -> result();
		//
		// return $list;
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
		if(isset($data['user_role_id']) && $data['user_role_id'] > -1) {
			$this -> db -> where('user_role_id', $data['user_role_id']);
		}
		if(isset($data['role_id']) && $data['role_id'] > -1) {
			$this -> db -> where('_m.role_id', $data['role_id']);
		}

		if(isset($data['corp_id']) && $data['corp_id'] > -1) {
			$this -> db -> where('_m.corp_id', $data['corp_id']);
		}

		if(isset($data['id']) && $data['id'] > -1) {
			$this -> db -> where('_m.id', $data['id']);
		}
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join("users mu", "mu.id = _m.manager_id", "left");
		// $this -> db -> join("users iu", "iu.id = _m.intro_id", "left");
		// $this -> db -> join("roles r", "r.id = _m.role_id", "left");
	}

}
?>
