<?php
class Ktx_drink_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('ktx_drink');
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

	function find_user($area_num){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> wwhere('_m.area_num',$area_num);

		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}



}
?>
