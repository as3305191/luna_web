<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// $this->load->helper('captcha');
		$this -> load -> model('Sing_dao', 'sing_dao');
		$this -> load -> model('Sing_status_dao', 'sing_status_dao');
	}

	public function index() {
		$data = array();

		$data['item'] = $this -> sing_status_dao -> find_active_sing();
		$this -> load -> view('sing/sing_index', $data);
	}

	public function give_ticket() {
		$res = array();
		$deviceUUID = $this -> get_post('deviceUUID');
		$ticket = $this -> get_post('num');
		$find_active_sing = $this -> sing_status_dao -> find_active_sing();
		$data['uuid'] = $deviceUUID;
		$data['ticket'] = $ticket;
		$data['sing_status_id'] = $find_active_sing[0]->id;
		$last_id = $this -> sing_dao -> insert($data);

		$res['last_id'] = $last_id;
		$res['success'] = TRUE;
		$this -> to_json($res);
		
	}

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('old_system_view/login');
	}

}
