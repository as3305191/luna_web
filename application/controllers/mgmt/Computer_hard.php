<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Computer_hard extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Computer_hard_dao', 'dao');

		$this -> load -> model('Members_log_dao', 'members_log_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Ketone_record_dao', 'ketone_record_dao');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		// $data['role_list'] = $this -> users_dao -> find_all_roles();
		// $data['hospital_list'] = $this -> users_dao -> find_all_hospital();
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);

				// $this -> to_json($data);
		$this->load->view('mgmt/computer_hard/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'type',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$items = $this -> dao -> query_ajax($data);
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
				'order',
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			if(!empty($list)){
				$item = $list[0];
			} else{
				$item = 0;
			}
			$data['item'] = $item;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		// $this -> to_json($data);

		$this->load->view('mgmt/computer_hard/edit', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'computer_hard_name',
			'computer_num',
			'computer_property_num'
		));
		if(empty($id)) {
			// insert
			$this -> dao -> insert($data);
		} else {
			// update
			$this -> dao -> update($data, $id);
		}
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$id = $this -> get_get('id');
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$data['is_delete'] = 1;
		$data['delete_userid'] = $login_user->id;
		$this -> dao -> update($data, $id);
		$this -> to_json($res);
	}

	public function update_here() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'seed',
			'level_status'
		));
		$login_count = $this -> get_post('login_count');
		$the_day_list = $this -> dao -> find_by_id($id);
		$the_day = $the_day_list -> last_login_time;
		$that_day = date('Y-m-d',strtotime($the_day));
		$the_day_before = date("Y-m-d H:i:s",strtotime($the_day.'-1 day'));
		if(!empty($id)) {
			// insert
			$this -> dao -> update($data, $id);
			if (!empty($login_count)) {
				$u_data['login_count'] = $login_count;
				$u_data['last_login_time'] = $the_day_before;
				$this -> dao -> update($u_data, $id);
				$log_last = $this -> members_log_dao -> find_by_log111($id,$that_day);
				if(!empty($log_last)){
					$this -> members_log_dao -> delete($log_last);
				}
			}
		}

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function check_account($id) {
		$account = $this -> get_post('account');
		$item = $this -> dao -> find_by("account", $account);
		$res = array();
		if(!empty($id)) {
			if (!empty($item)) {
				if($item -> id == $id) {
					$res['valid'] = TRUE;
				} else {
					$res['valid'] = FALSE;
				}

				$res['item'] = $item;
			} else {
				$res['valid'] = TRUE;
			}
		} else { // create
			if (!empty($item)) {
				$res['valid'] = FALSE;
			} else {
				$res['valid'] = TRUE;
			}
		}

		$this -> to_json($res);
	}

	public function check_code() {
		$res = array();
		$code = $this -> get_post('intro_code');
		$list = $this -> dao -> find_all_by('code', $code);
		$res['valid'] = (count($list) > 0);
		$this -> to_json($res);
	}

	public function chg_user() {
		$user_id = $this -> get_post('user_id');
		$this -> session -> set_userdata('user_id', $user_id);
		$res = array();

		$this -> to_json($res);
	}

	public function find_doctor(){
		$res = array();
		$hospital_id = $this -> get_post('hospital');
		// $res['result'] = TRUE;
		$res['list'] = $this -> users_dao -> find_doctor_by_hospital($hospital_id);
		$res['list_1'] = $this -> users_dao -> find_manager_by_hospital($hospital_id);

		$this -> to_json($res);
	}

	function export_all() {
			$this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
			$date = date('YmdHis');
      $filename = $date."-user.csv";

			$corp_list = $this -> corp_dao -> find_all();

			//create a file pointer
    	$f = fopen('php://memory', 'w');
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'帳號'),
				iconv("UTF-8","Big5//IGNORE",'會員姓名'),
				'Email',
				'LINE ID',
				iconv("UTF-8","Big5//IGNORE",'公司'),
				iconv("UTF-8","Big5//IGNORE",'貨幣數量'),
				'NTD',
				iconv("UTF-8","Big5//IGNORE",'藍鑽')
			);
			fputcsv($f, $fields, $delimiter);

      $query = "SELECT id, account,
				user_name,
				email, line_id, corp_id
      	FROM `users`
				WHERE status = 0 ";

			$s_data = $this -> setup_user_data(array());
			$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
			$data['login_user'] = $login_user;

			if($login_user -> role_id == 99) {
				// all roles

			} else {
				$query .= " and corp_id = {$login_user->corp_id} ";
			}

      $result = $this->db->query($query) -> result();
			foreach($result as $each) {
				$lineData = array($each -> account, iconv("UTF-8","Big5//IGNORE",$each -> user_name), $each -> email, $each -> line_id);

				$corp_sys_name = '';
				foreach($corp_list as $corp) {
					if($each -> corp_id == $corp -> id) {
						$corp_sys_name = $corp -> sys_name;
					}
				}

				$lineData[] = $corp_sys_name;
				$lineData[] = $this -> wtx_dao -> get_sum_amt($each -> id);
				$lineData[] = $this -> wtx_ntd_dao -> get_sum_amt($each -> id);
				$lineData[] = $this -> wtx_bdc_dao -> get_sum_amt($each -> id);
				// $lineData[]= 0;
				// $lineData[]= 0;
				// $lineData[]= 0;
				// foreach($lineData as $aCol) {
				// 	$aCol = iconv("UTF-8","Big5//IGNORE",$aCol);
				// }

				fputcsv($f, $lineData, $delimiter);
			}
			//move back to beginning of file

    	fseek($f, 0);

			//set headers to download file rather than displayed
			 header('Content-Type: text/csv');
			 header('Content-Disposition: attachment; filename="' . $filename . '";');

			 //output all remaining data on a file pointer
			 fpassthru($f);
      // $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
      // force_download($filename,@iconv("UTF-8","Big5//IGNORE",$data));
	}



}
