<?php
class Swot_dao extends MY_Model {

	function __construct() {
		parent::__construct();

		// initialize table name
		parent::set_table_name('swot');

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
		$this -> db -> select('s_s.swot_name as s_style_name');
		$this -> db -> select('s_t.swot_title as s_title_name');
		$this -> db -> select('d.name as d_or_c_name');
		$this -> db -> select('d.swot_pos as swot_pos');
		$this -> db -> select('s_t.is_lock as s_t_is_lock');
		$this -> db -> where("_m.is_delete<", 1);

		// join
		$this -> ajax_from_join();

		// search always
		$this -> search_always($data);

		// search
		$this -> ajax_column_setup($columns, $search, $this -> alias_map);

		// order
		$this -> ajax_order_setup($order, $columns, $this -> alias_map);
		$this -> db -> order_by('id', 'desc');
		// $this -> db -> order_by('swot_pos', 'asc');
		// limit
		$this -> db -> limit($limit, $start);

		// query results
		$query = $this -> db -> get();
		return $query -> result();

	}

	function query_ajax_export($data) {

		// select
		$this -> db -> select('_m.*');
		$this -> db -> select('s_s.swot_name as s_style_name');
		$this -> db -> select('s_t.swot_title as s_title_name');
		$this -> db -> select('s_t.is_lock as s_t_is_lock');
		$this -> db -> select('d.swot_pos as swot_pos');

		$this -> db -> select('d.name as d_or_c_name');
		$this -> db -> where("_m.is_delete<", 1);
		// join
		$this -> ajax_from_join();

		// search always
		$login_user_array = explode(",",$data['login_user_array']);
		foreach($login_user_array as $each){
			$this -> search_always($data);
		}
		

		$this -> db -> order_by('id', 'desc');

		// query results
		$query = $this -> db -> get();
		return $query -> result();
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> join("swot_style s_s", "s_s.id = _m.swot_style_id", "left");
		$this -> db -> join("swot_title s_t", "s_t.id = _m.title", "left");
		$this -> db -> join("department d", "d.id = _m.class_id", "left");

	}

	function search_always($data) {
		
		if(!empty($data['id'])){
			$id = $data['id'];
			$this -> db -> where("_m.id",$id);
		}


		if(!empty($data['d_or_c']) && $data['d_or_c']>0){
			$d_or_c = $data['d_or_c'];
			if(!empty($data['list_style']) && !empty($data['list_title']) && $data['list_style']>0&& $data['list_title']>0){
				$list_style = $data['list_style'];
				$list_title = $data['list_title'];
				if(!empty($data['parent_id']) &&$data['parent_id']>0){
					$parent_id = $data['parent_id'];
					$this -> db -> group_start();
					$this -> db -> where("_m.role_id",$d_or_c);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.class_id",$d_or_c);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.role_id",$parent_id);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.class_id",$parent_id);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> group_end();
					$this -> db -> group_end();
					$this -> db -> group_end();
					$this -> db -> group_end();
				}  else{
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> group_start();
					$this -> db -> where("_m.class_id",$d_or_c);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.role_id",$d_or_c);
					$this -> db -> group_end();
					$this -> db -> group_end();
				}
				
			} else if(!empty($data['list_style']) && $data['list_style']>0 && $data['list_title']==0){
				$list_style = $data['list_style'];
				if(!empty($data['parent_id'])){
					$parent_id = $data['parent_id'];
					$this -> db -> group_start();
					$this -> db -> where("_m.role_id",$d_or_c);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.class_id",$d_or_c);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.role_id",$parent_id);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.class_id",$parent_id);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> group_end();
					$this -> db -> group_end();
					$this -> db -> group_end();
					$this -> db -> group_end();
				} else{
					$this -> db -> group_start();
					$this -> db -> where("_m.role_id",$d_or_c);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.class_id",$d_or_c);
					$this -> db -> where("_m.swot_style_id",$list_style);
					$this -> db -> group_end();
					$this -> db -> group_end();
				}
				
			} else if(!empty($data['list_title'])&& $data['list_title']>0 && $data['list_style']==0){
				$list_title = $data['list_title'];
				if(!empty($data['parent_id'])){
					$parent_id = $data['parent_id'];
					$this -> db -> group_start();
					$this -> db -> where("_m.role_id",$d_or_c);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.class_id",$d_or_c);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.role_id",$parent_id);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.class_id",$parent_id);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> group_end();
					$this -> db -> group_end();
					$this -> db -> group_end();
					$this -> db -> group_end();
				} else{
					$this -> db -> group_start();
					$this -> db -> where("_m.role_id",$d_or_c);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> or_group_start();
					$this -> db -> where("_m.class_id",$d_or_c);
					$this -> db -> where("_m.title",$list_title);
					$this -> db -> group_end();
					$this -> db -> group_end();
				}
				
			} else{
				if($data['list_style']==0 && $data['list_title']==0){
					// $this -> db -> where("_m.role_id",$d_or_c);
					// $this -> db -> or_where("_m.class_id",$d_or_c);
					if(!empty($data['parent_id'])){
						$parent_id = $data['parent_id'];
						$this -> db -> group_start();
						$this -> db -> where("_m.role_id",$d_or_c);
						$this -> db -> or_group_start();
						$this -> db -> where("_m.class_id",$d_or_c);
						$this -> db -> or_group_start();
						$this -> db -> where("_m.class_id",$parent_id);
						$this -> db -> or_group_start();
						$this -> db -> where("_m.role_id",$parent_id);
						$this -> db -> group_end();
						$this -> db -> group_end();
						$this -> db -> group_end();
						$this -> db -> group_end();
					} else{
						$this -> db -> group_start();
						$this -> db -> where("_m.role_id",$d_or_c);
						$this -> db -> or_group_start();
						$this -> db -> where("_m.class_id",$d_or_c);
						$this -> db -> group_end();
						$this -> db -> group_end();
					}
				}
				
			}

		} else{
			if(!empty($data['list_style']) && $data['list_style']>0){
				$list_style = $data['list_style'];
				$this -> db -> where("_m.swot_style_id",$list_style);
			}
			if(!empty($data['list_title']) && $data['list_title']>0){
				$list_title = $data['list_title'];
				$this -> db -> where("_m.title",$list_title);
			}
		}
		if(!empty($data['dep'])){
			$dep = $data['dep'];
			$this -> db -> where("_m.role_id",$dep);
			if($dep==11){
				if(!empty($data['type'])&&$data['type']==1){
					$this -> db -> where("_m.class_id <> 37");
				}
			}
		}
		if(!empty($data['unify'])&&$data['unify']==1){
			if(!empty($data['unify_type'])&&$data['unify_type']==1){
				$this -> db -> where("_m.unify",1);
			} else{
				$this -> db -> where("_m.unify<> 1");
			}

			// $this -> db -> where("_m.unify<> 1");
			$this -> db -> order_by('d.parent_id', 'desc');
		}

		$this -> db -> where("_m.is_delete<", 1);
	}

	function find_all_by_me($user_id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.is_use_user_id',$user_id);
		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_all_by_p($swot_title_id,$swot_style_id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.id');
		$this -> db -> select('_m.is_lock');

		$this -> db -> where('_m.title',$swot_title_id);
		$this -> db -> where('_m.swot_style_id',$swot_style_id);
		$this -> db -> where('_m.is_delete',0);

		$list = $this -> db -> get() -> result();
		return $list;
	}

	function find_is_lock($swot_title_id,$swot_style_id){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');

		$this -> db -> where('_m.title',$swot_title_id);
		$this -> db -> where('_m.swot_style_id',$swot_style_id);

		$list = $this -> db -> get() -> result();
		if(count($list)>0){
			return $list[0];
		} else{
			return null;
		}
		
	}
	
	function find_all_is_use(){
		$before_a_day = date('Y-m-d H:i:s',strtotime('-1 day'));
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');

		$this -> db -> where('_m.is_use',1);
		$this -> db -> where("_m.use_time <= '{$before_a_day}'");
		// $this -> db -> or_where("_m.use_time",null);
		$list = $this -> db -> get() -> result();
		if(count($list)>0){
			return $list;
		} else{
			return null;
		}
		
	}

	function find_if_is_lock($swot_style,$title){
		$this -> db -> from("$this->table_name as _m");
		$this -> db -> select('_m.*');
		$this -> db -> where('_m.swot_style_id',$swot_style);
		$this -> db -> where("_m.title",$title);
		// $this -> db -> or_where("_m.use_time",null);
		$list = $this -> db -> get() -> result();
		if(count($list)>0){
			return $list[0];
		} else{
			return null;
		}
		
	}


}
?>
