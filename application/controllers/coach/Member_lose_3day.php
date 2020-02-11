<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_lose_3day extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// $this->load->helper('captcha');

		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Corp_dao', 'corp_dao');
		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Records_dao', 'records_dao');

	}

	public function index() {
		$data = array();
		$s_data = $this -> setup_user_data(array());
		$data['login_user'] = $this -> dao -> find_by_id($s_data['login_user_id']);
		$res['items'] = $this -> dao -> find_all_by_coach($s_data['login_user_id']);
		$data['p'] = count($res['items']);
		$data['page'] = ceil($data['p']/5);

		$data['now'] = 'member_lose_3day';

		// $this -> to_json($data);

		$this -> load -> view('coach/member_lose_3day', $data);
	}

	public function get_data() {
		$res = array();
		$id = $this -> get_post('id');
		$page = $this -> get_post('page');

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		if($page>1){
			$b=((int)$page-1)*5;
			$items = $this -> dao -> query_ajax_by_coach($login_user->code,$b);
			foreach ($items as $each) {
				$each -> last_weight = $this -> records_dao -> find_last_w_lose3day($each->id);
			}
			$res['items'] = $items;
			$res['count_items'] = count($res['items']);
		} else{
			$items= $this -> dao -> query_ajax_by_coach($login_user->code,1);
			foreach ($items as $each) {
				$each -> last_weight = $this -> records_dao -> find_last_w_lose3day($each->id);
			}
			$res['items'] = $items;

			$res['count_items'] = count($res['items']);
		}

		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data['account']= $this -> get_post('account');
		$data['password']= $this -> get_post('password');
		$data['email']= $this -> get_post('email');
		if(!empty($id)) {
			// insert


			$this -> dao -> update($data, $id);
		} else {
			// update
			// $this -> dao -> update($data, $id);
		}

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}


}
