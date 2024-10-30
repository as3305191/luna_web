<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this->load->helper('captcha');

		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Corp_dao', 'corp_dao');
	}

	public function index() {
		$data = array();
		// check login
		if(!empty($this -> session -> userdata('user_id'))) {
			redirect("/old_system_view/coach_home");
			return;
		}
		$this -> load -> view('old_system_view/login', $data);
	}

	public function do_login() {
		$res = array();

		$account = $this -> get_post('account');
		$password = $this -> get_post('password');
		if (!empty($account) && !empty($password) ) {
			$user = $this -> dao -> find_by('account', $account);
			if (!empty($user) && $user -> password == $password) {
				$this -> session -> set_userdata('user_id', $user -> id);
			} else {
				$res['msg'] = "帳號或密碼錯誤";
			}

		} else {
			$res['msg'] = "請輸入必填資料";
		}

		$this -> to_json($res);
	}

	public function do_login_app($id) {
		$user = $this -> dao -> find_by_id($id);
		if($user-> type == 1){
			$this -> session -> set_userdata('user_id', $user -> id);
			redirect("/old_system_view/old_system_view_home");
		} else {
			echo "You Are Not Coach!!!";
		}
	}

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('old_system_view/login');
	}

}
