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
			$this -> db -> where("_m.from_user_id", $data['user_id']);
			$this -> db -> where("_m.to_user_id", $data['to_user_id']);
			$this -> db -> or_group_start();
			$this -> db -> where("_m.from_user_id", $data['to_user_id']);
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

	function find_not_read($my_id,$to_id) {

		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.to_user_id", $my_id);
		$this -> db -> where("_m.from_user_id", $to_id);
		$this -> db -> where("_m.status",0);
		$query = $this -> db -> get();
		$list = $query -> result();

		return count($list);
	}

	function find_by_me_no_read($my_id,$to_id) {

		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.to_user_id", $my_id);
		$this -> db -> where("_m.from_user_id", $to_id);
		$this -> db -> where("_m.status",0);
		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_last_message($data) {
		$from_user_id = $data['me_id'] ;
		$to_user_id = $data['to_message_id'];
		$content = $data['message'];
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.id');
		$this -> db -> where("_m.from_user_id", $from_user_id);
		$this -> db -> where("_m.to_user_id", $to_user_id);
		$this -> db -> where("_m.content",$content);
		$this -> db -> order_by("_m.create_time", "desc");

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}
}
?>
