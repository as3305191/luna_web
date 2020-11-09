<?php
class Place_mark_attributes_dao extends MY_Model
{

	function __construct()
	{
		parent::__construct();

		// initialize table name
		parent::set_table_name('place_mark_attributes');

		$this->alias_map = array();
	}

	function find_all_order($level)
	{
		$this->db->from("$this->table_name as _m");
		$this->db->select("_m.*");
		if($level>0){
			$this->db->where("_m.lv", $level);
		}
		$this->db->order_by("_m.pos", 'asc');
	

		$query = $this->db->get();

		return $query->result();
	}

	function query_ajax($data)
	{
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];

		// select
		$this->db->select('_m.*');

		// join
		$this->ajax_from_join();

		// search always
		$this->search_always($data);

		// search
		$this->ajax_column_setup($columns, $search, $this->alias_map);

		// order
		$this->ajax_order_setup($order, $columns, $this->alias_map);
		$this->db->order_by('id', 'asc');

		// limit
		$this->db->limit($limit, $start);

		// query results
		$query = $this->db->get();

		// echo $this -> db -> last_query();
		return $query->result();
	}

	function search_always($data)
	{
		if(!empty($data['id'])){
			$id = $data['id'];

			$this->db->where('_m.id', $id);
		}
	}

	function ajax_from_join()
	{
		// join
		$this->db->from("$this->table_name as _m");
		// $this -> db -> join("station as st", 'st.id = _m.station_id', "left");
	}

}
