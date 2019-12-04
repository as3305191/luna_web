<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_report extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('service/Order_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Order_product_dao', 'order_product_dao');
		$this -> load -> model('Order_dao', 'o_dao');

		$this -> load -> model('Thaw_dao', 'thaw_dao');
	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);
		$this->load->view('mgmt/daily_report_order/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'company_id',
			'status_filter',
			'start_time',
			'e_dt',
			'multiple',
		));


		$data['no_limit'] = TRUE;
		$this -> session -> set_userdata('daily_report_data', $data);
		$items = $this -> dao -> query_ajax($data);
		$res['items'] = $items;
		foreach($items as $each) {
			$each -> sum_weight_0 = $this -> order_product_dao -> sum_acutal_weight_by_type($each -> id, 0);
			$each -> sum_weight_2 = $this -> order_product_dao -> sum_acutal_weight_by_type($each -> id, 2);
		}

		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);


		// $res['status_cnt'] = $this -> dao -> count_all_status_by_data($data);
		// $res['pay_status_cnt'] = $this -> dao -> count_all_pay_status_by_data($data);

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

		$this->load->view('mgmt/daily_report_order/edit', $data);
	}
	function get_product_list($order_id, $type) {
		$list = array();
		if(!empty($order_id)) {
			$list = $this -> order_product_dao -> find_by_value(array(
				'order_id' => $order_id,
				'type' => $type,
			));

			if($type == 0) {
				$thaw_expire = 0;
				$thaw_list = $this -> thaw_dao -> find_all();

				foreach($list as $each_product) {
					$thaw_expire = 0;
					if($each_product -> thaw_id > 0 && !empty($each_product -> thaw_date)) {
						$thaw = NULL;
						foreach($thaw_list as $a_thaw) {
							if($a_thaw -> id == $each_product -> thaw_id) {
								$thaw = $a_thaw;
							}
						}
						if(!empty($thaw)) {
							$dStart = new DateTime($each_product->thaw_date);
							$dEnd  = new DateTime(date("Y-m-d"));
							$dDiff = $dStart -> diff($dEnd);
							$thaw_expire = $dDiff -> days;
							$tt = $dDiff->format('%R');
							$thaw_expire = ($tt == '+' ? 1 : -1) * $thaw_expire; // 顯示正負
							$thaw_expire = $thaw_expire - $thaw -> days;  // 扣掉天數
						}
					}
					$each_product -> thaw_expire = $thaw_expire;
				}
			}
		}

		return $list;
	}

	public function get_status_log() {
		$res = array();

		$order_id = $this -> get_post('order_id');
		$items = $this -> status_log_dao -> find_all_by_order_id($order_id);
		$res['items'] = $items;
		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'receive_name',
			'receive_phone',
			'receive_zip',
			'receive_address'
		));


		if(empty($id)) {
			// insert
			$id = $this -> dao -> insert($data);
		} else {
			// update
			$this -> dao -> update($data, $id);
		}

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete_status($id, $this -> session -> userdata('user_id'));
		$this -> to_json($res);
	}

	public function do_cancel() {
		$res['result'] = TRUE;
		$code = -50; // cancel by admin

		$order_id = $this -> get_post('id');
		$note = $this -> get_post('note');

		if(!empty($order_id)) {
			// update order
			$u_data['status'] = $code;

			// update pay staus
			$order = $this -> dao -> find_by_id($order_id);
			if($order -> pay_type_id == 4) { // Ticket
				$u_data['pay_status'] = -3;
			}

			$this -> dao -> update($u_data, $order_id);

			// release tickets
			$this -> tickets_dao -> release_pay_order($order_id);

			// update status log
			$i_data['user_id'] = $this -> session -> userdata('user_id');
			$i_data['order_id'] = $order_id;
			$i_data['status'] = $code;
			$i_data['note'] = empty($note) ? '' : $note;
			$this -> status_log_dao -> insert($i_data);
		} else {
			$res['error_code'][] = 'order_id_required';
		}

		$this -> to_json($res);
	}

	public function do_refund() {
		$res['result'] = TRUE;
		$pay_status = 0;

		$order_id = $this -> get_post('id');
		$note = $this -> get_post('note');

		if(!empty($order_id)) {
			// update pay staus
			$order = $this -> dao -> find_by_id($order_id);
			if($order -> pay_type_id == 1) { // Cash
				$pay_status = -1;
			}
			if($order -> pay_type_id == 3) { // Credit Card
				$pay_status = -2;
			}
			if($order -> pay_type_id == 4) { // Ticket
				$pay_status = -3;

				// release tickets
				$this -> tickets_dao -> release_pay_order($order_id);
			}
			$u_data['pay_status'] = $pay_status;
			$this -> dao -> update($u_data, $order_id);

			// update status log
			$i_data['user_id'] = $this -> session -> userdata('user_id');
			$i_data['order_id'] = $order_id;
			$i_data['status'] = $pay_status;
			$i_data['note'] = empty($note) ? '' : $note;
			$this -> ps_log_dao -> insert($i_data);
		} else {
			$res['error_code'][] = 'order_id_required';
		}

		$this -> to_json($res);
	}

	function get_product_list_by_type($order_id, $type) {
		$list = array();
		if(!empty($order_id)) {
			$list = $this -> order_product_dao -> find_by_value(array(
				'order_id' => $order_id,
				'type' => $type,
			));

			if($type == 0) {
				$thaw_expire = 0;
				$thaw_list = $this -> thaw_dao -> find_all();

				foreach($list as $each_product) {
					$thaw_expire = 0;
					if($each_product -> thaw_id > 0 && !empty($each_product -> thaw_date)) {
						$thaw = NULL;
						foreach($thaw_list as $a_thaw) {
							if($a_thaw -> id == $each_product -> thaw_id) {
								$thaw = $a_thaw;
							}
						}
						if(!empty($thaw)) {
							$dStart = new DateTime($each_product->thaw_date);
							$dEnd  = new DateTime(date("Y-m-d"));
							$dDiff = $dStart -> diff($dEnd);
							$thaw_expire = $dDiff -> days;
							$tt = $dDiff->format('%R');
							$thaw_expire = ($tt == '+' ? 1 : -1) * $thaw_expire; // 顯示正負
							$thaw_expire = $thaw_expire - $thaw -> days;  // 扣掉天數
						}
					}
					$each_product -> thaw_expire = $thaw_expire;
				}
			}
		}

		return $list;
	}

	function export_all() {
			$this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
			$date = date('YmdHis');
      $filename = $date."-pruduction-daily-product.csv";

			$data = $this -> session -> userdata("daily_report_data");

			//create a file pointer
    	$f = fopen('php://memory', 'w');
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'開始時間'),
				!empty($data['start_time'])? $data['start_time']: '',
				iconv("UTF-8","Big5//IGNORE",'結束時間'),
				!empty($data['e_dt'])? $data['e_dt']: '',
				"",
				"",
				"",
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'開始時間'),
				iconv("UTF-8","Big5//IGNORE",'工單編號'),
				iconv("UTF-8","Big5//IGNORE",'狀態'),
				iconv("UTF-8","Big5//IGNORE",'投入'),
				iconv("UTF-8","Big5//IGNORE",'產出'),
				iconv("UTF-8","Big5//IGNORE",'百分比'),
				iconv("UTF-8","Big5//IGNORE",'完工時間'),
			);
			fputcsv($f, $fields, $delimiter);


			$items = $this -> dao -> query_ajax($data);
			foreach($items as $each) {
				$each -> sum_weight_0 = $this -> order_product_dao -> sum_acutal_weight_by_type($each -> id, 0);
				$each -> sum_weight_2 = $this -> order_product_dao -> sum_acutal_weight_by_type($each -> id, 2);
			}
      $result = $items;
			$sum_weight = 0;
			$sum_number = 0;
			foreach($result as $each) {
				$lineData = array(
					$each -> start_time,
					$each -> sn,
					iconv("UTF-8","Big5//IGNORE",$each -> status_name),
					number_format((float)$each -> sum_weight_0, 2, '.', ''),
					number_format((float)$each -> sum_weight_2, 2, '.', ''),
					number_format((float)($each -> sum_weight_0 > 0 ? ($each -> sum_weight_2 / $each -> sum_weight_0) : ''), 2, '.', ''),
					$each -> finish_time,
				);
				// $sum_number += floatval($each -> sum_number);
				// $sum_weight += floatval($each -> sum_weight);
				fputcsv($f, $lineData, $delimiter);
			}
			// print sum
			// $lineData = array(
			// 	"",
			// 	iconv("UTF-8","Big5//IGNORE","總計"),
			// 	$sum_number,
			// 	$sum_weight,
			// );
			// fputcsv($f, $lineData, $delimiter);

			//move back to beginning of file
    	fseek($f, 0);

			//set headers to download file rather than displayed
		  header('Content-Type: text/csv');
		  header('Content-Disposition: attachment; filename="' . $filename . '";');

			//output all remaining data on a file pointer
			fpassthru($f);
	}

	function export_by_id() {
			$this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
			$date = date('YmdHis');
      $filename = $date."-pruduction-daily-product.csv";

			$id = $this -> session -> userdata("daily_report_data_by_id");
			// var_dump($data);
			$data = array();
			if(!empty($id)) {
				$q_data = $this -> get_posts(array(
					'length',
					'start',
					'columns',
					'search',
					'order'
				));

				$q_data['id'] = $id;
				$q_data['show_closed'] = "YES";
				$list = $this -> o_dao -> query_ajax($q_data);
				$item = $list[0];
				$data['item'] = $item;

				$data['type_0_list'] = $this -> get_product_list($item -> id, 0);
				$data['type_2_list'] = $this -> get_product_list($item -> id, 2);
			}
			// $this -> to_json($item);

			// create a file pointer
    	$f = fopen('php://memory', 'w');
			$fields = array(
				"",
				"",
				"",
				"",
			);
			fputcsv($f, $fields, $delimiter);
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'工單編號'),
				"",
				"",
				isset($item) ? $item -> sn : '',
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'工單編號SAP'),
				"",
				"",
				isset($item) ? $item -> sn_sap : '',
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'工單執行日期'),
				"",
				"",
				isset($item) ? $item -> start_time : '',
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'完工日期'),
				"",
				"",
				isset($item) ? $item -> start_time : '',

			);
			fputcsv($f, $fields, $delimiter);

			if($item -> status == 0){

				$fields = array(
					iconv("UTF-8","Big5//IGNORE",'狀態'),
					"",
					"",
					iconv("UTF-8","Big5//IGNORE",'未完成'),

				);
				fputcsv($f, $fields, $delimiter);

			} else if($item -> status == 1){
				$fields = array(
					iconv("UTF-8","Big5//IGNORE",'狀態'),
					"",
					"",
					iconv("UTF-8","Big5//IGNORE",'已完成'),

				);
				fputcsv($f, $fields, $delimiter);
				} else if($item -> status == 2){
					$fields = array(
						iconv("UTF-8","Big5//IGNORE",'狀態'),
						"",
						"",
						iconv("UTF-8","Big5//IGNORE",'取消'),

					);
					fputcsv($f, $fields, $delimiter);
					}


			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'備註'),
				"",
				"",
				isset($item) ? $item -> note : '',
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				"",
				"",
				"",
				"",
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'原料列表'),
				"",
				"",
				"",
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'料號'),
				iconv("UTF-8","Big5//IGNORE",'品名'),
				iconv("UTF-8","Big5//IGNORE",'櫃號'),
				iconv("UTF-8","Big5//IGNORE",'批號'),
				iconv("UTF-8","Big5//IGNORE",'需求重量'),
				iconv("UTF-8","Big5//IGNORE",'實際重量'),
				iconv("UTF-8","Big5//IGNORE",'解凍方式/日期'),

			);
			fputcsv($f, $fields, $delimiter);

			if(!empty($data['type_0_list'])){
				foreach($data['type_0_list'] as $each) {
					$lineData = array(
						$each -> lot_number,
						iconv("UTF-8","Big5//IGNORE",$each -> name),
						$each -> container_sn,
						$each -> trace_batch,
						$each -> weight,
						$each -> actual_weight,
						iconv("UTF-8","Big5//IGNORE",$each -> thaw_name.'/'.$each -> thaw_date ),
					);

					fputcsv($f, $lineData, $delimiter);
				}
			} else{
				$fields = array(
					"",
					"",
					"",
					"",
				);
				fputcsv($f, $fields, $delimiter);
			}

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'成品列表'),
				"",
				"",
				"",
			);

			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'料號'),
				iconv("UTF-8","Big5//IGNORE",'品名'),
				iconv("UTF-8","Big5//IGNORE",'櫃號'),
				iconv("UTF-8","Big5//IGNORE",'批號'),
				iconv("UTF-8","Big5//IGNORE",'需求重量'),
				iconv("UTF-8","Big5//IGNORE",'實際重量'),

			);
			fputcsv($f, $fields, $delimiter);

			if(!empty($data['type_2_list'])){
				foreach($data['type_2_list']as $each1) {
					$lineData = array(
						$each1 -> lot_number,
						iconv("UTF-8","Big5//IGNORE",$each1 -> name),
						$each1 -> container_sn,
						$each1 -> trace_batch,
						$each1 -> weight,
						$each1 -> actual_weight,
					);

					fputcsv($f, $lineData, $delimiter);
				}
			} else{
				$fields = array(
					"",
					"",
					"",
					"",
					"",
					"",
					"",

				);
				fputcsv($f, $fields, $delimiter);
			}

    	fseek($f, 0);

		  header('Content-Type: text/csv');
		  header('Content-Disposition: attachment; filename="' . $filename . '";');

			fpassthru($f);
	}
}
