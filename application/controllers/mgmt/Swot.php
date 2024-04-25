<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Swot extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Swot_dao', 'dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Swot_style_dao', 'swot_style_dao');
		$this -> load -> model('Swot_title_dao','swot_title_dao');
		$this -> load -> model('Department_dao','d_dao');
		// $this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$data['all_department_list'] = $this -> d_dao -> find_all_d_or_c();

		// $this -> to_json($data);

		$this -> load -> view('mgmt/swot/list', $data);
	}

	public function get_data() {
		$res = array();
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'list_title',
			'list_style'
		));
		$d_or_c = $this -> get_post('d_or_c');
		
		if($d_or_c >0){
			$d_lv = $this-> d_dao-> find_by_id($d_or_c);
			if($d_lv->parent_id>5){
				$data['parent_id'] = $d_lv->parent_id;
			}
		} 
		$data['d_or_c'] = $d_or_c ;
		$data['login_user'] = $login_user;
		$login_user_array = str_replace('#', ',', trim($login_user->in_department, "#"));
		$res['login_user_array'] = $login_user_array;

		$items = $this -> dao -> query_ajax($data);
		foreach($items as $each){
			if(!empty($each->class_id)){
				$d_or_c_level = $this-> d_dao-> find_by_id($each->class_id);
				if($d_or_c_level -> level==4){
					$each->department_list = $this-> d_dao-> find_by_id($d_or_c_level->parent_id);
				} 
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
		$s_data = array();
		$s_data = $this -> setup_user_data($s_data);
		$s_data['login_user'] = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['id'] = $id;
		$title = $this -> get_get('title');
		$style = $this -> get_get('style');
		$dep = $this -> get_get('dep');
		$type = $this -> get_get('type');
		if($id>0) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order'
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			if(!empty($list)){
				$item = $list[0];
			} else{
				$item = $list;
			}
			$data['item'] = $item;
			if(!empty($item->is_use_user_id) && $item->is_use_user_id>0){
				$is_use_user = $this -> users_dao -> find_by_id($item->is_use_user_id);
				$data['user_name'] = $is_use_user->user_name;
			} else{
				$data['user_name'] = '';
			}
			if(!empty($item->class_id) && $item->class_id>0){
				$swot_class= $this -> d_dao -> find_by_id($item->class_id);
				if($swot_class->level==3){
					$data['swot_class'] = $swot_class->name;
				} else if($swot_class->level==0){
					$data['swot_class'] = '寬仕';
				} else{
					$swot_dep= $this -> d_dao -> find_by_id($swot_class->parent_id);
					$data['swot_class'] =$swot_dep->name.'+'.$swot_class->name;
				}
			} 
		
			$data['unify'] = 0;

		} else{
			if($title>0||$style>0){
				$item = array();
				$q_data = $this -> get_posts(array(
					'length',
					'start',
					'columns',
					'search',
					'order'
				));
				$q_data['list_title'] =  $title;
				$q_data['list_style'] =  $style;
				$q_data['unify'] =  1;
				$q_data['type'] =  $type;
				$q_data['d_or_c'] =  $dep;
				if($q_data['d_or_c']  >0){
					$d_lv = $this-> d_dao-> find_by_id($q_data['d_or_c'] );
					if($d_lv->parent_id>5){
						$q_data['parent_id'] = $d_lv->parent_id;
					}
				} 
				$list = $this -> dao -> query_ajax($q_data);
				$s='';
				$w='';
				$o='';
				$t='';
				$s_o='';
				$w_o='';
				$s_t='';
				$w_t='';
				foreach($list as $each){	
					$s.=str_replace("</p>","(".$each->d_or_c_name.")</p>",trim(str_replace('<p>&nbsp;</p>','',$each->m_swot_s)));
					$w.=str_replace("</p>","(".$each->d_or_c_name.")</p>",trim(str_replace('<p>&nbsp;</p>','',$each->m_swot_w)));
					$o.=str_replace("</p>","(".$each->d_or_c_name.")</p>",trim(str_replace('<p>&nbsp;</p>','',$each->m_swot_o)));
					$t.=str_replace("</p>","(".$each->d_or_c_name.")</p>",trim(str_replace('<p>&nbsp;</p>','',$each->m_swot_t)));
					$s_o.=str_replace("</p>","(".$each->d_or_c_name.")</p>",trim(str_replace('<p>&nbsp;</p>','',$each->m_swot_s_o)));
					$w_o.=str_replace("</p>","(".$each->d_or_c_name.")</p>",trim(str_replace('<p>&nbsp;</p>','',$each->m_swot_w_o)));
					$s_t.=str_replace("</p>","(".$each->d_or_c_name.")</p>",trim(str_replace('<p>&nbsp;</p>','',$each->m_swot_s_t)));
					$w_t.=str_replace("</p>","(".$each->d_or_c_name.")</p>",trim(str_replace('<p>&nbsp;</p>','',$each->m_swot_w_t)));
				}

				$item['id'] = 0;
				$item['class_id'] = 0;
				$item['swot_style_id'] = $style;
				$item['title'] = $title;
				$m_swot_s = str_replace("<p><br></p>","",trim($s));
				$m_swot_w = str_replace("<p><br></p>","",trim($w));
				$m_swot_o = str_replace("<p><br></p>","",trim($o));
				$m_swot_t = str_replace("<p><br></p>","",trim($t));
				$m_swot_s_o = str_replace("<p><br></p>","",trim($s_o));
				$m_swot_w_o = str_replace("<p><br></p>","",trim($w_o));
				$m_swot_s_t = str_replace("<p><br></p>","",trim($s_t));
				$m_swot_w_t = str_replace("<p><br></p>","",trim($w_t));

				$item['m_swot_s'] = $this->replace_num_title($m_swot_s);
				$item['m_swot_w'] = $this->replace_num_title($m_swot_w);
				$item['m_swot_o'] = $this->replace_num_title($m_swot_o);
				$item['m_swot_t'] = $this->replace_num_title($m_swot_t);
				$item['m_swot_s_o'] = $this->replace_num_title($m_swot_s_o);
				$item['m_swot_w_o'] = $this->replace_num_title($m_swot_w_o);
				$item['m_swot_s_t'] = $this->replace_num_title($m_swot_s_t);
				$item['m_swot_w_t'] = $this->replace_num_title($m_swot_w_t);
				$data['item']= $item;

				if($style==8){
					if($dep>0){
						
						$dep_item = $this -> d_dao -> find_by_id($s_data['login_user']->role_id);
						if($dep_item->level==3){
							$data['swot_class'] = $dep_item->name;;
							$data['new_class_id'] = $dep;
						} else{
							$class_dep_item = $this -> d_dao -> find_by_id($dep_item->parent_id);
							$data['swot_class'] = $class_dep_item->name;
							$data['new_class_id'] = $class_dep_item->id;
						}
					} else{
						$dep_item = $this -> d_dao -> find_by_id(3);
						$data['swot_class'] = $dep_item->name;
						$data['new_class_id'] = 3;
					}
					
				} else{
					
					if($dep==0||$dep==3){
						$dep_item = $this -> d_dao -> find_by_id(3);
						$data['swot_class'] = $dep_item->name;
						$data['new_class_id'] = 3;
					} else{
						$dep_item = $this -> d_dao -> find_by_id($dep);
						$data['swot_class'] = $dep_item->name;
						$data['new_class_id'] = $dep;
					}
					
				}
				$data['unify'] = 1;
			} 
		}
		$u_data = $this -> setup_user_data($u_data);
		$data['login_user'] = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		$data['swot_class_for_0'] = $this -> d_dao -> find_by_id($data['login_user']->role_id);
		$data['login_user_role_array'] =  explode(",", str_replace('#', ',', trim($data['login_user']->in_department, "#")));
		$data['department_list'] = $this -> users_dao -> find_all_department();

		// $this -> to_json('style:'.$style.'dep:'.$dep);
		$this->load->view('mgmt/swot/edit', $data);
	}

	public function insert() {
		$res = array();
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
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
		$swot_style = $this -> get_post('swot_style');
		$department = $this -> get_post('department');
		$class_id = $this -> get_post('class_id');
		$make_user = $this -> get_post('make_user');
		$unify = $this -> get_post('unify');
		$swot_leader = $this -> get_post('swot_leader');
		
		$data['title'] =$title;
		$data['unify'] =$unify;
		$data['swot_leader'] =$this ->test_add_w4($swot_leader);
		$data['swot_style_id'] =$this ->test_add_w4($swot_style);
		$data['m_swot_s'] =$this ->test_add_w4($m_swot_s);
		$data['m_swot_w'] =$this ->test_add_w4($m_swot_w);
		$data['make_user'] =$this ->test_add_w4($make_user);
		$data['m_swot_o'] =$this ->test_add_w4($m_swot_o);
		$data['m_swot_t'] =$this ->test_add_w4($m_swot_t);
		$data['m_swot_s_o'] =$this ->test_add_w4($m_swot_s_o);
		$data['m_swot_w_o'] =$this ->test_add_w4($m_swot_w_o);
		$data['m_swot_s_t'] =$this ->test_add_w4($m_swot_s_t);
		$data['m_swot_w_t'] =$this ->test_add_w4($m_swot_w_t);
		$data['update_date'] = date("Y-m-d H:i:s");
		if(empty($id)||$id==0) {
			// insert
			// $role_array= explode(",", str_replace('#', ',', trim($login_user->in_department, "#")));
			if($class_id>0){
				$data['class_id'] = $class_id;
			} else{
				$data['class_id'] = $login_user->role_id;
			}
			$data['role_id'] = $department;
			$this -> dao -> insert($data);

		} else {
			if($id=='-1') {
				$data['role_id'] = $department;
				$data['class_id'] = $login_user->role_id;
				$this -> dao -> insert($data);
			} else{
				// update
				$data['is_use_user_id'] = '0';
				$data['is_use'] = '0';
				$this -> dao -> update($data, $id);
			}
		}
		$s_data = $this -> setup_user_data(array());
		// $res['m_swot_s'] = $this ->test_add_w4($m_swot_s); 
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function insert_new() {
		$res = array();
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$title = $this -> swot_title_dao -> find_all_not_lock(0);
		$swot_style = $this -> get_post('swot_style');
		if(!empty($title)){
			$swot_style_list_is_lock = $this -> swot_title_dao -> find_by_id($title[0]->id);
			$column = "iso_id_".$swot_style;
			if(!empty($title) && $swot_style_list_is_lock->$column<1){			
				$m_swot_s = $this -> get_post('m_swot_s');
				$m_swot_w = $this -> get_post('m_swot_w');
				$m_swot_o = $this -> get_post('m_swot_o');
				$m_swot_t = $this -> get_post('m_swot_t');
				$m_swot_s_o = $this -> get_post('m_swot_s_o');
				$m_swot_w_o = $this -> get_post('m_swot_w_o');
				$m_swot_s_t = $this -> get_post('m_swot_s_t');
				$m_swot_w_t = $this -> get_post('m_swot_w_t');
				
				$department = $this -> get_post('department');
				$class_id = $this -> get_post('class_id');
				$make_user = $this -> get_post('make_user');
				$swot_leader = $this -> get_post('swot_leader');
				$data['title'] = $title[0]->id;
				$data['swot_leader'] =$this ->test_add_w4($swot_leader);
				$data['swot_style_id'] =$this ->test_add_w4($swot_style);
				$data['m_swot_s'] =$this ->test_add_w4($m_swot_s);
				$data['m_swot_w'] =$this ->test_add_w4($m_swot_w);
				$data['make_user'] =$this ->test_add_w4($make_user);
				$data['m_swot_o'] =$this ->test_add_w4($m_swot_o);
				$data['m_swot_t'] =$this ->test_add_w4($m_swot_t);
				$data['m_swot_s_o'] =$this ->test_add_w4($m_swot_s_o);
				$data['m_swot_w_o'] =$this ->test_add_w4($m_swot_w_o);
				$data['m_swot_s_t'] =$this ->test_add_w4($m_swot_s_t);
				$data['m_swot_w_t'] =$this ->test_add_w4($m_swot_w_t);
				$data['update_date'] = date("Y-m-d H:i:s");
				if($class_id>0){
					$data['class_id'] = $class_id;
				} else{
					$data['class_id'] = $login_user->role_id;
				}
				$data['role_id'] = $department;
				$this -> dao -> insert($data);
				$res['success'] = TRUE;
			} else{
				$res['error_msg'] = '請洽企劃課開啟存取權限';
			}
		}
		
		
		$s_data = $this -> setup_user_data(array());
		
 		$this -> to_json($res);
	}

	 function test_add_w4($text){
		$new_text='';
		$new_text =str_replace("<br/>","</p><p>",trim($text));
		return $new_text;
	}


	public function new_swot_style(){
		$data = array();
		$this -> load -> view('layout/show_new_swot',$data);
	}

	public function add_swot(){
		$data = array();
		$swot_name = $this -> get_post('swot_name');
		$data['swot_name'] = $swot_name;
		$this -> swot_style_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_swot_style(){
		$res = array();
		$swot = $this -> swot_style_dao -> find_all();
		
		$res['swot'] = $swot;

		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_swot_style_edit(){
		$res = array();
		$s_title_id = $this -> get_post('s_title_val');
		$swot_style = $this -> swot_style_dao -> find_all();
		$swot_title = $this -> swot_title_dao -> find_by_id($s_title_id);
		foreach($swot_style as $each){
			$field_name = 'iso_id_'.$each->id;
			if($swot_title->$field_name==0){
				$res['swot'][] = $each;
			}
		}
		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
	public function new_swot_title(){
		$data = array();
		$this -> load -> view('layout/show_new_swot_title',$data);
	}

	public function add_title(){
		$data = array();
		$swot_title = $this -> get_post('swot_title');
		$data['swot_title'] = $swot_title;
		$this -> swot_title_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_swot_title(){
		$res = array();
		$id = $this -> get_post('id');
		$swot = $this -> swot_title_dao -> find_all_not_lock($id);

		$res['swot'] = $swot;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
	
	public function find_swot_title_list(){
		$res = array();
		$swot = $this -> swot_title_dao -> find_all();
		$res['swot'] = $swot;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function do_remove(){//by user
		$res = array();
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$all_files_by_me = $this -> dao -> find_all_by_me($login_user->id);
		if(count($all_files_by_me)>0){
			foreach($all_files_by_me as $each){
				$data['is_use_user_id'] = '0';
				$data['is_use'] = '0';
				$this -> dao -> update($data, $each->id);	
			}
		}

		$all_swot_list = $this -> dao -> find_all_is_use();
		if(!empty($all_swot_list)){
			foreach($all_swot_list as $each){
				$data['is_use_user_id'] = '0';
				$data['is_use'] = '0';
				$this -> dao -> update($data, $each->id);	
			}
		}
		$res['all_list'] = $all_swot_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$i_data['is_delete'] = 1;
		$this-> dao ->update_by($i_data,'id',$id);
		$this -> to_json($res);
	}

	public function is_use($id) {
		$res['success'] = TRUE;
		$data['is_use'] = '1';
		$data['use_time'] = date('Y-m-d H:i:s');
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$item = $this -> dao -> find_by_id($id);
		if($item->is_use==0){
			$data['is_use_user_id'] = $login_user->id;
			$this -> dao -> update($data, $id);	
		}
		$this -> to_json($res);
	}

	public function not_use($id) {
		$res['success'] = TRUE;
		$data['is_use'] = '0';
		$data['is_use_user_id'] = '0';
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$item = $this -> dao -> find_by_id($id);
		if($login_user->id==$item->is_use_user_id){
			$this -> dao -> update($data, $id);	
		}
		$this -> to_json($res);
	}

	public function find_is_use($id) {
		$res['success'] = TRUE;
		$item= $this -> dao -> find_by_id($id);	
		$res['is_use'] = $item->is_use;
		$this -> to_json($res);
	}

	public function export_all($id) {
		$data = array();
		$u_data = array();
		$u_data = $this -> setup_user_data($u_data);
		$data['login_user'] = $this -> users_dao -> find_by_id($u_data['login_user_id']);
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
		// $this -> to_json($data);
		$this->load->view('mgmt/swot/export', $data);
	}

	public function replace_num_title_after_del() {
		$res = array();
		$m_swot_s = $this -> get_post('m_swot_s');
		$m_swot_w = $this -> get_post('m_swot_w');
		$m_swot_o = $this -> get_post('m_swot_o');
		$m_swot_t = $this -> get_post('m_swot_t');
		$m_swot_s_o = $this -> get_post('m_swot_s_o');
		$m_swot_w_o = $this -> get_post('m_swot_w_o');
		$m_swot_s_t = $this -> get_post('m_swot_s_t');
		$m_swot_w_t = $this -> get_post('m_swot_w_t');

		$new_swot_s = $this->replace_num_title($m_swot_s);
		$new_swot_w = $this->replace_num_title($m_swot_w);
		$new_swot_o = $this->replace_num_title($m_swot_o);
		$new_swot_t = $this->replace_num_title($m_swot_t);
		$new_swot_s_o = $this->replace_num_title($m_swot_s_o);
		$new_swot_w_o = $this->replace_num_title($m_swot_w_o);
		$new_swot_s_t = $this->replace_num_title($m_swot_s_t);
		$new_swot_w_t = $this->replace_num_title($m_swot_w_t);
		$res['new_swot_s'] = $new_swot_s;
		$res['new_swot_w'] = $new_swot_w;
		$res['new_swot_o'] = $new_swot_o;
		$res['new_swot_t'] = $new_swot_t;
		$res['new_swot_s_o'] = $new_swot_s_o;
		$res['new_swot_w_o'] = $new_swot_w_o;
		$res['new_swot_s_t'] = $new_swot_s_t;
		$res['new_swot_w_t'] = $new_swot_w_t;

		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	 function replace_num_title($str_old) {
		$str = str_replace('<p>&nbsp;</p>','',$str_old);
		$total_array = explode("</p>",$str);
		$total_num = substr_count($str,'<p>');
		$new_str='';
		for($i=0;$i<=$total_num;$i++){
			$strbetween_p_p = $total_array[$i];
			$check = strstr($strbetween_p_p,'<p><span style');
			$j=$i+1;
			if (strpos($strbetween_p_p, ".") !== false) {
				if($check){
					$the_num_in_p_p = $this->get_between($strbetween_p_p, '">', '.');
					$before_num_text = $this->get_before_word($strbetween_p_p);
					$num = $this->text_find_num($strbetween_p_p);
					$new_str.=str_replace('&nbsp;','',str_replace($before_num_text.$num.'.',$before_num_text.$j.'.',trim($strbetween_p_p)));
					// $new_str=$num;
				}else{
					$the_num_in_p_p = $this->get_between($strbetween_p_p, '<p>', '.');
					$new_str.=str_replace('&nbsp;','',str_replace('<p>'.$the_num_in_p_p.'.','<p>'.$j.'.',trim($strbetween_p_p)));
				}
			} else{
				$the_num_in_p_p = $this->get_between($strbetween_p_p, '<p>', '</p>');
				$new_str.=str_replace('&nbsp;','',str_replace('<p>','<p>'.$j.'.',trim($strbetween_p_p)));
			}
			
			
		}
		return $new_str;
	}

	function get_between($input, $start, $end) {
		$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
		return $substr;
	}
	function get_before_word($text) {
		$n_text= $this->get_between($text, '<p>', '.');
		$res_num = strrpos($n_text, ';">', 0);
		$before_text = substr($n_text, 0, $res_num);
		return '<p>'.$before_text.';">';
	}
	function text_find_num($text) {
		$n_text= $this->get_between($text, '<p>', '.');
		$res_num = strrpos($n_text, ';">', 0);
		$before_num_text = '<p>'.substr($n_text, 0, $res_num).';">';
		$p_text = str_replace('',$before_num_text,$n_text);//到數字
		$pount_position = strrpos($p_text, '>', 0);
		$num = substr($p_text, $pount_position+1);
		return $num;
	}
}