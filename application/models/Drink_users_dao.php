<?php
class Drink_users_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('drink_users');

		$this -> alias_map = array(
			// 'store_name' => 'st.store_name'
		);
	}

	function find_user($area_num){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.area_num',$area_num);

		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}

}
?>
