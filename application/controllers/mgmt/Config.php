<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Config_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$this->load->view('mgmt/config/list', $data);
	}

	public function edit($id) {
		$data = array();
		$data['id'] = $id;
		$data = $this -> setup_user_data($data);
		$data['item'] = $this -> dao -> get_item();

		$this->load->view('mgmt/config/edit', $data);
	}

	public function insert() {
		$res = array();

		$data = $this -> get_posts(array(
			'title',
		));

		$this -> dao -> update($data, 1);

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}
}
