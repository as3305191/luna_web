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
		$this -> load -> model('Files_dao','file_dao');

		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Country_dao', 'country_dao');
		$this -> load -> model('Patent_status_dao', 'patent_status_dao');
		$this -> load -> model('Patent_category_dao', 'patent_category_dao');
		
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['patent_status'] = $this -> patent_status_dao -> find_all();
		// $this -> to_json($data);

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
			'application_person',
			'application_num',
			'invention_person_search',
			'public_num_search',
			'key_search',
			'patent_search',
			'summary_search',
			'now_category'
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
		$u_data = array();
		$data['id'] = $id;
		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order'
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			if(!empty($item -> img_id)) {
				$image= explode(",", $item -> img_id);
				$item -> image_id =$image ;
				foreach($image as $each){
					$item -> image[] = $this -> img_dao -> find_by_id($each);
				}
			} 

			if(!empty($item -> files_id)) {
				$files = explode(",", $item -> files_id);
				$item -> pdf_array =$files;
				foreach($files as $each){
					$item -> files[] = $this -> file_dao -> find_by_id($each);
				}
			}
			if(!empty($item -> public_num_file)) {
				$public_number = explode(",", $item -> public_num_file);				
				$item -> public_num_input =$public_number;
				foreach($public_number as $each){
					$item -> public_number[] = $this -> file_dao -> find_by_id($each);
				}
			}

			if(!empty($item -> patnet_num_file)) {
				$patnet_number = explode(",", $item -> patnet_num_file);
				$item -> patnet_num_input =$patnet_number;
				foreach($patnet_number as $each){
					$item -> patnet_number[] = $this -> file_dao -> find_by_id($each);
				}
			}

		

			$data['item'] = $item;
			$u_data = $this -> setup_user_data($u_data);
			$data['login_user'] = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		}
		// $data['country'] = $this -> country_dao -> find_all();

		// $this -> to_json($data);
		
		$this->load->view('mgmt/patent/edit', $data);
	}

	public function new_patent_family() {
		$res = array();
		$count_num = $this -> dao -> find_by_all_today_add();
		if($count_num=='0'){
			$last_num = $count_num+1;
			$family_num = date('Ymd').'0'.$last_num;
		} else{
			$last_num = $count_num+1;
			$family_num = date('Ymd').'0'.$last_num;
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
		$patent_name_eng = $this -> get_post('patent_name_eng');
		$patnet_name = $this -> get_post('patnet_name');
		$img= $this -> get_post('img');
		$pdf_array = $this -> get_post('pdf_array');
		$patent_key = $this -> get_post('patent_key');
		$patent_country = $this -> get_post('patent_country');
		$patnet_category = $this -> get_post('patnet_category');
		$public_num_input = $this -> get_post('public_num_input');
		$patnet_num_input = $this -> get_post('patnet_num_input');
		$application_date = $this -> get_post('application_date');
		$public_date = $this -> get_post('public_date');
		$announcement_date = $this -> get_post('announcement_date');
		$s_dt = $this -> get_post('s_dt');
		$e_dt = $this -> get_post('e_dt');
		$patent_finish_date = $this -> get_post('patent_finish_date');
		$patnet_status = $this -> get_post('patnet_status');
		$patent_note = $this -> get_post('patent_note');
		$patent_range = $this -> get_post('patent_range');
		$patent_family = $this -> get_post('patent_family');
		$application_num = $this -> get_post('application_number');
		$announcement_num = $this -> get_post('announcement_num');
		$patnet_note_for_users = $this -> get_post('patnet_note_for_users');
		$year = $this -> get_post('year');
		$public_num = $this -> get_post('public_num');
		$patnet_num = $this -> get_post('patnet_num');
		$applicant = $this -> get_post('applicant');
		$inventor = $this -> get_post('inventor');
		$patnet_type = $this -> get_post('patnet_type');

		$data['img_id'] = $img;
		$data['patnet_type'] = $patnet_type;
		$data['patent_name_eng'] = $patent_name_eng;
		$data['year'] = $year;
		$data['public_num'] = $public_num;
		$data['patnet_num'] = $patnet_num;
		$data['applicant'] = $applicant;
		$data['inventor'] = $inventor;
		$data['application_num'] = $application_num;
		$data['announcement_num'] = $announcement_num;
		$data['patent_family'] = $patent_family;
		$data['patnet_note_for_users'] = $patnet_note_for_users;
		$data['patent_country'] = $patent_country;
		$data['files_id'] = $pdf_array;
		$data['patent_name'] = $patnet_name;
		$data['patent_key'] = $patent_key;
		$data['patnet_category'] = $patnet_category;
		$data['public_num_file'] = $public_num_input;
		$data['patnet_num_file'] = $patnet_num_input;
		$data['application_date'] = $application_date;
		$data['public_date'] = $public_date;
		$data['announcement_date'] = $announcement_date;
		$data['patent_start_dt'] = $s_dt;
		$data['patent_end_dt'] = $e_dt;
		$data['patent_finish_date'] = $patent_finish_date;
		$data['patnet_status'] = $patnet_status;
		$data['patent_note'] = $patent_note;
		$data['patent_range'] = $patent_range;
		$data['update_date'] = date("Y-m-d H:i:s");

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

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	// public function send_mail() {
	// 	// mail("收件者","主旨","內容","from:寄件者");
	// 	mb_internal_encoding("utf-8");
	// 	$to="inf@kwantex.com";
	// 	$subject=mb_encode_mimeheader("自動發信","utf-8");
	// 	$message="測試一下";
	// 	$headers="MIME-Version: 1.0\r\n";
	// 	$headers.="Content-type: text/html; charset=utf-8\r\n";
	// 	$headers.="From:".mb_encode_mimeheader("江官駿","utf-8")."<inf@kwantex.com>\r\n";
	// 	mail($to,$subject,$message,$headers);
	// }

	public function find_all_category(){
		$res = array();
		$category = $this -> patent_category_dao -> find_all();
		$max= $this -> patent_category_dao -> get_max();
		$res['category'] = $category;
		$res['max'] = $max;

		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_next_category(){
		$res = array();
		$next_level= $this -> get_post('next_level');
		$this_val= $this -> get_post('this_val');
		$category = $this -> patent_category_dao -> find_next($next_level,$this_val);
		$res['category'] = $category;

		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_each_category_val(){
		$res = array();
		$item_id= $this -> get_post('item_id');
		$last_child_category= $this -> patent_category_dao -> find_by_id($item_id);
		$last_level = $last_child_category->level;
		for($i=$last_level;$i>-1;$i--){
			$last_child = $this -> patent_category_dao -> find_by_id($item_id);
			if($i=$last_level){
				$res['category_'.$i] = $item_id;
			} else{
				$j = $i+1;
				$last_child = $this -> patent_category_dao -> find_by_id($res['category_'.$j]);
				$res['category_'.$i] = $last_child->parent_id;
			}
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
}
