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
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
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

		}
		$u_data = $this -> setup_user_data($u_data);
		$data['login_user'] = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		// $this -> to_json($data);
		$this->load->view('mgmt/swot/export', $data);
	}

}
