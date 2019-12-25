<?php
class News extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		// setup models
		$this -> load -> model('News_dao', 'dao');

	}


	public function list_all(){
		$list = $this -> dao -> find_all();
		$res['list'] = $list;
		$this -> to_json($res);
	}

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





}
?>
