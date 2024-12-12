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

	function find_ordered($area,$dep){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.id');
		$this -> db -> where('_m.area',$area);
		$this -> db -> where('_m.dep',$dep);

		$query = $this -> db -> get();
		$list = $query -> result();
		if(count($list)>0){
			return $list[0];
		}else{
			return NULL;
		}
	}



}
?>
