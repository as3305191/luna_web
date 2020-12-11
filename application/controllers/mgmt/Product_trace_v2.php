<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_trace_v2 extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Order_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Station_dao', 'station_dao');
		$this -> load -> model('service/Production_service', 'production_service');
		$this -> load -> model('Order_product_dao', 'order_product_dao');
	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);

		$data['station_list'] = $this -> station_dao -> find_all();

		$this->load->view('mgmt/product_trace_v2/list', $data);
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
			'lot_number',
			'product_name',
			'trace_batch',
			'container_sn',
			'type',
			'sn'
		));

		$data['no_limit'] = TRUE;

		$this -> session -> set_userdata('Product_trace_data', $data);
		$items = array();


		if(
			 !empty($data['lot_number']) ||
			 !empty($data['product_name']) ||
			 !empty($data['trace_batch']) ||
			 !empty($data['container_sn'])||
			 !empty($data['sn'])
		 ) {
			 	$items = $this -> production_service -> sum_order_record($data);
				$map  = array();
		 		foreach($items  as $each) {
		 			$each -> sum_weight_0 = $this -> order_product_dao -> sum_acutal_weight_by_type($each -> order_id, 0);
					$each -> sum_weight_2 = $this -> order_product_dao -> sum_acutal_weight_by_type($each -> order_id, 2);
					// $map[$key] = fause;
					$key = "$each->order_sn.$each->lot_number";
					if(empty($map[$key])) {
						$map[$key] = true;
						// bypass empty
						$res['weight1'] = $each-> sum_weight;
						if($map[$key] = true){
							$weight_other = $this -> order_product_dao -> find_container_sn_1($each->container_sn,$each->order_id);
							if(!empty($weight_other)){
								$each-> sum_weight=intval($weight_other[0]-> actual_weight)+intval($each-> sum_weight);
								// $map[$key] = TRUE;
								$res['weighttttttt'] = $weight_other;
							}
						}

					}	else {
							// empty weight
							$each-> sum_weight="0";
						}
		 		}
		 }

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

		$this->load->view('mgmt/production_daily_product/edit', $data);
	}

	function export_all() {
			$this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
			$date = date('YmdHis');
      $filename = $date."-pruduction-daily-product.csv";

			//create a file pointer
    	$f = fopen('php://memory', 'w');
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'時間'),
				iconv("UTF-8","Big5//IGNORE",'原料/成品'),
				iconv("UTF-8","Big5//IGNORE",'櫃號'),
				iconv("UTF-8","Big5//IGNORE",'工單編號'),
				iconv("UTF-8","Big5//IGNORE",'料號'),
				iconv("UTF-8","Big5//IGNORE",'品名'),
				iconv("UTF-8","Big5//IGNORE",'條碼'),
				iconv("UTF-8","Big5//IGNORE",'批號'),
				iconv("UTF-8","Big5//IGNORE",'工單產成'),
				iconv("UTF-8","Big5//IGNORE",'成品料號'),
				iconv("UTF-8","Big5//IGNORE",'成品品名'),
				iconv("UTF-8","Big5//IGNORE",'成品批號'),
				iconv("UTF-8","Big5//IGNORE",'工單原料(KG)'),
				iconv("UTF-8","Big5//IGNORE",'工單產出(KG)')
			);

			fputcsv($f, $fields, $delimiter);

			$data = $this -> session -> userdata("Product_trace_data");
      		$result = $items = $this -> production_service -> sum_order_record($data);
			$map  = array();
			foreach($items  as $each) {
				$each -> sum_weight_0 = $this -> order_product_dao -> sum_acutal_weight_by_type($each -> order_id, 0);
				$each -> sum_weight_2 = $this -> order_product_dao -> sum_acutal_weight_by_type($each -> order_id, 2);
				$key = "$each->order_sn.$each->lot_number";
				if(empty($map[$key])) {
					$map[$key] = TRUE;
					// bypass empty
				}	else {
					// empty weight
					$each-> sum_weight="0";
				}
			}

			$sum_weight = 0;
			$sum_weight_0 = 0;
			$sum_weight_2 = 0;
			foreach($result as $each) {
				$lineData = array(
					$each -> create_date,
					iconv("UTF-8","Big5//IGNORE",$each -> type == 2 ? '成品' : '原料'),
					$each -> container_sn,
					$each -> order_sn,
					$each -> lot_number,
					iconv("UTF-8","Big5//IGNORE",$each -> product_name),
					$each -> psn,
					$each -> trace_batch,
					number_format((float)($each -> sum_weight_0 > 0 ? ($each -> sum_weight_2 / $each -> sum_weight_0) : ''), 2, '.', ''),
					$each -> p_lot_number,
					iconv("UTF-8","Big5//IGNORE",$each -> p_name),
					$each -> trace_batch,
					$each -> sum_weight,
					$each -> actual_weight

				);

				$sum_weight_0 += floatval($each -> sum_weight);
				$sum_weight_2 += floatval($each -> actual_weight);
				$sum_weight_3 = floatval($sum_weight_2/$sum_weight_0);

				fputcsv($f, $lineData, $delimiter);
			}
			// print sum
			$lineData = array(
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				iconv("UTF-8","Big5//IGNORE","原料總計"),
				$sum_weight_0,
				iconv("UTF-8","Big5//IGNORE","成品總計"),
				$sum_weight_2,
				iconv("UTF-8","Big5//IGNORE","產成率"),
				$sum_weight_3


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
}
