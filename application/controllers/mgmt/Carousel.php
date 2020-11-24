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
		$this_year_first_day = date("Y")."-01-01";
		$during_now = date('z', strtotime($today)); 
		$today_h = date("H");
		$today_m = date("i");
		$today_s = date("s");
		$total_weekends = $this -> get_weekend_days($this_year_first_day,$today);
		foreach($data['items'] as $each){
			if($each->news_style_id==3){
				$coat =$each->cost;
				$each->during_now_s= ((($during_now-$total_weekends)*86400)+($today_h*3600)+($today_m*60)+$today_s)*$coat;
			} else{
				$each->during_now_s=0;
			}
		}

		// $data['this_year_first_day']= $this_year_first_day;
		// $data['today']= $today;
		// $this -> to_json($data);
		$this->load->view('mgmt/carousel/list', $data);
	}

	public function get_weekend_days($start_date,$end_date){

		if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date);
		
		$start_reduce = $end_add = 0;
		
		$start_N = date('N',strtotime($start_date));
		$start_reduce = ($start_N == 7) ? 1 : 0;
		
		$end_N = date('N',strtotime($end_date));
		in_array($end_N,array(6,7)) && $end_add = ($end_N == 7) ? 2 : 1;
		
		$days = abs(strtotime($end_date) - strtotime($start_date))/86400 + 1;
		
		return floor(($days + $start_N - 1 - $end_N) / 7) * 2 - $start_reduce + $end_add;
	}
}
