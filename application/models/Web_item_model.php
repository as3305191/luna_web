<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web_item_model extends CI_Model {

  /**
   * 取得商城上架清單（支援關鍵字、分類、時間區間、分頁）
   *
   * @param string $q   關鍵字（item name 或 item_id）
   * @param int|null $bl 分類代碼（11/12/...）
   * @param int $page   第幾頁（1-based）
   * @param int $page_size 每頁筆數
   * @return array 結果陣列 (stdClass) 清單
   */
  public function list_shop_items($q = '', $bl = null, $page = 1, $page_size = 24) {
    // 安全分頁
    $page      = max(1, (int)$page);
    $page_size = max(1, (int)$page_size);
    $offset    = ($page - 1) * $page_size;

    $this->db
      ->select('
        s.shop_id,
        i.item_id,
        i.name_cn,
        i.bl,
        m.bl_name,
        s.price_cash,
        s.price_token,
        s.is_active,
        s.position,
        i.rarity
      ')
      ->from('web_itemshop s')
      ->join('web_item i', 'i.item_id = s.item_id')
      ->join('web_bl_map m', 'm.bl_code = i.bl', 'left')
      ->where('s.is_active', 1)
      // 上/下架時間過濾（使用 SQL 的 GETUTCDATE()，避免 PHP/DB 時區不一致）
      ->where('(s.start_time IS NULL OR s.start_time <= GETUTCDATE())', null, false)
      ->where('(s.end_time   IS NULL OR s.end_time   >  GETUTCDATE())', null, false);

    if ($q !== '') {
      $q = trim($q);
      $this->db->group_start()
               ->like('i.name_cn', $q)
               ->or_like('i.item_id', $q) // 讓輸入數字可直查 ID
               ->group_end();
    }

    if ($bl !== null && $bl !== '') {
      $this->db->where('i.bl', (int)$bl);
    }

    $this->db
      // 排序：未設 position 的丟後面 → position ASC → 稀有度 DESC → item_id ASC
      ->order_by('CASE WHEN s.position IS NULL THEN 1 ELSE 0 END', 'ASC', false)
      ->order_by('s.position', 'ASC')
      ->order_by('i.rarity', 'DESC')
      ->order_by('i.item_id', 'ASC')
      ->limit($page_size, $offset);

    return $this->db->get()->result();
  }

  public function get_item($item_id) {
    return $this->db->get_where('web_item', ['item_id' => (int)$item_id])->row();
  }
}
