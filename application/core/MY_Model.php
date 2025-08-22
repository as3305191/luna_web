<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    protected $table_name = '';
    protected $view_name  = '';
    protected $alias_map  = array();
    protected $db_group   = 'memberdb'; // 預設使用 memberdb

    public function __construct($db_group = null) {
        parent::__construct();
        $this->load->helper('common');

        // 如果有指定 DB group，覆蓋掉預設的
        if ($db_group !== null) {
            $this->db_group = $db_group;
        }

        // 載入指定的 DB
        $this->db = $this->load->database($this->db_group, TRUE);
    }

    public function set_table_name($tb_name) {
        $this->table_name = $tb_name;
        $this->set_view_name($tb_name);
    }

    public function set_view_name($tb_name) {
        $this->view_name = $tb_name . '_view';
    }

    public function get_db() {
        return $this->db;
    }

    public function count_all() {
        return $this->db->count_all($this->table_name);
    }

    public function count_all_by($name, $value) {
        $this->db->where($name, $value);
        $this->db->from($this->table_name);
        return $this->db->count_all_results();
    }

    public function count_all_query($columns) {
        foreach ($columns as $col) {
            $this->db->like($col->key, $col->value);
        }
        $this->db->from($this->table_name);
        return $this->db->count_all_results();
    }

    public function count_all_where($where) {
        $this->db->where($where);
        $this->db->from($this->table_name);
        return $this->db->count_all_results();
    }

    public function find_all() {
        return $this->db->get($this->table_name)->result();
    }

    public function find_exists_all() {
        $this->db->where('status', 0);
        return $this->db->get($this->table_name)->result();
    }

    public function find_all_view() {
        return $this->db->get($this->view_name)->result();
    }

    public function find_all_view_by($name, $value) {
        $this->db->where($name, $value);
        return $this->db->get($this->view_name)->result();
    }

    public function find_all_by($name, $value) {
        $this->db->where($name, $value);
        return $this->db->get($this->table_name)->result();
    }

    public function find_all_where($where) {
        $this->db->where($where);
        return $this->db->get($this->table_name)->result();
    }

    public function find_all_query($columns, $dir) {
        foreach ($columns as $col) {
            $this->db->like($col->key, $col->value);
        }
        $this->db->order_by("id", $dir ?? "asc");
        return $this->db->get($this->table_name)->result();
    }

    public function find_all_query_where($columns) {
        foreach ($columns as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->get($this->table_name)->result();
    }

    public function find_paging_all($start, $limit, $dir) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id", $dir ?? "asc");
        return $this->db->get($this->table_name)->result();
    }

    public function find_paging_with_date_all($start, $limit) {
        $this->db->limit($limit, $start);
        $this->db->where('start_date <= GETDATE()', NULL, FALSE);
        $this->db->order_by("start_date", 'desc');
        return $this->db->get($this->table_name)->result();
    }

    public function find_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table_name);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find_view_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->view_name);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find_by($name, $value) {
        $this->db->where($name, $value);
        $query = $this->db->get($this->table_name);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function insert($data) {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
    }

    public function update_by($data, $column, $value) {
        $this->db->where($column, $value);
        $this->db->update($this->table_name, $data);
    }

    public function delete($id) {
        $this->db->delete($this->table_name, ['id' => $id]);
    }

    public function delete_status($id, $user_id, $status = 1) {
        $data = [
            'status'       => $status,
            'delete_time'  => date('Y-m-d H:i:s'),
            'delete_userid'=> $user_id
        ];
        $this->update($data, $id);
    }

    public function delete_all_by($key, $value) {
        $this->db->where($key, $value);
        $this->db->delete($this->table_name);
    }

    public function empty_table() {
        $this->db->empty_table($this->table_name);
    }

    public function query_for_list($sql) {
        return $this->db->query($sql)->result();
    }

    // ---------- Helper ----------
    public function where_isset($data, $key, $col) {
        if (isset($data[$key]) && $data[$key] > -1) {
            $this->db->where($col, $data[$key]);
        }
    }

    public function get_safe($arr, $p) {
        return $arr[$p] ?? false;
    }
}
