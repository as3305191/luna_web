<?php
class Version_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('version');

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
		$this -> db -> join("product p", "p.id = _m.product_id", "left");

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('p.name');

		if(!empty($f['product_id'])) {
			$this -> db -> where('product_id', $f['product_id']);
		}

		$date = date('Y-m-d');
		$this -> db -> where('_m.start_time =',$date);

		$query = $this -> db -> get();
		// $this -> db -> last_query();
		$list = $query -> result();
		return $list;
	}



}
?>
