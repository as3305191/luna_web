<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members_dao extends CI_Model {

    protected $member_db;

    function __construct() {
        parent::__construct();
        // 綁定 memberdb
        $this->member_db = $this->load->database('memberdb', TRUE);
    }

    // 用帳號查詢會員
    function find_by($field, $value) {
        return $this->member_db->where($field, $value)->get('chr_log_info')->row();
    }

    // 用 ID 查詢會員
    function find_by_id($id) {
        return $this->member_db->where('id', $id)->get('chr_log_info')->row();
    }
}
