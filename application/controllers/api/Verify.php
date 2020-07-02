<?php
class Verify extends MY_Base_Controller {

	function __construct() {
		parent::__construct();


	}

	function index() {
		echo "index";
	}

	public function check_ver(){
		$url = '';
		$urls = $url.'&t='.mt_rand();
		$string = file_get_contents($urls);
		$a = strstr($string,'version');
		$a = strstr($a,',',true);
		$a = strstr($a,':');
		$a = str_replace('"','',$a);
		$a = str_replace(':','',$a);
		$data = array();
		$data['version'] = $a;
		$this -> to_json($data);
	}


}
?>
