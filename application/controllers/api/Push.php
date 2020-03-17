<?php
class Push extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Members_dao', 'members_dao');
		$this -> load -> model('App_reg_code_dao', 'app_reg_code_dao');
		$this -> load -> model('News_private_dao', 'news_private_dao');

	}

	function index() {
		echo "push";
	}

	public function do_push() {
		$res = array();
		$title = $this -> get_post("title");
		$message = $this -> get_post("message");
		// $target = $this -> get_post("target");
		$target = $this -> get_post("target");

		$date = date('Y-m-d H:i:s');
		if(!empty($title) && !empty($message) && !empty($target)) {

			if($target == "ALL") {
				$link = $this -> get_post("link");
				if(!empty($link)) {
					$action = array(
						"link" => $link // link
					);
					$title = $title;
					$msg = $message;
					$result = $this -> send_gcm_notification("", $title, $msg , $action, "'thev' in topics");
				} else {
					$res['error_code'][] = "columns_required";
					$res['error_message'][] = "缺少必填欄位link";
				}
			} else {
				$m = $this -> members_dao -> find_by_account($target);
				// $m = $this -> members_dao -> find_by_value(array('account'=> $target));
				if(!empty($m)){
					$res['success'] = TRUE;
	
					$update_data = array(
													'title' => $title,
													'member_id' => $m->id,
													'content' => $message
												);
					$np_id = $this -> news_private_dao -> insert($update_data);
	
					$code = $this -> app_reg_code_dao -> find_by_member($m->id);
					$res['msg_id'] = time();
					$action = array(
						"np_id" => $np_id // new privafte id
					);
					$token = $code -> token;
					$title = $title;
					$msg = $message;
					$this -> send_gcm_notification($token, $title, $msg , $action);
				}else{
					$res['error_code'][] = "account_not_found";
					$res['error_message'][] = "查無此帳號";
				}
			}
		} else {
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
			// $res['error_msg'] = "MISSING_REQUIRED_FIELD";
		}
		$this -> to_json($res);
	}

	public function send_gcm_notification($token, $title, $msg , $action = array(), $condition = "") {

		$url = 'https://fcm.googleapis.com/fcm/send';

		$fields = array (
				"priority" => "high",
				'notification' => array(
						"title" => $title,
						"body" => $msg,
						"sound" => "default"
				),
				"data" => $action
		);

		if(!empty($condition)) {
			$fields['condition'] = $condition;
		} else {
			$fields['to'] = $token;
		}
		$fields = json_encode($fields);
	//	echo $fields;
		$headers = array (
			'Authorization: key=AAAA_CE4W8k:APA91bH6NNPMao0pkiiktokas5I_dhnQQw5gscCYln7AJSaRCYyeO4ssnK7t8fCDPqJckKTi8rucUj1ngW0M6NOv5B-a0Xvh6VqrfEcG_bCZtF_9eXNtbscUMeyPF29b4FhXKhjAHzOQ',
			'Content-Type: application/json'
		);

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		curl_setopt(  $ch, CURLOPT_SSL_VERIFYPEER, false); // bypass ssl verify

		$result = curl_exec ( $ch );

		curl_close ( $ch );

		return $result;
	}






}
?>
