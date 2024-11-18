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
			$data['item'] = $item[0];
		}
		$this -> load -> view('sing/sing_index', $data);
		// $this -> to_json($data);

	}

	public function ranking() {
		$data = array();
		$winner_array = array();
		$sing_status_id= $this -> sing_status_dao -> find_can_ranking();

		$all_ticket_item_m1 = $this -> sing_dao -> find_all_ticket_by_num('m_1',$sing_status_id->id);
		$all_ticket_item_m2 = $this -> sing_dao -> find_all_ticket_by_num('m_2',$sing_status_id->id);
		$all_ticket_item_m3 = $this -> sing_dao -> find_all_ticket_by_num('m_3',$sing_status_id->id);
		$all_ticket_item_m4 = $this -> sing_dao -> find_all_ticket_by_num('m_4',$sing_status_id->id);
		$all_ticket_item_m5 = $this -> sing_dao -> find_all_ticket_by_num('m_5',$sing_status_id->id);
		$all_ticket = $all_ticket_item_m1+$all_ticket_item_m2+$all_ticket_item_m3+$all_ticket_item_m4+$all_ticket_item_m5;
		// $ticket_array =  array('m1' => $all_ticket_item_m1,
		// 					'm2' => $all_ticket_item_m2,
		// 					'm3' => $all_ticket_item_m3,
		// 					'm4' => $all_ticket_item_m4,
		// 					'm5' => $all_ticket_item_m5,);


		// arsort($ticket_array);
		// $winner =array_key_first($ticket_array) ;
		// foreach($ticket_array as $key=>$value){
		// 	if($value ==$ticket_array[$winner] ){
		// 		$user_name = $this -> sing_status_dao -> find_can_ranking_winner($value,$sing_status_id);
		// 		$winner_array[]=$user_name;
		// 	}
		// }
		$data['sing_status_id'] = $sing_status_id;

		// $data['winner_name'] = $winner_array;
		$data['all_ticket'] = $all_ticket;
		// $data['ticket_array'] = $ticket_array;
		// $data['winner']  = $winner;
		// $data['$ticket_array[$winner]']  = $ticket_array[$winner];

		$this -> to_json($data);

		$this -> load -> view('sing/sing_ranking', $data);
	}

	public function give_ticket() {
		$res = array();
		$deviceUUID_object= $this -> get_post('deviceUUID');
		$deviceUUID = $deviceUUID_object;
		$ticket = $this -> get_post('num');
		$find_active_sing = $this -> sing_status_dao -> find_active_sing();
		
		if(!empty($find_active_sing)){
			$data['sing_status_id'] = $find_active_sing[0]->id;
			$find_gave = $this -> sing_dao -> find_gave($data,$deviceUUID);
			$data['ticket'] = $ticket;
			if(empty($find_gave)){
				$data['uuid'] = $deviceUUID;
				$last_id = $this -> sing_dao -> insert($data);
				$res['last_id'] = $last_id;
	
			} else{
				$this -> sing_dao -> update($data, $find_gave[0]->id);
				$res['re_msg'] = '已更換投票人員';
			}
		} else{
			$res['msg'] = '活動已關閉無法投票';
		}
		

		$res['success'] = TRUE;
		$this -> to_json($res);
		
	}

	public function view_ranking() {
		$res = array();
		$sing_status_id= $this -> sing_status_dao -> find_can_ranking();
		if(!empty($sing_status_id)){
			$res['success'] = TRUE;
		} else{
			$res['msg'] = '比賽目前進行中，請稍候。';
		}
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

	public function show_winner(){
		$data = array();
		$this -> load -> view('layout/show_sing_winner',$data);
	}

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('old_system_view/login');
	}

}
