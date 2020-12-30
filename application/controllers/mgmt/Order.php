<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Order_dao', 'dao');
	
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		$data['thaw_list'] = $this -> thaw_dao -> find_all();
		$this->load->view('mgmt/orders/list', $data);
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
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);

		$thaw_list = $this -> thaw_dao -> find_all();

		$data['show_closed'] = "YES";
		$items = $this -> dao -> query_ajax($data);
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

		$this->load->view('mgmt/orders/edit', $data);
	}

	public function flow($id) {
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

			$order_station_list = $this -> order_station_dao -> find_by_value(array(
				'order_id' => $item -> id
			));
			foreach($order_station_list as $station) {
				$station -> or_product_list = $this -> or_dao -> find_group_product_all_by_order_and_station($item -> id, $station -> station_id);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 1);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list_0 = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 0);
			}
			$data['order_station_list'] = $order_station_list;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/orders/flow', $data);
	}

	public function flow_print($id) {
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

			$order_station_list = $this -> order_station_dao -> find_by_value(array(
				'order_id' => $item -> id
			));
			foreach($order_station_list as $station) {
				$station -> or_product_list = $this -> or_dao -> find_group_product_all_by_order_and_station($item -> id, $station -> station_id);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 1);
			}
			foreach($order_station_list as $station) {
				$station -> osr_product_list_0 = $this -> osr_dao -> find_group_product_all_by_order_station_and_type($item -> id, $station -> station_id, 0);
			}
			$data['order_station_list'] = $order_station_list;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/orders/flow_print', $data);
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
		$this -> session -> set_userdata('daily_report_data_by_id', $data['id']);

		// $this -> to_json($data);

		$this->load->view('mgmt/orders/edit_report', $data);
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
	public function mail()
	{
		$this->send_mail("inf@kwantex.com", "hi..", "測試郵件");
	}
}
