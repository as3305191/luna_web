<?php
class App_reg_code_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('app_reg_code');

		$this -> alias_map = array(

		);

	}

	// // join
	// function ajax_from_join() {
	// 	$this -> db -> from("$this->table_name as _m");
	// 	$this -> db -> join("orders o", "o.id = _m.order_id", "left");
	//
	// }

	function find_by_member_and_token($user_id, $token) {
		$this -> db -> where('member_id', $user_id);
		$this -> db -> where('token', $token);
		$list = $this -> find_all();
		return $list;
	}

	function delete_by_token($token,$user_id)  {
		$this -> db -> delete('app_reg_code', array('token' => $token,'member_id<>' => $user_id));
	}

	function find_by_member($user_id) {
		$this -> db -> where('member_id', $user_id);
		$list = $this -> find_all();

		if (count($list) > 0) {
			return $list[0];
		}
		return NULL;
	}



	function find_all_by_member_id($user_id) {
		$this -> db -> where('member_id', $user_id);
		$list = $this -> find_all();
		return $list;
	}

	function find_all_by_member_id_new($user_id) {
		$this -> db -> where('member_id', $user_id);
		$list = $this -> find_all();
		return $list;
	}


}
?>
