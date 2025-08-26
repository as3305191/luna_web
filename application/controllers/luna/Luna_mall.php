<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Luna_mall extends MY_Base_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('/luna/Members_dao', 'dao');
  }

  public function index() {
    if (empty($this->session->userdata('user_id'))) {
      redirect("/luna/login");
      return;
    }
    $data['userlv'] = $this->session->userdata('userlv');

    $data['now'] = 'luna_mall';
    $this->load->view('luna/luna_mall', $data);
  }
} // end class
