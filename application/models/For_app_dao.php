<?php
class For_app_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('for_app');

		$this -> alias_map = array(

		);

	}

}
?>
