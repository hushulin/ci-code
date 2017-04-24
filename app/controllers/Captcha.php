<?php
//header("Content-type: image/jpeg");
defined('BASEPATH') OR exit('No direct script access allowed');
/*
бщжЄТы
*/
class Captcha extends ST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('captcha2');
        $this->load->library('session');
        $this->load->helper('url');
    }
    public function index(){

    }
    public function get_code(){
  
    $code = $this->captcha2->getCaptcha();
    $this->session->set_userdata('code', $code);
    $this->captcha2->showImg();
 }
}

?>