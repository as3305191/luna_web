<?php
class Place_mark_dao extends MY_Model
{

	function __construct()
	{
		parent::__construct();

		// initialize table name
		parent::set_table_name('place_mark');

		$this->alias_map = array();
	}

	function query_ajax($data)
	{
		$start = $data['start'];
		$limit = $data['length'];
		$columns = $data['columns'];
		$search = $data['search'];
		$order = $data['order'];

		// select
		$this->db->select('_m.id');
		$this->db->select('_m.place_mark_name');
		$this->db->select('_m.lng');
		$this->db->select('_m.lat');
		$this->db->select('_m.create_time');
		$this->db->select('_m.category');
		$this->db->select('_m.description');
		$this->db->select('_m.gx_media_links');
		$this->db->select('_m.full_address');
		$this->db->select('_m.country');
		$this->db->select('_m.city');
		$this->db->select('_m.district');
		$this->db->select('_m.image_id');
		$this->db->select('_m.attribute');
		$this->db->select('_m.web_url');
		$this->db->select('_m.facebook_url');

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
		if (isset($data['id']) && $data['id'] > -1) {
			$this->db->where('_m.id', $data['id']);
		}
		$this->db->where('_m.status', 0);
	}

	function ajax_from_join()
	{
		// join
		$this->db->from("$this->table_name as _m");
		// $this -> db -> join("station as st", 'st.id = _m.station_id', "left");
	}


	function do_find_place_mark_with_area($city, $district, $place_name, $curr_page, $lng = 0, $lat = 0,$sAttr)
	{
	
		$this->db->from("$this->table_name as _m");
		if ($lng!== "" && $lat!== "") {
			$this->db->select("line_distance_meter(_m.lng, _m.lat, {$lng}, {$lat}) as distance", FALSE);
			$this->db->order_by("line_distance_meter(_m.lng, _m.lat, '{$lng}', '{$lat}') ASC");
		} else {
			if ($city !== "all") {
				$this->db->where('_m.city', $city);
			}
			if ($district !== "all") {
				$this->db->where('_m.district', $district);
			}
		}

		if (count($sAttr)==1) {
			foreach($sAttr as $each){
				$this->db->where("(_m.attribute like '#%{$each}%#' )");
			}
		} else{
			if (count($sAttr)>1) {
				foreach($sAttr as $each){
					$this->db->or_where("(_m.attribute like '#%{$each}%#')");
				}
			}
		}
	
		if ($place_name !== "") {
			$this->db->where("(_m.place_mark_name like '%{$place_name}%')");
		}

		$this->db->where('_m.status', 0);

		$query = $this->db->get();
		return $query->result();
	}

	function find_place_mark_with_area($city, $district, $place_name, $curr_page, $lng = 0, $lat = 0,$sAttr)
	{
		// $this -> db -> select('_m.*');
		$this->db->select('_m.id');
		$this->db->select('_m.place_mark_name');
		$this->db->select('_m.lng');
		$this->db->select('_m.lat');
		$this->db->select('_m.create_time');
		$this->db->select('_m.category');
		$this->db->select('_m.description');
		$this->db->select('_m.gx_media_links');
		$this->db->select('_m.full_address');
		$this->db->select('_m.country');
		$this->db->select('_m.city');
		$this->db->select('_m.district');
		$this->db->select('_m.image_id');
		$this->db->select('_m.attribute');
		$this->db->select('_m.web_url');
		$this->db->select('_m.facebook_url');
		$this->db->limit(10);

		// limit
		if ($curr_page > 1) {
			$this->db->limit(10, ((int) $curr_page - 1) * 10);
		} else if($curr_page==0){
			$this->db->limit(10);
		}

		
		
		

		$list = $this->do_find_place_mark_with_area($city, $district, $place_name, $curr_page, $lng, $lat,$sAttr);
		return $list;
	}

	function count_place_mark_with_area($city, $district, $place_name, $curr_page, $lng = 0, $lat = 0,$sAttr)
	{
		$this->db->select("count(*) as cnt");
		$list = $this->do_find_place_mark_with_area($city, $district, $place_name, $curr_page, $lng, $lat,$sAttr);
		if (count($list) > 0) {
			$cnt = $list[0]->cnt;
			return $cnt;
		}
		return 0;
	}

	function find_by_this_id($id)
	{
		$this->db->from("$this->table_name as _m");
		// $this -> db -> select('_m.*');
		$this->db->select('_m.id');
		$this->db->select('_m.place_mark_name');
		$this->db->select('_m.lng');
		$this->db->select('_m.lat');
		$this->db->select('_m.create_time');
		$this->db->select('_m.category');
		$this->db->select('_m.description');
		$this->db->select('_m.gx_media_links');
		$this->db->select('_m.full_address');
		$this->db->select('_m.country');
		$this->db->select('_m.city');
		$this->db->select('_m.district');
		$this->db->select('_m.image_id');
		$this->db->select('_m.attribute');
		$this->db->select('_m.web_url');
		$this->db->select('_m.facebook_url');

		$this->db->where('_m.id', $id);

		$query = $this->db->get();
		return $query->result();
	}

	function find_near_by_place($lat, $lng)
	{
		$this->db->from("$this->table_name as _m");
		// $this -> db -> select('_m.*');
		$this->db->select('_m.id');
		$this->db->select('_m.place_mark_name');
		$this->db->select('_m.lng');
		$this->db->select('_m.lat');
		$this->db->select('_m.create_time');
		$this->db->select('_m.category');
		$this->db->select('_m.description');
		$this->db->select('_m.gx_media_links');
		$this->db->select('_m.full_address');
		$this->db->select('_m.country');
		$this->db->select('_m.city');
		$this->db->select('_m.district');
		$this->db->select('_m.image_id');
		$this->db->select('_m.attribute');
		$this->db->select('_m.web_url');
		$this->db->select('_m.facebook_url');

		// $this -> db -> where(st_distance_sphere("_m.style_url", ST_GeomFromText("POINT($lat $lng)", 4326)) <= 3000);
		// $this -> db -> order_by(st_distance_sphere);
		$query = $this->db->get();
		return $query->result();
	}


	function query_ajax_with_member($login_member_id, $curr_page)
	{
		$this->db->from("$this->table_name as _m");
		// $this -> db -> select('_m.*');

		$this->db->select('_m.id');
		$this->db->select('_m.place_mark_name');
		$this->db->select('_m.lng');
		$this->db->select('_m.lat');
		$this->db->select('_m.create_time');
		$this->db->select('_m.category');
		$this->db->select('_m.description');
		$this->db->select('_m.gx_media_links');
		$this->db->select('_m.full_address');
		$this->db->select('_m.country');
		$this->db->select('_m.city');
		$this->db->select('_m.district');
		$this->db->select('_m.image_id');
		$this->db->select('_m.attribute');
		$this->db->select('_m.web_url');
		$this->db->select('_m.facebook_url');

		$this->db->where('_m.status', 0);

		$this->db->order_by("id", "desc");

		$this->db->limit(10);
		if ($curr_page > 1) {
			$this->db->limit(10, ((int) $curr_page - 1) * 10);
		} else {
			$this->db->limit(10);
		}

		if (!empty($login_member_id)) {
			$this->db->where('_m.member_id', $login_member_id);
			$query = $this->db->get();
			return $query->result();
		} else {
			return null;
		}
	}

	function find_near_place_lng_lat($lat,$lng,$now_lat,$now_lng)
	{
		// $this -> db -> select('_m.*');
		$this->db->select('_m.id');
		$this->db->select('_m.place_mark_name');
		$this->db->select('_m.lng');
		$this->db->select('_m.lat');
	
		$this->db->from("$this->table_name as _m");
		$this->db->where("_m.lng",$lng);
		$this->db->where("_m.lat",$lat);
		$this->db->where("line_distance_meter(_m.lng, _m.lat, {$lng}, {$lat}) < 10000");

		$this->db->where("line_distance_meter(_m.lng, _m.lat, {$lng}, {$lat}) < 10000");
		$this->db->order_by("line_distance_meter(_m.lng, _m.lat, '{$lng}', '{$lat}') ASC");

		$query = $this->db->get();
		$list = $query->result();
		if(count($list)>0){
			return $list[0];
		} else{
			return null;
		}
		 
	}

	function find_this_place($place_name)
	{
		$this->db->select('_m.lng');
		$this->db->select('_m.lat');
	
		$this->db->from("$this->table_name as _m");
		$this->db->where("_m.place_mark_name",$place_name);

		$query = $this->db->get();
		return $query->result();
	}

}
