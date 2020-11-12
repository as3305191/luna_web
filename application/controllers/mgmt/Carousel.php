<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carousel extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Place_mark_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Img_style_dao', 'img_style_dao');

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);

		$this->load->view('mgmt/carousel/list', $data);
	}


}
