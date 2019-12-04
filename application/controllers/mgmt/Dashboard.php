<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Members_log_dao', 'members_log_dao');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['count_level_1']  =  $this -> dao -> count_all_level_p(1);
		$data['count_level_2'] =  $this -> dao -> count_all_level_p(2);
		$data['count_level_3'] =  $this -> dao -> count_all_level_p(3);
		$data['count_level_4'] =  $this -> dao -> count_all_level_p(4);
		$data['count_24hr'] =  $this -> members_log_dao -> count_all_24hr();

		// $this->to_json($data);
		$this->load->view('mgmt/dashboard/list', $data);
	}
}
