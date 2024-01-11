<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_order extends MY_Mgmt_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('Menu_order_dao', 'dao');
		$this -> load -> model('Menu_dao', 'menu_dao');
		$this -> load -> model('Images_dao', 'img_dao');
		$this -> load -> model('Menu_style_dao', 'menu_style_dao');
		$this -> load -> model('Users_dao', 'users_dao');

	}

	public function index()
	{
		$data = array();
		$data = $this -> setup_user_data($data);
		$login_user = $this -> users_dao -> find_by_id($data['login_user_id']);		
		$login_user_dep=explode('#',ltrim(rtrim($login_user->in_department,'#'),'#'));
		$list = $this -> menu_dao -> find_all_open();
		$map_list= array();
		$weekarray=array("日","一","二","三","四","五","六");
		
		foreach($list as $each){
			if($each->open_date!=='0000-00-00'){
				$weekday = $weekarray[date("w",strtotime($each->open_date))];
				$each->timestamp = date('m.d',strtotime($each->open_date)).' ('.$weekday.')';
				// $each->timestamp = $each->open_date.' ('.$weekday_cn.')';

			} else{
				$each->timestamp= '';
			}
			if($each->open_dep==0){
				$map_list[]= $each;
			} else{
				$each_open_dep=explode(',',$each->open_dep);
				foreach($each_open_dep as $each_o_dep){
					if(in_array($each_o_dep, $login_user_dep)){
						$map_list[]= $each;
					}
				}
			}
		}

		$data['login_user'] = $login_user;
		if($login_user->id!=='205'||$login_user->id!=='114'){
			$data['menu_list'] = $map_list;
		} else{
			$data['menu_list'] = $list;
		}

		
		$data['open_menu_count'] = count($list);
		// $this -> to_json($data);
		$this -> load -> view('mgmt/menu_order/list', $data);
	}

	public function get_data() {
		$res = array();
		$data = array();
		$u_data = array();
		$u_data = $this -> setup_user_data($u_data);
		$user_list = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order',
		));
		$menu_id = $this -> get_post('menu_id');
		$data['menu_id'] = $menu_id;
		$data['login_user_id'] = $user_list->id;
		$items = $this -> dao -> query_ajax($data);
		$res['items'] = $items;
		// $res['user_list'] = $user_list;
		$res['recordsFiltered'] = $this -> dao -> count_ajax($data,true);
		$res['recordsTotal'] = $this -> dao -> count_all_ajax($data,true);
		$this -> to_json($res);
	}


	public function get_data_other() {
		$res = array();
		$data = array();
		$u_data = array();
		$u_data = $this -> setup_user_data($u_data);
		$user_list = $this -> users_dao -> find_by_id($u_data['login_user_id']);
		$data = $this -> get_posts(array(
			'length',
			'start',
			'columns',
			'search',
			'order'
		));
		$menu_id = $this -> get_post('menu_id');
		$data['menu_id'] = $menu_id;
		$data['login_user_id'] = $user_list->id;
		$items = $this -> dao -> find_all_order_list_other($data);
		$res['items'] = $items;
		$res['recordsFiltered'] = $this -> dao -> find_all_order_list_other($data,true);
		$res['recordsTotal'] = $this -> dao -> find_all_order_list_other($data,true);
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
		$this->load->view('mgmt/menu_order/edit', $data);
	}



	public function insert() {//新增
		$res = array();
		$s_data = array();
		$data = array();
		$menu_id = $this -> get_post('menu_id');
		$order_name = $this -> get_post('order_name');
		$amount = $this -> get_post('amount');
		$note = $this -> get_post('note');
		$sugar = $this -> get_post('sugar');
		$ice = $this -> get_post('ice');
	
		$s_data = $this -> setup_user_data($s_data);
		$user_list = $this -> users_dao -> find_by_id($s_data['login_user_id']);
		$data['user_id'] = $user_list->id;
		$data['menu_id'] = $menu_id;
		$data['order_name'] = $order_name;
		$data['amount'] = $amount;
		$data['note'] = $note;
		if(!(empty($sugar))&& $sugar!==''){
			$data['sugar'] = $sugar;
		}
		if(!(empty($ice)) && $ice!==''){
			$data['ice'] = $ice;
		}
		if(!empty($menu_id)) {
			// insert
			
			$menu_list = $this -> menu_dao -> find_by_id($menu_id);
			if($menu_list->status=='1'&&$menu_list->is_stop=='0'){
				$last_id = $this -> dao -> insert($data);
				$res['success'] = TRUE;
			} else{
				$res['too_late'] = TRUE;
			}
			
		}
		
 		$this -> to_json($res);
	}

	public function delete($id) {
		$res['success'] = TRUE;
		$this -> dao -> delete($id);
		$this -> to_json($res);
	}

	public function find_img_style(){
		$res = array();
		$img_style_list = $this -> img_style_dao -> find_all();
		$res['img_style'] = $img_style_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}
	public function find_menu_style(){
		$res = array();
		$id = $this -> get_post('id');
		$list = $this -> menu_dao -> find_by_id($id );
		$res['list'] = $list;
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

	public function find_all_menu(){
		$res = array();
		$s_data = array();
		$id = $this -> get_post('id');
		$login_user = $this -> users_dao -> find_by_id($s_data['login_user_id']);		
		$login_user_dep=explode('#',ltrim(rtrim($login_user->in_department,'#'),'#'));
		$list = $this -> menu_dao -> find_all_open();

		foreach($list as $each){
			
			if($each->open_dep==0){
				$map_list[]= $each;
			} else{
				$each_open_dep=explode(',',$each->open_dep);
				foreach($each_open_dep as $each_o_dep){
					if(in_array($each_o_dep, $login_user_dep)){
						$map_list[]= $each;
					}
				}
			}
		}
		$res['list'] = $map_list;
		$res['success'] = TRUE;
		$this -> to_json($res);
	}

	public function find_all_open_menu(){
		$res = array();
		$id = $this -> get_post('id');
		$list = $this -> menu_dao -> find_all_open_menu($id);
		if(!empty($list -> img_id)) {
			$image= explode(",", $list -> img_id);
			$list -> image_id =$image ;
			foreach($image as $each){
				$res['list_image'][] = $each;
			}
			$res['note'] =$list->note;			
		} else{
			$res['list_image'] =array();
			$res['note'] ='';
		}
		$res['list'] =$list;
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

	function get_between($input, $start, $end) {//2字串中間
		$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
		return $substr;
	}
}
