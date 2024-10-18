<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patent extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Patent_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Files_dao','file_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Country_dao', 'country_dao');
		$this -> load -> model('Patent_status_dao', 'patent_status_dao');
		$this -> load -> model('Patent_category_dao', 'patent_category_dao');
		$this -> load -> model('Patent_fail_status_dao', 'patent_fail_status_dao');
		$this -> load -> model('Patent_key_dao', 'patent_key_dao');
		$this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['patent_status'] = $this -> patent_category_dao -> find_all();
		// $this -> to_json($data)

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
			'now_category',
			'patent_family_search',
			'patent_name',
			'or_and_type',
			'key_search_array'
		));
		$patent_status = $this->get_post('patent_status');
		if(!empty($patent_status)){
			$data['patent_status'] = explode(",", str_replace('#', ' ,', $patent_status));
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$items = $this -> dao -> query_ajax($data);

		foreach($items as $each){
			if(!empty($each -> patent_country)){
				$my_patent_country = $this -> country_dao -> find_by_id($each -> patent_country);
				$each -> my_patent_country = $my_patent_country -> country_name ;
			} 

			if(!empty($each -> img_id)) {
				$image= explode(",", $each -> img_id);
				$each -> image_id =$image ;
				$each -> image = $image[0];
			} else{
				$each -> image =0;
			}
			if(!empty($each -> patent_family)){
				$patent_country_list = $this -> dao -> find_total_country($each -> patent_family);
				$patent_country_name=[];
				foreach($patent_country_list as $each_country_list){
					if(!in_array($each_country_list->patent_country_name, $patent_country_name)){
						$patent_country_name[] = $each_country_list->patent_country_name;
					}
				}
				$each -> total_country = $patent_country_name;
				// $each -> total_country = array_unique($patent_country_name);

			} else{
				$each -> total_country = '';
			}			
		}
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
			} else{
				$item -> image =array();
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

			if(!empty($item -> patent_family)) {
				$same_family = $this -> dao -> find_same_family($item->patent_family);
				$data['same_family'] = $same_family;
				foreach($same_family as $each){
					$same_family_id_array[] = $each->id;
				}
				$data['same_family_id'] = implode(",",$same_family_id_array);
			}
			if(!empty($item -> patent_key_id_array)){
				$patent_key_array = $item -> patent_key_id_array;
				
				$key_array = substr(substr($patent_key_array,0,-1),1);
				$data['patent_key_array'] = str_replace('#', ',', $key_array);
			}
			
			$data['item'] = $item;
		}
		$data['patent_fail_status'] = $this -> patent_fail_status_dao -> find_all();

		$u_data = $this -> setup_user_data($u_data);
		$data['login_user'] = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		$data['country'] = $this -> country_dao -> find_all();
		// $this -> to_json($data['same_family'] );
		// $this -> to_json($data['same_family_id']);
		$this->load->view('mgmt/patent/edit', $data);
	}

	public function new_patent_family() {
		$res = array();
		$count_num = $this -> dao -> find_by_all_today_add();
		if($count_num>0){
			$the_last_family_num = intval($count_num);
			
			$family_num_md = date('md');
			if($family_num_md==substr($the_last_family_num, 4, -2)){
				$family_num = $the_last_family_num+1;
			} else{
				$family_num = date('Ymd').'01';;
			}
		} else{
			$count_num_fake = $this -> dao -> find_by_all_like_today_add();
			if($count_num_fake>0){
				$family_num = intval($count_num_fake)+1;
			} else{
				$last_num = intval($count_num)+1;
				$family_num = date('Ymd').'0'.$last_num;
			}
		}
		$res['family_num'] = $family_num;	
		// $res['last_num'] =$count_num;
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
		$img_array = array();
		$id = $this -> get_post('id');
		$patent_name_eng = $this -> get_post('patent_name_eng');
		$patnet_name = $this -> get_post('patnet_name');
		$img= $this -> get_post('img');
		$pdf_array = $this -> get_post('pdf_array');
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
		$patent_key_id_array= $this -> get_post('patent_key_id_array');
		$together= $this -> get_post('together');
		$same_family_id= $this -> get_post('same_family_id');
		$p_id_for_priority= $this -> get_post('p_id_for_priority');
		$p_id_for_continuous_cases= $this -> get_post('p_id_for_continuous_cases');
		$p_id_for_part_continuous_cases= $this -> get_post('p_id_for_part_continuous_cases');
		$p_id_for_split_case= $this -> get_post('p_id_for_split_case');
		
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
		if(!empty($p_id_for_priority)){
			$data['p_id_for_priority'] = implode(',',$p_id_for_priority);
		} else{
			$data['p_id_for_priority'] = NULL;
		}

		if(!empty($p_id_for_continuous_cases)){
			$data['p_id_for_continuous_cases'] = implode(',',$p_id_for_continuous_cases);
		} else{
			$data['p_id_for_continuous_cases'] = NULL;
		}

		if(!empty($p_id_for_part_continuous_cases)){
			$data['p_id_for_part_continuous_cases'] = implode(',',$p_id_for_part_continuous_cases);
		}else{
			$data['p_id_for_part_continuous_cases'] = NULL;
		}

		if(!empty($p_id_for_split_case)){
			$data['p_id_for_split_case'] = implode(',',$p_id_for_split_case);
		} else{
			$data['p_id_for_split_case'] = NULL;
		}
		
		if(explode(',',$patent_key_id_array)>1){
			$data['patent_key_id_array'] = '#'.str_replace(',', '#',$patent_key_id_array).'#';
		} else{
			$data['patent_key_id_array'] = '#'.$patent_key_id_array.'#';
		}

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
			$same_family_id = explode(',',$same_family_id);
			if($together==1){
				foreach($same_family_id as $each){
					$this->dao->update_by(array('patent_key_id_array' =>$data['patent_key_id_array']),'id',$each);
				}
			}
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
		$res = array();
		$country = $this -> country_dao -> find_all();
		$res['country'] = $country;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function new_key(){
		$data = array();
		$this -> load -> view('layout/show_new_key',$data);
	}

	public function add_key(){
		$data = array();
		$key_name = $this -> get_post('key');
		$data['key'] = $key_name;
		$this -> patent_key_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function minus_key(){
		$data = array();
		$key = $this -> patent_key_dao -> find_all();
		$data['key'] = $key;
		$this -> load -> view('layout/minus_key',$data);
	}

	public function del_key(){
		$data = array();
		$id= $this -> get_post('key');
		foreach ($id as $each){
			$this -> patent_key_dao -> delete($each);
		}
		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_key(){
		$res = array();
		$key = $this -> patent_key_dao -> find_all();
		$res['key'] = $key;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
	
	public function patent_family_search(){
		$data = array();
		$search_item = $this -> get_post('search_item');
		if(!empty($search_item)){
			$item = $this -> dao -> search_by_family_patent($search_item);
			$res['item'] = $item;
		}
		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function patent_application_number_search(){
		$res = array();
		$search_item = $this -> get_post('search_item');
		if(!empty($search_item)){
			$item = $this -> dao -> find_by_application_number($search_item);
			$res['item'] = $item;
		}
		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
	
	public function find_mode_4(){
		$res = array();
		$item_id = $this -> get_post('item_id');
		if(!empty($item_id)){
			$item = $this -> dao -> find_each_mode4_by_id($item_id);
			if(!empty($item[0]->p_id_for_priority)){
				$p_id_for_priority = explode(',',$item[0]->p_id_for_priority);
				foreach($p_id_for_priority as $each){
					$priority_item = $this -> dao -> find_by_id($each);
					$res['priority_item'][] = $priority_item;
				}
			}
			if(!empty($item[0]->p_id_for_continuous_cases)){
				$p_id_for_continuous_cases = explode(',',$item[0]->p_id_for_continuous_cases);
				foreach($p_id_for_continuous_cases as $each){
					$continuous_cases_item = $this -> dao -> find_by_id($each);
					$res['continuous_cases_item'][] = $continuous_cases_item;
				}
			}
			if(!empty($item[0]->p_id_for_part_continuous_cases)){
				$p_id_for_part_continuous_cases = explode(',',$item[0]->p_id_for_part_continuous_cases);
				foreach($p_id_for_part_continuous_cases as $each){
					$part_continuous_cases_item = $this -> dao -> find_by_id($each);
					$res['part_continuous_cases_item'][] = $part_continuous_cases_item;
				}
			}
			if(!empty($item[0]->p_id_for_split_case)){
				$p_id_for_split_case = explode(',',$item[0]->p_id_for_split_case);
				foreach($p_id_for_split_case as $each){
					$split_case_item = $this -> dao -> find_by_id($each);
					$res['split_case_item'][] = $split_case_item;
				}
			}
			$res['item'] = $item;
		}
		
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
		$category = $this -> patent_status_dao -> find_all();
		$max= $this -> patent_status_dao -> get_max();
		$res['category'] = $category;
		$res['max'] = $max;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_next_category(){
		$res = array();
		$next_level= $this -> get_post('next_level');
		$this_val= $this -> get_post('this_val');
		$category = $this -> patent_status_dao -> find_next($next_level,$this_val);
		$max= $this -> patent_status_dao -> get_max();
		$res['category'] = $category;
		$res['success'] = TRUE;
		$res['max'] = $max;
		$this -> to_json($res);
	}

	public function find_each_category_val(){
		$res = array();
		$item_id= $this -> get_post('item_id');
		$patent= $this -> dao -> find_by_id($item_id);
		$last_child_category = $this -> patent_status_dao -> find_by_id($patent->patnet_status);
		if(!empty($last_child_category)){
			$last_level = $last_child_category->level;
			for($i=$last_level;$i>=0;$i--){
				$last_child = $this -> patent_status_dao -> find_by_id($last_child_category->id);
				if($i<$last_level){
					$j = $i+1;
					$last_child = $this -> patent_status_dao -> find_by_id($res['patnet_status_'.$j]);
					// $res['patnet_status_'.$i] = $last_child -> parent_id;
					$res = array(['patnet_status_'.$i]=>$last_child -> parent_id);
				} else{
					// $res['patnet_status_'.$i] = $last_child -> id;
					$res = array(['patnet_status_'.$i]=>$last_child -> id);

				}
			}
		}
		$res['success'] = TRUE;
		$this -> to_json(array_reverse($res));
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
		$this->load->view('mgmt/patent/export', $data);
	}

	function export_all_11() {
		
  $this->load->helper('file');
  $this->load->helper('download');
  $delimiter = ",";
  $newline = "\r\n";
		$date = date('YmdHis');
  $filename = $date."-patent.csv";


		//create a file pointer
	$f = fopen('php://memory', 'w');
	
		$fields = array(
			iconv("UTF-8","Big5//IGNORE",'申請號'),
			iconv("UTF-8","Big5//IGNORE",'關鍵字'),
		);
		fputcsv($f, $fields, $delimiter);

  		$items = $this -> dao -> find_all();
	
		foreach($items as $each) {
			$lineData = array(
				iconv("UTF-8","Big5//IGNORE",$each -> application_num),
				iconv("UTF-8","Big5//IGNORE",$each -> patent_key)
			);
		
			fputcsv($f, $lineData, $delimiter);
		}
	

		//move back to beginning of file
	fseek($f, 0);

		//set headers to download file rather than displayed
	  header('Content-Type: text/csv');
	  header('Content-Disposition: attachment; filename="' . $filename . '";');

		//output all remaining data on a file pointer
		fpassthru($f);
}
}
