<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_log_dao extends MY_Model {

    private const TABLE = 'TB_ITEM_SHOPWEB_LOG';
    private const PK    = 'LOG_IDX';

    protected $db;          // 指向 logdb 連線
    private $last_error = null; // 記錄最後一次 DB 錯誤

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('logdb', TRUE); // 連 logdb
    }

    /** 取最後一次錯誤（給 controller 用） */
    public function get_last_error() {
        return $this->last_error;
    }

    /** 依欄位查一筆 */
    function find_by($field, $value) {
        return $this->db->where($field, $value)->get(self::TABLE)->row();
    }

    /** 依主鍵查一筆（用 LOG_IDX） */
    function find_by_id($id) {
        return $this->db->where(self::PK, $id)->get(self::TABLE)->row();
    }
    
    /**
     * 插入一筆 LOG 並回傳 LOG_IDX（int）；失敗回傳 false
     */
   public function insert_item(array $data) {
    // 可選：保留最後錯誤給 controller 取用
    if (!property_exists($this, 'last_error')) $this->last_error = null;
    $this->last_error = null;

    $table = 'TB_ITEM_SHOPWEB_LOG';
    $pk    = 'LOG_IDX';

    // 支援外面傳 [DATE]
    if (isset($data['[DATE]'])) {
        $data['DATE'] = $data['[DATE]'];
        unset($data['[DATE]']);
    }

    // 白名單 + 型別穩定
    $row = [
        'TYPE'       => isset($data['TYPE'])       ? (int)$data['TYPE']       : 0,
        'USER_IDX'   => isset($data['USER_IDX'])   ? (int)$data['USER_IDX']   : 0,
        'USER_ID'    => isset($data['USER_ID'])    ? (string)$data['USER_ID'] : '',
        'ITEM_IDX'   => isset($data['ITEM_IDX'])   ? (int)$data['ITEM_IDX']   : 0,
        'ITEM_DBIDX' => isset($data['ITEM_DBIDX']) ? (int)$data['ITEM_DBIDX'] : 0,
        'SIZE'       => isset($data['SIZE'])       ? (int)$data['SIZE']       : 0,
        'DATE'       => isset($data['DATE'])
                        ? (string)$data['DATE']
                        : (new DateTime('now', new DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s'),
    ];

    // 基本防呆
    if ($row['USER_IDX'] <= 0 || $row['ITEM_IDX'] <= 0 || $row['SIZE'] <= 0) {
        $this->last_error = ['code'=>0,'message'=>'invalid payload (USER_IDX/ITEM_IDX/SIZE)'];
        return false;
    }

    // 1) 直接 insert（Query Builder）
    $ok = $this->db->insert($table, $row);
    if (!$ok) {
        $err = $this->db->error();
        $this->last_error = ['code'=>$err['code'] ?? -1, 'message'=>$err['message'] ?? 'insert failed'];
        return false;
    }

    // 2) 先拿 insert_id（大多數情況可用）
    $id = (int)$this->db->insert_id();
    if ($id > 0) return $id;

    // 3) 罕見情況：fallback -> SCOPE_IDENTITY()
    $q = $this->db->query("SELECT CAST(SCOPE_IDENTITY() AS bigint) AS {$pk}");
    if ($q === false) {
        $err = $this->db->error();
        $this->last_error = ['code'=>$err['code'] ?? -1, 'message'=>$err['message'] ?? 'scope_identity failed'];
        return false;
    }

    // 這裡一定先檢查再存取，避免 row_array() on bool
    if (method_exists($q, 'num_rows') && $q->num_rows() > 0) {
        // 用 row() 也可，依你喜好
        $r = $q->row();
        if ($r && isset($r->$pk)) {
            return (int)$r->$pk;
        }
        // 再試一次用 row_array()，一樣要先確定不是 bool
        if (method_exists($q, 'row_array')) {
            $ra = $q->row_array();
            if (is_array($ra) && isset($ra[$pk])) {
                return (int)$ra[$pk];
            }
        }
    }

    // 4) 最後的保險：用條件查最新一筆（避免 triggers 影響 SCOPE_IDENTITY）
    //    這段依你表結構調整條件，這裡用 USER_IDX/ITEM_IDX/DATE 近時查一筆
    $safe = $this->db
        ->select($pk)
        ->from($table)
        ->where('USER_IDX', $row['USER_IDX'])
        ->where('ITEM_IDX', $row['ITEM_IDX'])
        ->order_by($pk, 'DESC')
        ->limit(1)
        ->get();

    if ($safe && $safe->num_rows() > 0) {
        $last = $safe->row();
        if ($last && isset($last->$pk)) return (int)$last->$pk;
    }

    $this->last_error = ['code'=>0,'message'=>'unable to determine inserted id'];
    return false;
}

}
