<?php
class Order_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('orders');
		$this -> alias_map = array(

		);
	}

	function query_by_station($f){
		// join
		$this -> ajax_from_join();

		$this -> db -> select('_m.id, _m.user_id, _m.status');

		$query = $this -> db -> get();
		$list = $query -> result();
		return $list;
	}

	// join
	function ajax_from_join() {
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("order_status os", "os.id = _m.status", "left");
		$this -> db -> join("users as uu", 'uu.id = _m.update_user_id', "left");

		// $this -> load -> model('order_station_dao', 'o_st_dao');
	}



	// api query
	function query_all($f , &$res = array()) {
		$this -> load -> model('Goods_transfer_dao', 'g_tr_dao');

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('m.image_id as member_image_id,m.user_name as member_name, m.currency_code as member_currency_code');
		$this -> db -> select('pc.image_id as place_image_id');

		// join
		$this -> ajax_from_join();
		// search always

		if(empty($f['no_limit'])) {
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
		}


		$res['page'] = $page;
		$res['limit'] = $limit;
		$start = $page * $limit;

		// limit
		if(empty($f['page_disable'])){
			$this -> db -> limit($limit, $start);
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
		$this -> db -> select('os.status_name');
		$this -> db -> select('uu.user_name as update_user_name');

		// $this -> db -> select('cl.lang_name');

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
		if(!empty($data['show_closed'])) {
			// $this -> db -> where('(_m.status = 0 or _m.status = 1 or )');
		} else {
			// $this -> db -> where('_m.status > -1');
		}

		if(!empty($data['id'])) {
			$this -> db -> where('_m.id', $data['id']);
		}

		if(!empty($data['lang'])) {
			$this -> db -> where('_m.lang', $data['lang']);
		}

		if(!empty($data['start_time'])) {
			$this -> db -> where('_m.start_time', $data['start_time']);
		}

		if(isset($data['status_filter'])) {
			$sf = $data['status_filter'];
			if($sf != 'all') {
				$this -> db -> where('_m.status', $sf);
			}
		}

		if(isset($data['status']) && $data['status'] > -2) {
			$this -> db -> where('_m.status', $data['status']);
		}
	}

}
?>
