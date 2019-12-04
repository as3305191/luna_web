<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Order_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Station_dao', 'station_dao');
		$this -> load -> model('Order_record_dao', 'or_dao');
		$this -> load -> model('service/Production_service_v2', 'production_service_v2');
		$this -> load -> model('service/Production_service', 'production_service');
		$this -> load -> model('Mantissa_dao', 'mantissa_dao');


	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		$data['station_list'] = $this -> station_dao -> find_all();
		// $this -> to_json($data);
		$this->load->view('mgmt/receipt/list', $data);
	}

	public function get_user_list() {
		$station_id = $this -> get_post('station_id');
		$res = array();

		$list = $this -> users_dao -> find_all_by_station($station_id);
		$res['list'] = $list;
		$this -> to_json($res);
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
			'user_id',
			'type',
		));

		$data['no_limit'] = TRUE;

		if($data['type'] == '0') {
			$this -> session -> set_userdata('yield_rate_user_last_data_type_0', $data);
		} else {
			$this -> session -> set_userdata('yield_rate_user_last_data', $data);
		}

		$items = $this -> production_service_v2 -> list_all_by_date($data);
		error_log($this -> production_service_v2 -> db -> last_query());
		$res['items'] = $items;
		$this -> to_json($res);
	}

	public function flow() {
		$data = array();

		$s_data = $this -> get_posts(array(
			's_dt',
			'e_dt',
			'multiple',
		));

		$this -> session -> set_userdata('order_flow_last_s_data', $s_data);

		$order_station_list = $this -> station_dao -> find_all();
		foreach($order_station_list as $station) {
			$or_product_list = $this -> or_dao -> find_all_group_product_by_station_without_storage_1($station -> id,
				$s_data['multiple'],
				$s_data['s_dt'],
				$s_data['e_dt']
			);
			foreach ($or_product_list as $opl) {
				$man_weight =	$this -> mantissa_dao -> find_all_weight($opl -> id);
				$opl -> man_weight = $man_weight;

			}
			$station -> or_product_list = $or_product_list;
		}


		$data['order_station_list'] = $order_station_list;

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		// $this -> to_json($data);
		$this->load->view('mgmt/receipt/flow', $data);
	}

	public function flow_print() {
		$data = array();

		$s_data = $this -> session -> userdata("order_flow_last_s_data");

		$order_station_list = $this -> station_dao -> find_all();
		foreach($order_station_list as $station) {
			$station -> or_product_list = $this -> or_dao -> find_all_group_product_by_station_without_storage($station -> id,
				$s_data['multiple'],
				$s_data['s_dt'],
				$s_data['e_dt']
			);
		}

		$data['s_dt'] = $s_data['s_dt'];
		$data['e_dt'] = $s_data['e_dt'];

		$data['order_station_list'] = $order_station_list;

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/receipt/flow_print', $data);
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

		$this->load->view('mgmt/receipt/edit', $data);
	}

	function export_all() {
			$this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
			$date = date('YmdHis');
      $filename = $date."-yield_rate_user.csv";

			//create a file pointer
    	$f = fopen('php://memory', 'w');
			// type 0
			$lineData = array(
				iconv("UTF-8","Big5//IGNORE","發料"),
				"",
				"",
				"",
			);
			fputcsv($f, $lineData, $delimiter);
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

			// ---
			$sum_weight_0 = 0;
			$sum_weight_1 = 0;

			$data = $this -> session -> userdata("yield_rate_user_last_data_type_0");
      $result = $items = $this -> production_service -> list_all_by_date($data);

			$sum_weight = 0;
			$sum_reward = 0;
			foreach($result as $each) {
				$lineData = array(
					$each -> create_date,
					iconv("UTF-8","Big5//IGNORE",$each -> station_name),
					iconv("UTF-8","Big5//IGNORE",$each -> account),
					iconv("UTF-8","Big5//IGNORE",$each -> user_name),
					$each -> lot_number,
					iconv("UTF-8","Big5//IGNORE",$each -> product_name),
					$each -> sum_weight,
					($each -> is_foreign == 1 ? $each -> reward_foreign : $each -> reward),
					($each -> is_foreign == 1 ? $each -> sum_reward_foreign : $each -> sum_reward),
				);

				$sum_weight += floatval($each -> sum_weight);
				$sum_reward += floatval(($each -> is_foreign == 1 ? $each -> sum_reward_foreign : $each -> sum_reward));

				fputcsv($f, $lineData, $delimiter);
			}

			// print sum
			$sum_weight_0 = $sum_weight;
			$lineData = array(
				"",
				"",
				"",
				"",
				"",
				iconv("UTF-8","Big5//IGNORE", "總重"),
				$sum_weight,
				"",
				$sum_reward,
			);
			fputcsv($f, $lineData, $delimiter);

			// type 1
			$lineData = array(
				iconv("UTF-8","Big5//IGNORE","收料"),
				"",
				"",
				"",
			);
			fputcsv($f, $lineData, $delimiter);
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

			$data = $this -> session -> userdata("yield_rate_user_last_data");
      $result = $items = $this -> production_service -> list_all_by_date($data);

			$sum_weight = 0;
			$sum_reward = 0;
			foreach($result as $each) {
				$lineData = array(
					$each -> create_date,
					iconv("UTF-8","Big5//IGNORE",$each -> station_name),
					iconv("UTF-8","Big5//IGNORE",$each -> account),
					iconv("UTF-8","Big5//IGNORE",$each -> user_name),
					$each -> lot_number,
					iconv("UTF-8","Big5//IGNORE",$each -> product_name),
					$each -> sum_weight,
					($each -> is_foreign == 1 ? $each -> reward_foreign : $each -> reward),
					($each -> is_foreign == 1 ? $each -> sum_reward_foreign : $each -> sum_reward),
				);

				$sum_weight += floatval($each -> sum_weight);
				$sum_reward += floatval(($each -> is_foreign == 1 ? $each -> sum_reward_foreign : $each -> sum_reward));

				fputcsv($f, $lineData, $delimiter);
			}

			// print sum
			$sum_weight_1 = $sum_weight;
			$ratio = ($sum_weight_1 > 0 ? $sum_weight_0 / $sum_weight_1 : 0);
			$lineData = array(
				"",
				"",
				"",
				"",
				"",
				iconv("UTF-8","Big5//IGNORE", "總重"),
				$sum_weight,
				"",
				$sum_reward,
				iconv("UTF-8","Big5//IGNORE","產成比"),
				number_format($ratio, 2),
			);
			fputcsv($f, $lineData, $delimiter);

			//move back to beginning of file
    	fseek($f, 0);

			//set headers to download file rather than displayed
		  header('Content-Type: text/csv');
		  header('Content-Disposition: attachment; filename="' . $filename . '";');

			//output all remaining data on a file pointer
			fpassthru($f);
	}

	function mantissa() {
		$res = array();

		$i_data['order_id'] = $this -> get_post("order_id");
		$i_data['product_id']= $this -> get_post("product_id");
		$i_data['weight']= $this -> get_post("weight");
		$i_data['psn']= $this -> get_post("psn");
		$i_data['station_id']= $this -> get_post("station_id");
		$i_data['from_station_id']= $this -> get_post("from_station_id");
		$i_data['sloc']= $this -> get_post("sloc");
		$i_data['storage']= $this -> get_post("storage");
		$i_data['trace_batch']= $this -> get_post("trace_batch");
		$i_data['batch']= $this -> get_post("batch");
		$i_data['fty']= $this -> get_post("fty");
		$i_data['container_sn']= $this -> get_post("container_sn");
		$i_data['thaw_id']= $this -> get_post("thaw_id");
		$i_data['thaw_date']= $this -> get_post("thaw_date");
		$i_data['note']= $this -> get_post("note");
		$i_data['actual_weight']= $this -> get_post("actual_weight");
		$i_data['create_id']= $this -> get_post("creat_id_m");
		$i_data['record_id']= $this -> get_post("record_id");

		if(!empty($i_data['weight'])){
			$this-> mantissa_dao ->insert($i_data);
			$res['success'] = "true";
		} else{
			$res['error'] = "true";
		}


		$this -> to_json($res);
	}
}
