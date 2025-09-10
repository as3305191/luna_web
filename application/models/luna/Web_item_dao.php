<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_item_dao extends MY_Model {

    /** 走 GameDB */
    protected $gdb;

    function __construct() {
        parent::__construct();
        // config/database.php 要有 'gamedb' DSN，且指向 LUNA_GAMEDB_2025
        $this->gdb = $this->load->database('gamedb', TRUE);
    }

    /** 依欄位拿單筆（原樣保留） */
    public function find_by($field, $value) {
        return $this->gdb->where($field, $value)->get('dbo.web_item')->row();
    }

    /** 以 item_id 取單筆（原樣保留，但表的主鍵是 item_id 不是 id） */
    public function find_by_id($id) {
        return $this->gdb->where('item_id', $id)->get('dbo.web_item')->row();
    }

    /**
     * 分頁查詢（支援依 item_id / name_cn 模糊查）
     * @return array [items,total,page,total_page]
     */
    public function search_paginated(string $q = '', int $limit = 10, int $page = 1): array {
        $page  = max(1, $page);
        $limit = max(1, $limit);
        $offset = ($page - 1) * $limit;

        // 計數
        $this->gdb->from('dbo.web_item');
        if ($q !== '') {
            $this->gdb->group_start()
                ->like('name_cn', $q)
                ->or_like("CAST(item_id AS NVARCHAR(50))", $q, 'both', FALSE)
            ->group_end();
        }
        $total = (int)$this->gdb->count_all_results('', false); // 保留查詢

        // 取資料
        $this->gdb->order_by('item_id', 'ASC')->limit($limit, $offset);
        $rows = $this->gdb->get()->result_array();

        // 映射到前端需要的鍵（跟你前端 js 對齊）
        $items = array_map(function($r){
            return [
                'product_code'    => (string)$r['item_id'],
                'name'            => (string)$r['name_cn'],
                'max_stack'       => (int)($r['stack_max'] ?? 0),
                // 你的表是「分鐘」，前端顯示的是「秒」，所以 *60；0 或 NULL 視為永久
                'endtime'         => isset($r['expire_minutes']) && (int)$r['expire_minutes'] > 0
                                        ? ((int)$r['expire_minutes'] * 60) : null,
                'wSeal'           => (int)($r['sealed'] ?? 0),
                'category_code'   => (int)($r['category'] ?? 0),
                'category_detail' => (int)($r['bl'] ?? 0),
                'rarity'          => isset($r['rarity']) ? (int)$r['rarity'] : 0,
            ];
        }, $rows);

        $total_page = max(1, (int)ceil($total / $limit));
        return compact('items','total','page','total_page');
    }

    /**
     * 取得一批 item 的 meta（給發送物品時查封印/疊加/限時）
     * 回傳：key = item_id(string)，value = ['wSeal','max_stack','endtime']
     */
    public function get_meta_map_by_ids(array $itemIds): array {
        $itemIds = array_values(array_filter(array_unique(array_map('strval', $itemIds))));
        if (empty($itemIds)) return [];

        $this->gdb->select('item_id, sealed, stack_max, expire_minutes')
                  ->from('dbo.web_item')
                  ->where_in('item_id', $itemIds);
        $rows = $this->gdb->get()->result_array();

        $map = [];
        foreach ($rows as $r) {
            $map[(string)$r['item_id']] = [
                'wSeal'     => (int)($r['sealed'] ?? 0),
                'max_stack' => (int)($r['stack_max'] ?? 0),
                'endtime'   => isset($r['expire_minutes']) && (int)$r['expire_minutes'] > 0
                                ? ((int)$r['expire_minutes'] * 60) : null,
            ];
        }
        return $map;
    }
    
}
