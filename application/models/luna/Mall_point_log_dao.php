<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mall_point_log_dao extends MY_Model {

    private const TABLE = 'mall_point_log';

    protected $db;                 // 指向 logdb 連線
    private $last_error = null;    // 記錄最後一次 DB 錯誤

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('logdb', TRUE); // 連接到 logdb
    }

    /** 新增一筆點數變更紀錄，成功回傳該筆 log_id（int），失敗回傳 false */
    public function insert_log($user_idx, $amount, $before_point, $after_point, $memo, $admin_loginid, $admin_ip) {
        $data = [
            'user_idx'      => (int)$user_idx,
            'amount'        => (int)$amount,
            'before_point'  => (int)$before_point,
            'after_point'   => (int)$after_point,
            'memo'          => (string)$memo,
            'admin_loginid' => (string)$admin_loginid,
            'admin_ip'      => (string)$admin_ip,
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        $ok = $this->db->insert(self::TABLE, $data);
        if (!$ok) {
            $this->last_error = $this->db->error();
            return false;
        }
        return (int)$this->db->insert_id();
    }

    public function get_user_logs($user_idx, $limit = 10, $offset = 0) {
        $query = $this->db->select('log_id, user_idx, amount, before_point, after_point, memo, admin_loginid, admin_ip, created_at')
                          ->from(self::TABLE)
                          ->where('user_idx', $user_idx)
                          ->limit($limit, $offset)
                          ->order_by('created_at', 'DESC')
                          ->get();
        return $query->num_rows() > 0 ? $query->result_array() : [];
    }

    public function get_user_logs_count($user_idx) {
        $row = $this->db->select('COUNT(*) AS total')->from(self::TABLE)->where('user_idx', $user_idx)->get()->row();
        return $row ? (int)$row->total : 0;
    }

    public function get_last_error() { return $this->last_error; }
}
