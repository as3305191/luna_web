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
		$urlArr=$_SERVER['REQUEST_URI'];
		if($urlArr=="menu_order"){
			$data['menu_order']=$urlArr;
			if(!empty($this -> session -> userdata('user_id'))) {
				redirect("/app/#mgmt/message");
				return;
			}
		} else{
			$data['menu_order']=$urlArr;
			if(!empty($this -> session -> userdata('user_id'))) {
				redirect("/app/#mgmt/message");
				return;
			}
		}
		
		$data = $this -> get_captcha($data);
		$data['num'] = rand(1,3);
		// $this -> to_json($data);

		$this -> load -> view('loginv', $data);
	}

	public function do_login() {
		$res = array();
		$corp_id = $this -> get_post('corp_id');
		$corp = $this -> corp_dao -> find_by_id($corp_id);

		// update session
		$this -> session -> set_userdata('corp', $corp);
	
		$account = $this -> get_post('account');
		$password = $this -> get_post('password');
		$captcha = $this -> get_post('captcha');
		if (!empty($account) && !empty($password) && !empty($captcha)) {
			$captcha_word = $this -> session -> userdata('captcha_word');
			if($captcha == $captcha_word) {
				$user = $this -> users_dao -> find_by('account', $account);
				$find_status = $this -> users_dao -> find_by_status1($account);
				if (!empty($user) && $user -> password == $password && $find_status[0]-> status==0) {
					$this -> session -> set_userdata('user_id', $user -> id);
					$uniqueId = uniqid(rand(), TRUE);
					$s_uid = md5($uniqueId);
					$this -> session -> set_userdata("s_uid", $s_uid);
					$this -> users_dao -> update(array('token' => $s_uid), $user -> id);
				} else {
					$res['msg'] = "帳號或密碼錯誤";
				}
			} else {
				$res['msg'] = "驗證碼錯誤";
			}
		} else {
			$res['msg'] = "請輸入必填資料";
		}
		$this -> to_json($res);
	}

	function get_captcha($data) {
		// numeric random number for captcha
		$random_number = substr(number_format(time() * rand(),0,'',''),0,4);
		// setting up captcha config

		$vals = array(
			 'word' => $random_number,
			 'img_path' => './img/captcha/',
			 'img_url' => base_url().'img/captcha/',
			 'img_width' => 140,
			 'img_height' => 32,
			 'expiration' => 7200,
			 'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
      		  )
			);

		$data['captcha'] = create_captcha($vals);
		// if(is_null($data['captcha'][0]->word)){
		// 	$this->session->set_userdata('captcha_word',$random_number);

		// } else{
		// 	$this->session->set_userdata('captcha_word',$data['captcha']['word']);
		// }
		$this->session->set_userdata('captcha_word',$data['captcha']['word']);

		return $data;
	}

	public function refresh_captcha() {
		$data = $this -> get_captcha(array());
		$this -> to_json($data);
	}

	public function logout() {
		$corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('/login');
	}

}
