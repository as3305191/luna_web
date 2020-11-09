<?php
class Images_dao extends MY_Model {

	function __construct() {
		parent::__construct();
		// initialize table name
		$this -> set_table_name("images");

		$this -> alias_map = array(
		);
	}

	function insert_image_data($i_data) {
		//insert data
		$image_path = $i_data['image_path'];
		$last_id = $this -> insert($i_data);

		$image_url = "$image_path/" . $last_id . ".jpg";
		$image_thumb_url = $image_path . "_thumb/" . $last_id . ".jpg";

		//update image data
		$u_data['image_url'] = $image_url;
		$u_data['image_thumb_url'] = $image_thumb_url;
		$this -> db -> where('id', $last_id);
		$result = $this -> db -> update('images', $u_data);

		if ($result) {
			return $last_id;
		} else {
			return "";
		}
	}

	//delete image
	function delete_by_id($id){
		$this -> db -> where('id',$id);
		$this -> db ->delete($this -> table_name);
	}

	function query_ajax($data) {
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];

		// select
		// $this -> db -> select('_m.*');
		$this -> db -> select('id,image_path,image_url,upload_time,image_thumb_url,image_name,width,height,mime,image_size,title,status');

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

	function search_always($data) {
		$this -> db -> where('_m.status', 0);
		$this -> db -> where('_m.image_path', 'general_img');

		if(!empty($data['store_id'])) {
			$this -> db -> where('store_id', $data['store_id']);
		}
	}

	function ajax_from_join() {
		// join
		$this -> db -> from("$this->table_name as _m");
	}

	function get_img_byte_length($id) {
		$this->db->from('images');
		$this->db->where('id', $id);
		$this->db->select('OCTET_LENGTH(img) as len');

		$query = $this->db->get();
    	return intVal($query -> result()[0]->len);
	}

	function get_img_thumb_byte_length($id) {
		$this->db->from('images');
		$this->db->where('id', $id);
		$this->db->select('OCTET_LENGTH(img_thumb) as len');

		$query = $this->db->get();
		return intVal($query -> result()[0]->len);
	}

	function find_by_id_data($id){
		$this -> db -> select('id,image_path,image_url,upload_time,image_thumb_url,image_name,width,height,mime,image_size,title,status');
		$this -> db -> from($this -> table_name);
		$this -> db -> where('id',$id);
		$this -> db -> where('status',0);
		$list = $this -> db -> get() -> result();
		foreach ($list as $row) {
			return $row;
		}
		return NULL;
	}

	function find_place_img($data, $is_count = FALSE) {

		$start = $data['start'];
		$limit = $data['length'];
		
		// select
		$this -> db -> from("$this->table_name as _m");

		$this -> db -> select('_m.id');
		$this -> db -> select('_m.upload_time');
		$this -> db -> select('_m.status');

		$this -> db -> order_by('_m.id','desc');

		
		if(!$is_count) {
			$this -> db -> limit($limit, $start);
		}
		
		$this -> db -> where('_m.status',0);
		$this -> db -> where('_m.image_path','news_img');

		// query results
		if(!$is_count) {
			$query = $this -> db -> get();
			return $query -> result();
		} else {
			return $this -> db -> count_all_results();
		}

	}
}
?>
