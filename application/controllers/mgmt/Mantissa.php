<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantissa extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Order_dao', 'dao');
		$this -> load -> model('Order_dao_v2', 'dao_v2');
		$this -> load -> model('Order_station_dao', 'order_station_dao');
		$this -> load -> model('Order_product_dao', 'order_product_dao');
		$this -> load -> model('Order_record_dao', 'or_dao');
		$this -> load -> model('Order_station_record_dao', 'osr_dao');
		$this -> load -> model('Order_sn_dao', 'order_sn_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Station_dao', 'station_dao');
		$this -> load -> model('Product_dao', 'product_dao');
		$this -> load -> model('Thaw_dao', 'thaw_dao');
		$this -> load -> model('Plant_dao', 'plant_dao');
		$this -> load -> model('Order_record_spare_dao', 'order_record_spare_dao');
		$this -> load -> model('Order_record_dao_v2', 'or_dao_v2');
		$this -> load -> model('Mantissa_dao', 'mantissa_dao');

	}
	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		// $data['thaw_list'] = $this -> thaw_dao -> find_all();
		// $data['sloc_list']= $this -> plant_dao -> list_all();
		$data['items'] = $this -> mantissa_dao -> find_list();
		// $this -> to_json($data);
		$this->load->view('mgmt/mantissa/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'status',
			'station_id',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);

		$thaw_list = $this -> thaw_dao -> find_all();
		$data['show_closed'] = "YES";
		$items = $this -> dao_v2 -> query_ajax($data);
		foreach($items as $each_item) {
			$this -> check_product_expire($each_item, $thaw_list);
		}
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);
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
			$q_data['show_closed'] = "YES";
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];


			$data['item'] = $item;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/mantissa/edit', $data);
	}

	public function flow($id) {
		$data = array();
		$data['id'] = $id;
		$station_id = $this -> get_post("station");
		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order'
			));
			if(!empty($station_id)) {
				$is_stock = $this -> station_dao -> find_by_id($station_id);
			}
			$q_data['id'] = $id;
			$q_data['show_closed'] = "YES";
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			$data['item'] = $item;

			$order_station_list = $this -> order_station_dao -> find_by_value(array(
				'order_id' => $item -> id
			));
			foreach($order_station_list as $station) {
				$station -> or_product_list = $this -> or_dao_v2-> find_group_product_all_by_order_and_station($item -> id, $station -> station_id);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 1);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list_0 = $this -> osr_dao-> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 0);
			}
			$data['order_station_list'] = $order_station_list;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		$data['is_stock'] = $is_stock;
	 	// $this -> to_json($data);

		$this->load->view('mgmt/mantissa/flow', $data);
	}

	public function edit_report($id) {
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
			$q_data['show_closed'] = "YES";
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			$data['item'] = $item;

			$data['type_0_list'] = $this -> get_product_list($item -> id, 0);
			$data['type_2_list'] = $this -> get_product_list($item -> id, 2);
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/mantissa/edit_report', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'sn',
			'note',
			'status',
			'start_time',
			'finish_time',
			'status',
		));

		$s_data = $this -> setup_user_data(array());

		$data['update_time'] = date("Y-m-d H:i:s");
		$data['update_user_id'] = $s_data['login_user_id'];

		if(empty($data['start_time'])) {
			$data['start_time'] = NULL;
		}
		if(empty($data['finish_time'])) {
			$data['finish_time'] = NULL;
		}

		// start transaction
		$this->dao->db->trans_begin();

		if(empty($id)) {
			// insert
			if(empty($data['sn'])) {
				$data['sn'] = $this -> order_sn_dao -> next_sn(date("Y-m-d"));
			}
			$id = $this -> dao -> insert($data);
		} else {
			$this -> dao -> update($data, $id);
		}

		// station list
		$station_list = $this -> get_post("station_list");
		$station_list = json_decode($station_list);
		foreach($station_list as $each) {
			// add
			if(empty($each -> id)) {
				$this -> order_station_dao -> insert(array(
					'station_id' => $each -> station_id,
					'order_id' => $id,
				));
			}
			// delete
			if(!empty($each -> id) && !empty($each -> is_del)) {
				$this -> order_station_dao -> delete($each -> id);
			}
		}

		// type0 list
		$tyep0_list = $this -> get_post("type0_list");
		$tyep0_list = json_decode($tyep0_list);
		foreach($tyep0_list as $each) {
			// add
			if(empty($each -> id)) {
				$this -> order_product_dao -> insert(array(
					'product_id' => $each -> product_id,
					'weight' => $each -> weight,
					'actual_weight' => $each -> actual_weight,
					'trace_batch' => $each -> trace_batch,
					'sloc' => $each -> sloc,
					'container_sn' => $each -> container_sn,
					'type' => 0,
					'order_id' => $id,
					'thaw_id' => $each -> thaw_id,
					'thaw_date' => empty($each -> thaw_date) ? NULL: $each -> thaw_date,
				));
			}

			// update
			if(!empty($each -> id)) {
				if(!empty($each -> is_del)) {
					// delete
					$this -> order_product_dao -> delete($each -> id);
				} else {
					// update
					$this -> order_product_dao -> update(array(
						'weight' => $each -> weight,
						'actual_weight' => $each -> actual_weight,
						'trace_batch' => $each -> trace_batch,
						'sloc' => $each -> sloc,
						'container_sn' => $each -> container_sn,
						'thaw_id' => $each -> thaw_id,
						'thaw_date' => empty($each -> thaw_date) ? NULL: $each -> thaw_date,
					), $each -> id);
				}
			}
		}

		// type1 list
		$tyep2_list = $this -> get_post("type2_list");
		$tyep2_list = json_decode($tyep2_list);
		foreach($tyep2_list as $each) {
			// add
			if(empty($each -> id)) {
				$this -> order_product_dao -> insert(array(
					'product_id' => $each -> product_id,
					'weight' => $each -> weight,
					'actual_weight' => $each -> actual_weight,
					'trace_batch' => $each -> trace_batch,
					'sloc' => $each -> sloc,
					'container_sn' => $each -> container_sn,
					'type' => 2,
					'order_id' => $id,
				));
			}

			// update
			if(!empty($each -> id)) {
				if(!empty($each -> is_del)) {
					// delete
					$this -> order_product_dao -> delete($each -> id);
				} else {
					// update
					$this -> order_product_dao -> update(array(
						'weight' => $each -> weight,
						'actual_weight' => $each -> actual_weight,
						'trace_batch' => $each -> trace_batch,
						'sloc' => $each -> sloc,
						'container_sn' => $each -> container_sn,
					), $each -> id);
				}
			}
		}

		if ($this->dao->db->trans_status() === FALSE)
		{
		        $this->dao->db->trans_rollback();
		}
		else
		{
		        $this->dao->db->trans_commit();
		}

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		//$this -> dao -> delete_status($id, $this -> session -> userdata('user_id'));
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	function check_product_expire($each_item, $thaw_list) {
		if($each_item -> status != 0) { // 除了進行中其他的狀態都不用計算
			return;
		}
		// find type 0
		$product_list = $this -> order_product_dao -> find_by_value(array(
			'order_id' => $each_item -> id,
			'type' => 0,
		));
		$max_expire = 0;
		$thaw_expire = 0;
		$order_expire = 0;

		// check product expire
		foreach($product_list as $each_product) {
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
					$max_expire = max($max_expire, $thaw_expire);
				}
			}
			$each_product -> thaw_expire = $thaw_expire;
		}

		$each_item -> thaw_expire = $max_expire;

		if(!empty($each_item -> start_time)) {
			$dStart = new DateTime($each_item->start_time);
			$dEnd  = new DateTime(date("Y-m-d"));
			$dDiff = $dStart -> diff($dEnd);
			$order_expire = $dDiff -> days;
		}
		$each_item -> order_expire = $order_expire;
	}

	// ---
	function station_list() {
		$res = array();
		$res['success'] = TRUE;

		$order_id = $this -> get_post("order_id");
		$list = array();
		if(!empty($order_id)) {
			$list = $this -> order_station_dao -> find_by_value(array(
				'order_id' => $this -> get_post("order_id")
			));
		}
		$res['list'] = $list;
		$this -> to_json($res);
 	}

	function station_search() {
		$res = array();
		$res['success'] = TRUE;

		$q = $this -> get_post("q");
		$res['list'] = $this -> station_dao -> search($q);
		$this -> to_json($res);
 	}

	function product_search() {
		$res = array();
		$res['success'] = TRUE;

		$q = $this -> get_post("q");
		$list = array();
		if(!empty($q)) {
			$list = $this -> product_dao -> search($q);
		}
		$res['list'] = $list;
		$this -> to_json($res);
 	}

	function barcode_search() {
		$res = array();
		$res['success'] = TRUE;
		$psn = $this -> get_post("psn");

		$q = substr("$psn", 0, 7);
		$list = array();
		if(!empty($psn)) {
			$list = $this -> product_dao -> search_barcode($q);
			$list1 = $this -> or_dao -> search_psn($psn);
		}
		$res['list'] = $list;
		$psn_7_4=substr($psn, 7, 6);
		$psn_2=substr($psn, -2);
		$res['trace_batch_number'] = "20".$psn_7_4.$psn_2;
		$this -> to_json($res);

 	}

	// ---
	function product_list() {
		$res = array();
		$res['success'] = TRUE;

		$order_id = $this -> get_post("order_id");
		$type = $this -> get_post("type");

		$list = $this -> get_product_list($order_id, $type);
		$res['list'] = $list;
		$this -> to_json($res);
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

	function rceipt() {
		$res = array();
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	function barcode_insert() {
		$res = array();
		$psn = $this -> get_post("psn");
		$order_id= $this -> get_post("order_id");
		$product_id= $this -> get_post("product_id");
		$station_id= $this -> get_post("station_id");
		$product_lot_number= $this -> get_post("product_lot_number");
		$product_name= $this -> get_post("product_name");
		$container_sn= $this -> get_post("container_sn");
		$product_sloc= $this -> get_post("product_sloc");
		$all_weight= $this -> get_post("all_weight");
		$all_pieces= $this -> get_post("all_pieces");
		$trace_batch_number= $this -> get_post("trace_batch_number");
		$factory_number= $this -> get_post("factory_number");

		$i_data['order_id']= $order_id;
		$i_data['from_station_id']= 0;
		$i_data['station_id']= $station_id;
		$i_data['storage']= 0;
		$i_data['product_id']= $product_id;
		$i_data['psn']= $psn;
		$i_data['trace_batch']= $trace_batch_number;
		$i_data['fty']= $factory_number;
		$i_data['container_sn']= $container_sn;
		$i_data['sloc']= $product_sloc;
		$i_data['weight']= $all_weight;
		$i_data['number']= $all_pieces;

		$i_data1['order_id']= $order_id;
		$i_data1['product_id']= $product_id;
		$i_data1['psn']= $psn;
		$i_data1['trace_batch']= $trace_batch_number;
		$i_data1['fty']= $factory_number;
		$i_data1['container_sn']= $container_sn;
		$i_data1['sloc']= $product_sloc;
		$i_data1['actual_weight']= $all_weight;

	if(!empty($factory_number)&&!empty($trace_batch_number)&&!empty($all_weight)&&!empty($all_pieces)&&!empty($product_sloc)){
		$find_op=$this -> order_product_dao -> find_by_op_value($order_id,$product_id);
		if(!empty($find_op)){
			$insert_spare = $this-> order_record_spare_dao -> insert($i_data);
			if($insert_spare){
				$find_od=$this -> or_dao -> find_by_od_value($order_id,$product_id,$trace_batch_number,$station_id);
				if(!empty($find_od)){
					$weight_s=intval($find_od[0]->weight)+$all_weight;
					$num_s=intval($find_od[0]->number)+$all_pieces;
					$update_or =$this-> or_dao -> update_by(array('weight' =>$weight_s,'number' =>$num_s),'id',$find_od[0]->id);
					$sum_weight=$this-> order_record_spare_dao -> find_sum($order_id,$product_id,$trace_batch_number,$factory_number,$container_sn,$product_sloc);
					$find_opd=$this -> order_product_dao -> find_by_opd_value($order_id,$product_id,$trace_batch_number,$factory_number,$container_sn,$product_sloc);
						if(!empty($find_opd)){
							$this-> order_product_dao -> update_by(array('actual_weight' =>$sum_weight[0]->weight),'id',$find_opd[0]->id);
							$res['success'] = "true";
						} else{
							$insert_or =$this-> order_product_dao -> insert($i_data1);
							$res['success'] = "true";
						}

				} else{
					$insert_or =$this-> or_dao -> insert($i_data);
					if($insert_or){
						$sum_weight=$this-> order_record_spare_dao -> find_sum($order_id,$product_id,$trace_batch_number,$factory_number,$container_sn,$product_sloc);
						$find_opd=$this -> order_product_dao -> find_by_opd_value($order_id,$product_id,$trace_batch_number,$factory_number,$container_sn,$product_sloc);
							if(!empty($find_opd)){
								$this-> order_product_dao -> update_by(array('actual_weight' =>$sum_weight[0]->weight),'id',$find_opd[0]->id);
								$res['success'] = "true";
							} else{
								$insert_or =$this-> order_product_dao -> insert($i_data1);
								$res['success'] = "true";
							}
					}
				}
			}
		} else{
			$res['err_message'] = "true";
		}
	} else{
	}
		$this -> to_json($res);

 	}

	function delete_or() {
		$res = array();
		$or_id = $this -> get_post("id");
		if(!empty($or_id)) {
			$d = $this-> or_dao_v2 -> find_item($or_id);
			if(!empty($d)){
				$data = array(
					"order_id" => $d -> order_id,
					"from_station_id" => $d -> from_station_id,
					"station_id" => $d -> station_id,
					"product_id" => $d -> product_id,
					"container_sn" => $d -> container_sn,
					"psn" => $d -> psn,
					"trace_batch" => $d -> trace_batch,
					"fty" => $d -> fty,
					"sloc" => $d -> sloc,
					"thaw_id" => $d -> thaw_id,
					"thaw_date" => $d -> thaw_date,
					"weight" => - $d -> weight,
					"number" => - $d -> number,
				);
				$res['success'] = $data;
				$this -> order_record_spare_dao -> insert($data);
				$this -> or_dao_v2 -> delete($or_id);
				$data1 = array("order_id" => $d -> order_id,
											"product_id" => $d -> product_id,
											);

				if(!empty($d -> psn)){
					$data1['psn'] = $d -> psn;
				}

				if(!empty($d -> trace_batch)){
					$data1['trace_batch'] = $d -> trace_batch;
				}

				if(!empty($d -> fty)){
					$data1['fty'] = $d -> fty;
				}

				if(!empty($d -> sloc)){
					$data1['sloc'] = $d -> sloc;
				}
				$sum = $this -> order_record_spare_dao -> sum_by($data1);
				$new_data['actual_weight'] = $sum[0]-> weight;
				if(!empty($new_data)){
					$op = $this -> order_product_dao -> find_by_value($data1);
					$this -> order_product_dao -> update($new_data,$op[0]->id);
					$res['success'] = "true";
				}
			}
		}
		$this -> to_json($res);
	}

	function find_is_stock() {
		$res = array();
		$res['success'] = TRUE;

		$station_id = $this -> get_post("st");
		$list = $this -> station_dao -> find_by_id($station_id);
		$res['is_stock'] = $list;
		$this -> to_json($res);
 	}

	function mantissa() {
		$res = array();

		$i_data['order_id'] = $this -> get_post("order_id");
		$i_data['product_id']= $this -> get_post("product_id");
		$weight= $this -> get_post("weight");
		$i_data['weight']=-$weight;
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
		$i_data['number']= $this -> get_post("number");
		$i_data['status']= "2";

		if(!empty($i_data['weight']) && !empty($i_data['number'])){
			$this-> mantissa_dao ->insert($i_data);
			$res['success'] = "true";
		} else{
			$res['error'] = "true";
		}


		$this -> to_json($res);
	}
}
