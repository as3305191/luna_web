<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Order_dao', 'dao');
	
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		$data['thaw_list'] = $this -> dao -> find_all();
		$this->load->view('mgmt/order/list', $data);
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

		$thaw_list = $this -> dao -> find_all();

		$data['show_closed'] = "YES";
		$items = $this -> dao -> query_ajax($data);
		foreach($items as $each_item) {
			// $this -> check_product_expire($each_item, $thaw_list);
		}
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);

		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		//$this -> dao -> delete_status($id, $this -> session -> userdata('user_id'));
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	public function test_mail()
	{
		$this->send_mail("inf@kwantex.com", "hi..", "測試郵件");
	}
}
