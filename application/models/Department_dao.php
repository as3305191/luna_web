<?php
class Department_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('department');

		$this -> alias_map = array(

 		);
	}

	function query_ajax($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];

		// select
		$this -> db -> select('_m.*');

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('id', 'desc');

		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function find_by_this_id($id) {
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.*');
		$this -> db -> where('_m.id', $id);

		$query = $this -> db -> get();
		return $query -> result();
	}

	function search_always($data) {
		$this -> db -> where('_m.status', 0);
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
	}

	function find_by_account($account) {
		$this -> db -> where('account', $account);
		$query = $this -> db -> get($this -> table_name);
		foreach ($query->result() as $row){
		    return $row;
		}
		return NULL;
	}

	function query_all($f) {
		$this -> db -> select('id, parent_id, cate_name, image_id');
		$this -> db -> from($this -> table_name);
		$query = $this -> db -> where('status', 0);

		if(isset($f['parent_id'])) {
			$this -> db -> where('parent_id', $f['parent_id']);
		}

		if(isset($f['store_id'])) {
			$this -> db -> where('store_id', $f['store_id']);
		}

		$query = $this -> db -> get();
		$list = $query -> result();
		foreach($list as $each) {
			if(!empty($each -> image_id)) {
				$each -> image_url =  get_img_url($each -> image_id);
				$each -> thumb_url =  get_thumb_url($each -> image_id);
			}
		}
		return $list;
	}

	public function insert_info($id,$infos){
		$this -> db -> delete($this -> table_name, array('project_duties_id' => $id));

		// add all
		foreach($infos as $w) {

				$i_data = array();
				$i_data['project_duties_id'] = $id;
				$i_data['duties_info_cate'] = $w['duties_info_cate'];
				$i_data['duties_info_list'] = $w['duties_info_list'];
				$i_data['duties_pay'] = $w['duties_pay'];
				$i_data['duties_pay_note'] = $w['duties_pay_note'];
				$this -> insert($i_data);

		}
	}

	function find_by_parameter($f) {
		// select
		$this -> db -> select('_m.*');

		// join
		$this -> ajax_from_join();

		if(!empty($f['recruit_id'])){
			$this -> db -> where('_m.recruit_id', $f['recruit_id']);
		}

		$query = $this -> db -> get();
		$list = $query -> result();

		return $list;
	}

	function find_all_department(){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('parent_id','0');
		$this -> db -> order_by('pos','asc');
		$list = $this -> db -> get() -> result();

		return $list;
	}

	function find_pa($pa){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('parent_id',$pa);
		$this -> db -> order_by('pos','asc');
		$list = $this -> db -> get() -> result();

		return $list;
	}

	function find_pm($pm){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('parent_id',$pm);
		$this -> db -> order_by('pos','asc');
		$list = $this -> db -> get() -> result();

		return $list;
	}

	function get_max(){
		$this -> db -> select('MAX(level) as max_level');
		$this -> db -> from($this -> table_name);
		$list = $this -> db -> get() -> result();

		foreach ($list as $row) {
			return $row -> max_level;
		}
		return $list;
	}

	function find_all_by_parent_id($parent_id){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('parent_id',$parent_id);
		$this -> db -> order_by('pos','asc');
		$list = $this -> db -> get() -> result();

		return $list;
	}

	function update_role_power($role_id, $nav_id_arr, $nav_power_arr) {
		$this -> del_power_by_role_id($role_id);
		// add power
		for($i = 0 ; $i < count($nav_id_arr) ; $i++) {
			$this -> db -> insert('role_power', array(
				'role_id' => $role_id,
				'nav_id' => $nav_id_arr[$i],
				'nav_power' => $nav_power_arr[$i]
			));
		}
	}


	function del_power_by_role_id($role_id) {
		$sql = "delete from role_power where role_id = $role_id";
		$this -> db -> query($sql);
	}

	function find_all_d_or_c(){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('level =','3');
		$this -> db -> where('id <>','35');
		$this -> db -> order_by('pos','asc');
		$list = $this -> db -> get() -> result();

		return $list;
	}
	function find_bfl_d_or_c(){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('level =','1');
		$this -> db -> where('id >=44');
		$this -> db -> order_by('pos','asc');
		$list = $this -> db -> get() -> result();

		return $list;
	}

	function find_ines_d_or_c(){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('level =','0');
		$this -> db -> where('id = ',"52");
		$this -> db -> order_by('pos','asc');
		$list = $this -> db -> get() -> result();

		return $list;
	}
	

	function find_all_ktx_dep(){
		$this -> db -> from($this -> table_name);
		$this -> db -> where('level =','3');
		$this -> db -> where('id <>','35');
		$this -> db -> where('id <','37');
		$this -> db -> order_by('pos','asc');
		$list = $this -> db -> get() -> result();

		return $list;
	}
	
	function find_under_roles($role_id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.parent_id', $role_id);
		$this -> db -> where('_m.id<>', '53');
		$this -> db -> where('_m.id<>', '78');
		$this -> db -> where('_m.id<>', '75');
		$this -> db -> where('_m.id<>', '76');
		$this -> db -> where('_m.id<>', '77');
		$this -> db -> where('_m.id<>', '78');
		$this -> db -> where('_m.id<>', '37');
		$this -> db -> where('_m.id<>', '21');
		$this -> db -> where('_m.id<>', '36');

		$this -> db -> order_by('id','asc');
		$list = $this -> db -> get() -> result();
		return $list;
	}
}
?>
