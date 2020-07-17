<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Computer extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Computer_dao', 'dao');
		$this -> load -> model('Computer_hard_dao', 'c_h_dao');
		$this -> load -> model('Computer_soft_dao', 'c_s_dao');
		$this -> load -> model('C_s_h_join_list_dao', 'c_s_h_join_list_dao');
		$this -> load -> model('Fix_record_dao', 'fix_record_dao');

		$this -> load -> model('Members_log_dao', 'members_log_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
	

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$this->load->view('mgmt/computer/list', $data);
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
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);

		$computer_hard_list = $this -> c_h_dao -> find_all_usage_not_zero();
		$computer_soft_list = $this -> c_s_dao -> find_all_usage_not_zero();
		// $all_user_list = $this -> c_s_dao -> find_all_user();

		$data['computer_hard_list'] = $computer_hard_list;//硬體所有list
		$data['computer_soft_list'] = $computer_soft_list;//軟體所有list
		$data['computer_soft_list'] = $computer_soft_list;//軟體所有list

		$data['login_user'] = $login_user;
		// $data['coach'] = $this -> dao -> find_all_coach();
		// $this -> to_json($data);

		$this->load->view('mgmt/computer/edit', $data);
	}

	public function get_fix_record() {
		$res = array();

		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'computer',
		));

		$res['items'] = $this -> fix_record_dao -> find_compter_fix($data);
		foreach($res['items'] as $each){
			$o_h = $each ->old_computer_hard_id;
			$o_s = $each ->old_computer_soft_id;
			$n_h = $each ->new_computer_hard_id;
			$n_s = $each ->new_computer_soft_id;
			$o_h_name = $this -> c_h_dao -> find_sh_name($o_h);
			$o_s_name = $this -> c_s_dao -> find_sh_name($o_s);
			$n_h_name = $this -> c_h_dao -> find_sh_name($n_h);
			$n_s_name = $this -> c_s_dao -> find_sh_name($n_s);
			if(!empty($o_h_name)){
				$each -> o_h_name = $o_h_name;
			} else{
				$each -> o_h_name = '';
			}
			if(!empty($o_s_name)){
				$each -> o_s_name = $o_s_name;
			} else{
				$each -> o_s_name = '';
			}
			if(!empty($n_h_name)){
				$each -> n_h_name = $n_h_name;
			} else{
				$each -> n_h_name = '';
			}
			if(!empty($n_s_name)){
				$each -> n_s_name = $n_s_name;
			} else{
				$each -> n_s_name = '';
			}
		}
		$res['recordsFiltered'] = $this -> fix_record_dao -> find_compter_fix($data, TRUE);
		$res['recordsTotal'] = $this -> fix_record_dao -> find_compter_fix($data, TRUE);

		$this -> to_json($res);
	}

	public function get_fix_recording() {
		$res = array();

		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'computer',
		));

		$res['items'] = $this -> fix_record_dao -> find_compter_fixing($data);
		foreach($res['items'] as $each){
			$o_h = $each ->old_computer_hard_id;
			$o_s = $each ->old_computer_soft_id;
			$n_h = $each ->new_computer_hard_id;
			$n_s = $each ->new_computer_soft_id;
			$o_h_name = $this -> c_h_dao -> find_sh_name($o_h);
			$o_s_name = $this -> c_s_dao -> find_sh_name($o_s);
			$n_h_name = $this -> c_h_dao -> find_sh_name($n_h);
			$n_s_name = $this -> c_s_dao -> find_sh_name($n_s);
			$each -> o_h_name = $o_h_name;
			$each -> o_s_name = $o_s_name;
			$each -> n_h_name = $n_h_name;
			$each -> n_s_name = $n_s_name;
			if(!empty($o_h_name)){
				$each -> o_h_name = $o_h_name;
			} else{
				$each -> o_h_name = '';
			}
			if(!empty($o_s_name)){
				$each -> o_s_name = $o_s_name;
			} else{
				$each -> o_s_name = '';
			}
			if(!empty($n_h_name)){
				$each -> n_h_name = $n_h_name;
			} else{
				$each -> n_h_name = '';
			}
			if(!empty($n_s_name)){
				$each -> n_s_name = $n_s_name;
			} else{
				$each -> n_s_name = '';
			}
		}
		$res['recordsFiltered'] = $this -> fix_record_dao -> find_compter_fixing($data, TRUE);
		$res['recordsTotal'] = $this -> fix_record_dao -> find_compter_fixing($data, TRUE);

		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$computer_name = $this -> get_post('computer_name');
		$computer_num = $this -> get_post('computer_num');
		$computer_property_num = $this -> get_post('computer_property_num');
		$admin_user = $this -> get_post('admin_user');
		$hard_id_array = $this -> get_post('hard_id_array');
		$soft_id_array = $this -> get_post('soft_id_array');
		$new_hard_id_array = mb_split(",", $hard_id_array);
		$new_soft_id_array = mb_split(",", $soft_id_array);
		$data['computer_name'] = $computer_name;
		$data['computer_num'] = $computer_num;
		$data['computer_property_num'] = $computer_property_num;
		$data['admin_user_id'] = $admin_user;

		if(empty($id)) {
			// insert
			$last_id = $this -> dao -> insert($data);
			$u_data['computer_id'] = $last_id;
			foreach($new_hard_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
			foreach($new_soft_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
		} else {
			$this -> dao -> update($data, $id);
			$u_data['computer_id'] = $id;
			foreach($new_hard_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
			foreach($new_soft_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
		}

		$res['success'] = TRUE;
		$res['computer_soft_id_array'] = $soft_id_array;
		$res['computer_hard_id_array'] = $hard_id_array;

 		$this -> to_json($res);
	}

	public function add_useful() {
		$res = array();
		$c_h_id = $this -> get_post('c_h_id');
		$c_s_id = $this -> get_post('c_s_id');

		if(!empty($c_h_id)){
			$c_h_list= $this -> c_h_dao -> find_by_id($c_h_id);
			$u_data['usage_count'] = intval($c_h_list->usage_count) -1;
			$i_data['computer_hard_id'] = $c_h_id;

			$last_id = $this -> c_s_h_join_list_dao -> insert($i_data);
			$this -> c_h_dao -> update($u_data,$c_h_id);
			$res['last_hard_id'] = $last_id;
			$res['hard_name'] = $c_h_list->computer_hard_name;
			$res['hard_num'] = $c_h_list->computer_num;

		} 
		
		if(!empty($c_s_id)){
			$c_s_list= $this -> c_s_dao -> find_by_id($c_s_id);
			$u_data['usage_count'] = intval($c_s_list->usage_count) -1;
			$i_data['computer_soft_id'] = $c_s_id;

			$last_id = $this -> c_s_h_join_list_dao -> insert($i_data);
			$this -> c_s_dao -> update($u_data,$c_s_id);
			$res['last_soft_id'] = $last_id;
			$res['soft_name'] = $c_s_list->computer_soft_name;
			$res['soft_num'] = $c_s_list->computer_num;

		} 
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$data['is_delete'] = 1;
		$data['delete_userid'] = $login_user->id;

		$hard_list = $this -> c_s_h_join_list_dao -> find_all_by_id($id,0);
		$soft_list = $this -> c_s_h_join_list_dao -> find_all_by_id($id,1);
		foreach($hard_list as $each){
			$this -> c_h_dao -> update($data, $each->hard_id);
		}
		foreach($soft_list as $each){
			$soft_now_list = $this -> c_s_dao -> find_by_id($each->soft_id);
			if(!empty($soft_now_list) && $soft_now_list->usage_count==0){//如過使用次數剩餘0才做刪除
				$this -> c_s_dao -> update($data, $soft_now_list->id);
			}
		}
		$this -> dao -> update($data, $id);
		$this -> to_json($res);
	}

	public function find_now_s_h_list() {
		$computer_id = $this -> get_post('computer_id');
		if($computer_id>0){
			$hard_list = $this -> c_s_h_join_list_dao -> find_use_now_by_computer($computer_id,0);
			$soft_list = $this -> c_s_h_join_list_dao -> find_use_now_by_computer($computer_id,1);
			$res['hard_list'] = $hard_list;
			$res['soft_list'] = $soft_list;

		}
		$res['success'] = TRUE;
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
