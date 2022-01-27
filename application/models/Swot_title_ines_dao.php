<?php
class Swot_title_ines_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('swot_title_ines');

		$this -> alias_map = array(
			// 'store_name' => 'st.store_name'
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
		// $this -> db -> select('st.store_name as store_name');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);
		
		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('_m.id', 'desc');

		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function search_always($data) {
		// $this -> db -> where('_m.status', 0);
		// $this -> db -> select('_m.*,cc.cate_name as cate_name,u.user_name as applicant_name,u1.user_name as principal_name');
		// $this -> db -> where('_m.corp_id',$data['corp_id']);
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join('custom_cate as cc','_m.cate = cc.id','left');
		// $this -> db -> join('users as u','u.id = _m.applicant','left');
		// $this -> db -> join('users as u1','u1.id = _m.principal','left');
		// $this -> db -> join("corp as co", 'st.id = _m.store_id', 'left');
 	}

}
?>
