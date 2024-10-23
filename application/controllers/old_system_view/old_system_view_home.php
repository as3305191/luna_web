<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Old_system_view_home extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// $this->load->helper('captcha');

		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Corp_dao', 'corp_dao');
		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Records_dao', 'records_dao');

	}

	public function index() {
		$data = array();
		$count_members_lose_3days_ = array();
		$count_today_= array();

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);

		$today = date("Y-m-d");
		$data['now'] = 'old_system_view_home';//現在哪頁
		$old_user_id = $this -> get_old_user_id($login_user->account);
		$menu_open_list = $this -> get_data_menu($today);
		$old_user_ewallet = $this -> get_user_ewallet($old_user_id);
		// $income = 0;
		// $outcome = 0;
		// foreach($old_user_ewallet as $each){
		// 	$income+=$each->$income;
		// 	$outcome+=$each->$outcome;
		// }
		// $total_old_user_ewallet = $income - $outcome;
		$data['old_user_id'] = $old_user_id;
		$data['old_user_ewallet'] = $old_user_ewallet;
		$data['menu_open_list'] = $menu_open_list;
		$this -> to_json($data);
		$this -> load -> view('old_system_view/old_system_view_home', $data);
	}

	public function get_data_menu($today) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		// $sql = "SELECT * FROM order_menu";    

		$sql = "SELECT * FROM order_menu where odate='$today' and enddate IS NULL";    
		
		/* Execute the query. */    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = $row;
        }
	    // $this -> to_json($result_array);
		if(count($result_array)>0){
			return $result_array[0];
		} else{
			return NULL;
		}
		// $this->load->view('mgmt/old_system_api/list', $result_array);
		sqlsrv_close($conn);
	}

	public function get_user_ewallet($old_user_id) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		
		$sql = "SELECT * FROM order_ewallet where usid=$old_user_id";    
		
		/* Execute the query. */    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = $row;
       }
		// $this -> to_json($result_array);
		if(count($result_array)>0){
			return $result_array[0];
		} else{
			return NULL;
		}

		// $this->load->view('mgmt/old_system_api/list', $result_array);
		sqlsrv_close($conn);
	}
	
	public function get_old_user_id($account) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		// $sql = "SELECT id FROM account";    

		$sql = "SELECT id FROM account where account='$account'";    
		
		/* Execute the query. */    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = array_shift($row);
        }
	    // $this -> to_json($result_array);
		if(count($result_array)>0){
			return $result_array[0];
		} else{
			return NULL;
		}

		// $this->load->view('mgmt/old_system_api/list', $result_array);
		sqlsrv_close($conn);
	}
	function update_graduate() {
		$res = array();

		$user_id = $this -> get_post("user_id");
		$i_data['status']= 1;


		if(!empty($user_id)){
			$this-> dao ->update_by($i_data,'id',$user_id);
			$res['success'] = "true";
		} else{
			$res['error'] = "true";
		}
		$this -> to_json($res);
	}

	function show_people() {
		$res = array();

		$id_array = $this -> get_post("id_array");

		foreach ($id_array as $each) {
			$items = $this-> dao ->find_by_id($each->id);
		}
		$res['items'] = $items;

		$this -> to_json($res);
	}

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('old_system_view/login');
	}

}
