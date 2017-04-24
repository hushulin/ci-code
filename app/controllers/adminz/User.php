<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $this->load->library('session');
        $this->load->model('Common');
        if($_SESSION['is_Admin']!==1){
        header('Location: /index.php/'.config_item("admin_").'/login');
        }
    }
	public function index()
	{
     $data['title']="用户管理-后台管理";
     $data['active']="user";
     //$_SESSION['is_Admin']=0;
     if(!empty($_GET['tel'])){
     $sql=" and tel='".$_GET['tel']."'";
     }
     if(!empty($_GET['nickname'])){
     $sql.=" and nickname like '%".$_GET['nickname']."%'";
     }
     if(!empty($_GET['name'])){
     $sql.=" and name like '%".$_GET['name']."%'";
     }
     $page=empty($_GET['page'])?1:$_GET['page'];
     $query=$this->db->query("select user.*,balance.balance,balance.uid,balance.type from st_user as user left join st_balance as balance on user.id=balance.uid where balance.type=1 ".$sql." order by id desc ");
     $data['pages']=ceil($this->db->affected_rows()/10)==0?1:ceil($this->db->affected_rows()/10);
     $query=$this->db->query("select user.*,balance.balance,balance.uid,balance.type from st_user as user left join st_balance as balance on user.id=balance.uid where balance.type=1 ".$sql." order by user.id desc limit ".(($page-1)*10).",10");
     $userlist=$query->result_array();
     $data['userlist']=$userlist;
		$this->load->view(config_item("admin_").'/user',$data);
	}
	public function torecharge(){
	$amount=floatval(trim($_POST['amount']));
	$type=intval(trim($_POST['type']));
	$userid=trim($_POST['uid']);
	if(empty($userid)){
	$data['status']=0;
	$data['msg']="参数错误，刷新页面重试";
	echo json_encode($data);
	exit;
	}
	if(empty($amount)||empty($type)){
	$data['status']=0;
	$data['msg']="请输入金额和充值类型";
	echo json_encode($data);
	exit;
	}
	$query=$this->db->query("select balance from st_balance where type=".$type." and uid=".$userid);
	$balance=$query->row_array()['balance'];
	$balance_data=array(
	'balance'=>$balance+$amount
	);
	$this->db->where('uid',$userid);
	$this->db->where('type',$type);
	if($this->db->update('balance',$balance_data)){
	$r_data['userid']=$userid;
	$r_data['status']=1;
	$r_data['is_human']=1;
	$r_data['amount']=$amount;
	$r_data['actual']=$amount;
	$r_data['time']=time();
	if($type==1){
	$this->db->insert('recharge_log', $r_data);
	}
	$data['status']=1;
	$data['msg']="充值成功";
	echo json_encode($data);
	exit;
	}else{
	$data['status']=0;
	$data['msg']="充值失败,请刷新重试";
	echo json_encode($data);
	exit;
	}
	}
	public function edituser(){
	$data['title']="编辑用户信息-后台管理";
	$userid=trim($_GET['uid']);
	$query=$this->db->query("select * from st_user where id=".$userid);
	$data['user']=$query->row_array();
	$this->load->view(config_item("admin_").'/edituser',$data);
	}
	public function do_saveuser(){
	$uid=trim($_GET['uid']);
	$data=$_POST;
	if(empty($uid)){
	exit;
	}
	$query=$this->db->query("select id from st_user where id=".$uid);
	if($this->db->affected_rows()>0){
	$this->db->where('id',$uid);
	if($this->db->update('user',$data)){
	show_message("更新用户资料成功",'',1);
	}else{
	show_message("更新资料失败，请重试");
	}
	}
	}
	
	public function cashflow(){
	$data['title']="用户资金流水-后台管理";
	$type=empty($_GET['t'])?1:$_GET['t'];
	$data['type']=$type;
	$page=empty($_GET['page'])?1:$_GET['page'];
	
	switch ($type){
	case 1:
  $ptype=empty($_GET['ptype'])?1:$_GET['ptype'];
  $data['ptype']=$ptype;
  $query=$this->db->query("select st_user.*,st_tran_log.* from st_tran_log left join st_user on st_tran_log.userid=st_user.id where ptype=".$ptype." and st_tran_log.userid=".$_GET['uid']." order by st_tran_log.time desc");
  $data['pages']=ceil($this->db->affected_rows()/15)==0?1:ceil($this->db->affected_rows()/10);
  $query=$this->db->query("select st_user.*,st_tran_log.* from st_tran_log left join st_user on st_tran_log.userid=st_user.id where ptype=".$ptype." and st_tran_log.userid=".$_GET['uid']." order by st_tran_log.time desc limit ".(($page-1)*10).",10");
  $data['tranlist']=$query->result_array();
   $query=$this->db->query("select sum(amount) as amount  from st_tran_log where profit>0 and ptype=1 and userid=".$_GET['uid']);
     $t_amount=$query->row_array()['amount'];
     $query=$this->db->query("select sum(profit) as profit from st_tran_log where profit<>0 and ptype=1 and userid=".$_GET['uid']);
     $t_profit=$query->row_array()['profit'];
     $data['transum']=$t_profit-$t_amount;

	break;
	case 2:
	$page=empty($_GET['page'])?1:$_GET['page'];
  $query=$this->db->query("select st_user.*,st_recharge_log.* from st_recharge_log left join st_user on st_recharge_log.userid=st_user.id where st_recharge_log.userid=".$_GET['uid']."  order by st_recharge_log.time desc");
  $data['pages']=ceil($this->db->affected_rows()/15)==0?1:ceil($this->db->affected_rows()/10);
  $query=$this->db->query("select st_user.*,st_recharge_log.* from st_recharge_log left join st_user on st_recharge_log.userid=st_user.id where st_recharge_log.userid=".$_GET['uid']." order by st_recharge_log.time desc limit ".(($page-1)*10).",10");
  $data['rechargelist']=$query->result_array();
  $query=$this->db->query("select sum(st_recharge_log.amount) as amount from st_recharge_log left join st_user on st_recharge_log.userid=st_user.id where st_recharge_log.userid=".$_GET['uid']." order by st_recharge_log.time desc ");
  $data['rechargesum']=$query->row_array()['amount'];
	break;
	case 3:
	$query=$this->db->query("select st_cash_log.*,st_user.* from st_cash_log left join st_user on st_cash_log.uid=st_user.id  where st_cash_log.uid=".$_GET['uid']." order by st_cash_log.time desc");
  $data['pages']=ceil($this->db->affected_rows()/10);
  $page=empty($_GET['page'])?1:$_GET['page'];
  $query=$this->db->query("select st_cash_log.*,st_user.*,st_cash_log.time as ctime,st_user.id as uid,st_cash_log.id as cid from st_cash_log left join st_user on st_cash_log.uid=st_user.id  where st_cash_log.uid=".$_GET['uid']." order by st_cash_log.time desc limit ".(($page-1)*10).",10");
  $data['cashlist']=$query->result_array();
  $query=$this->db->query("select sum(amount) as amount from st_cash_log  where uid=".$_GET['uid']." and status=1 order by time desc");
  $data['cashsum']=$query->row_array()['amount'];
	break;
	case 4:
	$query=$this->db->query("select st_reward_log.*,st_user.* from st_reward_log left join st_user on st_reward_log.userid=st_user.id  where st_reward_log.userid=".$_GET['uid']." order by st_reward_log.time desc");
  $data['pages']=ceil($this->db->affected_rows()/10);
  $page=empty($_GET['page'])?1:$_GET['page'];
  $query=$this->db->query("select st_reward_log.*,st_reward_log.time as rtime,st_user.*,st_user.id as uid,st_reward_log.id as rid from st_reward_log left join st_user on st_reward_log.userid=st_user.id  where st_reward_log.userid=".$_GET['uid']." order by st_reward_log.time desc limit ".(($page-1)*10).",10");
  $data['rewardlist']=$query->result_array();
  $query=$this->db->query("select sum(st_reward_log.reward) as reward from st_reward_log left join st_user on st_reward_log.userid=st_user.id  where st_reward_log.userid=".$_GET['uid']." order by st_reward_log.time desc limit ".(($page-1)*10).",10");
  $data['rewardsum']=$query->row_array()['reward'];
	break;
	case 5:
	$query=$this->db->query("select * from st_user where time<>0 and rpid=".$_GET['uid']);
  $data['pages']=ceil($this->db->affected_rows()/10);
  $page=empty($_GET['page'])?1:$_GET['page'];
  $query=$this->db->query("select * from st_user where time<>0 and rpid=".$_GET['uid']." order by time desc limit ".(($page-1)*10).",10");
  $data['rlist']=$query->result_array();
   /*下属用户盈亏*/
    $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit>0 and st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid'] );
    $t_amount=$query->row_array()['amount'];
    $query=$this->db->query("select sum(st_tran_log.profit) as profit from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit<>0 and st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid']);
    $t_profit=$query->row_array()['profit'];
    $data['allyk']=sprintf('%.2f',$t_profit-$t_amount);  //总盈亏
    $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit>0 and st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m')='".date('Y-m',time())."'");
    $t_amount=$query->row_array()['amount'];
    $query=$this->db->query("select sum(st_tran_log.profit) as profit from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit<>0 and st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m')='".date('Y-m',time())."'" );
    $t_profit=$query->row_array()['profit'];
    $data['allyk_m']=sprintf('%.2f',$t_profit-$t_amount);  //月盈亏
    $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit>0 and st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
    $t_amount=$query->row_array()['amount'];
    $query=$this->db->query("select sum(st_tran_log.profit) as profit from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit<>0 and st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m-%d')='".date('Y-m-d',time())."'" );
   $t_profit=$query->row_array()['profit'];
    $data['allyk_d']=sprintf('%.2f',$t_profit-$t_amount);
    /*交易额*/
    $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid'] );
    $data['allamount']=$query->row_array()['amount'];
    $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where  st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m')='".date('Y-m',time())."'");
    $data['allamount_m']=$query->row_array()['amount'];
    $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where   st_tran_log.ptype=1 and st_user.rpid=".$_GET['uid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
    $data['allamount_d']=$query->row_array()['amount'];
    /**/
	break;
	};
	$this->load->view(config_item("admin_").'/cashflow',$data);
	}
	public function deluser(){
	$uid=trim($_GET['uid']);
	if(empty($uid)){
	exit;
	}
		$this->db->where('id', $uid);
  $this->db->delete('user');
  $this->db->where('uid', $uid);
  $this->db->delete('balance');
  $this->db->where('userid', $uid);
  $this->db->delete('tran_log');
  $this->db->where('uid', $uid);
  $this->db->delete('cash_log');
  $this->db->where('userid', $uid);
  $this->db->delete('reward_log');
  show_message("删除成功","",1);
	}
	
	
}
