<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @brief 人才庫管理->人才庫查詢
 */
class Dialog extends MY_Mgmt_Controller {


	function __construct() {
		parent::__construct();

	}
	public function dialog1(){
		$data = array();

		$this -> load -> view('layout/dialog1',$data);
	}

}
