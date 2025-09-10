<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_itemshop_dao extends MY_Model {

    protected $gdb;

    function __construct() {
        parent::__construct();
        $this->gdb = $this->load->database('gamedb', TRUE);
    }

    public function find_by($field, $value) {
        return $this->gdb->where($field, $value)->get('web_itemshop')->row();
    }

    public function find_by_id($id) {
        // 依你表的主鍵調整，這裡假設也是 item_id
        return $this->gdb->where('item_id', $id)->get('web_itemshop')->row();
    }

    /**
     * 分頁查商城表（依實際欄位調整）
     * 可改 select 欄位；這裡假設至少有 item_id / name_cn / price / updated_at。
     */
    public function search_paginated(string $q = '', int $limit = 10, int $page = 1): array {
        $page  = max(1, $page);
        $limit = max(1, $limit);
        $offset = ($page - 1) * $limit;

        $this->gdb->from('web_itemshop');
        if ($q !== '') {
            $this->gdb->group_start()
                ->like('name_cn', $q)
                ->or_like("CAST(item_id AS NVARCHAR(50))", $q, 'both', FALSE)
            ->group_end();
        }
        $total = (int)$this->gdb->count_all_results('', false);

        $this->gdb->order_by('item_id', 'ASC')->limit($limit, $offset);
        $rows = $this->gdb->get()->result_array();

        $items = array_map(function($r){
            return [
                'item_id'    => (string)$r['item_id'],
                'name_cn'    => (string)($r['name_cn'] ?? ''),
                'price'      => isset($r['price']) ? (int)$r['price'] : null, // 若有欄位
                'updated_at' => $r['updated_at'] ?? null,
            ];
        }, $rows);

        $total_page = max(1, (int)ceil($total / $limit));
        return compact('items','total','page','total_page');
    }
}
