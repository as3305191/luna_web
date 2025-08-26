<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mall_point_log_dao extends MY_Model {

    private const TABLE = 'mall_point_log';

    protected $db;          // 指向 logdb 連線
    private $last_error = null; // 記錄最後一次 DB 錯誤

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('logdb', TRUE); // 連接到 logdb
    }

    // 新增一筆點數變更紀錄
    public function insert_log($user_idx, $amount, $before_point, $after_point, $memo, $admin_loginid, $admin_ip) {
        // 準備資料
        $data = [
            'user_idx'      => $user_idx,
            'amount'        => $amount,
            'before_point'  => $before_point,
            'after_point'   => $after_point,
            'memo'          => $memo,
            'admin_loginid' => $admin_loginid,
            'admin_ip'      => $admin_ip,
            'created_at'    => date('Y-m-d H:i:s')
        ];

        // 執行插入
        $this->db->trans_start();
        $this->db->insert(self::TABLE, $data);

        // 如果有錯誤，回滾事務
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->last_error = $this->db->error();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    // 取得某個用戶的點數變更紀錄（可以加分頁和排序）
    public function get_user_logs($user_idx, $limit = 10, $offset = 0) {
        $query = $this->db->select('log_id, user_idx, amount, before_point, after_point, memo, admin_loginid, created_at')
                          ->from(self::TABLE)
                          ->where('user_idx', $user_idx)
                          ->limit($limit, $offset)
                          ->order_by('created_at', 'DESC')
                          ->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return [];
    }

    // 取得某個用戶的點數變更紀錄總數
    public function get_user_logs_count($user_idx) {
        $query = $this->db->select('COUNT(*) AS total')
                          ->from(self::TABLE)
                          ->where('user_idx', $user_idx)
                          ->get();

        $row = $query->row();
        return $row ? (int) $row->total : 0;
    }

    // 取得最後一次錯誤訊息
    public function get_last_error() {
        return $this->last_error;
    }
}
