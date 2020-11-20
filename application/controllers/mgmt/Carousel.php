<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carousel extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Img_style_dao', 'img_style_dao');
		$this -> load -> model('News_dao', 'news_dao');
		$this -> load -> model('News_style_dao', 'news_style_dao');		
	}

	public function index()
	{
		$data = array();
		$items= $this -> news_dao -> find_carousel();
		$data['items']= $items;
		// $this -> to_json($data);
		$this->load->view('mgmt/carousel/list', $data);
	}


}
