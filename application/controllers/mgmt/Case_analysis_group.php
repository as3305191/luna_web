<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Case_analysis_group extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Daily_record_index_dao', 'd_r_index_dao');
		$this -> load -> model('Level_1_record_dao', 'level_1_record_dao');
		$this -> load -> model('Daily_record_question_dao', 'daily_r_q_dao');

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['role_list'] = $this -> dao -> find_all_roles();
		$data['hospital_list'] = $this -> dao -> find_all_hospital();
		$data['doctor'] = $this -> users_dao -> find_all_doctor();
		$data['manager'] = $this -> users_dao -> find_all_manager();
		$data['login_user'] = $this -> dao -> find_by_id($data['login_user_id']);
		$this->load->view('mgmt/case_analysis_group/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'hospital_id',

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
				'order',
				'hospital_id',

			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];

			$data['item'] = $item;
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		$data['hospital_list'] = $this -> dao -> find_all_hospital();
		$data['role_list'] = $this -> dao -> find_all_roles();
		$data['doctor'] = $this -> users_dao -> find_all_doctor();
		$data['manager'] = $this -> users_dao -> find_all_manager();

		$this->load->view('mgmt/case_analysis_group/edit', $data);
	}

	public function blood() {
		$algorithm = $this -> get_post('algorithm');
		$data = $this -> get_posts(array(
			'dt',
			'e_dt',
			'hospital',
			'doctor',
			'manager'
		));
		$res = array();
		if($algorithm==1){//平均
			$list = $this -> d_r_index_dao -> find_all_case_all($data);
			$res['blood'] = $list;
			$res['count'] = count($list);
			$comfortable_list_0 = $this -> level_1_record_dao -> find_all_type_0($data);
			$comfortable_list_1 = $this -> level_1_record_dao -> find_all_type_1($data);
			$res['comfortable_type_0'] = $comfortable_list_0;
			$res['comfortable_type_1'] = $comfortable_list_1;
			$res['count_type_0'] = count($comfortable_list_0);
			$res['count_type_1'] = count($comfortable_list_1);
			$question_14 = $this -> daily_r_q_dao -> find_all_question_group($data);
			$res['count_question_14'] = count($question_14);
			$res['question_14'] = $question_14;
		}
		if($algorithm==3){//中位數
			$list = $this -> d_r_index_dao -> find_all_for_mid($data);
			foreach ($list as $each) {
				$each->mid = $this -> d_r_index_dao -> find_all_mid_by_date($each->date1,$data);
				$each -> date= date('m-d',strtotime($each -> date1));
			}
			$res['blood'] = $list;
			$res['count'] = count($list);
			$comfortable_list_0 = $this -> level_1_record_dao -> find_mid_date_type1212($data,0);
			foreach ($comfortable_list_0 as $each_list0) {
				$each_list0->mid = $this -> level_1_record_dao -> find_mid_by_date($each_list0->date1,$data,0);
				$each_list0 -> date= date('m-d',strtotime($each_list0 -> date1));
			}
			$comfortable_list_1 = $this -> level_1_record_dao -> find_mid_date_type1212($data,1);
			foreach ($comfortable_list_1 as $each_list1) {
				$each_list1->mid = $this -> level_1_record_dao -> find_mid_by_date($each_list0->date1,$data,1);
				$each_list1 -> date= date('m-d',strtotime($each_list1 -> date1));
			}
			$res['comfortable_type_0'] = $comfortable_list_0;
			$res['comfortable_type_1'] = $comfortable_list_1;
			$res['count_type_0'] = count($comfortable_list_0);
			$res['count_type_1'] = count($comfortable_list_1);
			$question_14 = $this -> daily_r_q_dao -> find_all_question_date($data);
			foreach ($question_14 as $each_q14) {
				$each_q14 -> mid = $this -> daily_r_q_dao -> find_mid_by_date($each_q14->date1,$data,0);
				$each_q14 -> date= date('m-d',strtotime($each_q14 -> date1));
			}
			$res['count_question_14'] = count($question_14);
			$res['question_14'] = $question_14;
		}

		if($algorithm==2){//標準差
			$list = $this -> d_r_index_dao -> find_all_for_mid($data);
			foreach ($list as $each) {
				$each->s_d = $this -> d_r_index_dao -> find_s_d_by_date($each->date1,$data);
				$each -> date= date('m-d',strtotime($each -> date1));
			}
			$res['blood'] = $list;
			$res['count'] = count($list);
			$comfortable_list_0 = $this -> level_1_record_dao -> find_mid_date_type1212($data,0);
			foreach ($comfortable_list_0 as $each_list0) {
				$each_list0-> s_d = $this -> level_1_record_dao -> find_s_d_by_date($each_list0->date1,$data,0);
				$each_list0 -> date= date('m-d',strtotime($each_list0 -> date1));
			}
			$comfortable_list_1 = $this -> level_1_record_dao -> find_mid_date_type1212($data,1);
			foreach ($comfortable_list_1 as $each_list1) {
				$each_list1-> s_d = $this -> level_1_record_dao -> find_s_d_by_date($each_list0->date1,$data,1);
				$each_list1 -> date= date('m-d',strtotime($each_list1 -> date1));
			}
			$res['comfortable_type_0'] = $comfortable_list_0;
			$res['comfortable_type_1'] = $comfortable_list_1;
			$res['count_type_0'] = count($comfortable_list_0);
			$res['count_type_1'] = count($comfortable_list_1);
			$question_14 = $this -> daily_r_q_dao -> find_all_question_date($data);
			foreach ($question_14 as $each_q14) {
				$each_q14 -> s_d = $this -> daily_r_q_dao -> find_s_d_by_date($each_q14->date1,$data,0);
				$each_q14 -> date= date('m-d',strtotime($each_q14 -> date1));
			}
			$res['count_question_14'] = count($question_14);
			$res['question_14'] = $question_14;
		}

		$res['algorithm'] = $algorithm;
		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'account',
			'password',
			'user_name',
			'role_id',
			'hospital_id',

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
		$this -> dao -> delete($id);
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

	function stats_standard_deviation(array $a, $sample = false) {//標準差公式
         $n = count($a);
         if ($n === 0) {
             trigger_error("The array has zero elements", E_USER_WARNING);
             return false;
         }
         if ($sample && $n === 1) {
             trigger_error("The array has only 1 element", E_USER_WARNING);
             return false;
         }
         $mean = array_sum($a) / $n;
         $carry = 0.0;
         foreach ($a as $val) {
             $d = ((double) $val) - $mean;
             $carry += $d * $d;
         };
         if ($sample) {
            --$n;
         }
         return sqrt($carry / $n);
     }
}
