<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_title extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Question_dao', 'dao');
		$this -> load -> model('Question_option_dao', 'question_option_dao');
		$this -> load -> model('Question_record_by_user_dao', 'question_record_by_user_dao');
		$this -> load -> model('Question_title_dao', 'question_title_dao');

		// $this -> load -> model('Swot_dao', 'swot_dao');

		// $this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		// $data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);
		$this -> load -> view('mgmt/question_title/list', $data);
	}

	public function get_data() {
		$res = array();
		// $s_data = $this -> setup_user_data(array());
		// $login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$items = $this -> dao -> query_ajax($data);
	
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);
		$this -> to_json($res);
	}

	public function get_data_option() {
		$res = array();
		$data = array();
		$u_data = array();
		$u_data = $this -> setup_user_data($u_data);
		$user_list = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order'
		));
		$menu_id = $this -> get_post('menu_id');
		$data['menu_id'] = $menu_id;
		$data['login_user_id'] = $user_list->id;
		$items = $this -> dao -> find_all_order_list_other($data);
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> find_all_order_list_other($data,true);
		$res['recordsTotal'] = $this -> dao -> find_all_order_list_other($data,true);
		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$data['swot_title_id'] =$id;
 
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/question_title/edit', $data);
	}

	public function insert_question() {//新增
		$res = array();
		$data = array();
		
		$question = $this -> get_post('question');
	
		
		$data['question'] = $question;
		
		if(!empty($question)) {
			// insert
			
			$last_id = $this -> dao -> insert($data);
			$res['success'] = TRUE;
			
		}
		
 		$this -> to_json($res);
	}

	public function swot_title_get_data() {
		$res = array();
		$swot_title_id =$this -> get_post('swot_title_id');
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$data = array();
		$items= $this -> swot_style_dao -> find_all_style();

		foreach($items as $each){
			$list = $this -> dao -> find_by_id($swot_title_id);
			// if(!empty($list)){
			// 	if($list->is_lock==1){
			// 		$each->now_is_lock =  1;
			// 	} else{
			// 		$each->now_is_lock =  0;
			// 	}
			// } else {
			// 	$each->now_is_lock= 0;
			// } 
			$column = "iso_id_".$each ->id;
			$each->now_is_lock =  $list->$column;
			
		} 

		$res['items'] = $items;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function up_lock(){
		$swot_id = $this -> get_post('id');
		$u_data = array();
		$p = $this -> dao -> find_by_id($swot_id);
		if(!empty($p)){
			if($p->is_lock==0){
				$u_data['is_lock'] = 1;
				$res['success_msg'] = '變更已鎖定成功';
			} else{
				$u_data['is_lock'] = 0;
				$res['success_msg'] = '變更可編輯成功';
			}
			$this -> dao -> update($u_data, $swot_id);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function up_lock_swot_style(){
		$swot_title_id = $this -> get_post('swot_title_id');
		$swot_style_id = $this -> get_post('swot_style_id');

		$u_data = array();
		$column = "iso_id_".$swot_style_id;
		$find_each_id_is_lock = $this -> dao -> find_each_is_lock($swot_title_id);

		if($find_each_id_is_lock[0]->$column<1){
			$u_data['iso_id_'.$swot_style_id] = 1;
			$res['success_msg'] = '變更已鎖定成功';
		} else{
			$u_data['iso_id_'.$swot_style_id] = 0;
			$res['success_msg'] = '變更可編輯成功';
		}
			$this -> dao -> update($u_data, $swot_title_id);

		
		$res['success'] = TRUE;
		// $res['123'] = $find_each_id_is_lock[0]->$column;
		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

}
