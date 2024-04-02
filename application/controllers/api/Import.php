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
		$this -> load -> model('Patent_key_dao', 'p_k_dao');
		$this -> load -> model('Drink_users_dao', 'drink_users_dao');

		
		$this -> load -> model('Products_dao', 'products_dao');
		$this->load->library('excel');
	}

	public function index() {
		echo "index";
	}

	function import(){
		$object = PHPExcel_IOFactory::load("專利資訊(匯入專利檢索系統用)2021-美國(未匯入).xls");
		// 專利資訊(匯入專利檢索系統用)2021-歐洲
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
					// 'patent_country'=>'4'

				);
				$this->patent_dao->insert($data);
			}
		}
		// $res['success'] = TRUE;
		// $this -> to_json($res);
	}
	function import_user(){
		$object = PHPExcel_IOFactory::load("員工.xlsx");
		foreach($object->getWorksheetIterator() as $worksheet){
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			$idn=["和利","拉瑪","羅尼","艾弟","納陸","羅滿","蘇比","仁弟","安仨","阿吉","阿吉斯"];
			$vnm=["阮氏娥","梁氏梅","黎氏賢","農氏厚","黃氏慧","武氏定","阮氏媛","武氏填","武氏胡北","武氏香","陳氏詩","阮氏娟","黎氏慧","丁氏芳"];
			for($row=2; $row<=$highestRow; $row++){
				$account = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$user = $this -> users_dao -> find_by('account', $account);
				if (empty($user)) {
					$password = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					// $user_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$user_name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$depname = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

					// $user_name = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					if(in_array($user_name, $vnm)){
						$lang ="vnm";
					} else{
						if(in_array($user_name, $idn)){
							$lang ="idn";
						} else{
							$lang ="cht";
						}
					}
					$data = array(
						'account' =>$account,
						'password' =>$password,
						'user_name' =>$user_name,
						'lang' =>$lang,
						'depname' =>$depname,
					);
					$this->users_dao->insert($data);

				}
				
				
	
					
					// $this->users_dao->update_by($data,'empid',$empid);
			}
		}
		// $res['success'] = TRUE;
		// $this -> to_json($res);
	}
	function update_user(){
		$user = $this -> users_dao -> find_all();

		foreach ($user as $each){
			$idn=["和利","拉瑪","羅尼","艾弟","納陸","羅滿","蘇比","仁弟","安仨","阿吉","阿吉斯"];
			$vnm=["阮氏娥","梁氏梅","黎氏賢","農氏厚","黃氏慧","武氏定","阮氏媛","武氏填","武氏胡北","武氏香","陳氏詩","阮氏娟","黎氏慧","丁氏芳"];
			if($each->id>490){

				// if(in_array(trim($each->user_name), $idn)){
				// 	$data = array(
				// 		'lang' =>'idn',
				// 		'user_name' =>trim($each->user_name),
					
				// 	);
				// 	// $this->users_dao->update_by($data,'empid',$empid);
				// 	$this->users_dao->update($data,$each->id);
				// } else{

				// 	if(in_array(trim($each->user_name), $vnm)){
				// 		$data = array(
				// 			'lang' =>'vnm',
				// 			'user_name' =>trim($each->user_name),
				// 		);
				// 		// $this->users_dao->update_by($data,'empid',$empid);
				// 		$this->users_dao->update($data,$each->id);
				// 	}
				// }
				if($each->depname =='作業課' && $each->lang=='vnm'){
					$data = array(
						'role_id' =>76,
					
					);
					// $this->users_dao->update_by($data,'empid',$empid);
					$this->users_dao->update($data,$each->id);
				}
				if($each->depname =='作業課' && $each->lang=='idn'){
					$data = array(
						'role_id' =>75,
					
					);
					// $this->users_dao->update_by($data,'empid',$empid);
					$this->users_dao->update($data,$each->id);
				}
				if($each->depname =='作業課' && $each->lang=='cht'){
					$data = array(
						'role_id' =>31,
					
					);
					// $this->users_dao->update_by($data,'empid',$empid);
					$this->users_dao->update($data,$each->id);
				}
				
			}
		}
	}
	function import1(){
		$object = PHPExcel_IOFactory::load("員工資料1.xlsx");
		foreach($object->getWorksheetIterator() as $worksheet){
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			for($row=1; $row<=$highestRow; $row++){
				$user_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$area_num = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				
	
					$data = array(
						'user_name' =>$user_name,
						'area_num' =>$area_num,
					
					);
					// $this->users_dao->update_by($data,'empid',$empid);
					$this->drink_users_dao->insert($data);
			}
		}
		// $res['success'] = TRUE;
		// $this -> to_json($res);
	}

	function import2(){
		$object = PHPExcel_IOFactory::load("專利系統-申請號及關鍵字2022.4.6以前 - 1.xlsx");
		foreach($object->getWorksheetIterator() as $worksheet){
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			for($row=2; $row<=$highestRow; $row++){
				$application_num = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$key= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				
				$key_new = '#'.preg_replace('/\s+/', '#',$key).'#';
			
					$data = array(
						'patent_key_id_array' =>$key_new,
						
					);
					$this->patent_dao->update_by($data,'application_num',$application_num);
					// $this->p_k_dao->insert($data);
			}
		}
		// $res['success'] = TRUE;
		// $this -> to_json($res);
	}
}
?>
