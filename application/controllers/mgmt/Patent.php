<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patent extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Patent_dao', 'dao');
		$this -> load -> model('Computer_dao', 'computer_dao');
		$this -> load -> model('Computer_hard_dao', 'c_h_dao');
		$this -> load -> model('Computer_soft_dao', 'c_s_dao');
		$this -> load -> model('C_s_h_join_list_dao', 'c_s_h_join_list_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Country_dao', 'country_dao');
		$this -> load -> model('Patent_status_dao', 'patent_status_dao');

		
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['patent_status'] = $this -> patent_status_dao -> find_all();
		$this -> load -> view('mgmt/patent/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$items = $this -> dao -> query_fixing_ajax($data);
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
		$country = $this -> country_dao -> find_all();
		$data['computer_hard_list'] = $computer_hard_list;//硬體所有list
		$data['computer_soft_list'] = $computer_soft_list;//軟體所有list
		$data['country'] = $country;//軟體所有list
		$data['login_user'] = $login_user;
		// $data['coach'] = $this -> dao -> find_all_coach();
		// $this -> to_json($data);
		$this->load->view('mgmt/patent/edit', $data);
	}

	public function new_patent_family() {
		$res = array();
		$count_num = $this -> dao -> find_by_all_today_add("");
		$last_num = $count_num+1;
		if($last_num<10){
			$family_num = date('Ymd').'0'.$last_num;
		} else{
			$family_num = date('Ymd').$last_num;
		}
		$res['family_num'] = $family_num;		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function check_family() {
		$res = array();
		$patent_family = $this -> get_post('patent_family');
		$item = $this -> dao -> find_by("patent_family", $patent_family);
		if(!empty($patent_family)) {
			if (!empty($item)) {
				$res['valid'] = 'FALSE';
			} else {
				$res['valid'] = 'TRUE';
			}
			// $res['123'] = $item;

		} 
		$this -> to_json($res);
	}

	public function insert() {//新增
		$res = array();
		$id = $this -> get_post('id');
		$patnet_name = $this -> get_post('patnet_name');
		$img= $this -> get_post('img');
		$pdf_array = $this -> get_post('pdf_array');
		$patent_key = $this -> get_post('patent_key');
		$patnet_category = $this -> get_post('patnet_category');
		$public_num_input = $this -> get_post('public_num_input');
		$patnet_num_input = $this -> get_post('patnet_num_input');
		$application_date = $this -> get_post('application_date');
		$public_date = $this -> get_post('public_date');
		$announcement_date = $this -> get_post('announcement_date');
		$s_dt = $this -> get_post('s_dt');
		$e_dt = $this -> get_post('e_dt');
		$patnetend_end_date = $this -> get_post('patnetend_end_date');
		$patnet_status = $this -> get_post('patnet_status');
		$patent_note = $this -> get_post('patent_note');
		$patent_range = $this -> get_post('patent_range');

		$data['img_id'] = $img;
		$data['files_id'] = $pdf_array;
		$data['patent_name'] = $patnet_name;
		$data['patent_key'] = $patent_key;
		$data['patnet_category'] = $patnet_category;
		$data['public_num'] = $public_num_input;
		$data['patnet_num'] = $patnet_num_input;
		$data['application_date'] = $application_date;
		$data['public_date'] = $public_date;
		$data['announcement_date'] = $announcement_date;
		$data['s_dt'] = $s_dt;
		$data['e_dt'] = $e_dt;
		$data['patnetend_end_date'] = $patnetend_end_date;
		$data['patnet_status'] = $patnet_status;
		$data['patent_note'] = $patent_note;
		$data['patent_range'] = $patent_range;

		if(empty($id)) {
			// insert
			$last_id = $this -> dao -> insert($data);
		} else {
			$this -> dao -> update($data, $id);
		}
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function find_patent() {
		$data = $this -> get_post('data');
		$items = $this -> dao -> find_patent($data);
		$res['success'] = TRUE;
		$res['items'] = $items ;

		$this -> to_json($res);
	}

	public function do_save_fix_list() {
		$fix_record_id = $this -> session -> userdata('now_fix_record');
		if(!empty($fix_record_id) && count($fix_record_id)>0){
			$this->session->unset_userdata('now_fix_record');
		} else{
			$res['msg'] = '請先填寫維修單';
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function new_country(){
		$data = array();
		$this -> load -> view('layout/show_new_country',$data);
	}

	public function add_country(){
		$data = array();
		$country_name = $this -> get_post('country_name');
		$data['country_name'] = $country_name;
		$this -> country_dao -> insert($data);

		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_country(){
		$data = array();
		$country = $this -> country_dao -> find_all();
		$res['country'] = $country;

		$res['success'] = TRUE;
		$this -> to_json($res);
	}
}
