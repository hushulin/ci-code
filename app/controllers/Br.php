<?php
//header("Content-type: image/jpeg");
defined('BASEPATH') OR exit('No direct script access allowed');
/*
бщжЄТы
*/
class Br extends ST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Common');
    }
    public function index(){

    }
    	public function brandingreward(){
  $amount=floatval($_GET['amount']);
  $uid=intval($_GET['uid']);
  $this->Common->brandingreward($uid,$amount,'ГфжЕ');
  }
}

?>