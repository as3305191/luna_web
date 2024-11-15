<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// $this->load->helper('captcha');
		$this -> load -> model('Sing_dao', 'sing_dao');
		$this -> load -> model('Sing_status_dao', 'sing_status_dao');
		$this -> load -> model('Sing_uuid_dao', 'sing_uuid_dao');

	}

	public function index() {
		$data = array();
		$item = $this -> sing_status_dao -> find_active_sing();
		if(!empty($item)){
			$data['item'] = $item;
		}
		$this -> load -> view('sing/sing_index', $data);
		$this -> to_json($data);

	}

	public function ranking() {
		$data = array();
		
		$this -> load -> view('sing/sing_ranking', $data);
	}

	public function give_ticket() {
		$res = array();
		$deviceUUID_object= $this -> get_post('deviceUUID');
		$deviceUUID = json_decode(json_encode($deviceUUID_object) , true);
		$ticket = $this -> get_post('num');
		$find_active_sing = $this -> sing_status_dao -> find_active_sing();
		$data['ticket'] = $ticket;
		$data['sing_status_id'] = $find_active_sing[0]->id;
		$find_active_sing = $this -> sing_dao -> find_gave($data,$deviceUUID);
		if(empty($find_active_sing)){
			$data['uuid'] = $deviceUUID;
			$last_id = $this -> sing_dao -> insert($data);
			$res['last_id'] = $last_id;

		} else{
			$this -> sing_dao -> update($data, $find_active_sing[0]->id);
		}

		$res['success'] = TRUE;
		$this -> to_json($res);
		
	}
	public function find_uuid_is_used() {
		$res = array();
		$uuid = $this -> get_post('uuid');
		$data['uuid'] = $uuid;

		$find_active_sing = $this -> sing_uuid_dao -> find_not_used($uuid);
		if(empty($find_active_sing)){
			$res['not_use'] = TRUE;
			$last_id = $this -> sing_uuid_dao -> insert($data);

		} else{
			$res['is_used'] = TRUE;
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
		
	}

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('old_system_view/login');
	}

}
