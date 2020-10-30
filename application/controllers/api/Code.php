<?php
class Code extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// setup models
		$this -> load -> model('Code_dao', 'code_dao');
		$this -> load -> model('Code_tmp_dao', 'code_tmp_dao');
		// $this -> load -> model('Product_dao', 'product_dao');
	}

	public function check_product() {
		echo "check_product";
		$all_code = $this -> code_dao -> find_all();
		foreach($all_code as $each) {
			$item = $this -> product_dao -> find_by("weight_sn", $each -> items);
			if(empty($item)) {
				error_log("not found: " . $each -> items);
				$i_data = array();
				$i_data['weight_sn'] = $each -> items;
				$i_data['lot_number'] = $each -> iteml;
				$i_data['name'] = $each -> name;
				$this -> product_dao -> insert($i_data);
			} else {
				// error_log("found: " . $each -> items);
			}
		}

	}

	public function do_copy() {
		echo "do_copy";
		$all_code_tmp = $this -> code_tmp_dao -> find_all();
		foreach($all_code_tmp as $each) {
			$item = $this -> code_dao -> find_by('items', $each -> items);
			if(empty($item)) {
				$i_data = array();
				$i_data['source'] = $each -> source;
				$i_data['freeze'] = $each -> freeze;
				$i_data['chicken'] = $each -> chicken;
				$i_data['class'] = $each -> class;
				$i_data['seq'] = $each -> seq;
				$i_data['items'] = $each -> items;
				$i_data['iteml'] = $each -> iteml;
				$i_data['name'] = $each -> name;
				$i_data['valid'] = $each -> valid;
				$i_data['uwt'] = $each -> uwt;
				$i_data['price'] = $each -> price;
				$i_data['brk'] = $each -> brk;
				$i_data['cus_itm'] = $each -> cus_itm;
				$i_data['comment'] = $each -> comment;
				$this -> code_dao -> insert($i_data);
			} else {
				$i_data = array();
				$i_data['source'] = $each -> source;
				$i_data['freeze'] = $each -> freeze;
				$i_data['chicken'] = $each -> chicken;
				$i_data['class'] = $each -> class;
				$i_data['seq'] = $each -> seq;
				$i_data['items'] = $each -> items;
				$i_data['iteml'] = $each -> iteml;
				$i_data['name'] = $each -> name;
				$i_data['valid'] = $each -> valid;
				$i_data['uwt'] = $each -> uwt;
				$i_data['price'] = $each -> price;
				$i_data['brk'] = $each -> brk;
				$i_data['cus_itm'] = $each -> cus_itm;
				$i_data['comment'] = $each -> comment;
				$this -> code_dao -> update($i_data, $item -> id);
			}
		}
	}

	public function test_b_l()
    {
		// ignore_user_abort();
		// set_time_limit(0);
		// $sleep_time=3;
		// while(true){
		// 	echo "
		// 	<script>
		// 		var i=0;
		// 		function test(){
		// 			window.open('https://www.butterfly-love.com.tw');
		// 		}
				
		// 		for(i;i<=250;i++){
		// 			test();
		// 		}
		// 	</script>";
		// 	sleep($sleep_time);
		// };
		echo "
			<script>
				var i=0;
				function test(){
					window.open('https://www.butterfly-love.com.tw');
				}
				for(i;i<=200;i++){
						test();
				 }
				
				setTimeout(function(){
					location.reload();
				},180000);
			</script>";
            //secho "<script>window.onload = function() {document.location.href=https://www.butterfly-love.com.tw';};";
		
            //echo "<script>window.open('https://www.butterfly-love.com.tw');</script>";
			//header("https://www.butterfly-love.com.tw");
			
			// setTimeout(function(){
			// 	window.open('https://www.butterfly-love.com.tw');
			// },5000);
			// for(i;i<=250;i++){
			// 	test();
			// }
    }

	

}
?>
