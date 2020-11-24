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
		
		$today = date("Y-m-d");
		$during_now = date('z', strtotime($today)); 
		$today_h = date("H");
		$today_m = date("i");
		$today_s = date("s");
		$data['during_now_s']= ($during_now*86400)+($today_h*3600)+($today_m*60)+$today_s;
		$this -> to_json($data);
		$this->load->view('mgmt/carousel/list', $data);
	}


}
