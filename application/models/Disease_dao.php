<?php
class Disease_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('disease');
	}

	function find_by_parameter($f){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');

		$this -> db -> order_by("_m.level", 'asc');
		$this -> db -> order_by("_m.id", 'asc');

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}





}
?>
