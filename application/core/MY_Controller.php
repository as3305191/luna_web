<?php
class MY_Base_Controller extends CI_Controller {

  protected function render($view, $data = []) {
    // PJAX：只回中間內容，並回傳 Title / URL 讓前端更新
    $is_pjax = $this->input->get_request_header('X-PJAX') || $this->input->get('pjax') === '1';
    if ($is_pjax) {
      $title = isset($data['title']) ? $data['title'] : 'LUNA3';
      $this->output->set_header('X-PJAX-Title: '.$title);
      $this->output->set_header('X-PJAX-URL: '.$this->input->server('REQUEST_URI'));
      return $this->load->view($view, $data, false);
    }
    // 一般完整頁
    $data2 = ['content_view' => $view, 'data' => $data] + $data;
    return $this->load->view('luna/layout', $data2);
  }

  // 未登入：一般頁 -> redirect；AJAX/PJAX -> 401 交給前端導去登入
  protected function require_login() {
    $uid   = $this->session->userdata('user_id');
    $login = $this->session->userdata('login_user_id');

    if (empty($uid) && ($login === null || $login === '')) {
      if ($this->input->is_ajax_request() || $this->input->get_request_header('X-PJAX')) {
        $this->output->set_status_header(401)->set_content_type('text/plain')->set_output('LOGIN_REQUIRED');
        return false;
      }
      redirect('/luna/login');
      exit;
    }
    return true;
  }

  function __construct() {
    parent::__construct();
    $this->load->helper('common');
    $this->load->model('Users_dao', 'users_dao');
    $this->load->model('Push_msg_dao', 'pm_dao');
    $this->load->model('App_reg_code_dao', 'arc_dao');
    $this->load->model('Fix_record_dao', 'fix_record_dao');
    $this->load->model('C_s_h_join_list_dao', 'c_s_h_join_list_dao'); // ← 刪掉重複行
    $this->load->model('Department_dao', 'department_dao');
    $this->load->model('/luna/Members_dao', 'luna_mem_dao');

    /* ---------- 基本安全/快取 header（用 CI Output 設，別再 ob_*） ---------- */
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
    $this->output->set_header('Pragma: no-cache');
    $this->output->set_header('X-Frame-Options: SAMEORIGIN');
    $this->output->set_header('X-Content-Type-Options: nosniff');
    $this->output->set_header('Referrer-Policy: strict-origin-when-cross-origin');

    /* ---------- CORS：只在有 Origin 且同 host 時回，且處理 OPTIONS ---------- */
    $origin = $this->input->get_request_header('Origin', true);
    if ($origin) {
      $host       = $_SERVER['HTTP_HOST'] ?? '';
      $originHost = parse_url($origin, PHP_URL_HOST) ?: '';
      if ($originHost === $host) {
        $this->output->set_header('Access-Control-Allow-Origin: '.$origin);
        $this->output->set_header('Vary: Origin');
        $this->output->set_header('Access-Control-Allow-Credentials: true');
        $this->output->set_header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With, X-CSRF-Token, X-PJAX, Accept');
      }
    }
    if ($this->input->method(true) === 'OPTIONS') {
      $this->output->set_status_header(204);
      $this->output->_display();
      exit;
    }

    /* ---------- 其他 ---------- */
    date_default_timezone_set("Asia/Taipei");

    // 語系初始化
    $lang = $this->session->userdata('lang');
    if (empty($lang)) {
      $this->session->set_userdata('lang', 'cht');
    }
  }

  function get_header($key) { return $this->input->get_request_header($key); }
  function get_post($key)   { return $this->input->post($key); }
  function get_get($key)    { return $this->input->get($key); }
  function get_get_post($key){
    $val = $this->get_get($key);
    if ($val === FALSE) $val = $this->get_post($key);
    return $val;
  }

  function to_json($json_data) {
    $this->output->set_content_type('application/json; charset=utf-8')
                 ->set_output(json_encode($json_data, JSON_UNESCAPED_UNICODE));
  }

  public function get_posts($post_array, $bypass_empty = FALSE) {
    $i_data = [];
    foreach ($post_array as $each) {
      if ($bypass_empty) {
        if (!empty($this->get_post($each))) $i_data[$each] = $this->get_post($each);
      } else {
        $i_data[$each] = $this->get_post($each);
      }
    }
    return $i_data;
  }

  public function get_gets($post_array) {
    $i_data = [];
    foreach ($post_array as $each) $i_data[$each] = $this->get_get($each);
    return $i_data;
  }

  public function get_get_posts($post_array) {
    $i_data = [];
    foreach ($post_array as $each) {
      $val = $this->get_get_post($each);
      if (!($val === FALSE)) $i_data[$each] = $val;
    }
    return $i_data;
  }

  // resize
  public function resize($img_path, $width = 500, $height = 500) {
    $config = [
      'image_library'  => 'gd2',
      'source_image'   => $img_path,
      'create_thumb'   => FALSE,
      'maintain_ratio' => TRUE,
      'width'          => $width,
      'height'         => $height,
    ];
    $this->load->library('image_lib', $config);
    $this->image_lib->resize();
  }

  public function check_dir($dir) {
    if (!file_exists($dir)) mkdir($dir, 0777, true);
  }

  public function setup_user_data($data = []) {
    // user_id = 數字 id_idx；login_user_id = 帳號字串
    $user_idx      = $this->session->userdata('user_id');       // int (id_idx)
    $login_user_id = $this->session->userdata('login_user_id'); // string (id_loginid)
    $userlv        = $this->session->userdata('userlv');

    // 未登入處理（跟 require_login 一致）
    if (empty($user_idx) && ($login_user_id === null || $login_user_id === '')) {
      if ($this->input->is_ajax_request() || $this->input->get_request_header('X-PJAX')) {
        $this->output->set_status_header(401)->set_output('');
        return $data;
      } else {
        redirect('/luna/login');
        return $data;
      }
    }

    // 取使用者資料
    if (is_numeric($user_idx)) {
      $user = $this->luna_mem_dao->find_by('id_idx', (int)$user_idx);
    } elseif (!empty($login_user_id)) {
      if (method_exists($this->luna_mem_dao, 'find_by_loginid')) {
        $user = $this->luna_mem_dao->find_by_loginid((string)$login_user_id);
      } else {
        $user = $this->luna_mem_dao->find_by('id_loginid', (string)$login_user_id);
      }
    } else {
      $user = null;
    }

    $data['login_user_id'] = ($login_user_id === null ? '' : (string)$login_user_id);
    $data['l_user']        = $user;
    $data['userlv']        = (int)($userlv ?? 0);
    $data['login_user']    = ['login_user_id'=>$data['login_user_id'], 'l_user'=>$user];

    return $data;
  }

  function get_between($input, $start, $end) {
    $substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
    return $substr;
  }

  public function setup_coach_data($data) {
    $user_id = $this->session->userdata('user_id');
    if (empty($user_id)) {
      if ($this->input->is_ajax_request()) {
        echo "<script>window.location.reload();</script>";
      } else {
        redirect("coach/coach_home/logout");
      }
    } else {
      $user = $this->users_dao->find_by_id($user_id);
      $data['login_user_id'] = $user_id;
      $data['l_user'] = $user;
    }
    return $data;
  }

  protected function assign($name, $value = '') {
    $this->view->assign($name, $value);
    return $this;
  }

  public function js_alert($msg='error',$redirect_url=null) {
    echo "<script>";
    echo "alert('".$msg."');";
    if(empty($redirect_url)){
      echo "history.back();";
    }else{
      echo "window.location = '".$redirect_url."';";
    }
    echo "</script>";
    exit;
  }

  public function send_mail($to, $subject, $text, $cc = '') {
    $this->load->library('email');
    $this->email->initialize(mail_config());
    $this->email->from('inf@kwantex.com', 'system');
    $this->email->to($to);
    if (!empty($cc)) $this->email->cc($cc);
    $this->email->subject($subject);
    $this->email->message($text);
    $this->email->send();
  }

  public function mail($role_id ,$to, $subject, $text, $cc = '') {
    $department = $this->department_dao->find_by_id($role_id);
    $config = [
      'crlf'      => "\r\n",
      'newline'   => "\r\n",
      'charset'   => 'utf-8',
      'protocol'  => 'smtp',
      'mailtype'  => 'html',
      'smtp_host' => '192.168.1.246',
      'smtp_port' => '25',
      'smtp_user' => $department->email_account,
      'smtp_pass' => $department->email_password
    ];
    $this->load->library('email');
    $this->email->initialize($config);
    $this->email->from($department->email_account.'@kwantex.com', $department->email_account);
    $this->email->to($to);
    if (!empty($cc)) $this->email->cc($cc);
    $this->email->subject($subject);
    $this->email->message($text);
    $this->email->send();
  }
}

/* ========== 後台基底：避開 PATH_INFO、未登入攔截更穩 ========== */
class MY_Mgmt_Controller extends MY_Base_Controller {
  function __construct() {
    parent::__construct();
    $user_id = $this->session->userdata('user_id');
    $uri     = $this->uri->uri_string(); // 代替 PATH_INFO
    if (strpos('/'.$uri, '/app/mgmt') === 0 && empty($user_id)) {
      echo "<script>window.location.reload();</script>";
      exit;
    }
  }
}
