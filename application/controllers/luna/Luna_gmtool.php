<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Luna_gmtool extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// $this->load->helper('captcha');

		$this->load->model('/luna/Members_dao', 'dao');
	}

	public function index() {
		if(empty($this->session->userdata('user_id'))) {
			redirect("/luna/login");
			return;
		} else{
			if(!empty($this->session->userdata('user_id')) && $this->session->userdata('userlv')!=='2') {
				redirect("/luna/luna_home");
				return;
			}
		}
		$data = array();
		$s_data = $this -> setup_user_data(array());
		$data['login_user'] = $this -> dao -> find_by_id($s_data['login_user_id']);
		// $res['items'] = $this -> dao -> find_all_by_luna($data['login_user']->code);
		// $data['p'] = count($res['items']);
		// $data['page'] = ceil($data['p']/10);
		$data['now'] = 'luna_gmtool';
		// $this -> to_json($data);
		$this -> load -> view('luna/luna_gmtool', $data);
	}

	public function get_data() {
		$res = array();
		$id = $this -> get_post('id');
		$page = $this -> get_post('page');

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		if($page>1){
			$b=((int)$page-1)*5;
			$items = $this -> dao -> query_ajax_by_luna($login_user->code,$b);
			foreach ($items as $each) {
				$each -> last_weight = $this -> records_dao -> find_last_weight($each->id);
			}
			$res['items'] = $items;
			$res['count_items'] = count($res['items']);
		} else{
			$items= $this -> dao -> query_ajax_by_luna($login_user->code,1);
			foreach ($items as $each) {
				$each -> last_weight = $this -> records_dao -> find_last_weight($each->id);
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

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('luna/login');
	}

}
