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
		$this_month_first_day = date("Y-m")."-01";
		$during_now = date('z', strtotime($today)); 
		$today_h = date("H");
		$today_m = date("i");
		$today_s = date("s");
		$total_years_weekends = $this -> get_weekend_days($this_year_first_day,$today);
		$total_month_weekends = $this -> get_weekend_days($this_month_first_day,$today);
		$cost_list= $this -> news_dao -> find_last_cost();
		$cost = floatval($cost_list[0]->cost);
		$data['cost']  = $cost;
		$data['during_now_s'] = ((intval($during_now-$total_years_weekends)*28800)+(($today_h-8)*3600)+($today_m*60)+$today_s)*$cost;
		$data['during_m_now_s'] =(((intval(round((strtotime($today)-strtotime($this_month_first_day)))/3600/24)-$total_month_weekends)*28800)+(($today_h-8)*3600)+($today_m*60)+$today_s)*$cost;
		$data['during_today_now_s'] = ((($today_h-8)*3600)+($today_m*60)+$today_s)*$cost;
	
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
