<?php
class Daily_record_question_detail_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('daily_record_question_detail');

		$this -> alias_map = array(

		);

	}
	function query_ajax($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];
		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('q.content as question_name');
		$this -> db -> select('q.id as q_id');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('q.id', 'asc');

		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();

		// echo $this -> db -> last_query();
		return $query -> result();
	}
	function search_always($data) {
		$dt = $data['dt'];


		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$dt} 23:59:59' )");


	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("question q", "q.id = _m.question_id", "left");
	}
	function delete_by_value($f){
		$this -> db -> where('member_id',$f['member_id']);
		$this -> db -> where('daily_record_question_id',$f['daily_record_question_id']);
		$this -> db -> delete($this -> table_name);
	}

	function find_q_detail($id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("question q", "q.id = _m.question_id", "left");

		$this -> db -> select('_m.*');
		$this -> db -> select('q.content as question_name');
		$this -> db -> where("(_m.create_time >= '{$dt}' and _m.create_time <= '{$dt} 23:59:59' )");

		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}

}
?>
