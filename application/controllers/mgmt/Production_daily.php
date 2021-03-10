<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_daily extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Order_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Station_dao', 'station_dao');

		$this -> load -> model('service/Production_service', 'production_service');
	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);
		$data['station_list'] = $this -> station_dao -> find_all();

		$this->load->view('mgmt/production_daily/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'dt',
			'e_dt',
			'station_id',
			'multiple',
		));

		$data['no_limit'] = TRUE;

		$this -> session -> set_userdata('production_daily_last_data', $data);

		$items = $this -> production_service -> list_all_by_date($data);
		// error_log($this -> production_service -> db -> last_query());
		$res['items'] = $items;
		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$data['id'] = $id;

		$item = NULL;
		if(!empty($id)) {
			$q['id'] = $id;
			$items = $this -> dao -> query_ajax($q);
			$item = $items[0];
			$data['member'] = $this -> m_dao -> find_by_id($item -> member_id);
			$data['item'] = $item;

			$data['s_log_list'] = $this -> status_log_dao -> find_all_by_order_id($id);
			$data['p_log_list'] = $this -> ps_log_dao -> find_all_by_order_id($id);
		}

		$this->load->view('mgmt/production_daily/edit', $data);
	}

	function export_all() {
			$this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
			$date = date('YmdHis');
      $filename = $date."-pruduction-daily.csv";

			//create a file pointer
    	$f = fopen('php://memory', 'w');
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'日期'),
				iconv("UTF-8","Big5//IGNORE",'組別'),
				iconv("UTF-8","Big5//IGNORE",'人員帳號'),
				iconv("UTF-8","Big5//IGNORE",'名稱'),
				iconv("UTF-8","Big5//IGNORE",'料號'),
				iconv("UTF-8","Big5//IGNORE",'品名'),
				iconv("UTF-8","Big5//IGNORE",'總重'),
				iconv("UTF-8","Big5//IGNORE",'料品點數'),
				iconv("UTF-8","Big5//IGNORE",'總點數')
			);
			fputcsv($f, $fields, $delimiter);

			$dt = $this -> session -> userdata("production_daily_last_data");
      $result = $items = $this -> production_service -> list_all_by_date($dt);
			foreach($result as $each) {
				$lineData = array(
					$each -> account,
					iconv("UTF-8","Big5//IGNORE",$each -> user_name),
					$each -> lot_number,
					iconv("UTF-8","Big5//IGNORE",$each -> product_name),
					$each -> sum_weight,
					($each -> is_foreign == 1 ? $each -> reward_foreign : $each -> reward),
					($each -> is_foreign == 1 ? $each -> sum_reward_foreign : $each -> sum_reward),
				);

				fputcsv($f, $lineData, $delimiter);
			}
			//move back to beginning of file
    	fseek($f, 0);

			//set headers to download file rather than displayed
		  header('Content-Type: text/csv');
		  header('Content-Disposition: attachment; filename="' . $filename . '";');

			//output all remaining data on a file pointer
			fpassthru($f);
	}
}
