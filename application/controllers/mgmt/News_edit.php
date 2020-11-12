<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_edit extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('News_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('News_style_dao', 'news_style_dao');		
	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);
		$this -> load -> view('mgmt/news_edit/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'company_id',
			'role_id'
		));
		// set corp id
		$s_data = $this -> setup_user_data(array());
		$res['items'] = $this -> dao -> query_ajax($data);
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
				'order'
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			if(!empty($item -> image_id)) {
				$item -> img = $this -> img_dao -> find_by_id($item -> image_id);
			}

			$data['item'] = $item;
		}

		$this->load->view('mgmt/news_edit/edit', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$title = $this -> get_post('title');
		$m_content = $this -> get_post('m_content');
		$news_style = $this -> get_post('news_style');
		$data['title'] = $title;
		$data['m_content'] = $m_content;
		$data['news_style'] = $news_style;

		if(empty($id)) {
			// insert
			$s_data = $this -> setup_user_data(array());
			$this -> dao -> insert($data);
		} else {
			// update
			$this -> dao -> update($data, $id);
		}

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	public function check_account($id) {
		$account = $this -> get_post('account');
		$list = $this -> dao -> find_all_by('account', $account);
		$res = array();
		if(!empty($id)) {
			if (count($list) > 0) {
				$item = $list[0];
				if($item -> id == $id) {
					$res['valid'] = TRUE;
				} else {
					$res['valid'] = FALSE;
				}

				$res['item'] = $item;
			} else {
				$res['valid'] = TRUE;
			}
		} else {
			if (count($list) > 0) {
				$res['valid'] = FALSE;
			} else {
				$res['valid'] = TRUE;
			}
		}

		$this -> to_json($res);
	}

	public function check_code() {
		$code = $this -> get_post('intro_code');
		$list = $this -> dao -> find_all_by('code', $code);
		$res = array();
		$res['valid'] = (count($list) > 0);
		$this -> to_json($res);
	}

	public function chg_user() {
		$user_id = $this -> get_post('user_id');
		$this -> session -> set_userdata('user_id', $user_id);
		$res = array();

		$this -> to_json($res);
	}

	public function new_news_style(){
		$data = array();
		$this -> load -> view('layout/show_new_news_style',$data);
	}

	public function add_news_style(){
		$data = array();
		$news_style = $this -> get_post('news_style');
		$data['news_style'] = $news_style;
		$this -> news_style_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_news_style(){
		$res = array();
		$news_style_list = $this -> news_style_dao -> find_all();
		$res['news_style'] = $news_style_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
}
