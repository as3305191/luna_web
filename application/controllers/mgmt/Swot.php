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
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
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
		// $this -> to_json($data);
		$this->load->view('mgmt/swot/edit', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$title = $this -> get_post('title');
		$m_swot_s = $this -> get_post('m_swot_s');
		$m_swot_w = $this -> get_post('m_swot_w');
		$m_swot_o = $this -> get_post('m_swot_o');
		$m_swot_t = $this -> get_post('m_swot_t');
		$m_swot_s_o = $this -> get_post('m_swot_s_o');
		$m_swot_w_o = $this -> get_post('m_swot_w_o');
		$m_swot_s_t = $this -> get_post('m_swot_s_t');
		$m_swot_w_t = $this -> get_post('m_swot_w_t');
		$m_first = $this -> get_post('m_first');
		
		$data['title'] = $title;
		$data['m_swot_s'] = $m_swot_s;
		$data['m_swot_w'] = $m_swot_w;
		$data['m_swot_o'] = $m_swot_o;
		$data['m_swot_t'] = $m_swot_t;
		$data['m_swot_s_o'] = $m_swot_s_o;
		$data['m_swot_w_o'] = $m_swot_w_o;
		$data['m_swot_s_t'] = $m_swot_s_t;
		$data['m_swot_w_t'] = $m_swot_w_t;
		$data['m_first'] = $m_first;
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['role_id'] = $login_user->role_id;

		if(empty($id)) {
			// insert
			$this -> dao -> insert($data);
		} else {
			// update
			$this -> dao -> update($data, $id);
		}
		$s_data = $this -> setup_user_data(array());
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
