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
		$user_id = $this -> get_get('user_id');
		$login_user = $this -> users_dao -> find_by_id($user_id);
		$last_update_type = $this -> dao -> find_by_update_type($user_id);
		$corp_id = $this -> get_get('corp_id');
		$role_id = $login_user -> role_id;
		$last_date =0;
		$last_meal_name =' ';
		$last_cuisine_type =' ';

		if ($role_id==107) {
			if ($corp_id>-1) {
				if(isset($_FILES["file"]["name"])){
					$path = $_FILES["file"]["tmp_name"];
					$object = PHPExcel_IOFactory::load($path);
					foreach($object->getWorksheetIterator() as $worksheet){
						$highestRow = $worksheet->getHighestRow();
						$highestColumn = $worksheet->getHighestColumn();
						for($row=2; $row<=$highestRow; $row++){

							$menu_code = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							$menu_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

							if(!empty($menu_name)){
								$meal_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
								$cuisine_type = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

								$_date_ = $worksheet->getCellByColumnAndRow(4, $row);
							 	$_date = $_date_->getValue();
								if($_date_ ->getDataType() == PHPExcel_Cell_DataType::TYPE_NUMERIC ) {
									$cellstyleformat = $_date_->getWorksheet()-> getStyle( $_date_->getCoordinate() )->getNumberFormat();								$formatcode = $cellstyleformat->getFormatCode();
									if( preg_match( '/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode ) ) {
										$date = date( "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP( $_date ) );
									} else {
										$date = PHPExcel_Style_NumberFormat::toFormattedString($_date, $formatcode);
									}
								} else{
									$date = $_date;
								}

								if ($date!==NULL) {
									// $date =' '.$_date;
									if(!empty($date) && $date!==$last_date){
										$last_date = $date;
									}
								} else {
									$date = $last_date;
								}

								if ($meal_name!==NULL) {
									if(!empty($meal_name) && $meal_name!==$last_meal_name){
										$last_meal_name = $meal_name;
									}
								} else {
									$meal_name = $last_meal_name;
								}

							

								$grain_rhizomes = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

								$fish_eggs_l = $worksheet->getCellByColumnAndRow(6, $row)->getValue();//豆魚蛋肉類(低脂)
								$fish_eggs_m = $worksheet->getCellByColumnAndRow(7, $row)->getValue();//豆魚蛋肉類(中脂)
								$fish_eggs_h = $worksheet->getCellByColumnAndRow(8, $row)->getValue();//豆魚蛋肉類(高脂)
								$fish_eggs_vh = $worksheet->getCellByColumnAndRow(9, $row)->getValue();//豆魚蛋肉類(超高脂)
								if($fish_eggs_l==NULL){
									$fish_eggs_l = 0;//空直等於0
								}
								if($fish_eggs_m==NULL){
									$fish_eggs_m = 0;
								}
								if($fish_eggs_h==NULL){
									$fish_eggs_h = 0;
								}
								if($fish_eggs_vh==NULL){
									$fish_eggs_vh = 0;
								}

								$fish_eggs =$fish_eggs_l+$fish_eggs_m+$fish_eggs_h+$fish_eggs_vh;//豆魚蛋肉類(全部)

								$oils_nuts = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
								$vegetables = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
								$fruit = $worksheet->getCellByColumnAndRow(12, $row)->getValue();

								$dairy_products_off = $worksheet->getCellByColumnAndRow(13, $row)->getValue();//乳製品(脱脂)
								$dairy_products_low = $worksheet->getCellByColumnAndRow(14, $row)->getValue();//乳製品(低脂)
								$dairy_products_all = $worksheet->getCellByColumnAndRow(15, $row)->getValue();//乳製品(全脂)
								if($dairy_products_off==NULL){
									$dairy_products_off = 0;//空直等於0
								}
								if($dairy_products_low==NULL){
									$dairy_products_low = 0;
								}
								if($dairy_products_all==NULL){
									$dairy_products_all = 0;
								}
								$dairy_products = $dairy_products_off+$dairy_products_low+$dairy_products_all;//乳製品(全部)
								$total_calories = $worksheet->getCellByColumnAndRow(16, $row)->getCalculatedValue();

								if($menu_code==NULL){
									$menu_code = '';
								}
							

								if($cuisine_type==NULL){
									$cuisine_type = '';
								}

								if($grain_rhizomes==NULL){
									$grain_rhizomes = '0';
								}
								if($fish_eggs==NULL){
									$fish_eggs = '0';
								}
								if($oils_nuts==NULL){
									$oils_nuts = '0';
								}
								if($vegetables==NULL){
									$vegetables = '0';
								}
								if($fruit==NULL){
									$fruit = '0';
								}
								if($dairy_products==NULL){
									$dairy_products = '0';
								}
								if($total_calories==NULL){
									$total_calories = '0';
								}
								$new_last_update_type = intval($last_update_type->update_type)+1;

							$data = array(
												'menu_code'		=>	$menu_code,
												'menu_name'			=>	$menu_name,
												'meal_name'				=>	$meal_name,
												'cuisine_type'				=>	$cuisine_type,
												'date'		=>	$date,
												'grain_rhizomes'			=>	$grain_rhizomes,
												'fish_eggs_l'	=>	$fish_eggs_l,
												'fish_eggs_m'	=>	$fish_eggs_m,
												'fish_eggs_h'	=>	$fish_eggs_h,
												'fish_eggs_vh'	=>	$fish_eggs_vh,
												'fish_eggs'	=>	$fish_eggs,
												'oils_nuts' => $oils_nuts,
												'vegetables' => $vegetables,
												'fruit' => $fruit,
												'dairy_products_off' => $dairy_products_off,
												'dairy_products_low' => $dairy_products_low,
												'dairy_products_all' => $dairy_products_all,
												'dairy_products' => $dairy_products,
												'total_calories' => $total_calories,
												'corp_id' => $corp_id,
												'import_userid' => $user_id,
												'update_type' => $new_last_update_type

											);

												$this->dao->insert($data);

											}

						}

					}

						$res['success'] = TRUE;

						$this -> to_json($res);
				}
			}
		} else{
			if(isset($_FILES["file"]["name"])){
				$path = $_FILES["file"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);

				foreach($object->getWorksheetIterator() as $worksheet){
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					for($row=2; $row<=$highestRow; $row++){

						$menu_code = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$menu_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

						if(!empty($menu_name)){
							$meal_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
							$cuisine_type = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

							$_date_ = $worksheet->getCellByColumnAndRow(4, $row);
							$_date = $_date_->getValue();
							if($_date_ ->getDataType() == PHPExcel_Cell_DataType::TYPE_NUMERIC ) {
								$cellstyleformat = $_date_->getWorksheet()-> getStyle( $_date_->getCoordinate() )->getNumberFormat();								$formatcode = $cellstyleformat->getFormatCode();
								if( preg_match( '/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode ) ) {
									$date = date( "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP( $_date ) );
								} else {
									$date = PHPExcel_Style_NumberFormat::toFormattedString($_date, $formatcode);
								}
							} else{
								$date = $_date;
							}
							// $date = str_replace('/','-',$_date);
							if ($date!==NULL) {
								// $date =' '.$_date;
								if(!empty($date) && $date!==$last_date){
									$last_date = $date;
								}
							} else {
								$date = $last_date;
							}

							if ($meal_name!==NULL) {
								if(!empty($meal_name) && $meal_name!==$last_meal_name){
									$last_meal_name = $meal_name;
								}
							} else {
								$meal_name = $last_meal_name;
							}

						

							$grain_rhizomes = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

							$fish_eggs_l = $worksheet->getCellByColumnAndRow(6, $row)->getValue();//豆魚蛋肉類(低脂)
							$fish_eggs_m = $worksheet->getCellByColumnAndRow(7, $row)->getValue();//豆魚蛋肉類(中脂)
							$fish_eggs_h = $worksheet->getCellByColumnAndRow(8, $row)->getValue();//豆魚蛋肉類(高脂)
							$fish_eggs_vh = $worksheet->getCellByColumnAndRow(9, $row)->getValue();//豆魚蛋肉類(超高脂)
							if($fish_eggs_l==NULL){
								$fish_eggs_l = 0;//空直等於0
							}
							if($fish_eggs_m==NULL){
								$fish_eggs_m = 0;
							}
							if($fish_eggs_h==NULL){
								$fish_eggs_h = 0;
							}
							if($fish_eggs_vh==NULL){
								$fish_eggs_vh = 0;
							}

							$fish_eggs =$fish_eggs_l+$fish_eggs_m+$fish_eggs_h+$fish_eggs_vh;//豆魚蛋肉類(全部)

							$oils_nuts = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
							$vegetables = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
							$fruit = $worksheet->getCellByColumnAndRow(12, $row)->getValue();

							$dairy_products_off = $worksheet->getCellByColumnAndRow(13, $row)->getValue();//乳製品(脱脂)
							$dairy_products_low = $worksheet->getCellByColumnAndRow(14, $row)->getValue();//乳製品(低脂)
							$dairy_products_all = $worksheet->getCellByColumnAndRow(15, $row)->getValue();//乳製品(全脂)
							if($dairy_products_off==NULL){
								$dairy_products_off = 0;//空直等於0
							}
							if($dairy_products_low==NULL){
								$dairy_products_low = 0;
							}
							if($dairy_products_all==NULL){
								$dairy_products_all = 0;
							}
							$dairy_products = $dairy_products_off+$dairy_products_low+$dairy_products_all;//乳製品(全部)
							$total_calories = $worksheet->getCellByColumnAndRow(16, $row)->getCalculatedValue();

							if($menu_code==NULL){
								$menu_code = '';
							}
						

							if($cuisine_type==NULL){
								$cuisine_type = '';
							}

							if($grain_rhizomes==NULL){
								$grain_rhizomes = '0';
							}
							if($fish_eggs==NULL){
								$fish_eggs = '0';
							}
							if($oils_nuts==NULL){
								$oils_nuts = '0';
							}
							if($vegetables==NULL){
								$vegetables = '0';
							}
							if($fruit==NULL){
								$fruit = '0';
							}
							if($dairy_products==NULL){
								$dairy_products = '0';
							}
							if($total_calories==NULL){
								$total_calories = '0';
							}
							$new_last_update_type = intval($last_update_type->update_type)+1;
						$data = array(
											'menu_code'		=>	$menu_code,
											'menu_name'			=>	$menu_name,
											'meal_name'				=>	$meal_name,
											'cuisine_type'				=>	$cuisine_type,
											'date'		=>	$date,
											'grain_rhizomes'			=>	$grain_rhizomes,
											'fish_eggs_l'	=>	$fish_eggs_l,
											'fish_eggs_m'	=>	$fish_eggs_m,
											'fish_eggs_h'	=>	$fish_eggs_h,
											'fish_eggs_vh'	=>	$fish_eggs_vh,
											'fish_eggs'	=>	$fish_eggs,
											'oils_nuts' => $oils_nuts,
											'vegetables' => $vegetables,
											'fruit' => $fruit,
											'dairy_products_off' => $dairy_products_off,
											'dairy_products_low' => $dairy_products_low,
											'dairy_products_all' => $dairy_products_all,
											'dairy_products' => $dairy_products,
											'total_calories' => $total_calories,
											'corp_id' => $login_user -> corp_id,
											'import_userid' => $user_id,
											'update_type' => $new_last_update_type

										);

											$this->dao->insert($data);

										}

					}

				}

					$res['success'] = TRUE;

					$this -> to_json($res);
			}
		}

	}


}
?>
