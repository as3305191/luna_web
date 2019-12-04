<?php
class Soap extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model("Product_ton_dao", 'pt_dao');
		$this -> load -> model("Product_dao", 'p_dao');
		$this -> load -> model("Salary_code_dao", 's_code_dao');
		$this -> load -> model("Salary_code_tmp_dao", 's_code_tmp_dao');
	}

	function index() {
		$sh_param = array(
            'strUserName'    =>    'm301',
            'strPassword'    =>    '2531111');
		$soapClient = new SoapClient(null, array(
			"location" => "http://wsm301.greatwall.com.tw/WSM301/WebService_m301.asmx?WSDL",
			"uri" => "http://localhost/")
		);

		$headers[] = new SoapHeader('http://localhost/', 'AuthSoapHd', $sh_param);
		//
		// // Prepare Soap Client
		$soapClient->__setSoapHeaders($headers);
		$soapClient->__soapCall("mm_plant", array(
			"Plant1" => "1",
			"Plant2" => "z",
		));
		echo "hello..";
	}

	// 轉移噸工資
	function product_ton_tx() {
		echo "product_ton_tx<br/>";

		$list = $this -> pt_dao -> find_all();

		foreach($list as $each_ton) {
			$lot_number = trim($each_ton->lot_number);
			if(!empty($each_ton -> salary_code)) {
				echo "{$lot_number} - {$each_ton->salary_code}<br/>";
				$p_list = $this -> p_dao -> find_all_by("lot_number", $lot_number);
				foreach($p_list as $p) {
					$this -> p_dao -> update(array(
						'salary_code' => $each_ton -> salary_code,
						'salary_code_foreign' => $each_ton -> salary_code_foreign,
					), $p -> id);
				}
			}
		}
	}

	// 虛擬料號設定
	function product_fix_wsn() {
		echo "product_fix_wsn<br/>";

		$list = $this -> p_dao -> find_all();

		foreach($list as $each_ton) {
			$weight_sn = trim($each_ton->weight_sn);
			if(strlen($weight_sn) == 6) {
				echo  "{$weight_sn} <br/>";
				$this -> p_dao -> update(array(
					'weight_sn' => $weight_sn . "0"
				), $each_ton -> id);
			}

			// if(strlen($weight_sn) < 7) {
			// 	echo "{$weight_sn} <br/>";
			// }
		}
	}

	function salary_code_copy() {
		$list = $this -> s_code_tmp_dao -> find_all();
		foreach($list as $each) {
			echo "{$each->code}\r\n";
			$code = $each -> code;
			$item = $this -> s_code_dao -> find_by("code", $code);
			if(empty($item)) {
				$i_data = array();
				$i_data['code'] = $each -> code;
				$i_data['code_name'] = $each -> code_name;
				$i_data['val'] = $each -> val;
				$i_data['val_2'] = $each -> val_2;
				$this -> s_code_dao -> insert($i_data);
			}
		}
	}
}
?>
