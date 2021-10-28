<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Swot_title extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Swot_title_dao', 'dao');
		$this -> load -> model('Swot_style_dao', 'swot_style_dao');

		// $this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		// $data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);
		$this -> load -> view('mgmt/swot_title/list', $data);
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
		$data['swot_title_id'] =$id;

		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order'
			));
			$list = $this -> swot_style_dao -> find_all();
			
			$data['items'] = $list;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/swot_title/edit', $data);
	}

	public function swot_title_get_data() {
		$data = array();
		$list = $this -> swot_style_dao -> find_all();
		$data['items'] = $list;
		$data['success'] = TRUE;
		$this -> to_json($data);
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

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

}
