<?php
// use Lcobucci\JWT\Parser;
defined('BASEPATH') OR exit('No direct script access allowed');
use Lcobucci\JWT\Parser;
class Message extends MY_Mgmt_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> model('User_msg_dao', 'dao');
		$this -> load -> model('Computer_dao', 'computer_dao');
		$this -> load -> model('Computer_hard_dao', 'c_h_dao');
		$this -> load -> model('Computer_soft_dao', 'c_s_dao');
		$this -> load -> model('C_s_h_join_list_dao', 'c_s_h_join_list_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
	
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);
		if(empty($login_user)) $this->js_alert('尚未登入',site_url().'/login');
        // if(empty($this->session->username)) $this->js_alert('名稱錯誤',site_url().'/login');

		// $data['socket_url'] = "ws://192.168.3.251:8081/server.php";
		$data['socket_url'] = "ws://localhost:8081/server.php";
        $data['me'] = $login_user;
        $data['username'] = $login_user->user_name;
        $data['user_colour'] = $this->session->user_colour ;
        $data['sex'] = $this->session->sex ;
        $data['head'] = $this->session->head ;
		// $this -> to_json($data);

		$this->load->view('mgmt/message/list', $data);
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
		$items = $this -> dao -> query_fixing_ajax($data);
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

		$computer_hard_list = $this -> c_h_dao -> find_all_usage_not_zero();
		$computer_soft_list = $this -> c_s_dao -> find_all_usage_not_zero();
		// $all_user_list = $this -> c_s_dao -> find_all_user();

		$data['computer_hard_list'] = $computer_hard_list;//硬體所有list
		$data['computer_soft_list'] = $computer_soft_list;//軟體所有list

		$data['login_user'] = $login_user;
		// $data['coach'] = $this -> dao -> find_all_coach();
		// $this -> to_json($data);

		$this->load->view('mgmt/patent/edit', $data);
	}

	public function new_patent_family() {
		$res = array();
		$count_num = $this -> dao -> find_by_all_today_add("");
		$last_num = $count_num+1;
		if($last_num<10){
			$family_num = date('Ymd').'0'.$last_num;
		} else{
			$family_num = date('Ymd').$last_num;
		}
		$res['family_num'] = $family_num;		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function check_family() {
		$res = array();
		$patent_family = $this -> get_post('patent_family');
		$item = $this -> dao -> find_by("patent_family", $patent_family);
		if(!empty($patent_family)) {
			if (!empty($item)) {
				$res['valid'] = 'FALSE';
			} else {
				$res['valid'] = 'TRUE';
			}
			// $res['123'] = $item;

		} 
		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$me_id = $this -> get_post('me_id');
		$to_message_id = $this -> get_post('to_message_id');
		$msg = $this -> get_post('msg');

		$data['user_id'] = $me_id;
		$data['to_user_id'] = $to_message_id;
		$data['msg'] = $msg;

		if(!empty($me_id) && !empty($to_message_id) && !empty($msg)) {
			// insert
			$last_id = $this -> dao -> insert($data);

		} 
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function reload_message_record() {
		$res = array();
		$me_id = $this -> get_post('me_id');
		$to_message_id = $this -> get_post('to_message_id');

		$data['user_id'] = $me_id;
		$data['to_user_id'] = $to_message_id;

		if(!empty($me_id) && !empty($to_message_id)) {
			// insert
			$msg_list = $this -> dao -> find_record($data);
			$res['msg_list'] = $msg_list;
		} 

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function find_patent() {
		$data = $this -> get_post('data');
		$items = $this -> dao -> find_patent($data);
		$res['success'] = TRUE;
		$res['items'] = $items ;

		$this -> to_json($res);
	}

	public function find_this_computer() {
		$now_s_h_id = $this -> get_post('now_s_h_id');
		$fix_type = $this -> get_post('fix_type');

		if(!empty($fix_type)){
			if($fix_type==1){
				$now_s_h_list['computer'] = $this -> computer_dao -> find_by_id($now_s_h_id);
				$s_h_list= $this -> c_s_h_join_list_dao -> find_by_computer_id($now_s_h_id);
				foreach($s_h_list  as $each_c_s_h){
					if($each_c_s_h -> computer_hard_id>0){
						$hard= $this -> c_h_dao -> find_by_id($each_c_s_h -> computer_hard_id);
						$hard_array[] = $hard;
					} else{
						$soft= $this -> c_s_dao -> find_by_id($each_c_s_h -> computer_soft_id);
						$soft_array[] = $soft;
					}
				}
				$now_s_h_list['h_array'] = $hard_array;
				$now_s_h_list['s_array'] = $soft_array;
			}
			if($fix_type==2){
				// $fix_list = $this -> c_s_dao -> find_by_name($h_s_name);
			}
			if($fix_type==3){
				// $fix_list = $this -> c_h_dao -> find_by_name($h_s_name);
			}
			if(!empty($now_s_h_list)){
				$res['now_s_h_list'] = $now_s_h_list;
			} else{
				$res['msg'] = '搜尋不到結果';
			}
			$res['fix_type'] = $fix_type;

		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_h_or_s() {
		$type = $this -> get_post('type');
		$s_h_id = $this -> get_post('s_h_id');

		if(!empty($type)){
			if($type=='hard'){
				$s_h_list= $this -> c_h_dao -> find_all_this_table();
			} else if($type=='soft'){
				$s_h_list= $this -> c_s_dao -> find_all_this_table();
			}
			
			if(!empty($s_h_list)){
				$res['s_h_list'] = $s_h_list;
			} else{
				$res['msg'] = '搜尋不到結果';
			}
			$res['type'] = $type;

		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
	public function fix_record_insert() {
		$res = array();
		$fix_type = $this -> get_post('fix_type');
		$fix_way = $this -> get_post('fix_way');//軟硬體
		
		$s_h_type = $this -> get_post('s_h_type');//軟硬體
		
		if(!empty($fix_type)){
			if($fix_type =='1'){//電腦
				if($fix_way =='change'){//更換軟硬體
					$computer_id = $this -> get_post('computer_id');
					$new_sh = $this -> get_post('new_sh');
					$change_reason = $this -> get_post('change_reason');
					$change_way = $this -> get_post('change_way');
					$change_user = $this -> get_post('change_user');
					$change_date = $this -> get_post('change_date');
					$s_h_id = $this -> get_post('s_h_id');

					if($s_h_type =='soft'){
						$data['old_computer_soft_id'] = $s_h_id;
						$data['new_computer_soft_id'] = $new_sh;
						$find_soft = $this -> c_s_h_join_list_dao -> find_s_h_to_update($computer_id,$s_h_id,0);
						$s_h_j_id = $find_soft[0] -> id;

						// $this -> c_s_h_join_list_dao -> update($u_data, $s_h_j_id);
						$s_h_c_insert['computer_id'] = $computer_id;
						$s_h_c_insert['computer_soft_id'] = $new_sh;
						$s_h_c_insert['type'] = 1;

						$last_c_s_id = $this -> c_s_h_join_list_dao -> insert($s_h_c_insert);
						
					} elseif($s_h_type =='hard'){
						$data['old_computer_hard_id'] = $s_h_id;
						$data['new_computer_hard_id'] = $new_sh;
						$find_hard = $this -> c_s_h_join_list_dao -> find_s_h_to_update($computer_id,$s_h_id,1);
						$s_h_j_id = $find_hard[0] -> id;
					
						// $this -> c_s_h_join_list_dao -> update($u_data, $s_h_j_id);
						$s_h_c_insert['computer_id'] = $computer_id;
						$s_h_c_insert['computer_hard_id'] = $new_sh;
						$s_h_c_insert['type'] = 1;

						$last_c_s_id = $this -> c_s_h_join_list_dao -> insert($s_h_c_insert);
					
					}
					$data['fix_reason'] = $change_reason;
					$data['fix_way'] = $change_way;
					$data['report_date'] = $change_date;
					$data['fix_user_id'] = $change_user;
					$data['c_s_h_jion_list_id'] = $s_h_j_id;
					$data['new_c_s_h_jion_list_id'] = $last_c_s_id;
					$data['computer_id'] = $computer_id;
					$data['type'] = 1;
					$data['fix_type'] = $fix_way ;

					$last_id = $this -> dao -> insert($data);


				}
				if($fix_way =='add'){
					$s_h_type = $this -> get_post('s_h_type');
					$computer_id = $this -> get_post('computer_id');
					$s_h_id = $this -> get_post('s_h_id');

					if($s_h_type =='asoft'){
						$data['new_computer_soft_id'] = $s_h_id;
						// $this -> c_s_h_join_list_dao -> update($u_data, $s_h_j_id);
						$s_h_c_insert['computer_id'] = $computer_id;
						$s_h_c_insert['computer_soft_id'] = $s_h_id;
						$s_h_c_insert['type'] = 1;

						$last_c_s_id = $this -> c_s_h_join_list_dao -> insert($s_h_c_insert);
						
					} elseif($s_h_type =='ahard'){
						$data['new_computer_hard_id'] = $s_h_id;
					
						// $this -> c_s_h_join_list_dao -> update($u_data, $s_h_j_id);
						$s_h_c_insert['computer_id'] = $computer_id;
						$s_h_c_insert['computer_hard_id'] = $s_h_id;
						$s_h_c_insert['type'] = 1;

						$last_c_s_id = $this -> c_s_h_join_list_dao -> insert($s_h_c_insert);
					
					}

					$add_reason = $this -> get_post('add_reason');
					$add_way = $this -> get_post('add_way');
					$add_user = $this -> get_post('add_user');
					$add_date = $this -> get_post('add_date');
					$computer_id = $this -> get_post('computer_id');
					$data['computer_id'] = $computer_id;
					$data['fix_reason'] = $add_reason;
					$data['fix_way'] = $add_way;
					$data['report_date'] = $add_date;
					$data['fix_user_id'] = $add_user;
					$data['new_c_s_h_jion_list_id'] = $last_c_s_id;
					$data['type'] = 1;
					$data['fix_type'] = $fix_way ;

			
					$last_id = $this -> dao -> insert($data);

				}
				if($fix_way =='fix'){
					$computer_id = $this -> get_post('computer_id');
					$fix_type = $this -> get_post('fix_type');
					$fix_reason = $this -> get_post('fix_reason');
					$fix_way_ = $this -> get_post('fix_way_');
					$fix_user = $this -> get_post('fix_user');
					$fix_date = $this -> get_post('fix_date');
					$data['computer_id'] = $computer_id;
					$data['fix_reason'] = $fix_reason;
					$data['fix_way'] = $fix_way_;
					$data['report_date'] = $fix_date;
					$data['fix_user_id'] = $fix_user;
					$data['type'] = 1;
					$data['fix_type'] = $fix_way ;

					$last_id = $this -> dao -> insert($data);

				}
			} 
		}
		$res['last_id'] = $last_id;
		$res['success'] = TRUE;
		$s_data = array();
		$sess_data = $this -> setup_user_data($s_data);
		$now_page= $sess_data['now_page'];
		if($now_page=='fix_list'){
			$llast = $this -> session -> userdata('now_fix_record');

			$now_fix_record = $llast;
			$now_fix_record[] = $last_id;

			$this -> session -> set_userdata('now_fix_record',$now_fix_record);
			$res['session'] = $sess_data;
			$llast = $this -> session -> userdata('now_fix_record');

		}
		// $lllast = $this -> session -> userdata('now_fix_record');

		// $res['session_1'] = $lllast;

 		$this -> to_json($res);
	}

	public function do_save_fix_list() {
		$fix_record_id = $this -> session -> userdata('now_fix_record');
		if(!empty($fix_record_id) && count($fix_record_id)>0){
			$this->session->unset_userdata('now_fix_record');
		} else{
			$res['msg'] = '請先填寫維修單';
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_all_user() {
		$all_users = $this -> users_dao -> find_all_user_by_message();
		$res['all_users'] = $all_users;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
}
