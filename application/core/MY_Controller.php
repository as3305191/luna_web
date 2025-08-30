<?php
class MY_Base_Controller extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> helper('common');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Push_msg_dao', 'pm_dao');
		$this -> load -> model('App_reg_code_dao', 'arc_dao');
		$this -> load -> model('Fix_record_dao', 'fix_record_dao');
		$this -> load -> model('C_s_h_join_list_dao', 'c_s_h_join_list_dao');
		$this -> load -> model('C_s_h_join_list_dao', 'c_s_h_join_list_dao');
		$this -> load -> model('Department_dao', 'department_dao');
		$this->load->model('/luna/Members_dao', 'luna_mem_dao');

		// disable cache for back button
		ob_start();
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
		header('Access-Control-Max-Age: 3600');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Access-Control-Allow-Credentials: true');
		header("X-FRAME-OPTION: SAMEORIGIN");

		date_default_timezone_set("Asia/Taipei");
		ob_end_flush();
		$lang = $this -> session -> userdata('lang');
		if(empty($lang)) {
			$lang = 'cht';
			$this -> session -> set_userdata('lang', $lang);
		}
	}

	function get_header($key) {
		return $this -> input -> get_request_header($key);
	}

	function get_post($key) {
		return $this -> input -> post($key);
	}

	function get_get($key) {
		return $this -> input -> get($key);
	}

	function get_get_post($key) {
		$val = $this -> get_get($key);
		if ($val === FALSE) {
			$val = $this -> get_post($key);
		}
		return $val;
	}

	function to_json($json_data) {
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($json_data);
	}

	public function get_posts($post_array, $bypass_empty = FALSE) {
		$i_data = array();
		foreach ($post_array as $each) {
			if($bypass_empty) {
				if(!empty($this -> get_post($each))) {
					$i_data[$each] = $this -> get_post($each);
				}
			} else {
				$i_data[$each] = $this -> get_post($each);
			}
		}
		return $i_data;
	}

	public function get_gets($post_array) {
		$i_data = array();
		foreach ($post_array as $each) {
			$i_data[$each] = $this -> get_get($each);
		}
		return $i_data;
	}

	public function get_get_posts($post_array) {
		$i_data = array();
		foreach ($post_array as $each) {
			$val = $this -> get_get_post($each);
			if (!($val === FALSE)) {
				$i_data[$each] = $val;
			}
		}
		return $i_data;
	}

	// resize
	public function resize($img_path, $width = 500, $height = 500) {
		$config['image_library'] = 'gd2';
		$config['source_image'] = $img_path;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;

		$this -> load -> library('image_lib', $config);

		$this -> image_lib -> resize();
	}

	public function check_dir($dir) {
		if (!file_exists($dir)) {
			mkdir($dir);
		}
	}

	public function setup_user_data($data = []) {
		// 這兩個分清楚：user_id = 數字 id_idx；login_user_id = 帳號字串
		$user_idx       = $this->session->userdata('user_id');         // int (id_idx)
		$login_user_id  = $this->session->userdata('login_user_id');   // string (id_loginid)
		$userlv         = $this->session->userdata('userlv');

		// 未登入處理
		if (empty($user_idx) && ($login_user_id === null || $login_user_id === '')) {
			if ($this->input->is_ajax_request()) {
				// 不要回 <script>，給 401 乾淨一些
				$this->output->set_status_header(401)->set_output('');
				return $data;
			} else {
				redirect("app/luna/login/logout");
				return $data;
			}
		}

		// 取使用者資料：有 id_idx 就優先用數字查，否則用帳號字串查
		if (is_numeric($user_idx)) {
			$user = $this->luna_mem_dao->find_by('id_idx', (int)$user_idx);
		} elseif (!empty($login_user_id)) {
			// 建議你的 DAO 也有 find_by_loginid()（你上面已經做了）
			if (method_exists($this->luna_mem_dao, 'find_by_loginid')) {
				$user = $this->luna_mem_dao->find_by_loginid((string)$login_user_id);
			} else {
				// 至少強制字串比對
				$user = $this->luna_mem_dao->find_by('id_loginid', (string)$login_user_id);
			}
		} else {
			$user = null;
		}

		// 輸出格式：同時提供頂層與巢狀，兼容舊用法
		$data['login_user_id'] = ($login_user_id === null ? '' : (string)$login_user_id);
		$data['l_user']        = $user;
		$data['userlv']        = (int)($userlv ?? 0);

		$data['login_user'] = [
			'login_user_id' => $data['login_user_id'],
			'l_user'        => $user,
		];

		// 這兩行原本會用 PATH_INFO，很多環境沒設會 Notice：可以拿掉或改用 CI 的 URI
		// $array = explode('/', $_SERVER['PATH_INFO'] ?? '');
		// $last_key_word = substr(strrchr($_SERVER['PATH_INFO'] ?? '/', "/"), 1);

		return $data;
	}



	function get_between($input, $start, $end) {
		$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
		return $substr;
	}

	public function setup_coach_data($data) {
		$user_id = $this -> session -> userdata('user_id');
		$s_uid = $this -> session -> userdata('s_uid');
		$user = $this -> users_dao -> find_by_id($user_id);
		// echo $user -> token . '-';
		// echo $s_uid;
		// if(empty($user_id)|| $user -> token != $s_uid) {
		if(empty($user_id)) {

			if ($this -> input ->is_ajax_request()) {
				echo "<script>window.location.reload();</script>";
			} else {
				redirect("coach/coach_home/logout");
			}
		} else {
			$data['login_user_id'] = $user_id;
			$data['l_user'] = $user;
		}

		return $data;
	}

	// public function mail_to($params) {
	// 	$nres = $this -> curl -> simple_post("http://139.162.115.145:8080/MailSender/api/send/one",$params);
	// 	return $nres;
	// }

	// 推播
	// public function push_msg($member_id, $action = array(), $title, $msg){

	// 	// 寫入 push_msg // 並推播出去
	// 	$action_str = implode("#",$action);
	// 	$action_key = $action[0];
	// 	// $push_ids = array();

	// 	$i_data = array(
	// 		"action" => $action_str,
	// 		"member_id" => $member_id,
	// 		"title" => $title,
	// 		"msg" => $msg,
	// 	);

	// 	if($action_key != 'add_talk'){
	// 		// $pms = $this -> pm_dao -> find_all_where($i_data);
	// 		// if(empty($pms) || count($pms) == 0){
	// 		$this -> pm_dao -> insert($i_data);
	// 		$arcs = $this -> arc_dao -> find_all_by_member_id_new($member_id);

	// 		foreach($arcs as $each){
	// 			$result = send_gcm($each -> token, $title, $msg, $action_str);
	// 		}
	// 		// }
	// 	}else{
	// 		// 找到token
	// 		if($member_id > 0){
	// 			$arcs = $this -> arc_dao -> find_all_by_member_id_new($member_id);
	// 		}else{
	// 			$members = $this -> m_dao -> find_CS();
	// 			foreach ($members as $m) {
	// 				$arcs = $this -> arc_dao -> find_all_by_member_id_new($m -> id);
	// 			}
	// 		}
	// 		// return $arcs;
	// 		foreach($arcs as $each){
	// 			$result = send_gcm($each -> token, $title, $msg, $action_str);
	// 		}
	// 	}
	// 	return $arcs;

	// }

    protected function assign($name, $value = '')
    {
        $this->view->assign($name, $value);

        return $this;
	}
	
	public function js_alert($msg='error',$redirect_url=null)
    {
        echo "<script>";
        echo "alert('".$msg."');";
        if(empty($redirect_url)){
            echo "history.back();";
        }else{
            echo "window.location = '".$redirect_url."';";
        }
        echo "</script>";
        exit;
	}
	
	public function send_mail($to, $subject, $text, $cc = '') {

		$this->load->library('email');
		$this->email->initialize(mail_config());
		$this->email->from('inf@kwantex.com', 'system');
		$this->email->to($to);
		if (!empty($cc)) {
			$this->email->cc($cc);
		}
		$this->email->subject($subject);
		$this->email->message($text);
		$this->email->send();
	}

	public function mail($role_id ,$to, $subject, $text, $cc = '') {
		$department = $this -> department_dao -> find_by_id($role_id);
		$config = array(
			'crlf'          => "\r\n",
			'newline'       => "\r\n",
			'charset'       => 'utf-8',
			'protocol'      => 'smtp',
			'mailtype'      => 'html',
			'smtp_host'     => '192.168.1.246',
			'smtp_port'     => '25',
			'smtp_user'     => $department->email_account,
			'smtp_pass'     => $department->email_password
		);
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from($department->email_account.'@kwantex.com', $department->email_account);
		$this->email->to($to);
		if (!empty($cc)) {
			$this->email->cc($cc);
		}
		$this->email->subject($subject);
		$this->email->message($text);
		$this->email->send();
	}

}

/**
 * nne to check session
 */
class MY_Mgmt_Controller extends MY_Base_Controller {
	function __construct() {
		parent::__construct();
		// $data = array();
		// $urlArr=$_SERVER['PATH_INFO'];
		// if($urlArr=="menu_order"){
		// 	$data['menu_order']=$urlArr;
		// 	// $data['menu_order'] = '1';
		// } else{
		// 	$data['menu_order']=$urlArr;
		// 	// $data['menu_order'] = '0';
		// }
		// $this -> session -> set_userdata('menu_order', $data);
		$user_id = $this -> session -> userdata('user_id');
		if(strpos($_SERVER['PATH_INFO'], '/app/mgmt') == 0 && empty($user_id)) {
			echo "<script>window.location.reload();</script>";
			exit;
		}
	
	}
}
?>
