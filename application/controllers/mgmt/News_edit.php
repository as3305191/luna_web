<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_edit extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('News_dao', 'dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('News_style_dao', 'news_style_dao');
		$this -> load -> model('Img_month_use_dao', 'img_month_use_dao');		
		$this -> load -> model('Img_month_use_record_dao', 'img_month_use_record_dao');		

	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);
		$this -> load -> view('mgmt/news_edit/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			's_news_style',
		));
		// set corp id
		$s_data = $this -> setup_user_data(array());

		
		$items = $this -> dao -> query_ajax($data);
		// if($data['not_this_month']>0){
		// 	foreach($items as $items_key=>$each_items){
		// 		foreach($is_used_this_month_list as $each_used_key=>$each_used_this_month){
		// 			if($each_items->id==$each_used_this_month->img_id)
		// 			unset($items[$items_key]);
		// 		}
		// 	}
		// }
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
				'order'
			));
			$q_data['id'] = $id;
			$list = $this -> dao -> query_ajax($q_data);
			$item = $list[0];
			if(!empty($item -> image_id)) {
				$item -> img = $this -> img_dao -> find_by_id($item -> image_id);
			}

			$data['item'] = $item;
		}

		$this->load->view('mgmt/news_edit/edit', $data);
	}

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$title = $this -> get_post('title');
		$m_content = $this -> get_post('m_content');
		$news_style = $this -> get_post('news_style');
		$cost = $this -> get_post('cost');
		
		$data['title'] = $title;
		$data['content'] = $m_content;
		$data['news_style_id'] = $news_style;
		if(empty($cost)){
			$data['cost'] = '0.00';
		} else{
			$data['cost'] = $cost;
		}
		if(empty($id)) {
			// insert
			$this -> dao -> insert($data);
		} else {
			// update
			$this -> dao -> update($data, $id);
		}
		$s_data = $this -> setup_user_data(array());
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	public function check_account($id) {
		$account = $this -> get_post('account');
		$list = $this -> dao -> find_all_by('account', $account);
		$res = array();
		if(!empty($id)) {
			if (count($list) > 0) {
				$item = $list[0];
				if($item -> id == $id) {
					$res['valid'] = TRUE;
				} else {
					$res['valid'] = FALSE;
				}

				$res['item'] = $item;
			} else {
				$res['valid'] = TRUE;
			}
		} else {
			if (count($list) > 0) {
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

	public function chg_user() {
		$user_id = $this -> get_post('user_id');
		$this -> session -> set_userdata('user_id', $user_id);
		$res = array();

		$this -> to_json($res);
	}

	public function new_news_style(){
		$data = array();
		$this -> load -> view('layout/show_new_news_style',$data);
	}

	public function add_news_style(){
		$data = array();
		$news_style = $this -> get_post('news_style');
		$data['news_style'] = $news_style;
		$this -> news_style_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_news_style(){
		$res = array();
		$news_style_list = $this -> news_style_dao -> find_all();
		$res['news_style'] = $news_style_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function up_carousel(){
		$news_id = $this -> get_post('news_id');
		$u_data = array();
		$i_data = array();
		$p = $this -> dao -> find_by_id($news_id);
		if(!empty($p)){
			if($p->status==0){
				$u_data['status'] = 1;
				$res['success_msg'] = '變更輪播成功';
				if($p->news_style_id==9){
					$content_array=explode("</p>",$p->content);
					foreach($content_array as $each){
						$img_id = $this->get_between($each, "get/", '/thumb');
						$img_id_array[] = $img_id;
						foreach($img_id_array as $img_id_key=>$each_img_id){
							if(!is_numeric($each_img_id))
							unset($img_id_array[$img_id_key]);
						}
					}
					$new_img_array = $img_id_array;
					$res['new_img_array'] = $new_img_array;
					$this -> img_month_use_dao -> empty_table();

					foreach($new_img_array as $each){
						$i_data['img_id'] = $each;
						$this -> img_month_use_dao -> insert($i_data);
						$this -> img_month_use_record_dao -> insert($i_data);
					}
				}
				
			} else{
				$u_data['status'] = 0;
				$res['success_msg'] = '變更非輪播成功';
			}
			
			$this -> dao -> update($u_data, $news_id);
		
		}
		$res['success'] = TRUE;

	
		$this -> to_json($res);
	}

	function get_between($input, $start, $end) {
		$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
		return $substr;
	}
}
