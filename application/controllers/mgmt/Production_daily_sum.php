<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_daily_sum extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Order_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('service/Production_service', 'production_service');
	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);
		$this->load->view('mgmt/production_daily_sum/list', $data);
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
		));

		$data['no_limit'] = TRUE;

		$this -> session -> set_userdata('production_daily_sum_last_dt', $data['dt']);

		$items = $this -> production_service -> list_sum_all_by_date($data['dt']);
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

		$this->load->view('mgmt/production_daily_sum/edit', $data);
	}

	function export_all() {
			$this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
			$date = date('YmdHis');
      $filename = $date."-pruduction-daily-sum.csv";

			//create a file pointer
    	$f = fopen('php://memory', 'w');
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'人員帳號'),
				iconv("UTF-8","Big5//IGNORE",'名稱'),
				iconv("UTF-8","Big5//IGNORE",'總點數')
			);
			fputcsv($f, $fields, $delimiter);

			$dt = $this -> session -> userdata("production_daily_sum_last_dt");
      $result = $items = $this -> production_service -> list_sum_all_by_date($dt);
			foreach($result as $each) {
				$lineData = array(
					$each -> account,
					iconv("UTF-8","Big5//IGNORE",$each -> user_name),
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
