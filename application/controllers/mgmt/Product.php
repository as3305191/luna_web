<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Product_dao', 'dao');
		$this -> load -> model('Roles_dao', 'roles_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Station_dao', 'station_dao');

		$this -> load -> model('service/Trans_service', 'trans_service');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		$this->load->view('mgmt/product/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);

		$res['items'] = $this -> dao -> query_ajax($data);
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
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];

			$data['item'] = $item;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		// $data['s_data'] = $s_data;

		$rp = $this -> roles_dao -> get_role_power($login_user -> role_id, 130);
		$power_list = !empty($rp -> power_list) ? json_decode($rp -> power_list) : array();
		if(in_array(1, $power_list)) {
			$data['edit_power'] = 1;
		}

		$this->load->view('mgmt/product/edit', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			// 'brand',
			// 'brand_no',
			'name',
			'weight_sn',
			'lot_number',
			'salary_code',
			'salary_code_foreign',
			'reward',
			'cut_cost',
		));

		if(empty($id)) {
			// insert
			$this -> dao -> insert($data);
		} else {
			$this -> dao -> update($data, $id);
		}

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		//$this -> dao -> delete_status($id, $this -> session -> userdata('user_id'));
		$this -> to_json($res);
	}

	public function code() {
		$res['success'] = TRUE;
		$this -> trans_service -> copy_code();
		$this -> to_json($res);
	}

	public function upload_excel() {
		$res['success'] = TRUE;
		$info = '';

		$name = $_FILES['file']['name'];
		$tmp_name = $_FILES['file']['tmp_name'];
		$type = $_FILES['file']['type'];
		$size = $_FILES['file']['size'];

		$ext = pathinfo($name, PATHINFO_EXTENSION);

		$reader = NULL;
		if($ext == "xls") {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		}
		if($ext == "xlsx") {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}

		if(!empty($reader)) {
			$spreadsheet = $reader->load($tmp_name);

			$worksheet = $spreadsheet->getActiveSheet();

			// Get the highest row and column numbers referenced in the worksheet
			$highestRow = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
			$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

			for ($row = 2; $row <= $highestRow; ++$row) {
				$weight_sn = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				$lot_number = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				$product_name = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

				$weight_sn = trim($weight_sn);
				$lot_number = trim($lot_number);
				$product_name = trim($product_name);
				$item = $this -> dao -> find_by("weight_sn", $weight_sn);
				if(empty($item)) {
					error_log("not found: " . $weight_sn);
					$i_data = array();
					$i_data['weight_sn'] = $weight_sn;
					$i_data['lot_number'] = $lot_number;
					$i_data['name'] = $product_name;
					$this -> dao -> insert($i_data);
				} else {
					$this -> dao -> update(array(
						'name' => $product_name
					), $item -> id);
				}
			}
		} else {
			$res['error_msg'] = "不支援檔案";
		}



		$this -> to_json($res);
	}

}
