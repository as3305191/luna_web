<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_log_dao extends MY_Model {

    private const TABLE = 'TB_ITEM_SHOPWEB_LOG';
    private const PK    = 'LOG_IDX';

    protected $db;          // 指向 logdb 連線
    private $last_error = null; // 記錄最後一次 DB 錯誤

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('logdb', TRUE); // 連 logdb
    }



}
