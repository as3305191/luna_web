<?php
class Users extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// setup models
		$this -> load -> model('Users_dao', 'dao');
		$this -> load -> model('Members_dao', 'members_dao');


	}

	// 2019/01/08
	// 登入
	public function login() {
		$account = $this -> get_post('account');
		$password = $this -> get_post('password');

		$f = array();
		$is_success = FALSE;
		if(!empty($account) && !empty($password)) {
				$f['account'] = $account;

				$m = $this -> dao -> find_by_value($f);
				if(!empty($m)) {
					if($m[0] -> password == $password) {
						if($m[0] -> role_id == '100'){
							$res['error_code'][] = "no_permission";
							$res['error_message'][] = "無使用權限";
						}else{
							$res['success'] = TRUE;
							$res['member'] = $m[0];
						}
					} else {
						$res['error_code'][] = "wrong_password";
						$res['error_message'][] = "密碼錯誤";
					}
				} else {
					$res['error_code'][] = "account_not_found";
					$res['error_message'][] = "查無此帳號";
				}
		} else {
			$res['error_code'][] = "account_password_required";
			$res['error_message'][] = "請輸入帳號及密碼";
		}
		$this -> to_json($res);
	}

	public function me(){
		$id = $this -> get_post('id');
		$f = array();
		if(!empty($id)) {
			$f['id'] = $id;
			$m = $this -> dao -> find_by_value($f);
			$res['member'] = $m[0];
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	// 部門作業人員
	public function operator() {
		$res['success'] = TRUE;

		$station_id = $this -> get_post('station_id');
		if(!empty($station_id)) {
			$station = $this -> station_dao -> find_by_id($station_id);
			$all_stations = array();
			$all_stations[] = $station -> id;
			if(!empty($station -> operator_stations)) {
				$operator_stations = json_decode($station -> operator_stations);
				$all_stations = array_merge($all_stations, $operator_stations);
			}
 			// $list = $this -> dao -> find_by_role($station_id ,'100');
 			$list = $this -> dao -> find_by_stations_and_role($all_stations ,'100');
			$res['list'] = $list;
		}else{
			$res['error_code'][] = "station_id_required";
			$res['error_message'][] = "缺少station_id";
		}

		$this -> to_json($res);
	}

	public function change_identity(){
		$res = array('success' => TRUE);
		$id = $this-> get_post('id');
		$station_id = $this-> get_post('station_id');

		$this -> dao -> update(array("station_id" => $station_id),$id);
		$m = $this -> dao -> find_by_parameter($id);
		$res['member'] = $m;

		$this -> to_json($res);
	}

	// Original
	function info() {
		$auth = $this -> get_header('Authorization');
		$res = array('success' => TRUE);

		// payload
		$payload = jwt_decode($auth, "jihad");

		$user = $this -> users_dao -> find_by_id($payload['user_id']);
		if(!empty($user)) {
			$res['user'] = $payload;
		} else {
			$res['error_msg'] = "無此使用者";
		}

		$this -> to_json($res);
	}

	private function do_log($tag = '') {
		$i_data['post'] =json_encode($_POST, JSON_UNESCAPED_UNICODE);
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$i_data['tag'] = $tag;
		$i_data['full_path'] = $actual_link;
		$this -> post_log_dao -> insert($i_data);
	}

	public function list_users(){
		$role_id = $this-> get_post('role_id');

		if(!empty($role_id)) {
			$list = $this -> dao -> find_by_value(array('role_id' => $role_id));
			$res['list'] = $list;
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}

		$this -> to_json($res);
	}

	public function get_member() {
		$res = array();

		$account = $this -> get_post("account");
		$password = $this -> get_post("password");

		$this -> load -> library('aeswithopenssl');
		$arr = array(
			"account" => "{$account}",
			"password" => "{$password}",
			"time" => time(),
		);
		$str = json_encode($arr);
		$token = $this -> aeswithopenssl -> encryptWithOpenssl($str);

		$ret = $this -> curl -> simple_post($this -> aeswithopenssl -> getUrl("getMemberRequest"), array(
			"ApiKey" => $this -> aeswithopenssl -> getApiKey(),
			"token" => $token,
		));

		// $res['success'] = TRUE;
		// $res['token'] = $token;
		$res = array_merge($res, (array)json_decode($ret));

		$json = (array)json_decode($ret);

		if (array_key_exists("member_id",$json)){
			$member_id = $json['member_id'];
			$m = $this -> members_dao  -> find_by_account($member_id);
			if(!empty($m)){
				$res['member'] = $m;
			}else{
				$insert_data = array('account' => $member_id,
									 'password' => $member_id,
								 );
				$last_id = $this -> members_dao -> insert($insert_data);
				$value = str_pad($last_id,6,'0',STR_PAD_LEFT);
				$this -> members_dao -> update(array('code'=>$value),$last_id);
				$res['member'] = $this -> members_dao -> find_by_id($last_id);
			}
		}else{
			$res['error_message'] = $json['message'];
		}

		$this -> to_json($res);
	}

	public function change_member_pwd() {
		$res = array();

		$member_id = $this -> get_post("member_id");
		$account = $this -> get_post("account");
		$new_password = $this -> get_post("new_password");
		$old_password = $this -> get_post("old_password");

		$this -> load -> library('aeswithopenssl');
		$arr = array(
			"member_id" => "{$member_id}",
			"account" => "{$account}",
			"new_password" => "{$new_password}",
			"old_password" => "{$old_password}",
			"time" => time(),
		);

		$str = json_encode($arr);
		$token = $this -> aeswithopenssl -> encryptWithOpenssl($str);

		$ret = $this -> curl -> simple_post($this -> aeswithopenssl -> getUrl("changeMemberPwdRequest"), array(
			"ApiKey" => $this -> aeswithopenssl -> getApiKey(),
			"token" => $token,
		));

		// $res['success'] = TRUE;
		$res['str'] = $str;
		$res = array_merge($res, (array)json_decode($ret));
		$this -> to_json($res);
	}

	public function get_qrcode() {
		$res = array();

		$member_id = $this -> get_post("member_id");

		if(empty($member_id)) {
			return $this -> json_encode(array("error_msg" => "no member_id"));
		}
		$this -> load -> library('aeswithopenssl');
		$arr = array(
			"member_id" => "$member_id",
			"time" => time(),
		);
		$str = json_encode($arr);
		$token = $this -> aeswithopenssl -> encryptWithOpenssl($str);

		$ret = $this -> curl -> simple_post($this -> aeswithopenssl -> getUrl("getMemberQrcodeRequest"), array(
			"ApiKey" => $this -> aeswithopenssl -> getApiKey(),
			"token" => $token,
		));

		// $res['success'] = TRUE;
		// $res['token'] = $token;
		$res = array_merge($res, (array)json_decode($ret));
		$this -> to_json($res);
	}



}
?>
