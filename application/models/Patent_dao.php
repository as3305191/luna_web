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
		$this -> db -> select('_m.*');
		$this -> db -> where("_m.create_time like '{$date}%'");
		$this -> db -> order_by("_m.id","desc");

		$query = $this -> db -> get();
		$list = $query -> result();
		if(count($list)>0){
			if(!empty($list[0]->patent_family)){
				return $list[0]->patent_family;
			} else{
				return '0';
			}
		} else{
			return '0';
		}

		
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

	function query_ajax_export($data) {
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

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function search_always($data) {
		if(!empty($data['id'])){
			$id = $data['id'];
			$this -> db -> where("_m.id",$id);
		}
		if(!empty($data['application_person'])){
			$application_person = $data['application_person'];
			$this -> db -> where("_m.applicant like '%$application_person%'");
		}
		if(!empty($data['application_num'])){
			$application_num = $data['application_num'];
			$this -> db -> where("_m.application_num like '%$application_num%'");
		}
		if(!empty($data['invention_person_search'])){
			$invention_person_search = $data['invention_person_search'];
			$this -> db -> where("_m.inventor like '%$invention_person_search%'");
		}
		if(!empty($data['public_num_search'])){
			$public_num_search = $data['public_num_search'];
			$this -> db -> where("_m.public_num like '%$public_num_search%'");
		}
		
		if(!empty($data['patent_search'])){
			$patent_search = $data['patent_search'];
			$this -> db -> where("_m.patnet_num like '%$patent_search%'");
		}

		if(!empty($data['key_search'])){
			$key_search = $data['key_search'];
			$this -> db -> where("_m.patent_key like '%$key_search%'");
		}
		// if(!empty($data['summary_search'])){
		// 	$summary_search = $data['summary_search'];
		// 	$this -> db -> where("_m.id",$summary_search);
		// }
		if(!empty($data['now_category']) && $data['now_category']!=="all"){
			$category = $data['now_category'];
			$this -> db -> where("_m.patnet_category",$category);
		}
		
		// if(!empty($data['key_search'])){
		// 	$key_search = $data['key_search'];
		// 	$this -> db -> where("_m.id",$key_search);
		// }
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		// $this -> db -> join("roles r", "r.id = _m.role_id", "left");
	}


	function find_by_family($patent_family,$id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');

		$this -> db -> where("_m.patent_family",$patent_family);
		$this -> db -> where("_m.id<>",$id);

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}
}
?>
