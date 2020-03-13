<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coach_home extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// $this->load->helper('captcha');

		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Corp_dao', 'corp_dao');
		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Records_dao', 'records_dao');

	}

	public function index() {
		$data = array();
		$s_data = $this -> setup_user_data(array());
		$data['login_user'] = $this -> dao -> find_by_id($s_data['login_user_id']);
		$res['items'] = $this -> dao -> find_all_by_coach($s_data['login_user_id']);
		$data['p'] = count($res['items']);
		$data['page'] = ceil($data['p']/5);
		$data['now'] = 'coach_home';//現在哪頁

		$members_lose_3days = $this -> dao -> query_ajax_by_coachall($data['login_user']->code);
		foreach ($members_lose_3days as $each) {
			$each -> last_weight = $this -> records_dao -> find_last_w_lose3day($each->id);
		}
		foreach ($members_lose_3days as $each_lose_3days) {
			$last_weight = $this -> records_dao -> find_last_w_lose3day($each->id);
			$each_lose_3days -> last_weight = $last_weight;
		}
		foreach ($members_lose_3days as $each_lose_3days_items) {
			if($each_lose_3days_items->last_weight!==NULL){
				$data['count_members_lose_3days'] = count($members_lose_3days);
			} else{
				$data['count_members_lose_3days'] = 0;
			}
		}
		$find_all_members = $this -> dao -> query_ajax_by_coachall($data['login_user']->code);
		foreach ($find_all_members as $each) {
			$today_body_fat = $this -> records_dao -> find_today_body_fat($each->id);
			$last_body_fat = $this -> records_dao -> find_last_body_fat($each->id);
			if(!empty($last_body_fat) && !empty($today_body_fat)){
				$each->lose_body_fat = floatval($last_body_fat->body_fat_rate)-floatval($today_body_fat->body_fat_rate);
			} else{
				$each->lose_body_fat = 0;
			}
		}
		if(!empty($find_all_members)){
			$sum = 0;
			foreach($find_all_members as $item){
				$sum += (int) $item->lose_body_fat;
			}
			$data['all_lose_body_fat'] =$sum;

		} else{
			$data['all_lose_body_fat'] = 0;

		}
		// $this -> to_json($data);
		$this -> load -> view('coach/coach_home', $data);
	}

	public function get_data() {
		$res = array();
		$id = $this -> get_post('id');
		$page = $this -> get_post('page');

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		if($page>1){
			$b=((int)$page-1)*5;
		 	$items = $this -> dao -> query_ajax_by_coach($login_user->code,$b);
			foreach ($items as $each) {
				$the_new_weight_list= $this -> records_dao -> find_each_weight($each->id);
				$each-> the_new_weight = intval($the_new_weight_list-> weight)/10;
			}
		 	$res['items'] = $items;
			$res['count_items'] = count($res['items']);
		} else{
			$items  = $this -> dao -> query_ajax_by_coach($login_user->code,1);
			foreach ($items as $each) {
			$the_new_weight_list= $this -> records_dao -> find_each_weight($each->id);
			$the_original_weight_list= $this -> records_dao -> find_original_weight($each->id);

			$each-> the_new_weight = floatval($the_new_weight_list-> weight);
			$each-> the_weight_change = (floatval($the_original_weight_list-> weight)-floatval($the_new_weight_list-> weight));
			$each-> the_fat_rate_change = floatval($the_original_weight_list-> body_fat_rate)-floatval($the_new_weight_list-> body_fat_rate);
			$each-> the_fat_info = $the_new_weight_list-> fat_info;
			}
			$res['items'] = $items;
			$res['count_items'] = count($res['items']);
		}

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

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('coach/login');
	}

}
