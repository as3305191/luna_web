<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this->load->helper('captcha');

		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Corp_dao', 'corp_dao');
		$this -> load -> model('Department_dao','d_dao');

	}

	public function index() {
		$data = array();
		// check login
		
		if(!empty($this -> session -> userdata('user_id'))) {
			// $data = $this -> setup_user_data($data);
			// $user = $this -> users_dao -> find_by_id($data['user_id']);

			// if($user->role_id>2){
			// 	if($user_role_list->level==0){//公司
			// 		redirect("/app/#mgmt/menu_order");
			// 		return;
			// 	}
			// 	if($user_role_list->level==1){//總經理
			// 		redirect("/app/#mgmt/menu_order");
			// 		return;
			// 	}
			// 	if($user_role_list->level==2){//副總
			// 		redirect("/app/#mgmt/menu_order");
			// 		return;
			// 	}
			// 	if($user_role_list->level==3){//部門
			// 		$user_role_list_lv3 = $this -> d_dao -> find_by('id', $user_role_list->parent_id);
			// 		if($user_role_list_lv3->id==3){//部門
			// 			redirect("/app/#mgmt/menu_order");
			// 			return;
			// 		}
			// 	}
			// 	if($user_role_list->level==4){//課
			// 		$user_role_list_lv4 = $this -> d_dao -> find_by('id', $user_role_list->parent_id);
			// 		$user_role_list_lv5 = $this -> d_dao -> find_by('id', $user_role_list_lv4->parent_id);
			// 		if($user_role_list_lv5->id==3){//部門
			// 			redirect("/app/#mgmt/menu_order");
			// 			return;
			// 		}
			// 	}
			// } else{
				redirect("/app/home/");
				return;
			// }



			
		}
		$data = $this -> get_captcha($data);
		$data['num'] = rand(1,3);
		// $this -> to_json($data);

		// $this -> load -> view('coach\login', $data);
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
					$this -> session -> set_userdata("lang", $user->lang);
					$this -> users_dao -> update(array('token' => $s_uid), $user -> id);
					$user_role_list = $this -> d_dao -> find_by('id', $user->role_id);

					// if($user->role_id>2){
					// 	if($user_role_list->level==0){//公司
					// 		$res['menu_order'] = 1;
					// 	}
					// 	if($user_role_list->level==1){//總經理
					// 		$res['menu_order'] = 1;
					// 	}
					// 	if($user_role_list->level==2){//副總
					// 		$res['menu_order'] = 1;
					// 	}
					// 	if($user_role_list->level==3){//部門
					// 		$user_role_list_lv3 = $this -> d_dao -> find_by('id', $user_role_list->parent_id);
					// 		if($user_role_list_lv3->id==3){//部門
					// 			$res['menu_order'] = 1;
					// 		}
					// 	}
					// 	if($user_role_list->level==4){//課
					// 		$user_role_list_lv4 = $this -> d_dao -> find_by('id', $user_role_list->parent_id);
					// 		$user_role_list_lv5 = $this -> d_dao -> find_by('id', $user_role_list_lv4->parent_id);
					// 		if($user_role_list_lv5->id==3){//部門
					// 			$res['menu_order'] = 1;
					// 		}
					// 	}
					// } 
					
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
