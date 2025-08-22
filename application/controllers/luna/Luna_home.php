<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Luna_home extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		 $this->load->model('/luna/Members_dao', 'dao');
	}

	public function index() {
		$data = array();
		$count_members_lose_3days_ = array();
		$count_today_= array();

		$s_data = $this -> setup_user_data(array());
		$data['login_user'] = $this -> dao -> find_by('id_loginid',$s_data['user_id']);
	

		$this -> to_json($data);
		// $this -> load -> view('luna/luna_home', $data);
	}

	public function get_data() {
		$res = array();
		$id = $this -> get_post('id');
		$page = $this -> get_post('page');

		$s_data = $this -> setup_user_data(array());
		$all_user = $this -> dao -> find_by_id($s_data['login_user_id']);

		$this -> to_json($res);
	}

	public function find_today_weight() {
		$res = array();
		$name = $this -> get_post('name');

		$s_data = $this -> setup_user_data(array());
		$login_user= $this -> dao -> find_by_id($s_data['login_user_id']);

		if(!empty($name)){
			$member_name = $this -> dao -> find_by_member_name($name);
			if(!empty($member_name)){
				$member_weihght = $this -> records_dao -> find_by_member_weight($member_name[0]->id,$login_user);
			} else{
				$member_weihght = '沒有結果';
			}
		} else{
			$member_weihght = $this -> records_dao -> find_by_member_weight($member_id='no_person_',$login_user);
		}


		$res['member_weihght'] = $member_weihght;

		$this -> to_json($res);
	}

	function update_graduate() {
		$res = array();

		$user_id = $this -> get_post("user_id");
		$i_data['status']= 1;


		if(!empty($user_id)){
			$this-> dao ->update_by($i_data,'id',$user_id);
			$res['success'] = "true";
		} else{
			$res['error'] = "true";
		}
		$this -> to_json($res);
	}

	function show_people() {
		$res = array();

		$id_array = $this -> get_post("id_array");

		foreach ($id_array as $each) {
			$items = $this-> dao ->find_by_id($each->id);
		}
		$res['items'] = $items;

		$this -> to_json($res);
	}

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('luna/login');
	}

}
