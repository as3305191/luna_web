<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_dao extends MY_Model {

    /** 專用連到 GameDB 的連線 */
    protected $db;

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('gamedb', TRUE); // 確保這個 DSN 的 database 就是有 TB_ITEM 的 DB
    }

    // 這兩個舊方法留著無妨
    function find_by($field, $value) {
        return $this->db->where($field, $value)->get('TB_ITEM')->row();
    }
    function find_by_id($id) {
        return $this->db->where('id', $id)->get('TB_ITEM')->row();
    }

    /** 批次新增 TB_ITEM（走 GameDB 連線），預設 batch=500 */
    public function insert_items_batch(array $rows, int $batchSize = 500): int {
        if (empty($rows)) return 0;

        $cols = [
            'CHARACTER_IDX',
            'ITEM_IDX',
            'ITEM_SHOPIDX',
            'ITEM_SHOPLOGIDX',
            'mall_log_id',
            'ITEM_SEAL',
            'ITEM_DURABILITY',
            'ITEM_POSITION',
        ];
        $colList = implode(',', $cols);

        $aff = 0; $total = count($rows);
        for ($i = 0; $i < $total; $i += $batchSize) {
            $slice = array_slice($rows, $i, $batchSize);

            $placeholders = [];
            $binds = [];
            foreach ($slice as $r) {
                $placeholders[] = '(' . rtrim(str_repeat('?,', count($cols)), ',') . ')';
                foreach ($cols as $c) { $binds[] = $r[$c] ?? null; }
            }

            $sql = 'INSERT INTO TB_ITEM (' . $colList . ') VALUES ' . implode(',', $placeholders);
            $this->db->query($sql, $binds);
            $aff += $this->db->affected_rows();
        }
        return $aff;
    }

    /** 依本次 shoplog 補上 mall_log_id（仍走 GameDB） */
    public function update_mall_log_id_by_shoplog(int $mall_log_id, int $shop_log_id): void {
        $sql = "
          UPDATE TB_ITEM
             SET mall_log_id = ?
           WHERE ITEM_SHOPLOGIDX = ?
             AND (mall_log_id IS NULL OR mall_log_id = 0)
        ";
        $this->db->query($sql, [$mall_log_id, $shop_log_id]);
    }

    /** 單筆新增（保留給舊程式用，不建議大量呼叫） */
    public function insert_item($row) {
        $data = [
            'CHARACTER_IDX'   => (int)$row['CHARACTER_IDX'],
            'ITEM_IDX'        => (int)$row['ITEM_IDX'],
            'ITEM_SHOPIDX'    => (int)($row['ITEM_SHOPIDX'] ?? 0),
            'ITEM_SHOPLOGIDX' => (int)($row['ITEM_SHOPLOGIDX'] ?? 0),
            'mall_log_id'     => (int)($row['mall_log_id'] ?? 0),
            'ITEM_SEAL'       => (int)($row['ITEM_SEAL'] ?? 0),
            'ITEM_DURABILITY' => (int)($row['ITEM_DURABILITY'] ?? 0),
            'ITEM_POSITION'   => (int)($row['ITEM_POSITION'] ?? 320),
        ];
        return $this->db->insert('TB_ITEM', $data);
    }
}
