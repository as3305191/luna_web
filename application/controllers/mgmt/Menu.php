<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Menu_dao', 'dao');
		$this -> load -> model('Menu_order_dao', 'menu_order_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Menu_style_dao', 'menu_style_dao');
		$this -> load -> model('Users_dao', 'users_dao');
		$this -> load -> model('Department_dao','d_dao');

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$data['login_user'] = $this -> users_dao -> find_by_id($data['login_user_id']);

		$this -> load -> view('mgmt/menu/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
			's_menu_style',
			's_menu_name'
		));
		// set corp id
		$s_data = $this -> setup_user_data(array());

		$items = $this -> dao -> query_ajax($data);
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data);
		$this -> to_json($res);
	}

	public function edit($id) {
		$data = array();
		$s_data = array();
		$data['id'] = $id;
		$s_data = $this -> setup_user_data($s_data);
		$data['login_user'] = $this -> users_dao -> find_by_id($s_data['login_user_id']);
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
			// if(!empty($item -> image_id)) {
			// 	$item -> img = $this -> img_dao -> find_by_id($item -> image_id);
			// }
			if(!empty($item -> img_id)) {
				$image= explode(",", $item -> img_id);
				$item -> image_id =$image ;
				foreach($image as $each){
					$item -> image[] = $this -> img_dao -> find_by_id($each);
				}
			} else{
				$item -> image =array();
			}
			$data['item'] = $item;
		

		}
		$this->load->view('mgmt/menu/edit', $data);
	}

	public function insert() {//新增
		$res = array();
		$data = array();
		$id = $this -> get_post('id');
		$img= $this -> get_post('img');
		$menu_style_id= $this -> get_post('menu_style_id');
		$menu_name= $this -> get_post('menu_name');
		$note= $this -> get_post('note');
		$open_date= $this -> get_post('open_date');
		$dep_array= $this -> get_post('dep_array');
		$data['img_id'] = $img;
		$data['note'] = $note;
		$data['menu_style_id'] = $menu_style_id;
		$data['menu_name'] = $menu_name;
		$data['open_date'] = $open_date;
		if($dep_array!==''){
			$data['open_dep'] = $dep_array;
		} else{
			$data['open_dep'] = 0;
		}
		
		if(empty($id)) {
			// insert
			$last_id = $this -> dao -> insert($data);
		} else {
			$this -> dao -> update($data, $id);
			
		}
		$res['success'] = TRUE;
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	public function find_dep(){
		$res = array();
		$dep = $this -> d_dao -> find_all_ktx_dep();
		$res['dep'] = $dep;
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

	public function new_menu_style(){
		$data = array();
		$this -> load -> view('layout/show_new_menu_style',$data);
	}

	public function add_menu_style(){
		$data = array();
		$res = array();
		$menu_style = $this -> get_post('menu_style');
		$data['menu_style'] = $menu_style;
		$this -> menu_style_dao -> insert($data);
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function menu_name_check(){
		$data = array();
		$res = array();
		$menu_name = $this -> get_post('menu_name');
		if(!empty($menu_name)){
			$data['menu_name'] = $menu_name;
			$same_menu_name = $this -> dao -> find_same_menu_name($data);
			$count_same_menu_name = count($same_menu_name);
			$res['count_same_menu_name'] = $count_same_menu_name;
			$res['same_name_list'] = '';
			if($count_same_menu_name>0){
				if($count_same_menu_name>1){
					$res['same_name_list'] = $same_menu_name[0]->menu_name;
					for($i=1;$i<$count_same_menu_name;$i++){
						$res['same_name_list'] .= ','.$same_menu_name[$i]->menu_name;
					}
				} else{
					$res['same_name_list'] = $same_menu_name[0]->menu_name;
				}
				
			}
		}
		
		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_menu_style(){
		$res = array();
		$id = $this -> get_post('id');
		$menu_style_list = $this -> menu_style_dao -> find_all();
		$res['menu_style'] = $menu_style_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function update_menu_style() {
		$res = array();
		$last_id = $this -> get_post('last_id');
		$img_style = $this -> get_post('menu_style');
		$this -> img_dao -> update(array(
			'img_style' => $img_style
		), $last_id);

		$this -> to_json($res);
	}

	public function finish_menu() {
		$res = array();
		$id = $this -> get_post('id');
		$order_list = $this -> menu_order_dao -> find_by_all_this_menu($id);
		foreach($order_list as $each){
			$this -> menu_order_dao -> update(array(
				'is_done' => 1,
				'is_delete' => 1
			), $each->id);
		}
		$list = $this -> dao -> find_by_id($id);
		if($list->status==1){
			$u_data['status'] = 0;
			$res['success_msg'] = '菜單變更不開放';
			$this -> dao -> update($u_data, $id);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function order_set() {
		$res = array();
		$u_data = array();
		$id = $this -> get_post('id');
		$list = $this -> dao -> find_by_id($id);
		if($list->is_stop==1){
			$u_data['is_stop'] = 0;
			
		} else{
			$u_data['is_stop'] = 1;
		}
		
		$this -> dao -> update($u_data, $id);
		
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function up_lock_menu(){
		$menu_id = $this -> get_post('id');
		$u_data = array();
		$list = $this -> dao -> find_by_id($menu_id);
		if(!empty($list)){
			if($list->status==0){
				$u_data['status'] = 1;
				$res['success_msg'] = '菜單開放成功';
				$menu_order_list = $this -> menu_order_dao -> find_by_all_this_menu($menu_id);
				foreach($menu_order_list as $each){
					$up_d_data['is_delete'] = 0;
					$this -> menu_order_dao -> update($up_d_data, $each->id);
				}
			} else{
				$u_data['status'] = 0;
				$res['success_msg'] = '菜單變更不開放';
				$menu_order_list = $this -> menu_order_dao -> find_by_all_this_menu($menu_id);
				foreach($menu_order_list as $each){
					$up_d_data['is_delete'] = 1;
					$this -> menu_order_dao -> update($up_d_data, $each->id);
				}

			}
			$this -> dao -> update($u_data, $menu_id);
		}
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	function get_between($input, $start, $end) {//2字串中間
		$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
		return $substr;
	}
}
