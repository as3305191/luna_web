<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
	
		// $this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$this->load->view('layout/show_mail_window', $data);
	}

	public function auto_mail($to,$subject,$text,$cc = '')
	{
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$this->mail($login_user->role_id, $to, $subject, $text,$cc);
	}

}
