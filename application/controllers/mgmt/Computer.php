<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Computer extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Computer_dao', 'dao');
		$this -> load -> model('Computer_hard_dao', 'c_h_dao');
		$this -> load -> model('Computer_soft_dao', 'c_s_dao');
		$this -> load -> model('C_s_h_join_list_dao', 'c_s_h_join_list_dao');
		$this -> load -> model('Fix_record_dao', 'fix_record_dao');

		$this -> load -> model('Members_log_dao', 'members_log_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Users_dao', 'users_dao');
	
		$this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		$this->load->view('mgmt/computer/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'type',
		));
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> dao -> find_by_id($s_data['login_user_id']);
		$items = $this -> dao -> query_ajax($data);
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);

		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$data['id'] = $id;
		if(!empty($id)) {
			$q_data = $this -> get_posts(array(
				'length',
				'start',
				'columns',
				'search',
				'order',
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			if(!empty($list)){
				$item = $list[0];
			} else{
				$item = 0;
			}
			$data['item'] = $item;
			$this -> session -> set_userdata('fix_data', $q_data);

		}

		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);

		$computer_hard_list = $this -> c_h_dao -> find_all_usage_not_zero();
		$computer_soft_list = $this -> c_s_dao -> find_all_usage_not_zero();
		$user_list = $this -> users_dao -> find_all_user();

		// $all_user_list = $this -> c_s_dao -> find_all_user();

		$data['computer_hard_list'] = $computer_hard_list;//硬體所有list
		$data['computer_soft_list'] = $computer_soft_list;//軟體所有list
		$data['computer_soft_list'] = $computer_soft_list;//軟體所有list
		$data['user_list'] = $user_list;//所有員工list

		$data['login_user'] = $login_user;
		// $data['coach'] = $this -> dao -> find_all_coach();
		// $this -> to_json($data);

		$this->load->view('mgmt/computer/edit', $data);
	}

	public function get_fix_record() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'computer',
		));

		$res['items'] = $this -> fix_record_dao -> find_compter_fix($data);
		foreach($res['items'] as $each){
			$o_h = $each -> old_computer_hard_id;
			$o_s = $each -> old_computer_soft_id;
			$n_h = $each -> new_computer_hard_id;
			$n_s = $each -> new_computer_soft_id;
			$o_h_name = $this -> c_h_dao -> find_sh_name($o_h);
			$o_s_name = $this -> c_s_dao -> find_sh_name($o_s);
			$n_h_name = $this -> c_h_dao -> find_sh_name($n_h);
			$n_s_name = $this -> c_s_dao -> find_sh_name($n_s);
			if(!empty($o_h_name)){
				$each -> o_h_name = $o_h_name;
			} else{
				$each -> o_h_name = '';
			}
			if(!empty($o_s_name)){
				$each -> o_s_name = $o_s_name;
			} else{
				$each -> o_s_name = '';
			}
			if(!empty($n_h_name)){
				$each -> n_h_name = $n_h_name;
			} else{
				$each -> n_h_name = '';
			}
			if(!empty($n_s_name)){
				$each -> n_s_name = $n_s_name;
			} else{
				$each -> n_s_name = '';
			}
		}
		$res['recordsFiltered'] = $this -> fix_record_dao -> find_compter_fix($data, TRUE);
		$res['recordsTotal'] = $this -> fix_record_dao -> find_compter_fix($data, TRUE);

		$this -> to_json($res);
	}

	public function get_fix_recording() {
		$res = array();

		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'computer',
		));

		$res['items'] = $this -> fix_record_dao -> find_compter_fixing($data);
		foreach($res['items'] as $each){
			$o_h = $each ->old_computer_hard_id;
			$o_s = $each ->old_computer_soft_id;
			$n_h = $each ->new_computer_hard_id;
			$n_s = $each ->new_computer_soft_id;
			$o_h_name = $this -> c_h_dao -> find_sh_name($o_h);
			$o_s_name = $this -> c_s_dao -> find_sh_name($o_s);
			$n_h_name = $this -> c_h_dao -> find_sh_name($n_h);
			$n_s_name = $this -> c_s_dao -> find_sh_name($n_s);
			$each -> o_h_name = $o_h_name;
			$each -> o_s_name = $o_s_name;
			$each -> n_h_name = $n_h_name;
			$each -> n_s_name = $n_s_name;
			if(!empty($o_h_name)){
				$each -> o_h_name = $o_h_name;
			} else{
				$each -> o_h_name = '';
			}
			if(!empty($o_s_name)){
				$each -> o_s_name = $o_s_name;
			} else{
				$each -> o_s_name = '';
			}
			if(!empty($n_h_name)){
				$each -> n_h_name = $n_h_name;
			} else{
				$each -> n_h_name = '';
			}
			if(!empty($n_s_name)){
				$each -> n_s_name = $n_s_name;
			} else{
				$each -> n_s_name = '';
			}
		}
		$res['recordsFiltered'] = $this -> fix_record_dao -> find_compter_fixing($data, TRUE);
		$res['recordsTotal'] = $this -> fix_record_dao -> find_compter_fixing($data, TRUE);

		$this -> to_json($res);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$computer_name = $this -> get_post('computer_name');
		$computer_num = $this -> get_post('computer_num');
		$computer_property_num = $this -> get_post('computer_property_num');
		$admin_user = $this -> get_post('admin_user');
		$hard_id_array = $this -> get_post('hard_id_array');
		$soft_id_array = $this -> get_post('soft_id_array');
		$new_hard_id_array = mb_split(",", $hard_id_array);
		$new_soft_id_array = mb_split(",", $soft_id_array);
		$data['computer_name'] = $computer_name;
		$data['computer_num'] = $computer_num;
		$data['computer_property_num'] = $computer_property_num;
		$data['admin_user_id'] = $admin_user;

		if(empty($id)) {
			// insert
			$last_id = $this -> dao -> insert($data);
			$u_data['computer_id'] = $last_id;
			foreach($new_hard_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
			foreach($new_soft_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
		} else {
			$this -> dao -> update($data, $id);
			$u_data['computer_id'] = $id;
			foreach($new_hard_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
			foreach($new_soft_id_array as $each){
				$last_id = $this -> c_s_h_join_list_dao -> update($u_data, $each);
			}
		}

		$res['success'] = TRUE;
		$res['computer_soft_id_array'] = $soft_id_array;
		$res['computer_hard_id_array'] = $hard_id_array;

 		$this -> to_json($res);
	}

	public function add_useful() {
		$res = array();
		$c_h_id = $this -> get_post('c_h_id');
		$c_s_id = $this -> get_post('c_s_id');

		if(!empty($c_h_id)){
			$c_h_list= $this -> c_h_dao -> find_by_id($c_h_id);
			$u_data['usage_count'] = intval($c_h_list->usage_count) -1;
			$i_data['computer_hard_id'] = $c_h_id;

			$last_id = $this -> c_s_h_join_list_dao -> insert($i_data);
			$this -> c_h_dao -> update($u_data,$c_h_id);
			$res['last_hard_id'] = $last_id;
			$res['hard_name'] = $c_h_list->computer_hard_name;
			$res['hard_num'] = $c_h_list->computer_num;

		} 
		
		if(!empty($c_s_id)){
			$c_s_list= $this -> c_s_dao -> find_by_id($c_s_id);
			$u_data['usage_count'] = intval($c_s_list->usage_count) -1;
			$i_data['computer_soft_id'] = $c_s_id;

			$last_id = $this -> c_s_h_join_list_dao -> insert($i_data);
			$this -> c_s_dao -> update($u_data,$c_s_id);
			$res['last_soft_id'] = $last_id;
			$res['soft_name'] = $c_s_list->computer_soft_name;
			$res['soft_num'] = $c_s_list->computer_num;

		} 
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['is_delete'] = 1;
		$data['delete_userid'] = $login_user->id;

		$hard_list = $this -> c_s_h_join_list_dao -> find_all_by_id($id,0);
		// $soft_list = $this -> c_s_h_join_list_dao -> find_all_by_id($id,1);
		// foreach($hard_list as $each){
		// 	$this -> c_h_dao -> update($data, $each->hard_id);
		// }
		// foreach($soft_list as $each){
		// 	$soft_now_list = $this -> c_s_dao -> find_by_id($each->soft_id);
		// 	if(!empty($soft_now_list) && $soft_now_list->usage_count==0){//如過使用次數剩餘0才做刪除
		// 		$this -> c_s_dao -> update($data, $soft_now_list->id);
		// 	}
		// }
		// $this -> dao -> update($data, $id);
		$res['hard_list'] = $hard_list;
		// $res['soft_list'] = $soft_list;
		$this -> to_json($res);
	}

	public function find_now_s_h_list() {
		$computer_id = $this -> get_post('computer_id');
		if($computer_id>0){
			$hard_list = $this -> c_s_h_join_list_dao -> find_use_now_by_computer($computer_id,0);
			$soft_list = $this -> c_s_h_join_list_dao -> find_use_now_by_computer($computer_id,1);
			$res['hard_list'] = $hard_list;
			$res['soft_list'] = $soft_list;

		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function update_here() {
		$res = array();
		$id = $this -> get_post('id');
		$data = $this -> get_posts(array(
			'seed',
			'level_status'
		));
		$login_count = $this -> get_post('login_count');
		$the_day_list = $this -> dao -> find_by_id($id);
		$the_day = $the_day_list -> last_login_time;
		$that_day = date('Y-m-d',strtotime($the_day));
		$the_day_before = date("Y-m-d H:i:s",strtotime($the_day.'-1 day'));
		if(!empty($id)) {
			// insert
			$this -> dao -> update($data, $id);

			if (!empty($login_count)) {
				$u_data['login_count'] = $login_count;
				$u_data['last_login_time'] = $the_day_before;
				$this -> dao -> update($u_data, $id);
				$log_last = $this -> members_log_dao -> find_by_log111($id,$that_day);
				if(!empty($log_last)){
					$this -> members_log_dao -> delete($log_last);
				}
			}
		}

		$res['success'] = TRUE;

 		$this -> to_json($res);
	}

	public function update_fix_type() {
		$res = array();
		$u_data = array();
		$fix_record_id = $this -> get_post('fix_record_id');
		$fix_type = $this -> get_post('fix_type');
		$fix_date = $this -> get_post('fix_date');
		$done_fix_date = $this -> get_post('done_fix_date');
		$fix_way = $this -> get_post('fix_way');
		$fix_reason = $this -> get_post('fix_reason');
		
		if(!empty($fix_record_id)){
			$u_data['fix_type'] = $fix_type;
			$u_data['fix_date'] = $fix_date;
			$u_data['done_fix_date'] = $done_fix_date;
			$u_data['fix_way'] = $fix_way;
			$u_data['fix_reason'] = $fix_reason;
			if(!empty($done_fix_date)){
				$u_data['type'] = 0;//已完成維修需要把就有的軟硬體移除(假刪除)
				$item = $this -> fix_record_dao -> find_by_id($fix_record_id);
				if($item->fix_type=='change'){//啟用更換狀態的軟硬體和假刪除以壞掉的軟硬體
					$this -> c_s_h_join_list_dao -> update(array('is_ok' => 0), $item -> c_s_h_jion_list_id);
					$this -> c_s_h_join_list_dao -> update(array('is_ok' => 1), $item -> new_c_s_h_jion_list_id);
			
				}
			} else{
				$u_data['type'] = 2;
			}
			$this -> fix_record_dao -> update_by($u_data,'id',$fix_record_id);
			$res['success'] = TRUE;
		}
		
 		$this -> to_json($res);
	}

	function export_all() {
		$data = $this -> session -> userdata("fix_data");
		$list = $this -> dao -> query_ajax($data);
		$h = array();
		$s = array();

		if(!empty($list)){
			$item = $list[0];
			$hard_list = $this -> c_s_h_join_list_dao -> find_use_now_by_computer($item->id,0);
			$soft_list = $this -> c_s_h_join_list_dao -> find_use_now_by_computer($item->id,1);
			foreach($hard_list as $h_list){
				$h[] = $h_list->hard_name;
			}
			foreach($soft_list as $s_list){
				$s[] = $s_list->soft_name;
			}
			$compter_fix_list = $this -> fix_record_dao -> find_now_compter_fix($item->id);
		} 
	
		$PHPWord = new PHPWord(); 
		$PHPWord->setDefaultFontName('華康仿宋體'); 
		// $section = $PHPWord->createSection();
		$sectionStyle = array('orientation' => null,  'marginLeft' => 2000,  'marginRight' => 2000); //頁面設定
		$section = $PHPWord->createSection($sectionStyle); //建立一個頁面
		 
		
		// $tableStyle = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);

		// Add table style 
		// $PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow); 
		// $PHPWord->addTableStyle('tableStyle',$tableStyle,null);
		// $table = $section->addTable('tableStyle');
		// $table->addRow(900); 
		// $table->addCell(8000,$styleCell)->addText('寬事工業股份有限公司',$fontStyle,$centered); 
		
		// $table->addRow(900); 
		// $table->addCell(8000,$styleCell)->addText('電腦管制表',$fontStyle,$centered); 
		// $table->addRow(900); 
		// $table->addCell(8000,$styleCell)->addText('電腦編號：'.$item->computer_num); 
		// // Add table 
		// $table = $section->addTable('myOwnTableStyle'); 

		// $table->addRow(); 
		// $table->addCell(1000)->addText('項目',$fontStyle,$centered); 
		// $table->addCell(8000)->addText('內容明細',$fontStyle,$centered); 
		// $table->addRow(); 
		// $table->addCell(1000)->addText('硬體配備',$fontStyle,$centered); 
		// $table->addCell(8000)->addText(implode(",",$h),$fontStyle,$centered); 
		// $table->addRow(); 
		// $table->addCell(1000)->addText('安裝軟體',$fontStyle,$centered); 
		// $table->addCell(8000)->addText(implode(",",$s),$fontStyle,$centered);
		// $table->addRow(); 
		// $table->addCell(1000)->addText('使用者',$fontStyle,$centered); 
		// $table->addCell(8000)->addText($item->admin_user_id,$fontStyle,$centered);  
		// $table->addRow(); 
		// $table->addCell(9000)->addText('維修紀錄',$fontStyle,$centered); 
		// $table->addRow(); 
		// $table->addCell(1500)->addText('完修日期',$fontStyle,$centered); 
		// $table->addCell(3000)->addText('故障原因',$fontStyle,$centered); 
		// $table->addCell(3000)->addText('處置情形',$fontStyle,$centered); 
		// $table->addCell(1500)->addText('維修人員',$fontStyle,$centered); 

		// // Add more rows/cells 
		// foreach($compter_fix_list as $each){
		// 	$table->addRow(); 
		// 	$table->addCell(1500)->addText($each->done_fix_date,$fontStyle,$centered); 
		// 	$table->addCell(3000)->addText($each->fix_reason,$fontStyle,$centered); 
		// 	$table->addCell(3000)->addText($each->fix_way,$fontStyle,$centered); 
		// 	$table->addCell(1500)->addText($each->user_name,$fontStyle,$centered); 
		// } 
		$tableStyle = array('borderSize'=>6, 'borderColor'=>'black', 'cellMargin'=>80);
		$whitetableStyle = array('borderSize'=>6, 'borderColor'=>'ffffff', 'cellMargin'=>80);
		$footer_style = array('borderSize'=>6, 'borderColor'=>'ffffff', 'cellMargin'=>80);

		$PHPWord->addTableStyle('white_tableStyle',$whitetableStyle,null);
		$PHPWord->addTableStyle('tableStyle',$tableStyle,null);
		$PHPWord->addTableStyle('footer_tableStyle',$footer_style,null);

		$white_table = $section->addTable('white_tableStyle');
		$table = $section->addTable('tableStyle');
		$footer_table = $section->addTable('footer_tableStyle');

		$white_table->addRow();
		$white_table->addCell(8000,null,8)->addText('寬仕工業股份有限公司',array('bold' => true, 'size'=>25),array('align'=>'center'));

		$white_table->addRow();
		$white_table->addCell(8000,null,8)->addText('電腦管制表',array('size'=>25),array('align'=>'center', 'size'=>16));

		$white_table->addRow();
		$white_table->addCell(8000,null,8)->addText('電腦編號:'.$item->computer_num,null);

		$table->addRow();
		$table->addCell(1000,null,1)->addText('項目',null,array('align'=>'center'));
		$table->addCell(6000,null,6)->addText('內容明細',null,array('align'=>'center'));
		$table->addCell(1000,null,1)->addText('備註',null,array('align'=>'center'));

		$table->addRow();
		$table->addCell(1000,null,1)->addText('硬體配備',null,array('align'=>'center'));
		$table->addCell(6000,null,6)->addText(implode(",",$h),null);
		$table->addCell(1000,null,1)->addText('',null,array('align'=>'center'));

		$table->addRow();
		$table->addCell(1000,null,1)->addText('安裝軟體',null,array('align'=>'center'));
		$table->addCell(6000,null,6)->addText(implode(",",$s),null);
		$table->addCell(1000,null,1)->addText('',null,array('align'=>'center'));

		$table->addRow();
		$table->addCell(1000,null,1)->addText('使用者',null,array('align'=>'center'));
		$table->addCell(6000,null,6)->addText($item->admin_user_id,null);
		$table->addCell(1000,null,1)->addText('',null,array('align'=>'center'));

		$table->addRow();
		$table->addCell(8000,null,8)->addText('維修紀錄',null,array('align'=>'center'));

		$table->addRow();
		$table->addCell(1000,null,1)->addText('維修日期',null,array('align'=>'center'));
		$table->addCell(3000,null,3)->addText('故障原因',null,array('align'=>'center'));
		$table->addCell(3000,null,3)->addText('處置情形',null,array('align'=>'center'));
		$table->addCell(1000,null,1)->addText('維修人員',null,array('align'=>'center'));

		foreach($compter_fix_list as $each){
			$table->addRow();
			$table->addCell(1000,null,1)->addText(str_replace("-",",",$each->done_fix_date),null);
			$table->addCell(3000,null,3)->addText($each->fix_reason,null);
			$table->addCell(3000,null,3)->addText($each->fix_way,null);
			$table->addCell(1000,null,1)->addText($each->user_name,null);
		}
		$footer_table->addRow();
		$footer_table->addCell(8000,null,8)->addText('R020102-A',null,array('align'=>'right'));

		$date = date('YmdHis');
		$filename = $date."-維修單.docx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save('php://output');
	}


}
