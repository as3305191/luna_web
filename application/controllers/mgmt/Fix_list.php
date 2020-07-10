<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fix_list extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Computer_dao', 'computer_dao');
		$this -> load -> model('Computer_hard_dao', 'c_h_dao');
		$this -> load -> model('Computer_soft_dao', 'c_s_dao');
		$this -> load -> model('C_s_h_join_list_dao', 'c_s_h_join_list_dao');

		$this -> load -> model('Members_log_dao', 'members_log_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Ketone_record_dao', 'ketone_record_dao');

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$this->load->view('mgmt/fix_list/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'type',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$items = $this -> dao -> query_ajax($data);
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);
		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$data['id'] = $id;
		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order',
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			if(!empty($list)){
				$item = $list[0];
			} else{
				$item = 0;
			}
			$data['item'] = $item;
			
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);

		$computer_hard_list = $this -> c_h_dao -> find_all_usage_not_zero();
		$computer_soft_list = $this -> c_s_dao -> find_all_usage_not_zero();
		// $all_user_list = $this -> c_s_dao -> find_all_user();

		$data['computer_hard_list'] = $computer_hard_list;//硬體所有list
		$data['computer_soft_list'] = $computer_soft_list;//軟體所有list

		$data['login_user'] = $login_user;
		// $data['coach'] = $this -> dao -> find_all_coach();
		// $this -> to_json($data);

		$this->load->view('mgmt/fix_list/edit', $data);
	}


	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$computer_name = $this -> get_post('computer_name');
		$computer_num = $this -> get_post('computer_num');
		$computer_property_num = $this -> get_post('computer_property_num');
		$admin_user = $this -> get_post('admin_user');
		$hard_id_array = $this -> get_post('hard_id_array');
		$soft_id_array = $this -> get_post('soft_id_array');
		$new_hard_id_array = mb_split(",", $hard_id_array);
		$new_soft_id_array = mb_split(",", $soft_id_array);
		$data['computer_name'] = $computer_name;
		$data['computer_num'] = $computer_num;
		$data['computer_property_num'] = $computer_property_num;
		$data['admin_user_id'] = $admin_user;

		if(empty($id)) {
			// insert
			$last_id = $this -> dao -> insert($data);
			$u_data['computer_id'] = $last_id;
			foreach($new_hard_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
			foreach($new_soft_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
		} else {
			$this -> dao -> update($data, $id);
			$u_data['computer_id'] = $id;
			foreach($new_hard_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
			foreach($new_soft_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
		}

		$res['success'] = TRUE;
		$res['computer_soft_id_array'] = $soft_id_array;
		$res['computer_hard_id_array'] = $hard_id_array;

 		$this -> to_json($res);
	}

	public function find_now_s_h_list() {
		$fix_type = $this -> get_post('fix_type');//1:電腦 2:軟體 3:硬體
		$h_s_name = $this -> get_post('h_s_name');//軟硬體名稱

		if(!empty($fix_type)){
			if($fix_type==1){
				$fix_list = $this -> computer_dao -> find_by_name($h_s_name);
				foreach($fix_list  as $each){
					$c_s_h_join_list = $this -> c_s_h_join_list_dao -> find_by_computer_id($each -> id);
					foreach($c_s_h_join_list  as $each_c_s_h){
						if($each_c_s_h -> computer_hard_id>0){
							$hard= $this -> c_h_dao -> find_by_id($each_c_s_h -> computer_hard_id);
							$hard_array[] = $hard;
						} else{
							$soft= $this -> c_s_dao -> find_by_id($each_c_s_h -> computer_soft_id);
							$soft_array[] = $soft;
						}
					}
					$each ->h_array = $hard_array;
					$each ->s_array = $soft_array;
				}
			}
			if($fix_type==2){
				$fix_list = $this -> c_s_dao -> find_by_name($h_s_name);
			}
			if($fix_type==3){
				$fix_list = $this -> c_h_dao -> find_by_name($h_s_name);
			}
			if(!empty($fix_list)){
				$res['fix_list'] = $fix_list;
			} else{
				$res['msg'] = '搜尋不到結果';
			}
			$res['fix_type'] = $fix_type;

		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_this_computer() {
		$now_s_h_id = $this -> get_post('now_s_h_id');
		$fix_type = $this -> get_post('fix_type');

		if(!empty($fix_type)){
			if($fix_type==1){
				$now_s_h_list['computer'] = $this -> computer_dao -> find_by_id($now_s_h_id);
				$s_h_list= $this -> c_s_h_join_list_dao -> find_by_computer_id($now_s_h_id);
				foreach($s_h_list  as $each_c_s_h){
					if($each_c_s_h -> computer_hard_id>0){
						$hard= $this -> c_h_dao -> find_by_id($each_c_s_h -> computer_hard_id);
						$hard_array[] = $hard;
					} else{
						$soft= $this -> c_s_dao -> find_by_id($each_c_s_h -> computer_soft_id);
						$soft_array[] = $soft;
					}
				}
				$now_s_h_list['h_array'] = $hard_array;
				$now_s_h_list['s_array'] = $soft_array;
			}
			if($fix_type==2){
				// $fix_list = $this -> c_s_dao -> find_by_name($h_s_name);
			}
			if($fix_type==3){
				// $fix_list = $this -> c_h_dao -> find_by_name($h_s_name);
			}
			if(!empty($now_s_h_list)){
				$res['now_s_h_list'] = $now_s_h_list;
			} else{
				$res['msg'] = '搜尋不到結果';
			}
			$res['fix_type'] = $fix_type;

		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_h_or_s() {
		$type = $this -> get_post('type');
		$s_h_id = $this -> get_post('s_h_id');

		if(!empty($type)){
			if($type=='hard'){
				$s_h_list= $this -> c_h_dao -> find_all_this_table();
			} else if($type=='soft'){
				$s_h_list= $this -> c_s_dao -> find_all_this_table();
			}
			
			if(!empty($s_h_list)){
				$res['s_h_list'] = $s_h_list;
			} else{
				$res['msg'] = '搜尋不到結果';
			}
			$res['type'] = $type;

		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

}
