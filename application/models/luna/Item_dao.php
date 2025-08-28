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
    // function insert_item($data) {

    //     $this->db->insert('TB_ITEM', $data);
    //     return $this->db->affected_rows() > 0; // true=成功
    // }
    public function insert_item($row) {
        // 假設表名為 TB_ITEM（或你的實際表名）
        // 欄位依你 DB 為準：至少要包含這些欄位
        $data = [
            'CHARACTER_IDX'   => (int)$row['CHARACTER_IDX'],
            'ITEM_IDX'        => (int)$row['ITEM_IDX'],
            'ITEM_SHOPIDX'    => (int)($row['ITEM_SHOPIDX'] ?? 0),
            'ITEM_SHOPLOGIDX' => (int)($row['ITEM_SHOPLOGIDX'] ?? 0),
            'ITEM_SEAL'       => (int)($row['ITEM_SEAL'] ?? 0),
            'ITEM_DURABILITY' => (int)($row['ITEM_DURABILITY'] ?? 0),
            'ITEM_POSITION'   => (int)($row['ITEM_POSITION'] ?? 320), // 預設 320
        ];
        return $this->db->insert('TB_ITEM', $data);
        }

}
