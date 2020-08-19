<?php
class User_msg_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('user_msg');

		$this -> alias_map = array(

		);

	}

	function find_record($data) {

		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');

		if(!empty($data['user_id']) && !empty($data['to_user_id'])){
		
			$this -> db -> group_start();
			$this -> db -> where("_m.user_id", $data['user_id']);
			$this -> db -> where("_m.to_user_id", $data['to_user_id']);
			$this -> db -> or_group_start();
			$this -> db -> where("_m.user_id", $data['to_user_id']);
			$this -> db -> where("_m.to_user_id", $data['user_id']);
			$this -> db -> group_end();
			$this -> db -> group_end();

			$this -> db -> order_by("_m.create_time", "asc");
			$this -> db -> order_by("_m.id", "asc");
		}
		
		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}
}
?>
