<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include "aliyu/TopSdk.php";
    date_default_timezone_set('Asia/Shanghai'); 
class Register extends ST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    public function index(){
    if(!empty($_SESSION['userid'])){
    $query=$this->db->query("select * from st_user where id=".$_SESSION['userid']);
     $userinfo=$query->row_array();
     if(!empty($userinfo['tel'])&&!empty($userinfo['password']))
     {
     header('Location:/');
     exit;
     }
     }
   $data['userinfo']=$userinfo;
    
    $this->load->view('register',$data);
    }
     private function getverifyCode(){
        //随机生成一个4位数的数字验证码
        $num="";
        for($i=0;$i<4;$i++){
            $num .= rand(0,9);
        }
        return $num;
    }
    public function cphone(){    //验证手机号码
    $phone=$_POST['phone'];
    $pin=$this->getverifyCode();
    $_SESSION['pin'] = $pin;
    $_SESSION['phone'] = $_POST['phone'];
   $c = new TopClient;
$c->appkey = "23642979";
$c->secretKey = "6a03f6a7c29d8cf8715da9f3852e3472";
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req->setExtend("123456");
$req->setSmsType("normal");
$req->setSmsFreeSignName("恒益在线");
$req->setSmsParam("{\"code\":\"{$pin}\",\"product\":\"恒益在线\"}");
$req->setRecNum($phone);
$req->setSmsTemplateCode("SMS_47935161");
$resp = $c->execute($req);
echo 1;
    }
    public function do_post(){
    $tel=@$_POST['tel'];//手机号码
    $password=@$_POST['password'];//密码
    $code=@$_POST['code'];
    $pin=@$_POST['pin'];
    $rpid=@$_POST['rpid'];
    $time=time();
    
     if($pin!=$_SESSION['pin']||$_SESSION['phone']!=$tel){
   echo "601"; //手机号验证码错误
    exit;
    }
    if(!empty($rpid)){
    $query=$this->db->query("select * from st_user where id=".$rpid);
    $r=$query->result_array();
    if(!$r){
    echo "901"; //不存在该邀请用户
    exit;
    }
    }
    if(strlen($tel)!=11){
    echo "301"; //手机号码错误
    exit;
    }
    if(strlen($password)<6){
    echo "201"; //密码错误
    exit;
    }
    if($code!=$_SESSION['code']){
    echo "401"; //验证码错误
    exit;
    }
    $this->db->where("tel",$tel);
    $this->db->from('user');
    $query=$this->db->count_all_results();
    
    if($query>0){
    echo "501"; //手机已存在
    exit;
    }

    $setting=$this->getsetting();

    $data = array(
    'tel' => $tel,
    'password'=>$password,
    'time'=> time()
    );
    
    
    if(!empty($rpid)){
    $data['rpid']=$rpid;
    }

     
    if(!empty($_SESSION['userid'])){
    
    $newuid = $_SESSION['userid'];
    $this->db->where('id',$newuid);
    $this->db->update('user',$data);
    $balance1=array(
    'type' => 1,
    'uid' => $newuid,
    'balance' =>$setting['s_entity']
    );
    $balance2=array(
    'type' => 2,
    'uid' => $newuid,
    'balance' =>$setting['s_virtual']
    );
    $this->db->insert('balance',$balance1);
    $this->db->insert('balance',$balance2);
    $_SESSION['userid']=$newuid;
    echo "001";
    }else{
    $data['avatar']="/images/avatar_default.png";
    $data['nickname']="路人甲";
    $data['time']=time();
    if($this->db->insert('user',$data)){
    $newuid = $this->db->insert_id();
    $balance1=array(
    'type' => 1,
    'uid' => $newuid,
    'balance' =>$setting['s_entity']
    );
    $balance2=array(
    'type' => 2,
    'uid' => $newuid,
    'balance' =>$setting['s_virtual']
    );
    $this->db->insert('balance',$balance1);
    $this->db->insert('balance',$balance2);
    $_SESSION['userid']=$newuid;
    echo "001";
    }else{
    echo "002";
    }
    }
    

    }
}

?>