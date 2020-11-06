<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @brief 參數管理->條款
 */
class News extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Terms_of_service_dao', 'dao');
		// $this -> load -> model('About_articles_images_dao', 'aimg_dao');
		$this -> load -> model('Images_dao', 'img_dao');
	}

	public function index()
	{
		$data = array();
		$this -> setup_user_data($data);
		$data['id'] = $this -> dao -> find_max_id();

		$this->load->view('mgmt/news/list', $data);
	}

	/**
	 * @brief 取得資料
	 */

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			'company_id'
		));

		$items = $this -> dao -> query_ajax($data);
		// foreach($items as $item) {
		// 	if(!empty($item -> image_id)) {
		// 		$item -> img_url = get_img_url($item -> image_id);
		// 	}
		// }
		$res['items'] = $items;

		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);
		$this -> to_json($res);
	}

	/**
	 * @brief 條款編輯
	 */
	public function edit($id) {
		$data = array();
		$data['id'] = $id;

		$item = NULL;

			$item = $this -> dao -> find_all();
			// find images
			// $item -> images = $this -> aimg_dao -> find_image_by_product_id($id);

			$data['item'] = $item;




		$this->load->view('mgmt/news/edit', $data);
	}
	/**
	 * @brief 條款更新
	 */

	public function insert() {
		$res = array();
		$id = $this -> get_post('id');
		$data = array();
		$data_tos = array();
		$data_ur = array();
		$desc_tos = $this -> get_post('desc_tos');
		$data_tos['desc'] = $desc_tos;
		$desc_ur = $this -> get_post('desc_ur');
		$data_ur['desc'] = $desc_ur;
		if(!empty($desc_tos)){
			$this -> dao -> update_by($data_tos,'rule_type',1);
		}

		if(!empty($desc_ur)){
			$this -> dao -> update_by($data_ur,'rule_type',2);
		}


		// $end_time = $this -> get_post('end_time');
		// if(empty($end_time)) {
		// 	$data['end_time'] = NULL;
		// } else {
		// 	$data['end_time'] = $end_time;
		// }

		// $data['hidden'] = (!empty($this -> get_post('hidden')) ? 1 : 0);

		// if(empty($id)) {
		// 	// insert
		// 	$id = $this -> dao -> insert($data);
		// } else {
		// 	// update
		// 	$this -> dao -> update($data, $id);
		// }



		// add images
		// $img_id_str = $this -> get_post('img_id_list');
		// $img_id_list = explode(',', $img_id_str);
		// $this -> aimg_dao -> add_imgs($id, $img_id_list);

		$res['success'] = TRUE;
		$res['id'] = $id;
 		$this -> to_json($res);
	}

	/**
	 * @brief 移除
	 */

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete_status($id, $this -> session -> userdata('user_id'));
		$this -> to_json($res);
	}
}
