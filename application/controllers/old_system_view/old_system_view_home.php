<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Old_system_view_home extends MY_Base_Controller {

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
		$count_members_lose_3days_ = array();
		$count_today_= array();

		$s_data = $this -> setup_user_data(array());
		$data['login_user'] = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		// $items = $this -> dao -> find_all_by_old_system_view($data['login_user']->code);
		$data['p'] = count($items);
		$data['page'] = ceil($data['p']/10);
		$data['now'] = 'old_system_view_home';//現在哪頁

		// $members_lose_3days = $this -> dao -> query_ajax_by_old_system_viewall($data['login_user']->code);
		// foreach ($members_lose_3days as $each) {
		// 	$each -> last_weight = $this -> records_dao -> find_last_w_lose3day($each->id);
		// }
		// foreach ($members_lose_3days as $each_lose_3days_items) {
		// 	if($each_lose_3days_items->last_weight!==NULL){
		// 		$data['count_members_lose_3days_all_list'] = $each_lose_3days_items;
		// 		$count_members_lose_3days_[] = $each_lose_3days_items;//3天

		// 	}
		// }

		// $data['count_members_lose_3days'] = count($count_members_lose_3days_);
		// $data['members_lose_3days'] = $members_lose_3days;


		// $find_all_members = $this -> dao -> query_ajax_by_old_system_viewall($data['login_user']->code);
		// foreach ($find_all_members as $each) {
		// 	$today_body_fat = $this -> records_dao -> find_today_body_fat($each->id);
		// 	if($today_body_fat!==NULL){
		// 		$count_today_[] = $today_body_fat;//3天
		// 	}
		// }

		// $data['count_today'] = count($count_today_);
		// $the_fat_rate_change = $this -> dao -> query_ajax_by_old_system_viewall($data['login_user']->code);

		// foreach ($the_fat_rate_change as $each) {
		// 	$the_new_weight_list= $this -> records_dao -> find_each_weight($each->id);
		// 	$the_original_weight_list= $this -> records_dao -> find_original_weight($each->id);
		// 	if(!empty($the_original_weight_list->body_fat_rate) && !empty($the_new_weight_list->body_fat_rate)){
		// 		$each-> the_fat_rate_change = floatval($the_original_weight_list-> body_fat_rate)-floatval($the_new_weight_list-> body_fat_rate);
		// 	} else{
		// 		$each-> the_fat_rate_change = 0;
		// 	}
		// }

		// $sum = 0;
		// foreach($the_fat_rate_change as $each){
		// 	$sum += floatval($each->the_fat_rate_change);
		// }
		// $data['count_help_people'] = count($the_fat_rate_change);
		// $data['help_fat_rate_change'] =ROUND($sum,2) ;

		// $find_date = $this -> dao -> query_ajax_by_old_system_viewall($data['login_user']->code);
		// $map_date = 0;
		// foreach ($find_date as $each) {
		// 	$startdate = $this -> records_dao -> find_first_day($each->id);
		// 	if($map_date==0 || strtotime($map_date)>strtotime($startdate)){
		// 		$map_date = $startdate;
		// 	}
		// }

		$today = date("Y-m-d");
		// if(strtotime($today)>strtotime($map_date)){
		// 	$days=(strtotime($today)-strtotime($map_date))/(60*60*24);
		// } else{
		// 	$days=0;
		// }
		// $data['days'] = $days;

		// $this -> to_json($data);
		$this -> load -> view('old_system_view/old_system_view_home', $data);
	}

	public function get_data() {
		$res = array();
		$id = $this -> get_post('id');
		$page = $this -> get_post('page');

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		if($page>1){
			$b=((int)$page-1)*10;
		 	$items = $this -> dao -> query_ajax_by_old_system_view($login_user->code,$b);
			foreach ($items as $each) {
				$the_new_weight_list= $this -> records_dao -> find_each_weight($each->id);
				$each-> the_new_weight = intval($the_new_weight_list-> weight)/10;
			}
		 	$res['items'] = $items;
			$res['count_items'] = count($res['items']);
		} else{
			$items  = $this -> dao -> query_ajax_by_old_system_view($login_user->code,1);
			foreach ($items as $each) {
			$the_new_weight_list= $this -> records_dao -> find_each_weight($each->id);
			$the_original_weight_list= $this -> records_dao -> find_original_weight($each->id);
			if(!empty($the_new_weight_list-> weight)){
				$each-> the_new_weight = floatval($the_new_weight_list-> weight);
			} else{
				$each-> the_new_weight = 0;
			}
			if(!empty($the_original_weight_list-> weight) && !empty($the_new_weight_list-> weight)){
				$each-> the_weight_change = (floatval($the_original_weight_list-> weight)-floatval($the_new_weight_list-> weight));
			} else{
				$each-> the_weight_change = 0;
			}
			if(!empty($the_original_weight_list-> body_fat_rate) && !empty($the_new_weight_list-> body_fat_rate)){
				$each-> the_fat_rate_change = floatval($the_original_weight_list-> body_fat_rate)-floatval($the_new_weight_list-> body_fat_rate);
			} else{
				$each-> the_fat_rate_change = 0;
			}
			if(!empty( $the_new_weight_list-> fat_info)){
				$each-> the_fat_info = $the_new_weight_list-> fat_info;
			} else{
				$each-> the_fat_info = 0;
			}
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
		redirect('old_system_view/login');
	}

}
