<?php
header('Content-type:text/json');
//header('Content-type: text/javascript');
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Shanghai");
class Confirmbuy extends ST_Controller {
 public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Common');
        if($_SESSION['isLogin']==0){
        echo "未登陆";
        exit;
        }
        
    }
	public function index()
	{
	$data=$_POST;
	//$_SESSION['isLogin']=0;
	$data['userid']=$_SESSION["userid"];
	//$time=strtotime(date("Y-m-d H:i:s",strtotime("-5 second")));
	$query=$this->db->query("select * from st_type_setting where nickname='".$data['type']."'");
	$result=$query->result_array();
	if($result[0]['is_rest']==1){
	$r_data['status']=0;
	$r_data['msg']="该资产已休市";
	echo json_encode($r_data);
	exit;
	}elseif($result[0]['is_close']==1){
	$r_data['status']=0;
	$r_data['msg']="该资产已关闭";
	echo json_encode($r_data);
	exit;
	}
	
	$query=$this->db->query("select * from st_balance where type=".$data['ptype']." and uid=".$_SESSION['userid']);
	$result=$query->result_array();
	$balance=$result[0]['balance'];
  if($balance<floatval($data['amount']+($data['amount']*0.02))){
	$r_data['status']=0;
	$r_data['msg']="余额不足，请先充值";
	echo json_encode($r_data);
	exit;
	}
	if($data['amount']<$this->getsetting()['minbuy']){
	$r_data['status']=0;
	$r_data['msg']="金额必须".$this->getsetting()['minbuy']."元起";
	echo json_encode($r_data);
	exit;
	}
	$ptype=$data['ptype'];
	$balance_data=array(
    'balance'=>$balance-($data['amount']+($data['amount']*0.02))
	);
	$this->db->where('type', $ptype);
	$this->db->where('uid', $_SESSION['userid']);
	if(!$this->db->update('balance', $balance_data)){
	$r_data["status"]=0;
	$r_data["msg"]="未知错误,请联系客服";
	exit;
	}else{
	$r_data['balance']=$balance-($data['amount']+($data['amount']*0.02));
	if($this->getsetting()['rewardtype']==1&&$data['ptype']==1){
	$this->Common->brandingreward($_SESSION['userid'],$data['amount'],'交易');
	}
	if($ptype==1){
	$query=$this->db->query("UPDATE st_user SET can_cash=if(can_cash-".$data['amount']."<0,0,can_cash-".$data['amount'].") where id=".$_SESSION['userid']);
	}
	}
	$time=time();
	$data['time']=$time;
	$data['endtime']=strtotime(date("Y-m-d H:i:s",$time)." +".$data['timetype']." second");
	$query=$this->db->query("select * from st_type where type='".$data['type']."' order by time desc limit 1");
	
	$result=$query->result_array();
	switch($result[0]['type'])
	{
	case 'btc':$temp=2;break;
	case 'XAUUSD':$temp=2;break;
	case 'USOil':$temp=2;break;
	case 'EURUSD':$temp=5;break;
	case 'USDJPY':$temp=3;break;
	case 'GBPUSD':$temp=5;break;
	case 'XAGUSD':$temp=3;break;
	}
	$data['price']=sprintf('%.'.$temp.'f',$result[0]['price']);
	if($data['price']==0){
	$r_data["status"]=0;
	$r_data["msg"]="发生错误,请重试";
	exit;
	}
	$time=$result[0]['time'];
	$this->db->insert('tran_log',$data);
	$newid=$this->db->insert_id();
	if($newid){
	$r_data['status']=1;
	$r_data['id']=$newid;
	$r_data['msg']="Success";
	$r_data['time']=$time;
	$r_data['times']=date("H:i:s",$time);
	$r_data['amount']=$_POST['amount'];
	$r_data['type']=$this->Common->getTypename($_POST['type']);
	$r_data['direction']=intval($_POST['direction'])==1?"买跌":"买涨";
	$r_data['timetype']=$_POST['timetype'];
	$r_data['price']=$data['price'];
	$r_data['ptype']=$data['ptype'];
	echo json_encode($r_data);
	}else{
	//输出错误
	$r_data['status']=0;
	$r_data['msg']="购买失败";
	echo json_encode($r_data);
	}
	}
	public function getresult(){  //获取揭晓结果
	$id=$_GET['id'];
	if(empty($id)){
	exit;
	}
	$query=$this->db->query("select * from st_tran_log where id=".$id." and userid=".$_SESSION['userid']." order by time desc limit 1");
	$result=$query->result_array();  //交易记录

	
  $timetype=$result[0]['timetype'];
	$query=$this->db->query("select * from st_balance where type=".$result[0]['ptype']." and uid=".$_SESSION['userid']);
	$b_result=$query->result_array();
	$balance=$b_result[0]['balance']; //查询余额
  if($result[0]['profit']!=0){
  $data['status']=1; 
	$data['win']=$result[0]['status'];
	$data['profit']=$result[0]['profit'];
	$data['balance']=$balance; //返回当前余额
	$data['lastprice']=$result[0]['lastprice'];
	exit;
	}
	
	if(strtotime("+".($result[0]['timetype'])." second",$result[0]['time'])<=time()){
	$data['status']=1;  //已经揭晓
	$winpro=$result[0]['ptype']==1?$this->getsetting()['shiwin']:$this->getsetting()['xuwin'];
	$query=$this->db->query("select * from st_type where type='".$result[0]['type']."' and time<=".strtotime("+".($result[0]['timetype'])." second",$result[0]['time'])." order by time desc limit 1"); 
	$typeresult=$query->result_array();// 查询结束时间价格
	
	if($winpro!=0&&abs($typeresult[0]['price']-$result[0]['price'])<50){  //按照设定的概率

	if($typeresult[0]['price']==$result[0]['price']){
	$is_ping=true;
	}else{
	$is_ping=false;
	}
	$rand=rand(1,100);
	/*
	if(($result[0]['direction']==2&&$typeresult[0]['price']>$result[0]['price'])||($result[0]['direction']==1&&$typeresult[0]['price']<$result[0]['price'])){
	
	}else{
	$rand=1000;
	}
	*/
	$data['rand']=$rand;
	if($rand<=$winpro){  //中奖
	$timetype=$result[0]['timetype'];
	$query=$this->db->query("select profit from st_timetype where time=".$timetype);
	$profit=$query->row_array()['profit'];
	$data['win']=1;
	$data['profit']=sprintf('%.2f',$result[0]['amount']+(($profit/100)*$result[0]['amount']));  //获利
	$balance_data=array(
	'balance' => $balance+$data['profit']
	);
	$this->db->where('type', $result[0]['ptype']);
	$this->db->where('uid', $_SESSION['userid']);
	$this->db->update('balance', $balance_data);
	$data['balance']=$balance_data['balance'];
	}elseif($is_ping==true){  //百分之0.5平局
	$data['win']=0;
	$data['startprice']=$result[0]['price'];
	$data['endprice']=$result[0]['price'];
	$data['profit']=$result[0]['amount'];	
	$balance_data=array(
	'balance' => $balance+$data['profit']
	);
	$this->db->where('type', $result[0]['ptype']);
	$this->db->where('uid', $_SESSION['userid']);
	$this->db->update('balance', $balance_data);
	$data['balance']=$balance_data['balance']; //返回当前余额
	//平局不增不减
	}else{   //未中奖
	$data['win']=-1;
	$data['profit']=sprintf('%.2f',0-$result[0]['amount']);
	$data['balance']=$balance; //返回当前余额
	}
	$temp=explode('.',$result[0]['price']);
	
	if($temp[1]){
	$temp=strlen($temp[1]);
	}else{
	$temp=0;
	}
	switch($result[0]['type'])
	{
	case 'btc':$temp=2;$o=50;break;
	case 'XAUUSD':$temp=2;$o=50;break;
	case 'USOil':$temp=2;$o=50;break;
	case 'EURUSD':$temp=5;$o=20;break;
	case 'USDJPY':$temp=3;$o=20;break;
	case 'GBPUSD':$temp=5;$o=30;break;
	case 'XAGUSD':$temp=3;$o=30;break;
	}
	$xiaoshu=floatval(sprintf("%0.".($temp-1)."f",0)."1");
	$zrand=rand(1,5);
	$h_price=$xiaoshu*rand(1,$o);
	if(explode('.',$result[0]['price'])[1]==0){
	//$h_price=floatval(sprintf("%0.".($temp-1)."f",0).rand(1,9));
	}
	$query=$this->db->query("select * from st_type where type='".$result[0]['type']."' and price<".$result[0]['price']." order by time desc limit 1"); 
	$last=$query->row_array();// 查询少于价格
	$shao=$last['price'];
	$query=$this->db->query("select * from st_type where type='".$result[0]['type']."' and price>".$result[0]['price']." order by time desc limit 1"); 
	$last=$query->row_array();// 查询多于价格
	$duo=$last['price'];
	$query=$this->db->query("select * from st_type where type='".$result[0]['type']."' and price<>0 and time<=".strtotime("+".($result[0]['timetype'])." second",$result[0]['time'])." order by time desc limit 1"); 
	$typeresult=$query->row_array();// 查询结束时间价格
	if(($result[0]['direction']==2&&$data['win']==1)||($result[0]['direction']==1&&$data['win']==-1)){
	$lastprice=sprintf('%.'.$temp.'f',$result[0]['price']+$h_price);
	//$lastprice=$duo;
	if($typeresult['price']>$result[0]['price']){
	$lastprice=sprintf('%.'.$temp.'f',$typeresult['price']);
	}
	$data['info']=$result[0]['direction']."|".$data['win']."|".$h_price;
	}elseif($data['win']==0){
	$lastprice=sprintf('%.'.$temp.'f',$result[0]['price']);
	}else{
	$lastprice=sprintf('%.'.$temp.'f',$result[0]['price']-$h_price);
	//$lastprice=$shao;
	if($typeresult['price']<$result[0]['price']){
	$lastprice=sprintf('%.'.$temp.'f',$typeresult['price']);
	}
	
	}
	$data['lastprice']=$lastprice;   //最后价格
	}else{  //不干预
	$query=$this->db->query("select * from st_type where type='".$result[0]['type']."' and time<=".strtotime("+".($result[0]['timetype'])." second",$result[0]['time'])." order by time desc limit 1"); 
	$typeresult=$query->result_array();// 查询结束时间价格
	if(($result[0]['direction']==2&&$typeresult[0]['price']>$result[0]['price'])||($result[0]['direction']==1&&$typeresult[0]['price']<$result[0]['price'])){  //中奖
	$query=$this->db->query("select profit from st_timetype where time=".$timetype);
	$profit=$query->row_array()['profit'];
	$data['win']=1;
	$data['profit']=sprintf('%.2f',$result[0]['amount']+(($profit/100)*$result[0]['amount']));  //获利
	$balance_data=array(
	'balance' => $balance+$data['profit']
	);
	$this->db->where('type', $result[0]['ptype']);
	$this->db->where('uid', $_SESSION['userid']);
	$this->db->update('balance', $balance_data);
	$data['balance']=$balance_data['balance'];
	}elseif($typeresult[0]['price']==$result[0]['price']){   //平局
	$data['win']=0;
	$data['startprice']=$result[0]['price'];
	$data['endprice']=$result[0]['price'];
	$data['profit']=$result[0]['amount'];	
	$balance_data=array(
	'balance' => $balance+$data['profit']
	);
	
	$this->db->where('type', $result[0]['ptype']);
	$this->db->where('uid', $_SESSION['userid']);
	$this->db->update('balance', $balance_data);
	$data['balance']=$balance_data['balance']; //返回当前余额
	//平局不增不减

	}else{
	$data['win']=-1;
	$data['profit']=sprintf('%.2f',0-$result[0]['amount']);
	$data['balance']=$balance; //返回当前余额
	/*
	$balance_data=array(
	'balance' => $balance+$data['profit']
	);
	$this->db->where('type', $result[0]['ptype']);
	$this->db->where('uid', $_SESSION['userid']);
	$this->db->update('balance', $balance_data);
	//购买已扣余额
	*/
	
	}
	switch($typeresult[0]['type'])
	{
	case 'btc':$temp=2;break;
	case 'XAUUSD':$temp=2;break;
	case 'USOil':$temp=2;break;
	case 'EURUSD':$temp=5;break;
	case 'USDJPY':$temp=3;break;
	case 'GBPUSD':$temp=5;break;
	case 'XAGUSD':$temp=3;break;
	}
	$data['lastprice']=sprintf('%.'.$temp.'f',$typeresult[0]['price']);
	}//
	
	$updata = array(
    'lastprice' => $data['lastprice'],
    'status' => $data['win'],
    'profit' => $data['profit']
);
  $this->db->where('id', $id);
  $this->db->update('tran_log', $updata);
	echo json_encode($data);
	
	}else{
	$data['status']=0;
	$data['start']=date("Y-m-d H:i:s",$result[0][time]);
	$data['end']=date("Y-m-d H:i:s",strtotime("+".($result[0][timetype])." second",$result[0][time]));
	$data['now']=date("Y-m-d H:i:s",time());
	echo json_encode($data);
	}
}
}
?>