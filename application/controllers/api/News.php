<?php
class News extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// setup models
		$this -> load -> model('News_private_dao', 'dao');

	}


	// public function list_all(){
	// 	$page = $this -> get_post('page');
	// 	$f = array();
	// 	if(!empty($page)){
	// 		$f['page'] = $page;
	// 	}
	// 	$list = $this -> dao -> find_by_parameter($f);
	// 	$res['list'] = $list;
	// 	$this -> to_json($res);
	// }

	public function add(){
		$res = array();
		$title = $this -> get_post('title');
		$content = $this -> get_post('content');

		if(!empty($title) && !empty($content)) {
				$update_data = array(
												'title' => $title,
												'content' => $content
											);
				$m = $this -> dao -> insert($update_data);
				$res['success'] = TRUE;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function list_all(){
		$res = array();

		$member_id = $this -> get_post('member_id');
		$page = $this -> get_post('page');
		$f = array();
		if(!empty($page)){
			$f['page'] = $page;
		}
		if(!empty($member_id)){
			$f['member_id'] = $member_id;
			$count = $this -> dao -> find_unread($f);
			$list = $this -> dao -> find_by_parameter($f);

			foreach ($list as $each) {
				$value = '<!DOCTYPE html><html lang="zh-Hant-TW"><head><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
									<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"><meta charset="UTF-8">
									</head><body>'.$each->content.'</body></html';
				$each->html = $value;
			}

			$res['success'] = TRUE;
			$res['unread'] = $count->count;
			$res['list'] = $list;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}

		$this -> to_json($res);
	}

	public function add_read(){
		$res = array();
		$id = $this -> get_post('id');
		if(!empty($id)){
			$this -> dao -> update(array('is_read'=> 1),$id);
			$res['success'] = TRUE;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}

	public function do_delete(){
		$res = array();
		$id = $this -> get_post('id');
		if(!empty($id)){
			$this -> dao -> update(array('is_delete'=> 1),$id);
			$res['success'] = TRUE;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}







}
?>
