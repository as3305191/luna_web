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

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);

		$today = date("Y-m-d");
		$data['now'] = 'old_system_view_home';//現在哪頁
		$old_user_id = $this -> get_old_user_id($login_user->account);
		$menu_open_list = json_decode(json_encode($this -> get_data_menu($today),true));
		$old_user_ewallet = json_decode(json_encode($this -> get_user_ewallet($old_user_id),true));
		$income = 0;
		$outcome = 0;
		if($_SERVER['HTTP_HOST']=='192.168.1.205'){
			$host = '192.168.1.211/eform/order';
		} else{
			$host = '211.21.221.121/eform/order';
		}
		foreach($old_user_ewallet as $each){
			
			if($each->income !=='null'){
				$income+=intval($each->income);
			}
			if($each->outcome !=='null'){
				$outcome+=intval($each->outcome);
			}
		}
		$store = array();
		if($menu_open_list!==null){
			foreach($menu_open_list as $each){
				$store[] =  json_decode(json_encode($this -> get_store($each->storeid),true));
			}
			foreach($store as $each){
				$each->new_img_address = $host.ltrim($each->piclink,'.');
			}
		}
		
		$total_old_user_ewallet = $income - $outcome;
		$data['old_user_id'] = $old_user_id;
		$data['total_old_user_ewallet'] = $total_old_user_ewallet;
		$data['store_list'] = $store;
		$data['menu_open_list'] = $menu_open_list;

		// $this -> to_json($data);
		$this -> load -> view('old_system_view/old_system_view_home', $data);
	}

	public function get_data_menu($today) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		// $sql = "SELECT * FROM order_menu";    

		$sql = "SELECT * FROM order_menu where enddate IS NULL";    
		
		/* Execute the query. */    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = $row;
        }
	    // $this -> to_json($result_array);
		if(count($result_array)>0){
			return $result_array;
		} else{
			return NULL;
		}
		// $this->load->view('mgmt/old_system_api/list', $result_array);
		sqlsrv_close($conn);
	}

	public function get_store($storeid) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		// $sql = "SELECT * FROM order_menu";    

		$sql = "SELECT * FROM order_store where id='$storeid'";    
		
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

	public function re_money() {
		$res = array();
		$usid = $this -> get_post('usid');
		$old_user_ewallet = json_decode(json_encode($this -> get_user_ewallet($usid),true));
		$income = 0;
		$outcome = 0;
		foreach($old_user_ewallet as $each){
			if($each->income !=='null'){
				$income+=intval($each->income);
			}
			if($each->outcome !=='null'){
				$outcome+=intval($each->outcome);
			}
		}
		$total_old_user_ewallet = $income - $outcome;
		$res['total_old_user_ewallet'] = $total_old_user_ewallet;
		$this -> to_json($res);
	}

	public function get_user_ewallet($old_user_id) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		
		$sql = "SELECT * FROM order_ewallet where usid=$old_user_id and delmark=0";    
		
		/* Execute the query. */    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = $row;
       }
		// $this -> to_json($result_array);
		if(count($result_array)>0){
			return $result_array;
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

	public function order_meal() {
		$res = array();
		$data = $this -> get_posts(array(
			'usid',
			'store_id',
			'order_name',
			'note',
			'amount'
		));
		$date = date('Y-m-d h:m:s');
		$orderid = json_decode(json_encode($this -> get_s_o_id($data['store_id']),true));
		$last_id = json_decode(json_encode($this -> order_deal($orderid,$data,$date),true));
		$pay_money_last_id = json_decode(json_encode($this -> pay_money($last_id,$data),true));
		$res['orderid'] = $orderid;
		$res['last_id'] = $last_id;
		// $res['date'] = $date;
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function finish_order() {
		$res = array();
		$old_user_id = $this -> get_post('old_user_id');
		$today = date("Y-m-d");
		$finish_list = json_decode(json_encode($this -> get_finish_order_by_user($today),true));
		if($finish_list !==null && count($finish_list)>0){
			$res['success'] = 'already';
			$res['finish_list'] = $finish_list;
		} else{
			$res['success'] = 'not_order';
		}
 
 		$this -> to_json($res);
	}

	public function get_finish_order_by_user($today) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);

		$sql = "SELECT * FROM order_record as o_r LEFT JOIN order_menu as o_m ON o_r.orderid = o_m.id where o_r.rdate like '$today'% and o_m.enddate IS NULL";    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = array_shift($row);
        }
		if(count($result_array)>0){
			return $result_array;
		} else{
			return NULL;
		}

		sqlsrv_close($conn);
	}

	public function get_s_o_id($store_id) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);

		$sql = "SELECT id FROM order_menu where storeid='$store_id' and enddate IS NULL";    
				
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = array_shift($row);
        }
		if(count($result_array)>0){
			return $result_array[0];
		} else{
			return NULL;
		}

		sqlsrv_close($conn);
	}

	public function order_deal($orderid,$data,$date) {
		$usid = $data['usid'];
		$order_name = $data['order_name'];
		$note = $data['note'];
		$amount = $data['amount'];
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		// $sql = "SELECT id FROM account";    
		$sql = "INSERT INTO order_record(orderid,userid,orderitem,notice,price,rdate) OUTPUT Inserted.id VALUES ('$orderid','$usid','$order_name','$note','$amount','$date');";    

		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = array_shift($row);
        }
		if(count($result_array)>0){
			return $result_array[0];
		} else{
			return NULL;
		}

		sqlsrv_close($conn);
	}

	public function pay_money($last_id,$data) {
		$usid = $data['usid'];
		$amount = $data['amount'];
		$serverName="KTX-2008D1\sqlexpress";

		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		// $sql = "SELECT id FROM account";    

		$sql = "INSERT INTO order_ewallet(usid,outcome,operator,rid) OUTPUT Inserted.id VALUES ('$usid','$amount','$usid','$last_id');";    
				
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = array_shift($row);
        }
		if(count($result_array)>0){
			return $result_array[0];
		} else{
			return NULL;
		}

		sqlsrv_close($conn);
	}

	public function get_already_order($usid) {
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
			return $result_array;
		} else{
			return NULL;
		}

		// $this->load->view('mgmt/old_system_api/list', $result_array);
		sqlsrv_close($conn);
	}

	public function logout() {
		// $corp = $this -> session -> userdata('corp');
		$this -> session -> sess_destroy();
		redirect('old_system_view/login');
	}

}
