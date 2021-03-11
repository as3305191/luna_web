<?php
class Terms_of_service_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('terms_of_service');

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
		$this -> db -> where('_m.status', 0);
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join("product_cate as pc1", 'pc1.id = _m.cate_1', 'left');
		// $this -> db -> join("product_cate as pc2", 'pc2.id = _m.cate_2', 'left');
	}

	function find_by_account($account) {
		$this -> db -> where('account', $account);
		$query = $this -> db -> get($this -> table_name);
		foreach ($query->result() as $row){
		    return $row;
		}
		return NULL;
	}

	function query_all($f, &$res = array()) {
		// select
		$this -> db -> select('_m.*');
		// $this -> db -> select('pc1.cate_name as cate_1_name');
		// $this -> db -> select('pc2.cate_name as cate_2_name');

		// join
		$this -> ajax_from_join();

		// if(!empty($f['cate_id'])) {
		// 	$this -> db -> where('_m.cate_2', $f['cate_id']);
		// }
		// if(!empty($f['cate_1'])) {
		// 	$this -> db -> where('_m.cate_1', $f['cate_1']);
		// }
		// if(!empty($f['cate_2'])) {
		// 	$this -> db -> where('_m.cate_2', $f['cate_2']);
		// }
		if(!empty($f['no_hidden'])) {
			$this -> db -> where('_m.hidden', 0);
		}
		$this -> db -> order_by('_m.id', 'desc');

		// search always
		$this -> search_always($f);

		// limit
		if(empty($f['page'])) {
			$page = 0;
		} else {
			$page = intval($f['page']);
		}

		if(empty($f['limit'])) {
			// default is 10
			$limit = 10;
		} else {
			$limit = intval($f['limit']);
		}

		$res['page'] = $page;
		$res['limit'] = $limit;

		$start = $page * $limit;
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();
		$list = $query -> result();

		foreach($list as $each) {
			if(!empty($each -> image_id)) {
				$each -> image_url = get_img_url($each -> image_id);
				$each -> thumb_url = get_thumb_url($each -> image_id);
			}
		}
		return $list;
	}


	//front
	function count_paging_with_query_and_date($columns) {
		//$this -> column_setup($columns);
		$this -> db -> from($this -> table_name);
		return $this -> db -> count_all_results();
	}

	function find_paging_with_query_and_date($start, $limit, $columns) {
		//$this -> column_setup($columns);
		$this -> db -> limit($limit, $start);
		$this -> db -> order_by("id", isset($dir) ? $dir : "desc");
		$query = $this -> db -> get($this -> table_name);
		return $query -> result();
	}

	function find_max_id(){
		$this->db->select_max('id');
		$res1 = $this->db->get($this->table_name);
		$res2 = $res1->result_array();
		$result = $res2[0]['id'];

		if($result){
			return $result;
		}else{
			return 0;
		}
	}

}
?>
