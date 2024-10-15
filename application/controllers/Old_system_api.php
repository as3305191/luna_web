<?php
// use Lcobucci\JWT\Parser;
defined('BASEPATH') OR exit('No direct script access allowed');
use Lcobucci\JWT\Parser;
class Old_system_api extends MY_Mgmt_Controller {
	function __construct() {
		parent::__construct();
		// $this -> load -> model('User_msg_dao', 'dao');
		// $this -> load -> model('Images_dao', 'img_dao');
		// $this -> load -> model('Users_dao', 'users_dao');
		// $this -> load -> model('User_online_dao', 'user_online_dao');

	}

	public function index()
	{
		header("Content-Type:text/html; charset=utf-8");
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		
		$sql = "SELECT * FROM [informationexc].[dbo].[order_store]";    
		
		/* Execute the query. */    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
		if ( $stmt ){    
			 //   $id = $stmt['id']; 
			  echo "<td>".json_encode($stmt)."</td>"; 
			 //  echo"<td>".$stmt['name2']."</td>";
		 } 
		else{ 
			 echo "Error in statement execution.\n";    
			 die( print_r( sqlsrv_errors(), true));    
		}    
		
		sqlsrv_free_stmt( $stmt);    
		sqlsrv_close( $conn);
		// $this -> to_json($data);
		$this->load->view('mgmt/old_system_api/list', $stmt);
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
		$res['last_id'] = $last_id;
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function find_last() {
		$res = array();
		$data = array();
		$me_id = $this -> get_post('me');
		$to_message_id = $this -> get_post('f_chat_id');
		$message = $this -> get_post('message');
		$data['me_id'] = $me_id;
		$data['to_message_id'] = $to_message_id;
		$data['message'] = $message;
		$last_id = $this -> dao -> find_last_message($data);
		$res['last_id'] = $last_id;
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function reload_message_record() {
		$res = array();
		$me_id = $this -> get_post('me_id');
		$to_message_id = $this -> get_post('to_message_id');
		$type = $this -> get_post('type');
		$f_chat_id = $this -> get_post('f_chat_id');

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
				if($f_chat_id>0 ){
					$find_me_no_read = $this -> dao -> find_by_me_no_read($me_id,$to_message_id);
					foreach($find_me_no_read as $each_no_read_list){
						$u_data['status'] = '1';
						$this -> dao -> update($u_data, $each_no_read_list->id);
					}
				}
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
		$data = array();
		$data = $this -> setup_user_data($data);
		$offline_arr = $this -> get_post('id_array');
		$online_id_array = $this -> get_post('online_id_array');
		if(!empty($offline_arr)){
			foreach($offline_arr[0] as $each_offline){
				$all_users = $this -> users_dao -> find_all_offline_users($each_offline);
				foreach($all_users as $each_offline_user){
					$not_read = $this -> dao -> find_not_read($data['login_user_id'],$each_offline_user->id);
					$each_offline_user->no_read =$not_read;
				}
				// $res['offline_users'][] = $all_users;
				foreach($all_users as $each_offline_user){
					if($each_offline_user->no_read>0){
						$res['offline_users'][] = $each_offline_user;
					} else{
						$res['offline_users_no_noread'][] = $each_offline_user;
					}
				}
			}
		}
			if(!empty($online_id_array)){
				foreach($online_id_array as $each_online){
					$online_users = $this -> users_dao -> find_all_offline_users($each_online);
					foreach($online_users as $each_online_user){
						$not_read = $this -> dao -> find_not_read($data['login_user_id'],$each_online_user->id);
						$each_online_user->no_read =$not_read;
					}
					$res['online_users'][] = $online_users;
				}
			} else{
				$res['online_users']=false;
			}
	
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

	public function find_me_is_online() {
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		$is_online_list= $this -> user_online_dao -> find_me_is_online_or_not();
		if(!empty($is_online_list->now_online)){
			$is_online_array[] = $is_online_list[0]->now_online;
			if(in_array($login_user ->id, $is_online_array)){
				$res['is_online'] = 0;//在線上
			} else{
				$res['is_online'] = 2;//不在線上
			}
		} else{
			$res['is_online'] = 2;//不在線上
		}

		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
}
