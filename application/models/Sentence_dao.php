<?php
class Sentence_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('sentence');

		$this -> alias_map = array(

		);

	}

	function find_by_value(){
		$this -> db -> from("$this->table_name as _m");
		// select
		$this -> db -> select('_m.*');
		$this -> db -> order_by('rand()');
	 	$this -> db -> limit(1);

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$row = $query -> row();
			return $row;
		}

		return NULL;
	}

}
?>
