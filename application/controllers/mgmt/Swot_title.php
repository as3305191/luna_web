<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Swot_title extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Swot_title_dao', 'dao');
		$this -> load -> model('Swot_style_dao', 'swot_style_dao');
		$this -> load -> model('Swot_dao', 'swot_dao');

		// $this -> load-> library('word');
	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		// $data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);
		// $this -> to_json($data);
		$this -> load -> view('mgmt/swot_title/list', $data);
	}

	public function get_data() {
		$res = array();
		// $s_data = $this -> setup_user_data(array());
		// $login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$items = $this -> dao -> query_ajax($data);
	
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);
		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$data['swot_title_id'] =$id;
 
		$s_data = $this -> setup_user_data(array());
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['login_user'] = $login_user;

		$this->load->view('mgmt/swot_title/edit', $data);
	}

	public function swot_title_get_data() {
		$res = array();
		$swot_title_id =$this -> get_post('swot_title_id');
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$data = array();
		$items= $this -> swot_style_dao -> find_all_style();

		foreach($items as $each){
			$list = $this -> swot_dao -> find_is_lock($swot_title_id,$each->id);
			if(!empty($list)){
				if($list[0]->is_lock==1){
					$items->now_is_lock = 1;
				} else{
					$items->now_is_lock = 0;
				}
			} else {
				$items->now_is_lock = 0;
			} 
		} 
		$res['items'] = $items;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function up_lock(){
		$swot_id = $this -> get_post('id');
		$u_data = array();
		$p = $this -> dao -> find_by_id($swot_id);
		if(!empty($p)){
			if($p->is_lock==0){
				$u_data['is_lock'] = 1;
				$res['success_msg'] = '變更已鎖定成功';
			} else{
				$u_data['is_lock'] = 0;
				$res['success_msg'] = '變更可編輯成功';
			}
			$this -> dao -> update($u_data, $swot_id);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function up_lock_swot_style(){
		$swot_title_id = $this -> get_post('swot_title_id');
		$swot_style_id = $this -> get_post('swot_style_id');

		$u_data = array();
		$p = $this -> swot_dao -> find_all_by_p($swot_title_id,$swot_style_id);
		foreach($p as $each){
			if($each->is_lock==0){
				$u_data['is_lock'] = 1;
				$res['success_msg'] = '變更已鎖定成功';
			} else{
				$u_data['is_lock'] = 0;
				$res['success_msg'] = '變更可編輯成功';
			}
			$this -> dao -> update($u_data, $each->id);
		}
		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

}
