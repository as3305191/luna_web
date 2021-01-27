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
		$this -> load -> model('Patent_dao', 'patent_dao');
		$this -> load -> model('Users_dao', 'users_dao');

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
				$priority = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$patent_name_eng = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$patent_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$application_num = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$application_date = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$public_num = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$public_date = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				$patnet_num = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				$announcement_num = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
				$announcement_date = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
				$applicant = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
				$inventor = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
				$patent_start_dt = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
				$patent_end_dt = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
				$patent_finish_date = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
				$patnet_note = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
				$patent_range = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
				$patent_key = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
				$patnet_note_for_users = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
				$new_application_date =substr($application_date, 0, 4)."-".substr($application_date, 4, 2)."-".substr($application_date, 6, 2);
				$new_public_date =substr($public_date, 0, 4)."-".substr($public_date, 4, 2)."-".substr($public_date, 6, 2);
				$new_announcement_date =substr($announcement_date, 0, 4)."-".substr($announcement_date, 4, 2)."-".substr($announcement_date, 6, 2);
				$patent_start_dt_new = str_replace("/", '-', $patent_start_dt);
				$patent_end_dt_new = str_replace("/", '-', $patent_end_dt);
				$patent_finish_date_new = str_replace("/", '-', $patent_finish_date);
				if($priority==null){
					$priority='';
				}
				if($patent_name_eng==null){
					$patent_name_eng='';
				}
				if($patent_name==null){
					$patent_name='';
				}
				if($application_num==null){
					$application_num='';
				}
				if($new_application_date==null){
					$new_application_date='';
				}
				if($public_num==null){
					$public_num='';
				}
				if($patnet_num==null){
					$patnet_num='';
				}
				if($announcement_num==null){
					$announcement_num='';
				}
				if($new_announcement_date==null){
					$new_announcement_date='';
				}
				if($applicant==null){
					$applicant='';
				}
				if($inventor==null){
					$inventor='';
				}
				if($patent_start_dt==null){
					$patent_start_dt='';
				}
				if($patent_end_dt==null){
					$patent_end_dt='';
				}
				if($patent_finish_date==null){
					$patent_finish_date='';
				}
				if($patnet_note==null){
					$patnet_note='';
				}
				if($patent_range==null){
					$patent_range='';
				}
				if($patent_key==null){
					$patent_key='';
				}
				if($patnet_note_for_users ==null){
					$patnet_note_for_users ='';
				}

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
					'patent_start_dt' =>$patent_start_dt_new,
					'patent_end_dt' =>$patent_end_dt_new,
					'patent_finish_date' =>$patent_finish_date_new,
					'patnet_note_for_users' =>$patnet_note_for_users,
					'patent_note' =>$patnet_note,
					'patent_range' =>$patent_range,
					'inventor' =>$inventor,
					'patent_key' =>$patent_key,
					'applicant' =>$applicant,
					'patnet_status' =>'',
					'patent_country'=>'1'
				);
				$this->patent_dao->insert($data);
			}
		}
		// $res['success'] = TRUE;
		// $this -> to_json($res);
	}

	function import1(){
		$object = PHPExcel_IOFactory::load("123.xlsx");
		foreach($object->getWorksheetIterator() as $worksheet){
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			for($row=2; $row<=$highestRow; $row++){
				$account = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$password = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$user_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$depname = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
				$depmail = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
				$personalmail = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
	
					$data = array(
						'account' =>$account,
						'password' =>$password,
						'user_name' =>$user_name,
						'depname' =>$depname,
						'depmail' =>$depmail,
						'personalmail' =>$personalmail,
					);
					// $this->users_dao->update_by($data,'empid',$empid);
					$this->users_dao->insert($data);
			}
		}
		// $res['success'] = TRUE;
		// $this -> to_json($res);
	}

}
?>
