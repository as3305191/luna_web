<?php
class User_online_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('user_online');

		$this -> alias_map = array(
		
		);
	}

	function find_me_is_online_or_not($user_id) {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.id",1);
		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

}
?>
