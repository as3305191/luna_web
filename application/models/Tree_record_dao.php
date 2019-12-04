<?php
class Tree_record_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('tree_record');

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



}
?>
