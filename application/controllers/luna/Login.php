<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Base_Controller {

    function __construct() {
        parent::__construct();
        // $this->load->helper('captcha');
        $this->load->model('/luna/Members_dao', 'dao');  // 這個 DAO 要連到 chr_log_info
    }

    public function index() {
        $data = array();
        // 已登入 → 跳轉
        if(!empty($this->session->userdata('user_id'))) {
            redirect("/luna/luna_home");
            return;
        }
        $this->load->view('luna/login', $data);
    }

    public function do_login() {
        $res = array();

        $account = $this->get_post('account');
        $password = $this->get_post('password');

        if (!empty($account) && !empty($password)) {
            // chr_log_info.id_loginid = 帳號
            $user = $this->dao->find_by('id_loginid', $account);

            if (!empty($user) && $user->id_passwd == $password) {
                if($user->UserLevel == 2||$user->UserLevel == 6){
                    $this->session->set_userdata('user_id', $user->id_loginid);
                    $this->session->set_userdata('userlv', $user->UserLevel);
                    // redirect("/luna/luna_home");
                    // $res['status'] = true;
                    // $res['msg'] = "登入成功";
                } else {
                    $res['status'] = false;
                    $res['msg'] = "你被鎖了，請聯絡GM。";
                }
            } else {
                $res['status'] = false;
                $res['msg'] = "帳號或密碼錯誤";
            }

        } else {
            $res['status'] = false;
            $res['msg'] = "請輸入帳號與密碼";
        }

        $this->to_json($res);
    }

    // public function do_login_app($id) {
    //     $user = $this->dao->find_by_id($id);
    //     if(!empty($user) && $user->UserLevel >= 1){
    //         $this->session->set_userdata('user_id', $user->id_idx);
    //         redirect("/luna/luna_home");
    //     } else {
    //         echo "權限不足，無法登入！";
    //     }
    // }

    public function logout() {
        $this->session->sess_destroy();
        redirect('luna/login');
    }

}
