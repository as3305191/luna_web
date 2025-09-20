<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Base_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('/luna/Members_dao', 'dao');  // 連 chr_log_info
    }

    public function index() {
        // 先種/刷新 CSRF cookie，避免第一次進頁 token 為空
        if (method_exists($this->security, 'csrf_set_cookie')) {
            $this->security->csrf_set_cookie();
        }
        if (!empty($this->session->userdata('user_id'))) {
            redirect("/luna/luna_home");
            return;
        }
        $data = [
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        ];
        $this->load->view('luna/login', $data);
    }

    public function do_login() {
        // 走到這裡前，CI 已幫你做 CSRF 驗證；失敗會直接 403，不會執行到下面
        $this->output->set_content_type('application/json');

        $account  = trim((string)$this->get_post('account'));
        $password = trim((string)$this->get_post('password'));

        if ($account === '' || $password === '') {
            return $this->_json_fail('請輸入帳號與密碼');
        }

        // chr_log_info.id_loginid = 帳號
        $user = $this->dao->find_by_loginid((string)$account);


        if (empty($user) || $user->id_passwd !== $password) {
            return $this->_json_fail('帳號或密碼錯誤');
        }

        if (!in_array((int)$user->UserLevel, [2,6], true)) {
            return $this->_json_fail('你被鎖了，請聯絡GM。');
        }

        // ✅ 統一 session 欄位：同時存「數字 id_idx」與「字串 id_loginid」
        $this->session->set_userdata([
            'user_id'        => (int)$user->id_idx,     // 給需要數字 USER_IDX 的程式用
            'userlv'         => (string)$user->UserLevel,
            'login_user_id'  => (string)$user->id_loginid, // 你專案其他地方會用到
        ]);

        // 成功：回傳 redirect + 最新 CSRF，前端會更新 hidden，下一次操作不會 403
        return $this->_json_ok([
            'redirect' => site_url('luna/luna_mall'),
            'msg'      => '登入成功',
        ]);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('luna/login');
    }

    /* --------------------- 共用 JSON 包裝：每次都回新 CSRF --------------------- */

    private function _json_ok(array $extra = []) {
        if (method_exists($this->security, 'csrf_set_cookie')) {
            $this->security->csrf_set_cookie();
        }
        $payload = array_merge([
            'ok'        => true,
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        ], $extra);
        return $this->output->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE));
    }

    private function _json_fail(string $msg, int $code = 200) {
        if (method_exists($this->security, 'csrf_set_cookie')) {
            $this->security->csrf_set_cookie();
        }
        $payload = [
            'ok'        => false,
            'msg'       => $msg,
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        ];
        return $this->output->set_status_header($code)->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE));
    }
}
