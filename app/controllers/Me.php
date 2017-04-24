<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Me extends ST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('Common');
        $this->load->library('session');
        /*登录*/
        if(is_weixin()&&empty($_SESSION['userid'])){
        $this->Common->oauth();
        $_SESSION['isLogin']=1;
        $openid=$this->Common->getOpenid($_GET['code']);
        $_SESSION['userid']=$this->Common->checkopenid($openid,$_GET['code']);
        $this->db->where('id',$_SESSION['userid']);
        $this->db->update('user',array('lastip'=>get_onlineip(),'lasttime'=>time()));
        $this->Common->is_reg($_SESSION['userid']);
        }
        $this->Common->isLogin();
        
        /**/
        $this->Common->lottery();
        $data['ptype']=empty($_GET['t'])?1:intval(trim($_GET['t']));
        if($this->getsetting()['open_virtual']==0&&$data['ptype']==2){
        show_message("虚拟盘已关闭","/");
        }
    }
	public function index()
	{
	/*
    if(empty($_SESSION['userid'])){
        header('Location: /index.php/login');
        exit;
    }
        */
     $data['ptype']=empty($_GET['t'])?1:intval(trim($_GET['t']));
     if($data['ptype']!=1&&$data['ptype']!=2){ //实体虚拟盘
     show_error2("参数错误",500,"提示信息");
     exit;
     }
     $data['title']="个人中心";
     $query=$this->db->query("select * from st_balance where uid=".$_SESSION['userid']." and type=1 limit 1");
     $result=$query->row_array();
     $data['balance1']=$result['balance'];
     $query=$this->db->query("select * from st_balance where uid=".$_SESSION['userid']." and type=2 limit 1");
     $result=$query->row_array();
     $data['balance2']=$result['balance'];
     $data["active"]="me";
     $query=$this->db->query("select * from st_user where id=".$_SESSION['userid']);
     $userinfo=$query->row_array();
     $data['userinfo']=$userinfo;
     if(!empty($userinfo['IDcard'])&&!empty($userinfo['IDcard'])){
     $data['isReal']=true;
     }
     
		$this->load->view('me',$data);
	}
	public function userinfo(){
    $data['title']="个人信息";
    $query=$this->db->query("select * from st_user where id=".$_SESSION['userid']);
     $userinfo=$query->row_array();
     $data['userinfo']=$userinfo;
     if(!empty($userinfo['IDcard'])&&!empty($userinfo['IDcard'])){
     $data['isReal']=true;
     }
    $this->load->view('userinfo',$data);
	}
	public function userreal(){
     $data['title']="实名认证";
     $this->load->view('userreal',$data);
	}
	public function cheakreal(){ //验证实名认证
	$name=trim($_POST['name']);
	$idcard=trim($_POST['idcard']);
	if(!isChineseName($name)){
	$data['status']=0;
	$data['msg']="请填写真实的姓名";
	echo json_encode($data);
	exit;
	}elseif(!isIdCard($idcard)){
	$data['status']=0;
	$data['msg']="请填写正确的身份证号码";
	echo json_encode($data);
	exit;
	}
	$user_data=array(
	'name'=>$name,
	'IDcard'=>$idcard
	);
	$this->db->where("id",$_SESSION['userid']);
	if($this->db->update("user",$user_data)){
	$data['status']=1;
	$data['msg']="认证成功";
	echo json_encode($data);
	}else{
	$data['status']=0;
	$data['msg']="认证失败，请联系客服";
	echo json_encode($data);
	}
	}
	public function editpassword(){
	$data['title']="修改密码";
	$this->load->view('editpassword',$data);
	}
	public function setpassword(){  //修改密码
	$newpassword=$_POST['newpassword'];
	$usedpassword=$_POST['usedpassword'];
	if(empty($usedpassword)){
	$data['status']=0;
	$data['msg']="请输入新密码";
	echo json_encode($data);
	exit;
	}
	if(strlen($newpassword)<6){
	$data['status']=0;
	$data['msg']="密码长度必须大于6位";
	echo json_encode($data);
	exit;
	}
	$query=$this->db->query("select password from st_user where id=".$_SESSION['userid']);
	$password=$query->row_array()['password'];
	if($usedpassword!==$password){
	$data['status']=0;
	$data['msg']="旧密码输入错误";
	echo json_encode($data);
	exit;
	}else{
	$user_data=array('password'=>$newpassword);
	$this->db->where('id',$_SESSION['userid']);
	if($this->db->update('user',$user_data)){
	$data['status']=1;
	$data['msg']="修改密码成功";
	echo json_encode($data);
	exit;
	}else{
	$data['status']=0;
	$data['msg']="密码修改失败，请联系客服";
	echo json_encode($data);
	exit;
	}
	}
	
	}
	public function userset(){
	$data['title']='设置';
	$this->load->view('userset',$data);
	}
	public function recharge(){
	$data['title']='充值中心';
	$query=$this->db->query("select balance from st_balance where type=1 and uid=".$_SESSION['userid']);
	$data['balance']=$query->row_array()['balance'];
	$data['setting']=$this->getsetting();
	$this->load->view('recharge',$data);
	}
	public function torecharge(){
	$amount=trim($_GET['amount']);
	echo $amount;
	}
	public function cash(){
	$query=$this->db->query("select * from st_user where id=".$_SESSION['userid']);
     $userinfo=$query->row_array();
     if(empty($userinfo['IDcard'])||empty($userinfo['IDcard'])){
     show_error2("请先实名认证",'/index.php/me/userreal');
     exit;
     }
     if($userinfo['can_cash']>0){
     show_error2("您的资金流水未达到提现要求，至少还需交易".$userinfo['can_cash']."元才能提现");
     exit;
     }
	$query=$this->db->query("select * from st_user as user left join st_balance as balance on user.id=balance.uid where balance.type=1 and user.id=".$_SESSION['userid']);
	$data['userinfo']=$query->row_array();
	$data['title']='提现';
	$data['cashtimes']=$this->getsetting()['cashtimes'];
	$data['cashmin']=$this->getsetting()['cashmin'];
	$this->load->view('cash',$data);
	}
public function tocash(){
	$amount=$_POST['amount'];
	$code=$_POST['code'];
	$paytype=$_POST['paytype'];
	$alipay=$_POST['alipay'];
	$bankIDcard=$_POST['bankIDcard'];
	$bankname=$_POST['bankname'];
	$query=$this->db->query("select balance from st_balance where type=1 and uid=".$_SESSION['userid']);
	$balance=$query->row_array()['balance'];
	$cashfee=$this->getsetting()['cashfee']/100;
	$this->db->query("select * from st_cash_log where uid=".$_SESSION['userid']." and TO_DAYS(FROM_UNIXTIME( time, '%Y-%m-%d'))=TO_DAYS('".date("Y-m-d",time())."')");
	$cashtimes=$this->db->affected_rows();
	if($code!==$_SESSION['code']){
	$data['status']=0;
	$data['msg']="验证码输入错误";
	show_error2("验证码输入错误");
	//echo json_encode($data);
	exit;
	}
	if($paytype==1){
	if(empty($alipay)){
	show_error2("请支付宝账号");
	}
	$bankname="alipay";
	}
	if($paytype==2){
	if(empty($bankIDcard)){
	show_error2("请输入卡号");
	}
	if(empty($bankname)){
	show_error2("请输入开户银行名称");
	}
	$alipay=$bankIDcard;
	}
	if($amount<=0){
	$data['status']=0;
	$data['msg']="请输入正确的提现金额";
	show_error2("请输入正确的提现金额");
	//echo json_encode($data);
	exit;
	}
	if($amount>$balance){
	$data['status']=0;
	$data['msg']="提现余额不能超过余额";
	show_error2("提现余额不能超过余额");
	//echo json_encode($data);
	exit;
	}
	if($amount<$this->getsetting()['cashmin']){
	$data['status']=0;
	$data['msg']="最小提现额为".$this->getsetting()['cashmin']."元";
	show_error2("最小提现额为".$this->getsetting()['cashmin']."元");
	//echo json_encode($data);
	exit;
	}
	if($cashtimes>=$this->getsetting()['cashtimes'] && $this->getsetting()['cashtimes']!=0){
	$data['status']=0;
	$data['msg']="每天只能提现".$this->getsetting()['cashtimes']."次";
	show_error2("每天只能提现".$this->getsetting()['cashtimes']."次");
	//echo json_encode($data);
	exit;
	}
	$cash_data=array(
	'amount'=>$amount,
	'uid' =>$_SESSION['userid'],
	'fee' =>$cashfee*$amount,
	'time'=>time(),
	'paytype'=>$paytype,
	'alipay'=>$alipay,
	'bankname'=>$bankname
	);
	$balance_data=array(
	'balance'=>$balance-$amount
	);
	$this->db->where('type',1);
	$this->db->where('uid',$_SESSION['userid']);
	$this->db->update('balance',$balance_data);
	if($this->db->insert('cash_log',$cash_data)){
	$data['status']=1;
	$data['msg']="提现成功";
	show_error2("提现成功",'/index.php/me/cashflow?t=1',1);
	//echo json_encode($data);
	exit;
	}
	}
	public function exitlogin(){
	$_SESSION['userid']=0;
	$_SESSION['isLogin']=0;
	header('Location: /');
	}
	public function show(){
	echo "test";
	}
	public function cashflow(){
	$data['t']=empty($_GET['t'])?1:intval(trim($_GET['t']));
	$data['title']="资金流水";
	$query=$this->db->query("select * from st_user where id=".$_SESSION['userid']);
  $data['userinfo']=$query->row_array();
  $query=$this->db->query("select * from st_balance where uid=".$_SESSION['userid']." and type=1 limit 1");
  $result=$query->row_array();
  $data['balance1']=$result['balance'];
  $query=$this->db->query("select * from st_balance where uid=".$_SESSION['userid']." and type=2 limit 1");
  $result=$query->row_array();
  $data['balance2']=$result['balance'];
  $query=$this->db->query("select sum(amount) as amount from st_recharge_log where userid=".$_SESSION['userid']." and status=1");
  $data['rechargetotal']=$query->row_array()['amount'];
  $query=$this->db->query("select sum(amount) as amount from st_cash_log where uid=".$_SESSION['userid']." and status=1");
  $data['cashtotal']=$query->row_array()['amount'];
	$this->load->view('cashflow',$data);
	}
	public function tranlog(){
	$data['title']="交易记录";
	$data['ptype']=empty($_GET['t'])?1:intval(trim($_GET['t']));
	$query=$this->db->query("select * from st_user as user left join st_balance as balance on user.id=balance.uid where balance.type=1 and user.id=".$_SESSION['userid']);
	$data['userinfo']=$query->row_array();
	$query=$this->db->query("select * from st_balance where uid=".$_SESSION['userid']." and type=1 limit 1");
  $result=$query->row_array();
  $data['balance1']=$result['balance'];
  $query=$this->db->query("select * from st_balance where uid=".$_SESSION['userid']." and type=2 limit 1");
  $result=$query->row_array();
  $data['balance2']=$result['balance'];
  $query=$this->db->query('select sum(amount) as amount,count(*) as count from st_tran_log where userid='.$_SESSION['userid'].' and ptype='.$data['ptype']);
  $data['amount']=$query->row_array()['amount'];
  $data['count']=$query->row_array()['count'];
  $query=$this->db->query('select sum(profit) as amount,count(*) as count from st_tran_log where userid='.$_SESSION['userid'].' and ptype='.$data['ptype'].' and profit>0 and TO_DAYS(FROM_UNIXTIME(time))=TO_DAYS(now())');
  $data['dayamount']=$query->row_array()['amount'];
  $query=$this->db->query('select sum(amount) as amount,count(*) as count from st_tran_log where userid='.$_SESSION['userid'].' and ptype='.$data['ptype'].' and profit<>0 and TO_DAYS(FROM_UNIXTIME(time))=TO_DAYS(now())');
  $data['daycount']=$query->row_array()['count'];
  $query=$this->db->query('select t.*,s.* from st_tran_log as t left join st_type_setting as s on t.type=s.nickname where t.userid='.$_SESSION['userid'].' and t.ptype='.$data['ptype'].' and t.profit<>0 order by endtime desc');
  $data['list']=$query->result_array();
  if(empty($data['count'])){
  $data['count']="0";
  }
  if(empty($data['daycount'])){
  $data['daycount']="0";
  }
  if(empty($data['amount'])){
  $data['amount']="0.00";
  }
  if(empty($data['dayamount'])){
  $data['dayamount']="0.00";
  }
	$this->load->view('tranlog',$data);
	}
}
