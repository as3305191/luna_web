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
				$application_date = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$new_application_date =substr($application_date, 0, 4)."-".substr($application_date, 4, 2)."-".substr($application_date, 6, 2);
				$public_num = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$public_date = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				$new_public_date =substr($public_date, 0, 4)."-".substr($public_date, 4, 2)."-".substr($public_date, 6, 2);
				$patnet_num = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				$announcement_num = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
				$announcement_date = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
				$new_announcement_date =substr($announcement_date, 0, 4)."-".substr($announcement_date, 4, 2)."-".substr($announcement_date, 6, 2);
				$applicant = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
				$inventor = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
				$patent_start_dt = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
				$patent_end_dt = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
				$patent_finish_date = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
				$patnet_note = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
				$patent_range = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
				$patent_key = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
				$patnet_note_for_users = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
				

				$data = array(
					'patent_name_eng'  =>$patent_name_eng,
					'patent_name' =>$patent_name,
					'application_num' =>$application_num,
					'application_date' =>$new_application_date,
					'public_num' =>$public_num,
					'public_date' =>$new_public_date,
					'patnet_num' =>$patnet_num,
					'announcement_num' =>$announcement_num,
					'announcement_date' =>$new_announcement_date,
					'patent_start_dt' =>$patent_start_dt,
					'patent_end_dt' =>$patent_end_dt,
					'patent_finish_date' =>$patent_finish_date,
					'patnet_note_for_users' =>$patnet_note_for_users,
					'patnet_note' =>$patnet_note,
					'patent_range' =>$patent_range,
					'inventor' =>$inventor,
					'patent_key' =>$patent_key,
					'applicant' =>$applicant

				);
				$this->users_copy_dao->insert($data);
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
