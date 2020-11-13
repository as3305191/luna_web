<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carousel extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Img_style_dao', 'img_style_dao');
		$this -> load -> model('News_dao', 'news_dao');
		$this -> load -> model('News_style_dao', 'news_style_dao');		
	}

	public function index()
	{
		$data = array();

		// $data = $this -> setup_user_data($data);
		// $data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $content = file_get_contents('https://openapi.taifex.com.tw/v1/DailyForeignExchangeRates.php');
		// $currency = json_decode($content);
		// $data['currency'] = $currency;
		$items_img = $this -> img_style_dao -> find_carousel($data);
		foreach($items_img as $each){
			$data['carousel_id'][]= $each->id;
		}
		$items_news = $this -> news_dao -> find_carousel($data);
		$data['news']= $items_news[0];
		// $this -> to_json($data);
		$this->load->view('mgmt/carousel/list', $data);
	}


}
