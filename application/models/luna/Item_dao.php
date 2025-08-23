<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_dao extends MY_Model {

    protected $db;

    function __construct() {
        parent::__construct();
        // 綁定 memberdb
        $this->db = $this->load->database('gamedb', TRUE);
    }

    // 用帳號查詢會員
    function find_by($field, $value) {
        return $this->db->where($field, $value)->get('TB_ITEM')->row();
    }

    // 用 ID 查詢會員
    function find_by_id($id) {
        return $this->db->where('id', $id)->get('TB_ITEM')->row();
    }

    // ✅ 新增：插入一筆物品
    function insert_item($data) {

        $this->db->insert('TB_ITEM', $data);
        return $this->db->affected_rows() > 0; // true=成功
    }
}
