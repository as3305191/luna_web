<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Swot extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Swot_dao', 'dao');
	
		$this -> load -> model('Users_dao', 'users_dao');
	

		$this -> load-> library('word');

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);

		$this -> load -> view('mgmt/swot/list', $data);
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
			
			$data['item'] = $item;
		}

		$u_data = $this -> setup_user_data($u_data);
		$data['login_user'] = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		$data['country'] = $this -> country_dao -> find_all();
		// $this -> to_json($data);
		$this->load->view('mgmt/swot/edit', $data);
	}

	public function insert() {//新增
		$res = array();
		$img_array = array();
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
		$assignee = $this -> get_post('assignee');
		$now_patent_status = $this -> get_post('now_patent_status');
		$patent_fail_status = $this -> get_post('patent_fail_status');
		$patent_fail_person = $this -> get_post('patent_fail_person');
	
		// foreach ($img as $each) {
		// 	$img_array[]= explode(",", str_replace('#', ',', substr($each, 1, -1)));
		// }
		$data['img_id'] = $img;
		// $data['img_active'] = $img_array[0];
		$data['assignee'] = $assignee;
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
		$data['patent_fail_status_id'] = $patent_fail_status;
		$data['patent_fail_person'] = $patent_fail_person;

		if($now_patent_status=='##'){
			$now_patent_status=='';
		} else{
			if(substr($now_patent_status,-2)=="#" && substr($now_patent_status,0,2)=="#"){
				$data['now_patent_status'] = substr(ltrim($now_patent_status,'#'),0,-1);
			} else{
				if(substr($now_patent_status,-1)=="#" && substr($now_patent_status,0,1)=="#"){
					$data['now_patent_status'] = $now_patent_status;
				} else{
					$data['now_patent_status'] = "#".$now_patent_status."#";
				}
			}
		}
	
		if(empty($id)) {
			// insert
			$last_id = $this -> dao -> insert($data);
		} else {
			$this -> dao -> update($data, $id);
		}
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function export_all($id) {
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
					$item -> image[] = $image[0];
				}
			} else{
				$item -> image ='';
			}
			
			if(!empty($item -> files_id)) {
				$files = explode(",", $item -> files_id);
				$item -> pdf_array =$files;
				foreach($files as $each){
					$item -> files[] = $this -> file_dao -> find_by_id($each);
				}
			}else{
				$item -> files =array();
			}

			if(!empty($item -> public_num_file)) {
				$public_number = explode(",", $item -> public_num_file);				
				$item -> public_num_input =$public_number;
				foreach($public_number as $each){
					$item -> public_number[] = $this -> file_dao -> find_by_id($each);
				}
			}else{
				$item -> public_number =array();
			}

			if(!empty($item -> patnet_num_file)) {
				$patnet_number = explode(",", $item -> patnet_num_file);
				$item -> patnet_num_input =$patnet_number;
				foreach($patnet_number as $each){
					$item -> patnet_number[] = $this -> file_dao -> find_by_id($each);
				}
			}else{
				$item -> patnet_number =array();
			}

			$data['item'] = $item;
			$data['country'] = $this -> country_dao -> find_by_id($item->patent_country);

			if(!empty($item -> patnet_category)) {
				$data['patnet_status'] = $this -> patent_status_dao -> find_by_id($item->patnet_status);
			
			}

			if(!empty($item -> patnet_type)) {
				$patnet_type_list = $this -> patent_category_dao -> find_by_id($item -> patnet_type);
				$data['patnet_type_name'] = $patnet_type_list->name;
				if($item -> patnet_type==3){
					$data['patnet_fail_status'] = $this -> patent_fail_status_dao -> find_by_id($item->patent_fail_status_id);
				} else{
					$data['patnet_fail_status']='';
				}
			}else{
				$data['patnet_type_name'] ="";
			}

			if(!empty($item -> patnet_status)){
				$now_level_list = $this -> patent_status_dao -> find_by_id($item -> patnet_status);
				$now_level = $now_level_list->level;
				$all_patent_status_name=$now_level_list->name;
				if($now_level==0){
					$last_child = $this -> patent_status_dao -> find_by_id($item -> patnet_status);
					$data['all_patent_status_name'] = $last_child->name;
				} else{
					$now_parent=$now_level_list->parent_id;
					for($i=$now_level;$i>=0;$i--){
						$last_child = $this -> patent_status_dao -> find_by_id($now_parent);
						if($i>0){
							$all_patent_status_name = $last_child->name."-".$all_patent_status_name;	
							$now_parent=$last_child->parent_id;
						} else{
							if(!empty($last_child)){
								$all_patent_status_name = $last_child->name.$all_patent_status_name;	
							} else{
								$all_patent_status_name = $all_patent_status_name;	
							}
						} 
					}
					$data['all_patent_status_name'] = $all_patent_status_name;
				}		
			}

			if(!empty($item -> files_id) && $item -> files_id !=='') {
				$files = explode(",", $item -> files_id);
				// $item -> pdf_array =$files;
				$files=array();
				$map_files=array();
				foreach($files as $each){
					$map_files[] = $this -> file_dao -> find_by_id($each);

					foreach($map_files as $each_map){
						if(!in_array($files, $each_map->file_name)){
							$files[] = $each_map->file_name;
						}
					}
				}
				$item -> files[] = $files;
			}else{
				$item -> files ='';
			}

		}
		$u_data = $this -> setup_user_data($u_data);
		$data['login_user'] = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		// $this -> to_json($data);
		$this->load->view('mgmt/swot/export', $data);
	}

}
