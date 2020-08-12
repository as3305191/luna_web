<?php
class Customs_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('customs');

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
		$this -> db -> select('_m.*,cc.cate_name as cate_name,u.user_name as applicant_name,u1.user_name as principal_name');
		// $this -> db -> where('_m.corp_id',$data['corp_id']);

		if(isset($data['custom_cate'])){
			if(!empty($data['custom_cate'])){
				if($data['custom_cate'] == 'all'){

				}else{
					$this -> db -> where('_m.cate',$data['custom_cate']);
				}
			}
		}

		if(isset($data['fin_audit_status'])){
				if($data['fin_audit_status'] == 'all'){

				}else{
					$this -> db -> where('_m.fin_audit_status',$data['fin_audit_status']);
				}
		}

		if(isset($data['key_word'])){
			if(!empty($data['key_word'])){
				if($data['key_word_type'] == 1){
					$this -> db -> like('_m.code',$data['key_word']);
				}else if($data['key_word_type'] == 2){
					$this -> db -> like('_m.name_cn',$data['key_word']);
					$this -> db -> or_like('_m.name_en',$data['key_word']);
				}else if($data['key_word_type'] == 3){
					$this -> db -> like('u.user_name',$data['key_word']);
				}else if($data['key_word_type'] == 4){
					$this -> db -> like('u1.user_name',$data['key_word']);
				}else{
					$this -> db -> like('_m.code',$data['key_word']);
				}
			}
		}


	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join('custom_cate as cc','_m.cate = cc.id','left');
		$this -> db -> join('users as u','u.id = _m.applicant','left');
		$this -> db -> join('users as u1','u1.id = _m.principal','left');
		// $this -> db -> join("corp as co", 'st.id = _m.store_id', 'left');
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
		// $this -> db -> select('st.store_name as store_name');
		// join
		$this -> ajax_from_join();

		if(!empty($f['id'])) {
			$this -> db -> where('_m.id', $f['id']);
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

	//override
	function ajax_column_setup($columns, $search, $alias_map) {
		// search
		foreach($columns as $col) {
			if(!empty($col['search']['value'])) {
				if($col['data'] == 'mul_cate'){
					$mul_cate_val = explode(',',$col['search']['value']);
					foreach($mul_cate_val as $each){
						//** key step
							$this -> db -> where("FIND_IN_SET('$each',_m.main_cate) <>", 0);
					}

				}else{
					$col_name = $col['data'];
					$this -> db -> like($this -> get_alias_val($alias_map, $col_name), $col['search']['value']);
				}

			}
		}
	}

	//複製商品 檔名用
	function find_copy($product_name){
		$this -> db -> like('product_name',$product_name,'after');
		$this -> db -> order_by('create_time','desc');
		return $this -> find_exists_all();
	}

	function find_all_alive(){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('status',0);
		$this -> db -> where('FIN_audit_status','1');
		$list = $this -> db -> get() -> result();

		return $list;
	}

	function find_by_code($code,$id){
		$this -> db -> from("$this->table_name");
		$this -> db -> where('code', $code);
		$this -> db -> where('id <>',$id);
		$this -> db -> where('FIN_audit_status','1');
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}

	function find_row($id){
		$this -> db -> from("$this->table_name");
		$this -> db -> where('id', $id);
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list[0];
	}

	function find_cate($f) {
		$this -> db -> from("custom_cate");
		$this -> db -> where('id',$f);
		$query = $this -> db -> get();
		$list = $query -> result();
		return $list[0];
	}

	public function check_code($code){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('status',0);
		$this -> db -> where('code',$code);
		$list = $this -> db -> get() -> result();

		return $list;
	}

	public function find_all_custom_name_by_cate($name,$value){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('status',0);
		$this -> db -> where('FIN_audit_status','1');
		$this -> db -> where($name,$value);
		$list = $this -> db -> get() -> result();

		return $list;
	}
}
?>
