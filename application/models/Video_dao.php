<?php
class Video_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('video');

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
		if(!empty($f['video_id'])){
			$this -> db -> where('_m.id',$f['video_id']);
		}

		$query = $this -> db -> get();
		// $this -> db -> last_query();
		$list = $query -> result();
		return $list;
	}



}
?>
