<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if($_SESSION['is_Admin']==1){
        header('Location: /index.php/'.config_item("admin_"));
        }
    }
    
    public function index(){

    $this->load->view(config_item("admin_").'/login');
    
    }
    
    public function do_login(){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $verify_code=$_POST['verify_code'];
    
    if(empty($verify_code)){
    show_message("请输入验证码");
    }elseif(empty($username)){
    show_message("请输入用户名");
    }elseif(empty($password)){
    show_message("请输入密码");
    }
    
  if($verify_code==$_SESSION['code']){
    $query=$this->db->query("select * from st_admin where username='".$username."' and password='".md5($password)."'");
    $result=$query->result_array();
    if($result[0]){
    $_SESSION['adminid']=$result[0]['id'];
    $_SESSION['is_Admin']=1;
    $ip=get_onlineip();
    $data = array(
    'lastip' => $ip,
    'lasttime' => time()
);
    $this->db->where('id', $result[0]['id']);
    $this->db->update('st_admin', $data);
    show_message("登录成功","/index.php/".config_item("admin_"),1);
    }else{
    show_message("登录失败，用户名或密码错误");
    }
    }else{
    show_message("验证码输入错误");
    }
    }
   }


?>