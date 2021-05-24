<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Menu_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['role_list'] = $this -> dao -> find_all_roles();
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);

		$this->load->view('mgmt/menu/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
		));

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$items = $this -> dao -> query_ajax($data);
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
				'order',
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			$data['item'] = $item;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		$data['role_list'] = $this -> dao -> find_all_roles();
		// $this -> to_json($data);
		$this->load->view('mgmt/menu/edit', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'menu_code',
			'corp_id',
			'menu_name',
			'meal_name',
			'date',
		));

		if(empty($id)) {
			// insert
			$this -> dao -> insert($data);
		} else {
			$this -> dao -> update($data, $id);
		}
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	public function test() {

		$msg = "您好，歡迎使用本系統";
		$email = "inf@kwantex.com";
		$config = array(
		        'crlf'          => "\r\n",
		        'newline'       => "\r\n",
		        'charset'       => 'utf-8',
		        'protocol'      => 'smtp',
		        'mailtype'      => 'html',
		        'smtp_host'     => '192.168.1.246',
		        'smtp_port'     => '25',
		        'smtp_user'     => 'inf@kwantex.com',
		        'smtp_pass'     => '935m4TMw8Q'
		);

		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('inf@kwantex.com');
		$this->email->to($email);

		$this->email->subject('歡迎使用本系統');
		$this->email->message($msg);

		if($this->email->send()){
		    $res = "ok";
		}else{
		    $res = "faild";
		}

		echo $res;
	}
}
