<?php
class Utils extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// setup models
		$this -> load -> model('For_app_dao', 'for_app_dao');
		$this -> load -> model('Product_dao', 'prodcut_dao');
	}

	public function for_app() {
		$list = $this -> for_app_dao -> find_all();
		foreach($list as $each) {
			$p = $this -> prodcut_dao -> find_by("lot_number", trim($each -> lot_number));
			if(!empty($p)) {
				echo "4 app {$each->price} | {$p->lot_number}  <br/>";
				$this -> prodcut_dao -> update(array(
					'cut_cost' => $each -> price 
				), $p -> id);
			} else {
				// echo "{$each->price} | {$each->lot_number}  <br/>";
			}
		}

	}
}
?>
