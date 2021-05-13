<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_img extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Place_mark_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Img_style_dao', 'img_style_dao');
		$this -> load -> model('Img_month_use_dao', 'img_month_use_dao');		
		$this -> load -> model('Img_month_use_record_dao', 'img_month_use_record_dao');		
		// $this->load->library('excel');
	}

	public function index()
	{
		$data = array();
		// $data = $this -> setup_user_data($data);
		// $data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);
		$this->load->view('mgmt/news_img/list', $data);
	}

	public function carousel($reload=0)
	{
		$data = array();
		$items = $this -> img_style_dao -> find_carousel($data);
		foreach($items as $each){
			$data['carousel_id'][]= $each->id;
		}
		$this->load->view('mgmt/carousel/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'corp_id',

		));

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);

		$res['items'] = $this -> img_dao -> query_ajax($data);
		$res['recordsFiltered'] = $this -> img_dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> img_dao -> count_all_ajax($data);

		$this -> to_json($res);
	}

	public function get_data_image() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'not_used'
		));

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$is_used_this_month_list = $this -> img_month_use_record_dao -> find_this_month_use();

		if($data['not_used']>0){
			foreach($is_used_this_month_list as $each_used_this_month){
				$data['img_data'][]=$each_used_this_month->img_id;
			}
		} 
		$items = $this -> img_dao -> find_place_img($data);
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> img_dao -> find_place_img($data,true);
		$res['recordsTotal'] = $this -> img_dao -> find_place_img($data,true);
		$res['is_used_this_month_list'] = $is_used_this_month_list ;
		$this -> to_json($res);
	}

	public function update_img_style() {
		$res = array();
		$last_id = $this -> get_post('last_id');
		$img_style = $this -> get_post('img_style');
		$this -> img_dao -> update(array(
			'img_style' => $img_style
		), $last_id);

		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$data['id'] = $id;
		$attribute_new = array();
		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order',
				'corp_id',
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			if(!empty($item -> attribute)){
				$attribute = substr($item -> attribute,1,-1);
				$attribute_new_ = str_replace('#',',',$attribute);
				$attribute_new = explode(",",$attribute_new_);
				
			}
			$data['item'] = $item;
			$data['attribute_new'] = $attribute_new;

		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;
		// $this -> to_json($data);

		$this->load->view('mgmt/news_img/edit', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$lng = $this -> get_post('lng');
		$lat = $this -> get_post('lat');
		$sAttr = $this -> get_post('sAttr');
		
		$data = $this -> get_posts(array(
			'place_mark_name',
			'description',
			'full_address',
			'country',
			'city',
			'district',
			'web_url',
			'facebook_url',
		));
		$data['lng'] = $lng;
		$data['lat'] = $lat;
		$data['attribute'] = "#".$sAttr."#";

		if(empty($id)) {
		
			$this->dao->db->set("coordinate", "ST_GeomFromText('POINT($lng $lat)', 4326)", FALSE);

			$this -> dao -> insert($data);

		} else {
			$this->dao->db->set("coordinate", "ST_GeomFromText('POINT($lng $lat)', 4326)", FALSE);
			$this -> dao -> update($data, $id);

		}
		$res['attribute'] = $data['attribute'];
		$res['attribute_array'] = $sAttr;

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$find_list = $this -> img_dao -> find_by_img_id($id);
		$find_list_by_pm_id = $this -> img_dao -> find_by_pm_id($find_list->place_mark_id);	
		$list_count = count($find_list_by_pm_id);
		if($list_count>1){
			$find_img_join_place_list = $this -> img_dao -> find_img_join_place_list($id);	
			if($find_img_join_place_list->image_id == $id && $find_img_join_place_list->place_mark_status==1){//如果刪除預設圖
				// $this -> dao -> update(array('image_id'=>0), $find_img_join_place_list->pm_id);	

			} else{
				$this -> img_dao -> delete($id);	
			}
			$res['success'] = TRUE;
		} else{
			$res['message'] = '不能刪除僅有的預設圖';
		}
		
		$this -> to_json($res);
	}

	public function delete_img($id) {
		$res['success'] = TRUE;
		$this -> img_dao -> delete($id);

		// $this -> img_dao -> update(array('status'=>1), $id);	
		$this -> to_json($res);
	}

	public function check_account($id) {
		$account = $this -> get_post('account');
		$item = $this -> dao -> find_by("account", $account);
		$res = array();
		if(!empty($id)) {
			if (!empty($item)) {
				if($item -> id == $id) {
					$res['valid'] = TRUE;
				} else {
					$res['valid'] = FALSE;
				}

				$res['item'] = $item;
			} else {
				$res['valid'] = TRUE;
			}
		} else { // create
			if (!empty($item)) {
				$res['valid'] = FALSE;
			} else {
				$res['valid'] = TRUE;
			}
		}

		$this -> to_json($res);
	}

	public function check_code() {
		$code = $this -> get_post('intro_code');
		$list = $this -> dao -> find_all_by('code', $code);
		$res = array();
		$res['valid'] = (count($list) > 0);
		$this -> to_json($res);
	}

	public function img_post(){
		$img_id = $this -> get_post('img_id');
		$u_data = array();
		$reload=1;
		$p = $this -> img_dao -> find_by_id($img_id);
		if(!empty($p)){
			if($p->status==0){
				$u_data['status'] = 1;
				$res['success_msg'] = '變更預設成功';
			} else{
				$u_data['status'] = 0;
				$res['success_msg'] = '變更非預設成功';
			}
			$this -> img_dao -> update($u_data, $img_id);
			// $this -> curl -> simple_post("http://192.168.3.251/app/carousel/reload",$reload);
			// $this -> carousel(1);
		}
		$res['success'] = TRUE;

		// $find_list_by_pm_id = $this -> img_dao -> find_by_pm_id($p->place_mark_id);	
		// $list_count = count($find_list_by_pm_id);
		// if($list_count>1){
		// 	if($p -> place_mark_status == 0) {
		// 		$other_default_list= $this -> img_dao -> find_other_default($p->place_mark_id, $p->id);
		// 		if(!empty($other_default_list)){
		// 			$clean_default['place_mark_status'] = 0;//清除其他預設
		// 			$this -> img_dao -> update($clean_default, $other_default_list->id);//清除其他預設
		// 		}
	
		// 		$u_data['place_mark_status'] = 1;
		// 		$up_place_data['image_id'] = $img_id;
	
		// 		$this -> img_dao -> update($u_data, $img_id);
		// 		$this -> dao -> update($up_place_data, $p->place_mark_id);//回寫預設
		// 		$res['success_msg'] = '變更預設成功';
		// 		$res['success'] = TRUE;
		// 	}  else {
		// 		$u_data['place_mark_status'] = 0;
		// 		$up_place_data['image_id'] = 0;
		// 		$res['success_msg'] = '變更非預設成功';
		// 		$this -> img_dao -> update($u_data, $img_id);
		// 		$this -> dao -> update($up_place_data, $p->place_mark_id);//回寫預設
		// 		$res['success'] = TRUE;
	
		// 	}
		// } else{
		// 	$this -> dao -> update(array(
		// 		'image_id' => $img_id
		// 	), $p->place_mark_id);
		// 	$this -> img_dao -> update(array(
		// 		'place_mark_status' => 1
		// 	), $img_id);
		// 	$res['success_msg'] = '變更預設成功';
		// }
		$this -> to_json($res);
	}


	public function chg_user() {
		$user_id = $this -> get_post('user_id');
		$this -> session -> set_userdata('user_id', $user_id);
		$res = array();

		$this -> to_json($res);
	}

	public function do_update_type_delete() {
		$res['success'] = TRUE;
		$delete_num = $this -> get_post('delete_num');
		$each_id = $this -> dao -> find_by_each_id($delete_num);
		foreach ($each_id as $each) {
			$this -> dao -> delete($each->id);

		}
		$this -> to_json($res);
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

								if ($cuisine_type!==NULL) {
									if(!empty($cuisine_type) && $cuisine_type!==$last_cuisine_type){
										$last_cuisine_type = $cuisine_type;
									}
								} else {
									$cuisine_type = $last_cuisine_type;
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
								if($menu_name==NULL){
									$menu_name = '';
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

							if ($cuisine_type!==NULL) {
								if(!empty($cuisine_type) && $cuisine_type!==$last_cuisine_type){
									$last_cuisine_type = $cuisine_type;
								}
							} else {
								$cuisine_type = $last_cuisine_type;
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
							if($menu_name==NULL){
								$menu_name = '';
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

	function export_all() {
			$this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
			$date = date('YmdHis');
      $filename = $date."-user.csv";

			$corp_list = $this -> corp_dao -> find_all();

			//create a file pointer
    	$f = fopen('php://memory', 'w');
			$fields = array(
				iconv("UTF-8","Big5//IGNORE",'帳號'),
				iconv("UTF-8","Big5//IGNORE",'會員姓名'),
				'Email',
				'LINE ID',
				iconv("UTF-8","Big5//IGNORE",'公司'),
				iconv("UTF-8","Big5//IGNORE",'貨幣數量'),
				'NTD',
				iconv("UTF-8","Big5//IGNORE",'藍鑽')
			);
			fputcsv($f, $fields, $delimiter);

      $query = "SELECT id, account,
				user_name,
				email, line_id, corp_id
      	FROM `menu`
				WHERE status = 0 ";

			$s_data = $this -> setup_user_data(array());
			$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
			$data['login_user'] = $login_user;

			if($login_user -> role_id == 99) {
				// all roles

			} else {
				$query .= " and corp_id = {$login_user->corp_id} ";
			}

      $result = $this->db->query($query) -> result();
			foreach($result as $each) {
				$lineData = array($each -> account, iconv("UTF-8","Big5//IGNORE",$each -> user_name), $each -> email, $each -> line_id);

				$corp_sys_name = '';
				foreach($corp_list as $corp) {
					if($each -> corp_id == $corp -> id) {
						$corp_sys_name = $corp -> sys_name;
					}
				}

				$lineData[] = $corp_sys_name;
				$lineData[] = $this -> wtx_dao -> get_sum_amt($each -> id);
				$lineData[] = $this -> wtx_ntd_dao -> get_sum_amt($each -> id);
				$lineData[] = $this -> wtx_bdc_dao -> get_sum_amt($each -> id);
				// $lineData[]= 0;
				// $lineData[]= 0;
				// $lineData[]= 0;
				// foreach($lineData as $aCol) {
				// 	$aCol = iconv("UTF-8","Big5//IGNORE",$aCol);
				// }

				fputcsv($f, $lineData, $delimiter);
			}
			//move back to beginning of file

    	fseek($f, 0);

			//set headers to download file rather than displayed
			 header('Content-Type: text/csv');
			 header('Content-Disposition: attachment; filename="' . $filename . '";');

			 //output all remaining data on a file pointer
			 fpassthru($f);
      // $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
      // force_download($filename,@iconv("UTF-8","Big5//IGNORE",$data));
	}

	public function new_img_style(){
		$data = array();
		$this -> load -> view('layout/show_new_img_style',$data);
	}

	public function add_img_style(){
		$data = array();
		$img_style = $this -> get_post('img_style');
		$data['img_style'] = $img_style;
		$this -> img_style_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_img_style(){
		$res = array();
		$img_style_list = $this -> img_style_dao -> find_all();
		$res['img_style'] = $img_style_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	

}
