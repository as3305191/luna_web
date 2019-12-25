<?php
class Push extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		echo "push";
	}

	public function do_push() {
		$res = array();
		$title = $this -> get_post("title");
		$message = $this -> get_post("message");
		$target = $this -> get_post("target");
		if(!empty($title) && !empty($message) && !empty($target)) {
			$res['success'] = TRUE;
			$res['msg_id'] = time();
		} else {
			$res['error_msg'] = "MISSING_REQUIRED_FIELD";
		}
		$this -> to_json($res);
	}
}
?>
