<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends ST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    
    public function index(){
    
    $this->load->view('login');
    }
    public function do_login(){
    $username=@$_POST['username'];
    $password=@$_POST['password'];
    if(strlen($username)!=11){
    echo "301"; //ÊÖ»úºÅÂë´íÎó
    exit;
    }
    if(strlen($password)<6){
    echo "201";  //ÃÜÂë´íÎó
    exit;  
    }
    $this->db->where("tel",$username);
    $this->db->where("password",$password);
    $this->db->from('user');
    $query=$this->db->count_all_results();
    
    if($query<1){
    echo "101"; //ÕËºÅ»òÃÜÂë´íÎó
    exit;
    }else{
    $_SESSION['isLogin']=1;
   
    $query=$this->db->query("select * from st_user where tel='".$username."' and password='".$password."'");
    $userinfo=$query->result();
    $_SESSION['userid']=$userinfo[0]->id;
    $this->db->where('id',$_SESSION['userid']);
    $this->db->update('user',array('lastip'=>get_onlineip(),'lasttime'=>time()));
    echo "001"; //µÇÂ¼³É¹¦
    
    exit;
    }
    }
    
    }


?>