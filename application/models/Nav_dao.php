<?php
class Nav_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('nav');
		
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
		$this -> db -> order_by('id', 'desc');
		
		// limit
		$this -> db -> limit($limit, $start);
		
		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function search_always($data) {
		
		if(!empty($data['parent_id'])) {
			$this -> db -> where('_m.parent_id', $data['parent_id']);
		} else {
			$this -> db -> where('_m.parent_id', 0);
		}
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
	}
	
	function find_by_account($account) {
		$this -> db -> where('account', $account);
		$query = $this -> db -> get($this -> table_name);
		foreach ($query->result() as $row){
		    return $row;
		}
		return NULL; 
	}
	
	function query_all($f) {
		$this -> db -> select('id, parent_id, cate_name, image_id');
		$this -> db -> from($this -> table_name);
		
		if(isset($f['parent_id'])) {
			$this -> db -> where('parent_id', $f['parent_id']);
		}
		
		$query = $this -> db -> get();
		$list = $query -> result();
		foreach($list as $each) {
			if(!empty($each -> image_id)) {
				$each -> image_url =  get_img_url($each -> image_id);
				$each -> thumb_url =  get_thumb_url($each -> image_id);
			}
		}
		return $list;
	}
	
	function find_all_by_parent_id($parent_id) {
		$this -> db -> where('parent_id', $parent_id);
		$this -> db -> order_by('pos', 'asc');
		return $this -> find_all();
	}

	function find_all_not_lv1() {
		$this -> db -> where("parent_id <> 0");
		$this -> db -> order_by('pos', 'asc');
		return $this -> find_all();
	}
}
?>