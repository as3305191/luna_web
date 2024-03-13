<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_option extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Question_option_dao', 'dao');
		$this -> load -> model('Question_style_dao', 'question_style_dao');
		// $this -> load -> model('Swot_style_dao', 'swot_style_dao');
		// $this -> load -> model('Swot_dao', 'swot_dao');

		// $this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		// $data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);
		$this -> load -> view('mgmt/question_option/list', $data);
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

	public function edit($id) {
		$data = array();
		$id =$id;
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
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		
		$this->load->view('mgmt/question_option/edit', $data);
	}

	public function insert() {//新增
		$res = array();
		$data = array();
		$id = $this -> get_post('id');
		$question_style_id= $this -> get_post('question_style_id');
		$note= $this -> get_post('note');
		$data['question_style_id'] = $question_style_id;
		$data['note'] = $note;
		if(empty($id)) {
			// insert
			$last_id = $this -> dao -> insert($data);
		} else {
			$this -> dao -> update($data, $id);
			
		}
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function find_question_style(){
		$res = array();
		$question_style_list = $this -> question_style_dao -> find_all();
		$res['question_style'] = $question_style_list;
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

	public function up_lock_question_list(){
		$question_id = $this -> get_post('id');
		$u_data = array();
		$list = $this -> dao -> find_by_id($question_id);
		if(!empty($list)){
			if($list->is_close==1){
				$u_data['is_close'] = 0;
				$res['success_msg'] = '問卷開放成功';
				
			} else{
				$u_data['is_close'] = 1;
				$res['success_msg'] = '問卷變更不開放';
				
			}
			$this -> dao -> update($u_data, $question_id);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$u_data['is_delete'] = 1;
		$this -> dao ->  update($u_data, $id);
		$this -> to_json($res);
	}

}
