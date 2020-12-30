<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Order_dao', 'dao');
		$this -> load -> model('Order_station_dao', 'order_station_dao');
		$this -> load -> model('Order_product_dao', 'order_product_dao');
		$this -> load -> model('Order_record_dao', 'or_dao');
		$this -> load -> model('Order_station_record_dao', 'osr_dao');
		$this -> load -> model('Order_sn_dao', 'order_sn_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Station_dao', 'station_dao');
		$this -> load -> model('Product_dao', 'product_dao');
		$this -> load -> model('Thaw_dao', 'thaw_dao');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		$data['thaw_list'] = $this -> thaw_dao -> find_all();
		$this->load->view('mgmt/orders/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'status',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);

		$thaw_list = $this -> thaw_dao -> find_all();

		$data['show_closed'] = "YES";
		$items = $this -> dao -> query_ajax($data);
		foreach($items as $each_item) {
			$this -> check_product_expire($each_item, $thaw_list);
		}
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);

		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$data['id'] = $id;

		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order'
			));

			$q_data['id'] = $id;
			$q_data['show_closed'] = "YES";
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];


			$data['item'] = $item;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/orders/edit', $data);
	}

	public function flow($id) {
		$data = array();
		$data['id'] = $id;

		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order'
			));

			$q_data['id'] = $id;
			$q_data['show_closed'] = "YES";
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			$data['item'] = $item;

			$order_station_list = $this -> order_station_dao -> find_by_value(array(
				'order_id' => $item -> id
			));
			foreach($order_station_list as $station) {
				$station -> or_product_list = $this -> or_dao -> find_group_product_all_by_order_and_station($item -> id, $station -> station_id);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 1);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list_0 = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 0);
			}
			$data['order_station_list'] = $order_station_list;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/orders/flow', $data);
	}

	public function flow_print($id) {
		$data = array();
		$data['id'] = $id;

		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order'
			));

			$q_data['id'] = $id;
			$q_data['show_closed'] = "YES";
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			$data['item'] = $item;

			$order_station_list = $this -> order_station_dao -> find_by_value(array(
				'order_id' => $item -> id
			));
			foreach($order_station_list as $station) {
				$station -> or_product_list = $this -> or_dao -> find_group_product_all_by_order_and_station($item -> id, $station -> station_id);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 1);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list_0 = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 0);
			}
			$data['order_station_list'] = $order_station_list;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/orders/flow_print', $data);
	}

	public function mail()
	{
		$this->send_mail("inf@kwantex.com", "hi..", "測試郵件");
	}
}
