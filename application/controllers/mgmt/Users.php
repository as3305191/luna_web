<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Users_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Department_dao','d_dao');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['role_list'] = $this -> dao -> find_all_department();
		// $data['hospital_list'] = $this -> dao -> find_all_hospital();
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);
		$this->load->view('mgmt/users/list', $data);
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
		$items = $this -> dao -> query_ajax($data);
		if(!empty($items->in_departant)){
			$items->in_departants = explode(",", str_replace('#', ',', $items->in_departant));
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
				'order',
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			if($item->role_id>0){
				$department = $this -> d_dao -> find_by_id($item->role_id);
				if($department->level==4){
					$item->new_department_id = $department->parent_id;
					$item->div_id = $department->id;
					$data['div_list'] = $this -> dao -> find_all_div($department->parent_id);
				} else{
					$item->department_id = $department->id;
				}
				if($department->level==1){
					$item->new_department_id = $department->parent_id;
					$item->div_id = $department->id;
					$data['div_list'] = $this -> dao -> find_all_div($department->parent_id);
				} else{
					$item->department_id = $department->id;
				}
			} else{
				$item->department_id = 0;
			}
			if(!empty($item->in_department)){
				$item->in_departments = explode(",", str_replace('#', ',', trim($item->in_department, "#")));

			} else{
				$item->department_id = 0;
			}
			$data['item'] = $item;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		$data['department_list'] = $this -> dao -> find_all_k_b_i_department();
		$data['department_list_1'] = $this -> dao -> find_all_k_b_i_department_div();
		
		// $this -> to_json($data);

		$this->load->view('mgmt/users/edit', $data);
	}

	public function find_div_by_department() {
		$department = $this -> get_post('department');
		if($department>0){
			$list = $this -> d_dao -> find_all_by('parent_id', $department);
		}
		$res = array();
		$res['div_list'] = $list;
		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'account',
			'password',
			'user_name',
			
		));
		$role_id = $this -> get_post('role_id');
		$div_id = $this -> get_post('div_id');
		$department = $this -> get_post('in_department');
		if(!empty($department)){
			$new_department = str_replace(',', '#',implode(',',$department));
			if($new_department=='##'){
				$new_department=='0';
				$data['in_department'] = $new_department;
			} else{
				if(substr($new_department,-1)=="#" && substr($new_department,0,1)=="#"){
					$data['in_department'] = $new_department;
				} else{
					$data['in_department'] = "#".$new_department."#";
				}
			}
		}
		if(empty($id)) {
			// insert
			if(!empty($div_id)&&$div_id>0){
				$data['role_id'] = $div_id;
			} else{
				$data['role_id'] = $role_id;
			}
			$this -> dao -> insert($data);
		} else {
			if(!empty($div_id)&&$div_id>0){
				$data['role_id'] = $div_id;
			} else{
				$data['role_id'] = $role_id;
			}
			$this -> dao -> update($data, $id);
		}

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	// public function update_user_name() {
	// 	$list = $this -> dao -> find_all();
	// 	foreach($list as $each){
	// 		$data['user_name'] = trim($each->user_name);
	// 		$this -> dao -> update($data, $each->id);
	// 	}

	// }

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
		$code = $this -> get_post('intro_code');
		$list = $this -> dao -> find_all_by('code', $code);
		$res = array();
		$res['valid'] = (count($list) > 0);
		$this -> to_json($res);
	}

	public function chg_user() {
		$user_id = $this -> get_post('user_id');
		$this -> session -> set_userdata('user_id', $user_id);
		$res = array();

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
