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
		$object = PHPExcel_IOFactory::load("專利資訊匯入專利檢索系統用台灣.xls");
		foreach($object->getWorksheetIterator() as $worksheet){
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			for($row=2; $row<=$highestRow; $row++){
				$patent_name_eng = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$patent_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$application_num = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$empid = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$empid = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$empid = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				$empid = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				$empid = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
				$empid = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
				$del_date = $worksheet->getCellByColumnAndRow(17, $row)->getValue();

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

	// function import1(){
	// 	$object = PHPExcel_IOFactory::load("234.xlsx");
	// 	foreach($object->getWorksheetIterator() as $worksheet){
	// 		$highestRow = $worksheet->getHighestRow();
	// 		$highestColumn = $worksheet->getHighestColumn();
	// 		for($row=2; $row<=$highestRow; $row++){
	// 			$empid = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 			$user_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
	// 			$emptel = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
	// 			$depname = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
	// 			$depmail = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
	// 			$usermail = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
	
	// 				$data = array(
	// 					'user_name' =>$user_name,
	// 					'emptel' =>$emptel,
	// 					'depname' =>$depname,
	// 					'depmail' =>$depmail,
	// 					'usermail' =>$usermail,
	// 				);
	// 				$this->users_copy_dao->update_by($data,'empid',$empid);
	// 		}
	// 	}
	// 	// $res['success'] = TRUE;
	// 	// $this -> to_json($res);
	// }

}
?>
