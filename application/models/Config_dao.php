<?php
class Config_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('config');

		$this -> alias_map = array(

 		);
	}

	function get_val($key) {
		$item = $this -> find_by_id(1);
		return $item -> $key;
	}

	function get_val_by_corp($key, $corp) {
		$item = $this -> get_item_by_corp($corp);
		return $item -> $key;
	}

	function get_item() {
		$item = $this -> find_by_id(1);
		return $item;
	}
}
?>
