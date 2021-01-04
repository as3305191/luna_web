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
		$res['items'] = $this -> dao -> query_news($data);
	
		$res['recordsFiltered'] = $this -> dao -> query_news($data, TRUE);
		$res['recordsTotal'] = $this -> dao -> query_news($data, TRUE);
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
			$list = $this -> dao -> query_news($q_data);
			$item = $list[0];
			// if(!empty($item -> image_id)) {
			// 	$item -> img = $this -> img_dao -> find_by_id($item -> image_id);
			// }

			$data['item'] = $item;
		}
		$this->load->view('mgmt/news/edit', $data);
	}

	public function test() {

		$msg = "您好，歡迎使用本系統";
		$email = "inf@kwantex.com";
		$config = array(
		        'crlf'          => "\r\n",
		        'newline'       => "\r\n",
		        'charset'       => 'utf-8',
		        'protocol'      => 'smtp',
		        'mailtype'      => 'html',
		        'smtp_host'     => '192.168.1.246',
		        'smtp_port'     => '900',
		        'smtp_user'     => 'inf',
		        'smtp_pass'     => '935m4TMw8Q'
		);

		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('inf@kwantex.com');
		$this->email->to($email);

		$this->email->subject('歡迎使用本系統');
		$this->email->message($msg);
		$this->email->send();
		if($this->email->send()){
		    $res = "ok";
		}else{
		    $res = "faild";
		}

		echo $res;
	}

}
