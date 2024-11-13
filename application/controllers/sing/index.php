<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Base_Controller {

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
		$data['ip'] = $this->getRequestIp(); 

		$data['mac'] = $this->getMacAddress();
		
		$this -> load -> view('sing/sing_index', $data);
	}

	function getMacAddress(){ 
		$result = shell_exec("/sbin/ifconfig"); 
		if(preg_match_all("HWaddr\s+([\w:]+)/", $result, $matches)){ 
			$macAddress = $matches[1][0]; 
			return $macAddress; 
		} 
		return null; 
	}

	function getRequestIp(){
		$ip_keys = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		];

		foreach ($ip_keys as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip);
					if ((bool) filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
						return $ip;
					}
				}
			}
		}

		return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '-';
	}


	public function index_lot() {
		$data = array();

		$this -> load -> view('inventory/index_draw_lots', $data);
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

	public function delete_order() {
		$res = array();
		$id = $this -> get_post('id');
		$usid = $this -> get_post('usid');

		$this -> delete_record($id);
		$this -> update_ewallet($usid,$id);
		$res['success'] = TRUE;
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

	public function delete_record($id) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		
		$sql = "DELETE FROM order_record where id='$id'";    

		$stmt = sqlsrv_query( $conn, $sql);    
		
	// 	$result_array = array();
	// 	while($row=sqlsrv_fetch_array($stmt)){
    //         $result_array[] = $row;
    //    }
	// 	// $this -> to_json($result_array);
	// 	if(count($result_array)>0){
	// 		return $result_array;
	// 	} else{
	// 		return NULL;
	// 	}

		// $this->load->view('mgmt/old_system_api/list', $result_array);
		sqlsrv_close($conn);
	}

	public function update_ewallet($usid,$id) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		
		$sql = "UPDATE order_ewallet set delmark='1' where usid='$usid' and rid='$id'";    

		/* Execute the query. */    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
	// 	$result_array = array();
	// 	while($row=sqlsrv_fetch_array($stmt)){
    //         $result_array[] = $row;
    //    }
	// 	// $this -> to_json($result_array);
	// 	if(count($result_array)>0){
	// 		return $result_array;
	// 	} else{
	// 		return NULL;
	// 	}

		// $this->load->view('mgmt/old_system_api/list', $result_array);
		sqlsrv_close($conn);
	}
	
	public function get_old_user_id($empindex) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);
		// $sql = "SELECT id FROM account";    

		$sql = "SELECT a_c.id FROM account as a_c left join employee as emp ON a_c.empid = emp.id where empindex='$empindex'";    
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
		$old_user_id = $this -> get_post('usid');
		$finish_list = json_decode(json_encode($this -> get_finish_order_by_user($old_user_id),true));
		if($finish_list !==null && count($finish_list)>0){
			$res['success'] = 'already';
			$res['finish_list'] = $finish_list;
		} else{
			$res['success'] = 'not_order';
		}
 		$this -> to_json($res);
	}

	public function get_finish_order_by_user($old_user_id) {
		$serverName="KTX-2008D1\sqlexpress";
		$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
		$conn=sqlsrv_connect($serverName,$connectionInfo);

		$sql = "SELECT order_record.* from order_record LEFT JOIN order_menu ON
				order_record.orderid = order_menu.id where order_record.userid='$old_user_id' and
				order_menu.enddate IS NULL;";    
		
		$stmt = sqlsrv_query( $conn, $sql);    
		
		$result_array = array();
		while($row=sqlsrv_fetch_array($stmt)){
            $result_array[] = $row;
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
