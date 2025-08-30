<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_log_dao extends MY_Model {

    // 若表在 dbo 下面，建議直接寫 schema-qualified 名稱
    private const TABLE = 'dbo.TB_ITEM_SHOPWEB_LOG';
    private const PK    = 'LOG_IDX';

    protected $db;                 // 指向 logdb 連線（確保 config/database.php 有 logdb）
    private $last_error = null;    // 記錄最後一次 DB 錯誤

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('logdb', TRUE); // 連 logdb
    }

    public function get_last_error() {
        return $this->last_error;
    }

    function find_by($field, $value) {
        return $this->db->where($field, $value)->get(self::TABLE)->row();
    }

    function find_by_id($id) {
        return $this->db->where(self::PK, $id)->get(self::TABLE)->row();
    }

    /**
     * 插入一筆 LOG 並回傳 LOG_IDX（int）；失敗回傳 false
     * 欄位：[TYPE],[USER_IDX],[USER_ID],[ITEM_IDX],[ITEM_DBIDX],[SIZE],[DATE]
     * 注意：DATE 是 SQL Server 保留字，務必以 [DATE] 包起來。
     */
    public function insert_item(array $data) {
        $this->last_error = null;

        $TYPE   = (int)($data['TYPE']       ?? 0);   // 0=逐品項、1=整單
        $U_IDX  = (int)($data['USER_IDX']   ?? 0);
        $U_ID   = (string)($data['USER_ID'] ?? '');
        $I_IDX  = (int)($data['ITEM_IDX']   ?? 0);
        $I_DB   = (int)($data['ITEM_DBIDX'] ?? 0);
        $SIZE   = (int)($data['SIZE']       ?? 0);
        $DATE   = (string)($data['DATE']    ?? (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s'));

        // ✅ 只有 TYPE=0（逐品項）才要求 ITEM_IDX > 0
        $needItemIdx = ($TYPE === 0);

        if ($U_IDX <= 0 || $SIZE <= 0 || ($needItemIdx && $I_IDX <= 0)) {
            $this->last_error = ['code'=>0,'message'=>'invalid payload'];
            return false;
        }

        // 若沒給 ITEM_DBIDX，就沿用 ITEM_IDX（可選）
        if ($I_DB <= 0) $I_DB = $I_IDX;

        $sql = "
            INSERT INTO ".self::TABLE."
                ([TYPE],[USER_IDX],[USER_ID],[ITEM_IDX],[ITEM_DBIDX],[SIZE],[DATE])
            VALUES (?,?,?,?,?,?,?)
        ";
        $ok = $this->db->query($sql, [$TYPE, $U_IDX, $U_ID, $I_IDX, $I_DB, $SIZE, $DATE]);
        if (!$ok) {
            $err = $this->db->error();
            $this->last_error = ['code'=>$err['code'] ?? -1, 'message'=>$err['message'] ?? 'insert failed'];
            log_message('error', 'shop_log insert fail: '.$this->last_error['code'].' '.$this->last_error['message']);
            return false;
        }

        $id = (int)$this->db->insert_id();
        if ($id > 0) return $id;

        $q = $this->db->query("SELECT CAST(SCOPE_IDENTITY() AS bigint) AS ".self::PK);
        if ($q && $q->num_rows() > 0) {
            $r = $q->row();
            if ($r && isset($r->{self::PK})) return (int)$r->{self::PK};
        }

        $this->last_error = ['code'=>0,'message'=>'unable to determine inserted id'];
        return false;
    }

}
