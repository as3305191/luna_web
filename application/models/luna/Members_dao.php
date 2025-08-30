<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members_dao extends MY_Model {

    protected $member_db;

    function __construct() {
        parent::__construct();
        // 綁定 memberdb
        $this->member_db = $this->load->database('memberdb', TRUE);
    }

    /** 推薦：明確用帳號查（安全、穩） */
    public function find_by_loginid($loginid) {
        $sql = "SELECT TOP 1 * FROM chr_log_info WHERE id_loginid = ?";
        return $this->member_db->query($sql, [(string)$loginid])->row();
    }

    /** 泛用版：僅允許白名單欄位，依欄位型態決定綁定值 */
    public function find_by($field, $value) {
        // 欄位白名單，避免被注入 identifier
        $allowed = ['id_loginid', 'id_idx'];
        if (!in_array($field, $allowed, true)) {
            throw new InvalidArgumentException('Unsupported field: '.$field);
        }

        // 依欄位型別綁定
        if ($field === 'id_loginid') {
            $sql = "SELECT TOP 1 * FROM chr_log_info WHERE id_loginid = ?";
            return $this->member_db->query($sql, [(string)$value])->row();
        } else { // id_idx（INT）
            $sql = "SELECT TOP 1 * FROM chr_log_info WHERE id_idx = ?";
            return $this->member_db->query($sql, [(int)$value])->row();
        }
    }

    /** 用數字主鍵（id_idx）查 */
    public function find_by_id($id_idx) {
        $sql = "SELECT TOP 1 * FROM chr_log_info WHERE id_idx = ?";
        return $this->member_db->query($sql, [(int)$id_idx])->row();
    }
}
