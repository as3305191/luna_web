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
			// redirect("/app/#mgmt/news");
			return;
		}
		$this -> load -> view('coach/login', $data);
	}

	public function do_login() {
		$res = array();
		$corp_id = $this -> get_post('corp_id');
		$corp = $this -> corp_dao -> find_by_id($corp_id);

		// update session
		$this -> session -> set_userdata('corp', $corp);

		$account = $this -> get_post('account');
		$password = $this -> get_post('password');
		// $captcha = $this -> get_post('captcha');
		if (!empty($account) && !empty($password) ) {
			$user = $this -> users_dao -> find_by('account', $account);
			$find_status = $this -> users_dao -> find_by_status1($account);
			if (!empty($user) && $user -> password == $password) {
				if($find_status[0]-> type==1){
					$this -> session -> set_userdata('user_id', $user -> id);
					// $this -> session -> set_userdata("s_uid", $s_uid);
					$this -> users_dao -> update(array('token' => $s_uid), $user -> id);
				} else {
					$res['msg'] = "您不是教練喔！";
				}
			} else {
				$res['msg'] = "帳號或密碼錯誤";
			}

		} else {
			$res['msg'] = "請輸入必填資料";
		}

		$this -> to_json($find_status);
	}


	public function logout() {
		$corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('coach/login');
	}

}
