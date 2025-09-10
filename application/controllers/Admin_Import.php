<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date as XlsDate;

class Admin_Import extends CI_Controller
{
    private $BATCH = 1000;

    // ✅ 允許的 bl 對照（不查 DB，直接用白名單避免 FK）
    private $BL_ALLOWED = [
        11,12,13,14,15,
        21,22,23,24,25,
        30,31,32,33,35,36,37,
        42,43,44,45,
        51
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        @ini_set('memory_limit', '2G');
        @ini_set('max_execution_time', '600');

        // 強制切 DB（避免 default DB 不是 LUNA_GAMEDB_2025）
        $this->db->query('USE [LUNA_GAMEDB_2025]');
    }

    /* ---------------- 共用：Excel Reader（只讀值） & 小工具 ---------------- */

    private function xlsxReader(): Xlsx {
        $r = new Xlsx();
        $r->setReadDataOnly(true);
        $r->setReadEmptyCells(false);
        return $r;
    }
    private function getVal($sheet, int $col, int $row) {
        return $sheet->getCellByColumnAndRow($col, $row)->getValue();
    }
    private function getInt($sheet, int $col, int $row): ?int {
        $v = $this->getVal($sheet, $col, $row);
        if ($v === null || $v === '') return null;
        return (int)$v;
    }
    private function getStr($sheet, int $col, int $row): ?string {
        $v = trim((string)$this->getVal($sheet, $col, $row));
        return ($v === '') ? null : $v;
    }
    private function toDateTime($v): ?string {
        if ($v === null || $v === '') return null;
        if (is_numeric($v)) {
            $ts = XlsDate::excelToTimestamp($v);
            return date('Y-m-d H:i:s', $ts);
        }
        $t = strtotime((string)$v);
        return $t ? date('Y-m-d H:i:s', $t) : null;
    }
    private function nowStr(): string { return date('Y-m-d H:i:s'); }

    // ✅ 批次插入：不中斷，失敗列收集錯誤
    private function bulk_insert_no_fail(string $table, array $rows, int &$okCnt, array &$errRows) {
        foreach ($rows as $r) {
            try {
                $this->db->insert($table, $r);
                $okCnt++; // 計數累加
            } catch (\Throwable $e) {
                $errRows[] = [
                    'row' => $r,
                    'msg' => $e->getMessage(),
                ];
            }
        }
    }

    /* ---------------- 匯入：itemlistcn.xlsx（無表頭，固定欄位） ----------------
       A(1) item_id、B(2) name_cn、M(13) stack_max、T(20) expire_minutes、
       BE(57) sealed、BL(64) bl、BM(65) category(先塞細類代碼字串)
    --------------------------------------------------------------------------- */
    public function itemlistcn()
    {
        $path = FCPATH . 'assets/luna/itemlistcn.xlsx';
        if (!is_file($path)) show_error("找不到檔案：$path");

        $COL_ItemIdx      = 1;   // A → item_id
        $COL_ItemName     = 2;   // B → name_cn
        $COL_Stack        = 13;  // M → stack_max
        $COL_TimeMinutes  = 20;  // T → expire_minutes
        $COL_wSeal        = 57;  // BE → sealed
        $COL_dwType       = 64;  // BL → bl
        $COL_dwTypeDetail = 65;  // BM → category(細類代碼字串)

        $sheet = $this->xlsxReader()->load($path)->getActiveSheet();
        $hi = $sheet->getHighestRow();

        // 如需每次匯入都清空，解除註解：
        // $this->db->query('DELETE FROM dbo.web_itemshop');
        $this->db->query('DELETE FROM dbo.web_item');

        $buf = [];
        $ok = 0; $err = [];
        for ($r=1; $r <= $hi; $r++) {
            $item_id = (int)($this->getInt($sheet, $COL_ItemIdx, $r) ?? 0);
            $name_cn = $this->getStr($sheet, $COL_ItemName, $r);

            if ($item_id === 0 && ($name_cn ?? '') === '') continue; // 空列
            if ($item_id === 0 || ($name_cn ?? '') === '') {
                $err[] = ['row'=>$r, 'msg'=>'缺少 item_id 或 name_cn'];
                continue;
            }

            $stack_max = $this->getInt($sheet, $COL_Stack, $r);
            $expireMin = $this->getInt($sheet, $COL_TimeMinutes, $r);
            $sealed    = $this->getInt($sheet, $COL_wSeal, $r);
            $blRaw     = $this->getInt($sheet, $COL_dwType, $r);       // 不查 DB
            $detail    = $this->getStr($sheet, $COL_dwTypeDetail, $r); // 存到 category

            // ✅ 用白名單過濾，非法值（含 0 / 空）→ NULL，避免 FK 爆
            $bl = ($blRaw !== null && in_array($blRaw, $this->BL_ALLOWED, true)) ? $blRaw : null;

            $buf[] = [
                'item_id'        => $item_id,
                'name_cn'        => $name_cn,
                'category'       => $detail,
                'bl'             => $bl,
                'stack_max'      => ($stack_max && $stack_max > 0) ? $stack_max : null,
                'sealed'         => ($sealed ? 1 : 0),
                'expire_minutes' => ($expireMin && $expireMin > 0) ? $expireMin : null,
                'rarity'         => null,
                'updated_at'     => $this->nowStr(),
            ];

            if (count($buf) >= $this->BATCH) {
                $this->bulk_insert_no_fail('dbo.web_item', $buf, $ok, $err);
                $buf = [];
            }
        }
        if (!empty($buf)) $this->bulk_insert_no_fail('dbo.web_item', $buf, $ok, $err);

        $resp = ['ok_rows'=>$ok, 'ng_rows'=>count($err)];
        if (!empty($err)) $resp['errors'] = $err;
        $this->output->set_content_type('application/json')->set_output(json_encode($resp, JSON_UNESCAPED_UNICODE));
    }

    /* ---------------- 匯入：item_shop.xlsx（無表頭，固定欄位） ----------------
       A(1) item_id、B(2) price_cash、C(3) price_token、D(4) limit_per_buy、
       E(5) position、F(6) is_active、G(7) start_time、H(8) end_time
       ※ 不查 DB；若 item_id 不存在、撞 FK，就只記該列錯誤。
    --------------------------------------------------------------------------- */
public function itemshop()
{
    $path = FCPATH . 'assets/luna/item_shop.xlsx';
    if (!is_file($path)) show_error("找不到檔案：$path");

    // A:id, B:name_cn, C:price_cash, D:name_en（其餘欄位有就吃、沒有就預設）
    $COL_ItemIdx  = 1; // A
    $COL_ItemName = 2; // B
    $COL_Price    = 3; // C
    $COL_NameEN   = 4; // D

    // 選配（有則讀，無則設預設）
    $C_PRICE_TOKEN = 5;  // E
    $C_LIMIT       = 6;  // F
    $C_POSITION    = 7;  // G
    $C_ACTIVE      = 8;  // H
    $C_START       = 9;  // I
    $C_END         = 10; // J

    $wb = $this->xlsxReader()->load($path);
    $sheetNames = $wb->getSheetNames();

    // 先清空
    $this->db->query('DELETE FROM dbo.web_itemshop WITH (TABLOCK)');

    $ok = 0; $err = [];
    $buf = [];

    foreach ($sheetNames as $sheetName) {
        $sheet = $wb->getSheetByName($sheetName);
        if (!$sheet) continue;

        $highestRow = $sheet->getHighestRow();

        // 和前台一致：找第一列資料（A/B 有字且 C 為數字）
        $startRow = 1;
        for ($r = 1; $r <= $highestRow; $r++) {
            $a = trim((string)$sheet->getCellByColumnAndRow($COL_ItemIdx,  $r)->getValue());
            $b = trim((string)$sheet->getCellByColumnAndRow($COL_ItemName, $r)->getValue());
            $c = $sheet->getCellByColumnAndRow($COL_Price,   $r)->getValue();
            if ($a !== '' && $b !== '' && is_numeric($c)) { $startRow = $r; break; }
        }

        // 分頁名 = 分類
        $category = trim((string)$sheetName);

        for ($r = $startRow; $r <= $highestRow; $r++) {
            $idStr   = trim((string)$sheet->getCellByColumnAndRow($COL_ItemIdx,  $r)->getValue());
            $name    = trim((string)$sheet->getCellByColumnAndRow($COL_ItemName, $r)->getValue());
            $cval    = $sheet->getCellByColumnAndRow($COL_Price,   $r)->getValue();
            $nameEn  = trim((string)$sheet->getCellByColumnAndRow($COL_NameEN,   $r)->getValue());

            if ($idStr === '' || $name === '' || !is_numeric($cval)) continue;

            $item_id    = (int)$idStr;
            $price_cash = (int)$cval;
            if ($item_id === 0 || $price_cash <= 0) {
                $err[] = ['sheet'=>$sheetName, 'row'=>$r, 'msg'=>'缺少 item_id 或 price_cash<=0'];
                continue;
            }

            $price_token = $sheet->getCellByColumnAndRow($C_PRICE_TOKEN, $r)->getValue();
            $limit       = $sheet->getCellByColumnAndRow($C_LIMIT,       $r)->getValue();
            $position    = $sheet->getCellByColumnAndRow($C_POSITION,    $r)->getValue();
            $active_i    = $sheet->getCellByColumnAndRow($C_ACTIVE,      $r)->getValue();
            $start_raw   = $sheet->getCellByColumnAndRow($C_START,       $r)->getValue();
            $end_raw     = $sheet->getCellByColumnAndRow($C_END,         $r)->getValue();

            $buf[] = [
                'item_id'       => $item_id,
                'name_cn'       => $name,               // B
                'name_en'       => $nameEn,             // D
                'category'      => $category,           // ★ 分頁名稱當分類
                'price_cash'    => $price_cash,         // C
                'price_token'   => (is_numeric($price_token) ? (int)$price_token : null),
                'limit_per_buy' => (is_numeric($limit) ? (int)$limit : 99),
                'position'      => (is_numeric($position) ? (int)$position : null),
                'is_active'     => (is_numeric($active_i) ? ((int)$active_i ? 1 : 0) : 1),
                'start_time'    => $this->toDateTime($start_raw),
                'end_time'      => $this->toDateTime($end_raw),
                'updated_at'    => $this->nowStr(),
            ];

            if (count($buf) >= $this->BATCH) {
                $this->bulk_insert_no_fail('dbo.web_itemshop', $buf, $ok, $err);
                $buf = [];
            }
        }
    }

    if (!empty($buf)) {
        $this->bulk_insert_no_fail('dbo.web_itemshop', $buf, $ok, $err);
    }

    $resp = ['ok_rows'=>$ok, 'ng_rows'=>count($err)];
    if (!empty($err)) $resp['errors'] = $err;
    $this->output->set_content_type('application/json')
                 ->set_output(json_encode($resp, JSON_UNESCAPED_UNICODE));
}



    /* ---------------- 一鍵全做 ---------------- */
    public function import_all()
    {
        // 如需先清空兩表再匯入，解除註解：
        // $this->db->query('DELETE FROM dbo.web_itemshop');
        // $this->db->query('DELETE FROM dbo.web_item');

        ob_start();
        $this->itemlistcn(); $itemsOut = ob_get_clean();

        ob_start();
        $this->itemshop();   $shopOut  = ob_get_clean();

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'items' => json_decode($itemsOut, true),
            'shop'  => json_decode($shopOut, true),
        ], JSON_UNESCAPED_UNICODE));
    }
}
