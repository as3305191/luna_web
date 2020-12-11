<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('News_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('News_style_dao', 'news_style_dao');
		$this -> load -> model('Img_month_use_dao', 'img_month_use_dao');		
		$this -> load -> model('Img_month_use_record_dao', 'img_month_use_record_dao');		

	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);
		$this -> load -> view('mgmt/news/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			's_news_style',
		));
		// set corp id
		$s_data = $this -> setup_user_data(array());
		$items = $this -> dao -> query_ajax($data);
		$res['items'] = $items;
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
		$this->load->view('mgmt/news/edit', $data);
	}


}
