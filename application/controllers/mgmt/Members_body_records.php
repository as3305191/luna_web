<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members_body_records extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Members_log_dao', 'members_log_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Records_dao', 'records_dao');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$this->load->view('mgmt/members_body_records/list', $data);
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
			'dt',
			'e_dt',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$items = $this -> records_dao -> query_ajax($data);

		$res['items'] = $items;

		$res['recordsFiltered'] = $this -> records_dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> records_dao -> count_all_ajax($data);
		$this -> session -> set_userdata('members_body_records', $data);

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
			$health_report = $this -> records_dao -> find_record($q_data['id']);

			$data['item'] = $item;
			$data['health_report'] = $health_report[0];
		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$data['coach'] = $this -> dao -> find_all_coach();
		// $this -> to_json($data);

		$this->load->view('mgmt/members_body_records/edit', $data);
	}

	public function get_weight_history() {
		$res = array();

		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'member_id',

		));

		$res['items'] = $this -> records_dao -> find_user_weight_history($data);
		$res['recordsFiltered'] = $this -> records_dao -> find_user_weight_history($data, TRUE);
		$res['recordsTotal'] = $this -> records_dao -> find_user_weight_history($data, TRUE);

		$this -> to_json($res);
	}

	public function get_Keton_data() {
		$res = array();

		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'member_id',

		));

		$res['items'] = $this -> ketone_record_dao -> find_user_ketone($data);
		$res['recordsFiltered'] = $this -> ketone_record_dao -> find_user_ketone($data, TRUE);
		$res['recordsTotal'] = $this -> ketone_record_dao -> find_user_ketone($data, TRUE);

		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'account',
			'password',
			'user_name',
			'age',
			'gender',
			'height',
			'type',
			'coach_id',
			'birth',
			'email'
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
		$this -> records_dao -> delete($id);
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
      $filename = $date."-members_body_records.csv";

			$data = $this -> session -> userdata("members_body_records");

			//create a file pointer
    	$f = fopen('php://memory', 'w');
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'開始時間'),
				!empty($data['dt'])? $data['dt']: '',
				iconv("UTF-8","Big5//IGNORE",'結束時間'),
				!empty($data['e_dt'])? $data['e_dt']: '',
			);
			fputcsv($f, $fields, $delimiter);

			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'會員'),
				iconv("UTF-8","Big5//IGNORE",'阻抗'),
				iconv("UTF-8","Big5//IGNORE",'體重'),
				iconv("UTF-8","Big5//IGNORE",'體脂率'),
				iconv("UTF-8","Big5//IGNORE",'脂肪'),
				iconv("UTF-8","Big5//IGNORE",'內臟脂肪率'),
				iconv("UTF-8","Big5//IGNORE",'蛋白率'),
				iconv("UTF-8","Big5//IGNORE",'水分率'),
				iconv("UTF-8","Big5//IGNORE",'肌肉率'),
				iconv("UTF-8","Big5//IGNORE",'骨骼肌率'),
				iconv("UTF-8","Big5//IGNORE",'骨重率'),
				iconv("UTF-8","Big5//IGNORE",'皮下脂肪率'),
				iconv("UTF-8","Big5//IGNORE",'肥胖等級'),
				iconv("UTF-8","Big5//IGNORE",'BMR'),
				iconv("UTF-8","Big5//IGNORE",'身體年齡'),
				iconv("UTF-8","Big5//IGNORE",'BMI'),
				iconv("UTF-8","Big5//IGNORE",'BMI最佳'),
				iconv("UTF-8","Big5//IGNORE",'體重最佳'),
				iconv("UTF-8","Big5//IGNORE",'體脂率最佳'),
				iconv("UTF-8","Big5//IGNORE",'體脂最佳'),
				iconv("UTF-8","Big5//IGNORE",'建立時間'),

			);
			fputcsv($f, $fields, $delimiter);

      $result = $items = $this -> records_dao -> query_ajax_for_all($data);

			foreach($result as $each) {
				$lineData = array(

					iconv("UTF-8","Big5//IGNORE",$each -> user_name),
					iconv("UTF-8","Big5//IGNORE",$each -> adc1),
					iconv("UTF-8","Big5//IGNORE",$each -> weight / 1000.0),
					iconv("UTF-8","Big5//IGNORE",$each -> body_fat_rate),
					iconv("UTF-8","Big5//IGNORE",$each -> body_fat / 1000.0),
					iconv("UTF-8","Big5//IGNORE",$each -> visceral_fat_rate),
					iconv("UTF-8","Big5//IGNORE",$each -> protein_rate),
					iconv("UTF-8","Big5//IGNORE",$each -> moisture_rate),
					iconv("UTF-8","Big5//IGNORE",$each -> muscle_rate),
					iconv("UTF-8","Big5//IGNORE",$each -> skeletal_muscle_rate),
					iconv("UTF-8","Big5//IGNORE",$each -> bone_mass_rate),
					iconv("UTF-8","Big5//IGNORE",$each -> subcutaneous_fat_rate),
					iconv("UTF-8","Big5//IGNORE",$each -> fat_info),
					iconv("UTF-8","Big5//IGNORE",$each -> bmr),
					iconv("UTF-8","Big5//IGNORE",$each -> physical_age),
					iconv("UTF-8","Big5//IGNORE",$each -> bmi),
					iconv("UTF-8","Big5//IGNORE",$each -> bmi_best),
					iconv("UTF-8","Big5//IGNORE",$each -> weight_best),
					iconv("UTF-8","Big5//IGNORE",$each -> fat_rate_best),
					iconv("UTF-8","Big5//IGNORE",$each -> fat_best),
					iconv("UTF-8","Big5//IGNORE",$each -> create_time),

				);

				fputcsv($f, $lineData, $delimiter);
			}

			//move back to beginning of file
    	fseek($f, 0);

			//set headers to download file rather than displayed
		  header('Content-Type: text/csv');
		  header('Content-Disposition: attachment; filename="' . $filename . '";');

			//output all remaining data on a file pointer
			fpassthru($f);
	}



}
