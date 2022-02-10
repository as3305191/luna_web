<?php
class Ktxapi extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		
	}

	public function test() {
		// echo "sms123";
		// $m_acc = "0970632144";
		// $m_pwd = "aaa123";
		// $mobile = "0925815921";
		// $msg = "test";

		$res = $this -> curl -> simple_post("http://192.168.1.248/vwZZ_ASK_LEAVE");
				$txt = iconv("big5","UTF-8", $res);
				echo $txt;
	}
}
?>
