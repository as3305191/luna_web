<?php
class Ketone_record_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('ketone_record');

		$this -> alias_map = array(

		);
	}

	function find_by_parameter($f){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("ketone k", "k.id = _m.ketone_id", "left");


		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('k.value,k.color,k.r,k.g,k.b');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$this -> db -> where('_m.is_delete',0);


		$this -> db -> order_by("id", "desc");

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

	function find_by_one($f){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("ketone k", "k.id = _m.ketone_id", "left");


		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('k.value,k.color,k.r,k.g,k.b');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$this -> db -> where('_m.is_delete',0);
		$this -> db -> order_by("id", "desc");


		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;

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

}
?>
