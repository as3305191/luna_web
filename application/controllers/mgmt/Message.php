<?php
// use Lcobucci\JWT\Parser;
defined('BASEPATH') OR exit('No direct script access allowed');
use Lcobucci\JWT\Parser;
class Message extends MY_Mgmt_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> model('User_msg_dao', 'dao');
		
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
	
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['socket_url'] = "ws://192.168.3.251:8081/server.php";
		// $data['socket_url'] = "ws://localhost:8081/server.php";
        $data['me'] = $login_user;
		$data['username'] = $login_user->user_name;
		$data['me_id'] = $login_user->id;
		// $this -> to_json($data);
		$this->load->view('mgmt/message/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$items = $this -> dao -> query_fixing_ajax($data);
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);
		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$me_id = $this -> get_post('me');
		$to_message_id = $this -> get_post('f_chat_id');
		$msg = $this -> get_post('message');
		$status = $this -> get_post('status');

		$data['from_user_id'] = $me_id;
		$data['to_user_id'] = $to_message_id;
		$data['content'] = $msg;
		$data['status'] = $status;

		if(!empty($me_id) && !empty($to_message_id) && !empty($msg)) {
			// insert
			$last_id = $this -> dao -> insert($data);

		} 
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function reload_message_record() {
		$res = array();
		$me_id = $this -> get_post('me_id');
		$to_message_id = $this -> get_post('to_message_id');
		$data['user_id'] = $me_id;
		$data['to_user_id'] = $to_message_id;
		if(!empty($me_id) && !empty($to_message_id)) {
			// insert
			$msg_list = $this -> dao -> find_record($data);
			foreach($msg_list as $each){
				$user_name_find = $this -> users_dao -> find_by_id($each->from_user_id);
				$to_user_name_find = $this -> users_dao -> find_by_id($each->to_user_id);
				$each->user_name = $user_name_find->user_name;
				$each->to_user_name = $to_user_name_find->user_name;
				$u_data['status'] = '1';
				$this -> dao -> update($u_data, $each->id);
			}
			$to_user_name_list = $this -> users_dao -> find_by_id($to_message_id);
			$res['msg_list'] = $msg_list;
			$res['to_user_name_list'] = $to_user_name_list;
		} 
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function find_all_user() {
		$all_users = $this -> users_dao -> find_all_user_by_message();
		$res['all_users'] = $all_users;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_offline_users() {
		$offline_arr = $this -> get_post('id_array');
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		foreach($offline_arr[0] as $each_offline){
			$all_users = $this -> users_dao -> find_all_offline_users($each_offline);
			foreach($all_users as $each_offline_user){
				$not_read = $this -> dao -> find_each_not_read($login_user->id,$each_offline_user->id);
				$res['offline_users_123'][] = $each_offline_user->id;
				$each_offline_user->not_read = $not_read;
			}
			$res['offline_users'][] = $all_users;
		}
		// $res['login_user'] = $login_user;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_offline_user() {
		$f_chat_id = $this -> get_post('f_chat_id');
		// json_decode($offline_arr,true);
		$user_list = $this -> users_dao -> find_by_id($f_chat_id);
		$res['user_list'] = $user_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
}
