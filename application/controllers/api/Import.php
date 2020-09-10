<?php
class Import extends MY_Base_Controller {
	var $mime_map = array(
			'image/jpeg' => 'jpg',
			'image/png' => 'png',
			'image/gif' => 'gif'
		);


	function __construct() {
		parent::__construct();
		$this -> load -> model('Images_dao', 'dao');
		$this -> load -> model('Users_copy_dao', 'users_copy_dao');
		$this->load->library('excel');
	}

	public function index() {
		echo "index";
	}
	function import(){
		$object = PHPExcel_IOFactory::load("123.xlsx");
		foreach($object->getWorksheetIterator() as $worksheet){
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			for($row=2; $row<=$highestRow; $row++){
				$account = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$password = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$empid = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

				if($del_date=='NULL'){

					$data = array(
						'account'  =>$account,
						'password' =>$password,
						'empid' =>$empid
					);
					$this->users_copy_dao->insert($data);

				}
			}
		}
		// $res['success'] = TRUE;
		// $this -> to_json($res);
	}



}
?>
