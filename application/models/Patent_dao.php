<?php
class Patent_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('patent');

		$this -> alias_map = array(
		
		);
	}

	function find_patent($data){
		$this -> db -> from("$this->table_name as _m");

		if(!empty($data['keyword'])){
			$keyword = $data['keyword'];
			$this -> db -> where("_m.patent_name like '%$keyword%'");
		}

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_by_all_today_add(){
		$date = date('Y-m-d');
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> where("_m.create_time like '{$date}%'");

		$query = $this -> db -> get();
		$list = $query -> result();

		return count($list);
	}

}
?>
