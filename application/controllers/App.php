<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends MY_Base_Controller {

	public function index()
	{
		$data = array();
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('User_msg_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('User_online_dao', 'user_online_dao');
		// setup user data
		$data = $this -> setup_user_data($data);

		// get user name
		$user_id = $data['login_user_id'];
		$user = $this -> users_dao -> find_by_id($user_id);
		$data['login_user_name'] = $user -> user_name;

		// group list
		$data['group_list'] = $this -> users_dao -> find_group_users($user_id);
		
		// get menu data
		$role_id = $user -> role_id;
		$list = $this -> users_dao -> nav_list_by_role_id($role_id);
		$data['socket_url'] = "ws://192.168.1.205:8081/server.php";
		// $data['socket_url'] = "ws://localhost:8081/server.php";
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['me'] = $login_user;
		$data['username'] = $login_user->user_name;
		$data['me_id'] = $login_user->id;
		$data['old_socket'] = $login_user->code;
		$data['menu_list'] = $list;
	
		
		$this->load->view('layout/main', $data);

	}

	public function test() {

		$res['success'] = TRUE;
		$this -> load -> model('Users_dao', 'users_dao');
		$list = $this -> users_dao -> nav_list();
		$res['list'] = $list;
		$this -> to_json($res);
	}

}
