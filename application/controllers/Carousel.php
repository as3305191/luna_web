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
		$items = $this -> img_style_dao -> find_carousel($data);
		foreach($items as $each){
			$data['carousel_id'][]= $each->id;
		}
		$this->load->view('carousel/list', $data);
	}


}
