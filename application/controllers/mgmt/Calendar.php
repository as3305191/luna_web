<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Img_style_dao', 'img_style_dao');
		$this -> load -> model('News_dao', 'news_dao');
		$this -> load -> model('News_style_dao', 'news_style_dao');		
	}

	public function index()
	{
		$data = array();
		
		// $this -> to_json($data);
		$this->load->view('mgmt/calendar/list', $data);
	}

	public function new_work($date){
		$data = array();
		$data['date'] = $date;
		$this -> load -> view('layout/show_new_work',$data);
	}


}
