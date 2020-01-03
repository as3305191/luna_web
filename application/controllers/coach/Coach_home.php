<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coach_home extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// $this->load->helper('captcha');

		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Corp_dao', 'corp_dao');
	}

	public function index() {
		$data = array();
		// $this -> to_json($data);
		$this -> load -> view('coach/coach_home', $data);
	}

	public function get_data() {
		$res = array();
		// $data = $this -> get_posts(array(
		// 	'length',
		// 	'start',
		// 	'columns',
		// 	'search',
		// 	'order',
		// ));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);

		$res['items'] = $this -> dao -> query_ajax_by_coach($s_data['login_user_id']);
		// $res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		// $res['recordsTotal'] = $this -> dao -> count_all_ajax($data);

		$this -> to_json($res);
	}

	public function logout() {
		$corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('coach/login');
	}

}
