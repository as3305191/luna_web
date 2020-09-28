<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @brief 系統管理->權限管理
 */
class Patent_category extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
	
		$this -> load -> model('Patent_category_dao', 'dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Department_dao','d_dao');
		$this -> load -> model('Customs_dao','c_dao');
	}

	/**
	 * @brief 權限管理列表
	 */

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);

		$item = $this -> dao -> find_all_by('parent_id','0');
		// $data['item'] = $item;
		$max_level = $this -> dao -> get_max();
		$data['max_level'] = $max_level;
		$datas = $this -> dao -> find_all();

		$data['items'] = $items = $this -> generateTree($datas);

		$t_data = $this -> drawTree($items);
		$data['t_data'] = $t_data;
		// $this -> to_json($t_data);
		$this->load->view('mgmt/Patent_category/list', $data);
	}

	public function re_index()
	{
		$data = array();
		$this -> setup_user_data($data);

		$item = $this -> dao -> find_all_by('parent_id','0');
		// $data['item'] = $item;
		$max_level = $this -> dao -> get_max();
		$data['max_level'] = $max_level;
		$datas = $this -> dao -> find_all();

		$data['items'] = $items = $this -> generateTree($datas);

		$t_data = $this -> drawTree($items);
		$data['t_data'] = $t_data;
		// $this -> to_json($t_data);
		$this -> to_json($data);
	}

	/**
	 * @brief 畫權限管理列表的樹
	 */

	public function generateTree($data, $pid = 0){
		$tree = [];
		if($data && is_array($data)){
			foreach ($data as $v) {
				if($v -> parent_id == $pid){
					$tree[] = [
						'id' => $v -> id,
						'name' => $v -> name,
						'parent_id' => $v -> parent_id,
						'level' => $v -> level,
						'children' => $this -> generateTree($data,$v -> id),
					];
				}
			}
		}
		return $tree;
	}

	/**
	 * @brief 畫樹
	 */

	public function drawTree($items,$t_data =''){
		if(!isset($t_data)){
			$t_data = '';
		}else{
			$t_data = $t_data;
		}

		foreach ($items as $each) {
			$t_data .= '<tr>';
			$t_data .= '<td style="line-height:34px">'.$each['name'].'</td>';
			$t_data .= '<td class="min300"><button class="btn btn-default role-btn" onclick="add_under('.$each['id'].')">增加下級</button><button class="btn btn-default role-btn" onclick="edit_page('.$each['id'].')">編輯</button><button class="btn btn-default role-btn" onclick="del_page('.$each['id'].')">移除</button></td>';
			$t_data .= '</tr>';
			$t_data .= $this -> draw($each['children']);

		}
		return $t_data;
	}

	/**
	 * @brief 畫樹
	 */

	public function draw($data){
		$s_data = '';
		foreach ($data as $each) {
			$s_data .= '<tr>';
			$s_data .= '<td style="line-height:34px">';
			if($each['level'] >= 1){
				for ($k=0; $k < $each['level']; $k++) {
					$s_data .= '&emsp;&emsp;';
				}
				$s_data .= '└ ';
				$s_data .= $each['name'];
			}

			$s_data .= '</td><td><button class="btn btn-default role-btn" onclick="add_under('.$each['id'].')">增加下級</button><button class="btn btn-default role-btn" onclick="edit_page('.$each['id'].')">編輯</button><button class="btn btn-default role-btn" onclick="del_page('.$each['id'].')">移除</button></td>';
			$s_data .= '</tr>';
			// if(!empty($each['children'])){
				foreach ($each['children'] as $ec) {
					$s_data .= '<tr>';
					$s_data .= '<td style="line-height:34px">';
					if($ec['level'] >= 1){
						for ($k=0; $k < $ec['level']; $k++) {
							$s_data .= '&emsp;&emsp;';
						}
						$s_data .= '└ ';
						$s_data .= $ec['name'];
					}
					$s_data .= '</td><td><button class="btn btn-default role-btn" onclick="add_under('.$ec['id'].')">增加下級</button><button class="btn btn-default role-btn" onclick="edit_page('.$ec['id'].')">編輯</button><button class="btn btn-default role-btn" onclick="del_page('.$ec['id'].')">移除</button></td>';
					$s_data .= '</tr>';
					// if(!empty($ec['children'])){
					$s_data .= $this -> draw($ec['children']);
					// }

				}
			// }
		}
		return $s_data;

	}

	/**
	 * @brief 刪除
	 */

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	/**
	 * @brief 增加下級部門
	 */

	public function add_under(){
		$res = array();

		$parent_id = $this -> get_post('parent_id');
		$parent_child = $this -> dao -> find_all_by('parent_id',$parent_id);

		$name = $this -> get_post('new_name');
		$parent = $this -> dao -> find_by_id($parent_id);
		$plevel = $parent -> level;
		$level = $plevel + 1;
		$ppos = count($parent_child);
		$pos = $ppos + 1;
		$i_data = array();
		$i_data['parent_id'] = $parent_id;
		$i_data['name'] = $name;
		$i_data['level'] = $level;
		$i_data['pos'] = $pos;
		$this -> dao -> insert($i_data);
		$res['success'] = TRUE;

		$this -> to_json($res);
	}

	/**
	 * @brief 增加下級跳窗
	 */

	public function show_role_window($id){
		$parent = $this -> dao -> find_by_id($id);
		$data = array();
		$data['parent'] = $parent;
		$this -> load -> view('layout/show_role_window',$data);
	}

	/**
	 * @brief 編輯權限
	 */

	public function edit_page($id) {

		$data = array();
		$data['id'] = $id;
		if(!empty($id)) {
			$item  = $this -> dao -> find_by_id($id);
			if(!empty($item -> image_id)) {
				$item -> img = $this -> img_dao -> find_by_id($item -> image_id);
			}

			$data['item'] = $item;
			$data['menu_list'] = $this -> users_dao -> nav_list_with_role_id($id);
		} else {
			$data['menu_list'] = $this -> users_dao -> nav_list();
		}

		$this->load->view('mgmt/Patent_category/edit', $data);
	}

	/**
	 * @brief 新增部門跳窗
	 */

	public function new_department(){
		$data = array();
		$this -> load -> view('layout/show_new_department',$data);
	}

	/**
	 * @brief 新增部門
	 */
	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'name'
		));

		$nav_ids = $this -> get_post('nav_ids');
		// $nav_powers = $this -> get_post('nav_powers');

		$nav_powers = array();
		foreach($nav_ids as $a_id) {
			$nav_powers[$a_id] = array();
			$post_arr = $this -> get_post("nav_powers_{$a_id}");
			if(!empty($post_arr)) {
				$nav_powers[$a_id] = $post_arr;
			}
		}

		if(empty($id)) {
			// insert
			$id = $this -> dao -> insert($data);
		} else {
			// dao
			$this -> dao -> update($data, $id);
		}
		$this -> dao -> update_role_power($id, $nav_ids, $nav_powers);

		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function add_department(){
		$data = array();
		$data['parent_id'] = '0';
		$pos_num = $this -> dao -> find_all_by('level',0);
		$pos_nums = count($pos_num);

		$data['pos'] = $pos_nums;
		$name = $this -> get_post('new_name');
		$data['name'] = $name;
		$data['level'] = '0';
		$this -> dao -> insert($data);

		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	/**
	 * @brief 移除部門 ＆＆ 檢查是否可以刪除
	 */

	public function del_page(){
		$res = array();
		$id = $this -> get_post('id');
		$childs = $this -> dao -> find_all_by('parent_id',$id);
		if (!empty($childs)) {
			$res['error_msg'] = '尚有子項目';
		} else {
			$this -> dao -> delete($id);
			$res['success'] = true;
		}

		$this -> to_json($res);

	}

	/**
	 * @brief 更新部門權限
	 */

	public function update_department(){
		$data = array();
		$post = $_POST;
		$id = $this -> get_post('roles_id');

		$data = $this -> get_posts(array(
			'name',
			'new_project',
			'view_project',
			'view_project_option',
			'edit_project',
			'cancel_project',
			'end_project',
			'new_recruit',
			'view_recruit',
			'view_recruit_option',
			'edit_recruit',
			'send_interview',
			'edit_interview',
			'view_talent_pool',
			'work_shift_recommend',
			'download_member_data',
			'download_member_picture',
			'download_member_health',
			'download_member_doc',
			'set_black_list',
			'review_doc',
			'view_work_shift',
			'view_work_shift_option',
			'send_hr',
			'change_work_shift',
			'new_work_shift',
			'review_change_work_shift',
			'view_ws_detail',
			'view_work_shift_detail',
			'view_work_shift_detail_option',
			'import_work_shift',
			'set_work_salary',
			'work_salary_review',
			'view_training',
			'view_training_option',
			'set_reminder',
			'view_mission',
			'view_mission_option',
			'new_mission',
			'view_arrange_time_search',
			'view_evaluation',
			'view_evaluation_option',
			'set_recommend_evaluation',
			'set_show_evaluation',
			'view_salary_report',
			'view_salary_report_option',
			'new_salary_report',
			'review_salary_report',
			'review_salary_report_order',
			'upload_pay_result',
			'edit_pay_result',
			'update_approval_amount',
			'view_daily_report',
			'view_daily_report_principal',
			'view_daily_report_custom',
			'view_daily_report_check_status',
			'export_daily_report',
			'view_daily_report_template',
			'set_daily_report_template',
			'check_daily_report',
			'view_manager_daily_report',
			'view_manager_daily_report_principal',
			'export_manager_daily_report',
			'export_manager_daily_report_option',
			'set_manager_daily_report_template',
			'check_manager_daily_report',
			'view_custom',
			'view_custom_option',
			'new_custom',
			'edit_custom',
			'disabled_custom',
			'disabled_custom_option',
			'review_custom',
			'change_custom_cate',
			'change_custom_principal',
			'view_market',
			'new_market',
			'review_market',
			'edit_market',
			'disabled_market',
			'export_project',
			'export_project_report',
			'temp_manager'
		));

		$this -> dao -> update_by($data,'id',$id);
		$res = array();
		$res['success'] = TRUE;
		$res['data'] = $data;

		$this -> to_json($res);
	}

	/**
	 * @brief 匯出條件
	 */

	public function search_role(){
			$r_id = $this -> get_post('r_id');

			$this -> session -> set_userdata('role_data',$r_id);
			$res = array();
			// $res['error'] = '金額狀態錯誤';
			$res['success'] = true;
			$this -> to_json($res);
	}

	/**
	 * @brief 匯出部門excel下載
	 */

	public function downloaddata(){
		$fileName = '部門權限_'.date('Y-m-d H:i:s').'.xls';
		// load excel library
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->setActiveSheetIndex(0);


		$objPHPExcel->getActiveSheet()->SetCellValue('A1', '部門名稱');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', '主功能');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', '權限項目');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', '其他設定');

		$rowCount = 2;

		$r_id = $this -> session -> userdata('role_data');
		$items = $this -> dao -> find_by_id($r_id);

		if($items -> new_project == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '專案設定');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '開案');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_project == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '專案設定');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看專案內容');
			$option = '';
			switch ($items -> view_project_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> edit_project == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '專案設定');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '編輯專案');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> export_project == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '專案設定');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '匯出專案');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> temp_manager == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '專案設定');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '模板管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> cancel_project == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '專案設定');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '取消專案');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> end_project == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '專案設定');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '結案');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> new_recruit == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '新增徵才訊息');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_recruit == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看徵才訊息');
			$option = '';
			switch ($items -> view_recruit_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> edit_recruit == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '編輯徵才訊息');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> send_interview == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '發送面試邀請');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> edit_interview == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '編輯面試邀請');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_talent_pool == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看人才庫');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> work_shift_recommend == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '加入排班推薦');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> download_member_data == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '下載人員資料');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> download_member_picture == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '下載人員會員照片');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> download_member_health == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '下載人員體檢表');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> download_member_doc == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '下載人員展資卡');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> set_black_list == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '將人員設為黑名單');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> review_doc == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '人才庫管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '審核展資卡');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}


		if($items -> view_work_shift == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看班表');
			$option = '';
			switch ($items -> view_work_shift_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> send_hr == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '指派HR');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> change_work_shift == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '異動班表');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> new_work_shift == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '新增場次');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_ws_detail == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看異動班表');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> review_change_work_shift == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '審核異動班表');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}



		if($items -> view_work_shift_detail == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看排班表');
			$option = '';
			switch ($items -> view_work_shift_detail_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> import_work_shift == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '匯入排班表');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> set_work_salary == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '人員待遇審核');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> work_salary_review == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '班表管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '審核人員待遇');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_training == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '上點提醒');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看培訓列表');
			$option = '';
			switch ($items -> view_training_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> set_reminder == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '上點提醒');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '設定上點提醒');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_mission == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '任務管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看任務內容');
			$option = '';
			switch ($items -> view_mission_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> new_mission == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '任務管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '建立任務');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_evaluation == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '評價管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看評價進度');
			$option = '';
			switch ($items -> view_evaluation_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> set_recommend_evaluation == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '評價管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '設定推薦評價');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> set_show_evaluation == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '評價管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '設定表現評價');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_salary_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '展資管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看展資報告');
			$option = '';
			switch ($items -> view_salary_report_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> new_salary_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '展資管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '新增展資報告');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> review_salary_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '展資管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '新增展資報告');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $items -> review_salary_report_order);
			$rowCount ++;
		}

		if($items -> upload_pay_result == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '展資管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '上傳支付結果');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> edit_pay_result == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '展資管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '修改支付結果');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> update_approval_amount == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '展資管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '更新核定金額');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> export_project_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '展資管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '跨專案匯出');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_daily_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看執行人員日報');
			$option = '';
			switch ($items -> view_daily_report_principal) {
				case '0':
					$option .= '所有人'."\n";
					break;

					case '1':
						$option .= '同組別'."\n";
						break;

						case '2':
							$option .= '下級'."\n";
							break;

							case '3':
								$option .= '自己'."\n";
								break;
				default:
					$option .= '所有人'."\n";
					break;
			}

			if($items -> view_daily_report_custom == '0'){
				$option .= '所有客戶'."\n";
			}else{
				$custom = $this -> c_dao -> find_by_id($items -> view_daily_report_custom);
				$option .= $custom -> name_cn;
			}

			if($items -> view_daily_report_check_status == 0){
				$option .= '全部'."\n";
			}else{
				$option .= '已完成'."\n";
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> export_daily_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '匯出執行人員日報');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_daily_report_template == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看執行人員日報模板');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> set_daily_report_template == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '設定執行人員日報模板');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> check_daily_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '檢查執行人員日報');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_manager_daily_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看督導日報');
			$option = '';
			switch ($items -> view_manager_daily_report_principal) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> export_manager_daily_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '匯出督導日報');
			$option = '';
			switch ($items -> export_manager_daily_report_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> set_manager_daily_report_template == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '設定督導日報模板');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> check_manager_daily_report == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '日報管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '檢查督導日報');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_custom == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看客戶資料');
			$option = '';
			switch ($items -> view_custom_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> new_custom == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '新增客戶');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> edit_custom == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '編輯客戶資訊');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> disabled_custom == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '使客戶失效');
			$option = '';
			switch ($items -> disabled_custom_option) {
				case '0':
					$option = '所有人';
					break;

					case '1':
						$option = '同組別';
						break;

						case '2':
							$option = '下級';
							break;

							case '3':
								$option = '自己';
								break;
				default:
					$option = '所有人';
					break;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $option);
			$rowCount ++;
		}

		if($items -> review_custom == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '審核客戶資訊');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> change_custom_cate == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '變更客戶分類');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> change_custom_principal == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '變更客戶負責人');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> view_market == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '查看通路資料');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> new_market == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '新增通路');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> review_market == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '審核通路資訊');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> edit_market == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '編輯通路資訊');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		if($items -> disabled_market == 1){
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $items -> name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '參數管理');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '使通路失效');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$rowCount ++;
		}

		// $recordsFiltered = $this -> ri_dao -> count_ajax($s_data);
		// $recordsTotal = count($items);
		// $recordsTotals = $recordsTotal + 1;
		$objPHPExcel->getActiveSheet()->getStyle('A1:D'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:D'.$rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:D'.$rowCount)->getAlignment()->setWrapText(true);
		// $chrA = ord('A');
		// $chrAB = ord('Z');
		//
		// // var_dump($chrA);
		// // var_dump($chrAB);
		// $item_count = count($items) + 2;
		// for ($i = $chrA; $i <= $chrAB ; $i++) {
		// 	// $objPHPExcel->getActiveSheet()->getColumnDimension(chr($i))->setWidth(40);
		//
		// 	// $objPHPExcel->getActiveSheet()->getColumnDimension(chr($i))->setWidth(15);
		// 	// var_dump(chr($i));
		// 	for ($j=1; $j <= $item_count; $j++) {
		//
		//
		// 	}
		//
		// }
		//

		//
		// $this -> to_json($items);
		// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		// download file
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		// $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		// $this -> to_json($data);
	}

}
