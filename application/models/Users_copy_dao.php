<?php
class Users_copy_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('users_copy');

		$this -> alias_map = array(
		
		);
	}

	
}
?>
