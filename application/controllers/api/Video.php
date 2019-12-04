<?php
class Video extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('Members_dao', 'dao');
		$this -> load -> model('Members_log_dao', 'log_dao');
		$this -> load -> model('Video_dao', 'video_dao');
		$this -> load -> model('Video_detail_dao', 'video_detail_dao');
		$this -> load -> model('Video_record_dao', 'video_record_dao');

	}

	function index() {
		echo "index";
	}

	public function list_video() {
		$video_id = $this -> get_post('video_id');

		$list;
		if(!empty($video_id)){
			$list = $this -> video_dao -> find_by_value(array('video_id'=>$video_id));
		}else{
			$list = $this -> video_dao -> find_all();
		}
		foreach ($list as $each) {
			$detail = $this -> video_detail_dao -> find_by_value(array('video_id'=> $each->id));

			foreach ($detail as $each1) {
				$detail2 = $this -> video_detail_dao -> find_by_value(array('parameter_id'=> $each1->id));
				if(!empty($detail2)){
					$each1 -> detail = $detail2;
				}
			}
			$each -> detail = $detail;
		}
		$res['list'] = $list;
		$this -> to_json($res);
	}

	public function add_video_record() {
		$id = $this -> get_post('member_id');
		$video_id = $this -> get_post('video_id');

		if(!empty($id) && !empty($video_id)) {
			$i_data = array('member_id'=> $id , 'video_detail_id'=> $video_id);
			$id = $this -> video_record_dao -> insert($i_data);

			$res['success'] = TRUE;
			$res['id'] = $id;
		}else{
			$res['error_code'][] = "columns_required";
			$res['error_message'][] = "缺少必填欄位";
		}
		$this -> to_json($res);
	}


}
?>
