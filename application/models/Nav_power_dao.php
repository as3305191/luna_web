<?php
class Nav_power_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('nav_power');

		$this -> alias_map = array(

		);
	}

	function find_all_by_nav_id($nav_id) {
		$this -> db -> where('nav_id', $nav_id);
		$this -> db -> order_by('pos', 'asc');
		return $this -> find_all();
	}
}
?>
