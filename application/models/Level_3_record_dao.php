<?php
class Level_3_record_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('level_3_record');

		$this -> alias_map = array(

		);

	}


	// // join
	// function ajax_from_join() {
	// 	$this -> db -> from("$this->table_name as _m");
	// 	$this -> db -> join("orders o", "o.id = _m.order_id", "left");
	//
	// }

	function find_by_value($f){
		$this -> db -> from("$this->table_name as _m");

		// select
		$this -> db -> select('_m.*');

		if(!empty($f['member_id'])){
			$this -> db -> where('_m.member_id',$f['member_id']);
		}

		$startTime = date('Y-m-d 00:00:00');
		$endTime = date('Y-m-d 23:59:59');
		$this -> db -> where('_m.create_time >', $startTime);
		$this -> db -> where('_m.create_time <=', $endTime);

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}
		return NULL;
	}

	function query_ajax($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('m.user_name as user_name');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('id', 'desc');
		if(!empty($data['id'])){
		} else{
			$this -> db -> group_by('_m.member_id');
		}
		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();

		// echo $this -> db -> last_query();
		return $query -> result();
	}

	function export_all() {

	}

	function search_always($data) {
		if(!empty($data['dt'])){
			$dt = $data['dt'];
		}
		if(!empty($data['e_dt'])){
			$e_dt = $data['e_dt'];
		}
		if (!empty($data['user_name'])) {
			$user_name = $data['user_name'];
			if(strlen($user_name)>0){
				$this -> db -> where("m.user_name like'{$user_name}'");
			}
		}
		if(!empty($data['user_name']) && !empty($data['e_dt'])){
			$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$e_dt} 23:59:59' )");
		}

	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("members as m", 'm.id = _m.member_id', "left");
	}

}
?>
