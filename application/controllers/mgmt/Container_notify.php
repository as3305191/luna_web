<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Container_notify extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Container_notify_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Station_dao', 'station_dao');

		$this -> load -> model('service/Trans_service', 'trans_service');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		$this->load->view('mgmt/container_notify/list', $data);
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
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/container_notify/edit', $data);
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
			'short_sn',
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

	public function copy() {

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

				$trace_code = $worksheet->getCell('G' . $row)->getCalculatedValue();
				$container_sn = $worksheet->getCell('P' . $row)->getCalculatedValue();
				$factory_sn = $worksheet->getCell('N' . $row)->getCalculatedValue();
				$product_name = $worksheet->getCell('O' . $row)->getCalculatedValue();

				$item = $this -> dao -> find_by_excel($trace_code, $container_sn, $factory_sn, $product_name);

				if(empty($item)) {
					$idx = 1;
					$i_data = array();
					$i_data['流水#'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['案號'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['品編'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['入廠地點'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['樣本編號'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['採購單'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['追溯批號'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['入廠日期'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['入廠數量'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['產品規格'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['拆櫃時間'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['購入公司'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['廠商名稱'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['生產廠號'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['品名'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['櫃號'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['屠宰日-起'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['屠宰日-迄'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['保存天數'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['有效日-起'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['有效日-迄'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['檢疫證號'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['封條'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();
					$i_data['異常數量'] = $worksheet->getCellByColumnAndRow($idx++, $row)->getCalculatedValue();

					$this -> dao -> insert($i_data);
				} else {

				}
			}
		} else {
			$res['error_msg'] = "不支援檔案";
		}



		$this -> to_json($res);
	}

}
