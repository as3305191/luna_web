<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CHARACTER_dao extends MY_Model {

    protected $db;
    protected $table = 'TB_CHARACTER';
    protected $createInfoTable = 'TB_CharacterCreateInfo';

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('gamedb', TRUE);
    }

    /**
     * 依帳號(=USER_IDX)撈角色列表
     * 刪除判斷：CreateInfo.DELETE_DATE IS NULL => 未刪；非 NULL => 已刪
     * 沒有 CreateInfo 記錄視為未刪
     *
     * @param int  $user_idx
     * @param bool $include_deleted  是否包含已刪除角色（預設 false 不含）
     * @return array
     */
    public function list_by_user($user_idx, $include_deleted = false) {
        $qb = $this->db->select("
                    c.CHARACTER_IDX          AS CharId,
                    c.USER_IDX               AS UserId,
                    c.CHARACTER_NAME         AS CharName,
                    c.CHARACTER_GRADE        AS Level,
                    c.CHARACTER_JOB          AS Job,
                    c.CHARACTER_CURRENTMAP   AS MapId,
                    c.CHARACTER_STATE        AS State,
                    c.CHARACTER_LASTMODIFIED AS LastModified,
                    ci.DELETE_DATE,
                    ci.DELETE_IP,
                    CASE WHEN ci.DELETE_DATE IS NOT NULL THEN 1 ELSE 0 END AS is_deleted
                ", false)
            ->from($this->table . ' c')
            ->join($this->createInfoTable . ' ci', 'ci.CHARACTER_IDX = c.CHARACTER_IDX', 'left')
            ->where('c.USER_IDX', (int)$user_idx);

        // 不包含已刪除：保留 (DELETE_DATE IS NULL) 或根本沒有 CreateInfo 記錄
        if (!$include_deleted) {
            $qb->group_start()
                    ->where('ci.DELETE_DATE IS NULL', null, false)
                    ->or_where('ci.CHARACTER_IDX IS NULL', null, false)
               ->group_end();
        }

        return $qb->order_by('c.CHARACTER_GRADE', 'DESC')
                  ->order_by('c.CHARACTER_IDX',   'ASC')
                  ->get()->result();
    }

    /** 依角色主鍵(CHARACTER_IDX)取單筆（不含刪除過濾） */
    public function find_by_id($character_idx) {
        return $this->db->where('CHARACTER_IDX', (int)$character_idx)
                        ->get($this->table)->row();
    }
}
