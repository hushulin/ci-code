<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="wap-font-scale" content="no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title><?php echo $title;?></title>
	<link href="/images/favicon218877.ico" rel="Shortcut Icon">
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <script src="/js/jquery-1.11.3.min.js"></script>
</head>
  <style>
  *{
  font-family:'Microsoft YaHei';
  }
  body{
  margin:0px;
  padding:0;
  font-size:12px;
  }
  .row{
  margin:0px;
  }
  .content{
  margin-left:100px;
  float:left;
  }
  .form-group{
  padding-bottom:30px;
  }
  .media-list li{
  border-bottom:1px solid #eee;
  padding-bottom:10px;
  }
  .panel{
  margin-top:15px;
  }
  </style>
  <body>
  <div style="min-width:1080px;">
  <?php include 'header.php';?>
  <div class="row">
  <?php include 'theme/'.config_item("admin_").'/nav.php';?>
  <div class="content">
  <div style="width:800px;margin:0 auto;">
  <center>
 <div class="btn-group">
  <button type="button" onclick="location.href='?uid=<?php echo $_GET['uid'];?>&t=1'" class="btn btn-default <?php if($type==1){echo "active";}?>">交易记录(实)</button>
  <button type="button" onclick="location.href='?uid=<?php echo $_GET['uid'];?>&t=2'" class="btn btn-default <?php if($type==2){echo "active";}?>">充值记录</button>
  <button type="button" onclick="location.href='?uid=<?php echo $_GET['uid'];?>&t=4'" class="btn btn-default <?php if($type==4){echo "active";}?>">推广记录</button>
  <button type="button" onclick="location.href='?uid=<?php echo $_GET['uid'];?>&t=5'" class="btn btn-default <?php if($type==5){echo "active";}?>">好友列表</button>
  <button type="button" onclick="location.href='?uid=<?php echo $_GET['uid'];?>&t=3'" class="btn btn-default <?php if($type==3){echo "active";}?>">提现记录</button>
  </div>
  </center> 
  <?php if($type==1){ ?>
  <div class="pull-right">总额：￥<b><?php echo $transum;?></b>（正数为用户所赢）</div>
  <!--交易记录-->
   <table class="table">
   <thead>
          <tr>
            <th>用户</th>
            <th>资产类型</th>
            <th>涨跌</th>
            <th>选择时间</th>
            <th>购买时间</th>
            <th>金额</th>
            <th>盈利情况</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($tranlist as $list){ ?>
        <tr>
        <td><a href="../user/edituser?uid=<?php echo $list['userid'];?>"><?php echo empty($list['nickname'])?$list['tel']:$list['nickname'];?></a></td>
        <td><?php echo $this->Common->getTypename($list['type']);?></td>
        <td><?php echo $list['direction']==1?'跌':'涨';?></td>
        <td><?php echo $list['timetype'];?> 秒</td>
        <td><?php echo date("Y-m-d H:i:s",$list['time']);?></td>
        <td>￥<?php echo $list['amount'];?></td>
        <td><?php if($list['status']==-1){echo '亏';}elseif($list['status']==1){echo '盈';}else{echo '平';};?></td>
        </tr>
        <?php } ?>
        </tbody>
  </table>
    <!--/交易记录-->
 <?php }elseif($type==2){  ?>
  <div class="pull-right">总额：￥<b><?php echo $rechargesum;?></b></div>
<!--充值记录-->
   <table class="table">
   <thead>
          <tr>
            <th>用户</th>
            <th>充值金额</th>
            <th>到账金额</th>
            <th>微信交易号</th>
            <th>是否人工充值</th>
            <th>充值时间</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($rechargelist as $list){ ?>
        <tr>
        <td><a href="../user/edituser?uid=<?php echo $list['userid'];?>"><?php echo empty($list['nickname'])?$list['tel']:$list['nickname'];?></a></td>
        <td><?php echo $list['amount'];?></td>
        <td><?php echo $list['actual'];?></td>
        <td><?php echo $list['transaction_id'];?></td>
        <td><?php echo $list['is_human']==1?"后台充值":"微信支付";?></td>
        <td><?php echo date("Y-m-d H:i:s",$list['time']);?></td> 
        </tr>
        <?php } ?>
        </tbody>
  </table>
    <!--/充值记录-->
 <?php }elseif($type==3){ ?>
 <div class="pull-right">总额：￥<b><?php echo $cashsum;?></b></div>
  <!--提现记录-->
   <table class="table">
   <thead>
          <tr>
            <th>用户名</th>
            <th>oid</th>
            <th>金额</th>
            <th>手续费</th>
            <th>实际到账</th>
            <th>申请时间</th>
            <th>状态</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($cashlist as $list){ ?>
        <tr>
        <td><a href="../user/edituser?uid=<?php echo $list['uid'];?>"><?php echo empty($list['nickname'])?$list['tel']:$list['nickname'];?></a></td>
        <td><?php echo $list['openid'];?></td>
        <td><?php echo $list['amount'];?></td>
        <td><?php echo $list['fee'];?></td>
        <td><?php echo $list['amount']-$list['fee'];?></td>
        <td><?php echo date('Y-m-d H:i:s',$list['ctime']);?></td>
        <td <?php if($list['status']==-1){ ?>style="color:#d9534f">拒绝<?php }elseif($list['status']==1){ ?>>通过<?php }else{ ?>>待审<?php };?></td>
        </tr>
        <?php } ?>
  </table>
    <!--/提现记录-->
 <?php }elseif($type==4){ ?>
 <div class="pull-right">总额：￥<b><?php echo $rewardsum;?></b></div>
    <!--推广记录-->
   <table class="table">
   <thead>
          <tr>
            <th>用户名</th>
            <th>来自用户</th>
            <th>来自金额</th>
            <th>奖励金额</th>
            <th>关系</th>
            <th>行为</th>
            <th>奖励时间</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($rewardlist as $list){ ?>
        <tr>
        <td><a href="../user/edituser?uid=<?php echo $list['uid'];?>"><?php echo empty($list['nickname'])?$list['tel']:$list['nickname'];?></a></td>
        <td><a href="../user/edituser?uid=<?php echo $list['from_uid'];?>"><?php echo $list['from_uid'];?></a></td>
        <td><?php echo $list['amount'];?></td>
        <td><?php echo $list['reward'];?></td>
        <td><?php echo $list['stage'];?>级</td>
        <td><?php echo $list['msg'];?></td>
        <td><?php echo date('Y-m-d H:i:s',$list['rtime']);?></td>
        </tr>
        <?php } ?>
  </table>
    <!--/推广记录-->
     <!--/推广记录-->
 <?php }elseif($type==5){ ?>
 <!--好友列表-->
 <br />
 <div class="pull-right">总交易：￥<b><?php echo $allamount;?></b>&nbsp;|&nbsp;月交易：￥<b><?php echo $allamount_m;?></b>&nbsp;|&nbsp;今日交易：￥<b><?php echo $allamount_d;?></b>&nbsp;|&nbsp;总盈亏：￥<b><?php echo $allyk;?></b>&nbsp;|&nbsp;月盈亏：￥<b><?php echo $allyk_m;?></b>&nbsp;|&nbsp;今日盈亏：￥<b><?php echo $allyk_d;?></b></div>
   <table class="table">
   <thead>
          <tr>
           <th>手机号</th>
            <th>用户名</th>
            <th>余额</th>
            <th>总交易</th>
            <th>今日交易</th>
            <th>注册时间</th>
    
          </tr>
        </thead>
        <tbody>
        <?php foreach($rlist as $list){ ?>
        <tr>
        <td><a href="../user/edituser?uid=<?php echo $list['id'];?>"><?php echo $list['tel'];?></a></td>
        <td><?php echo $list['nickname'];?></td>
        <td><?php $query=$this->db->query('select * from st_balance where type=1 and uid='.$list['id']);
        echo $query->row_array()['balance'];
        ?></td>
        <td><?php $query=$this->db->query('select sum(amount) as amount from st_tran_log where ptype=1 and userid='.$list['id']);
        echo $query->row_array()['amount'];
        ?></td>
            <td><?php $query=$this->db->query("select sum(amount) as amount from st_tran_log where ptype=1 and userid=".$list['id']." and  DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
        echo empty($query->row_array()['amount'])?'0.00':$query->row_array()['amount'];
        ?></td>
        <td><?php echo date("Y-m-d H:i:s",$list['time']);?></td>
        </tr>
        <?php } ?>
         </tbody>
        </table> 
 <?php } ?>
<?php getPageHtml(empty($_GET['page'])?1:$_GET['page'],$pages,"/index.php/".config_item("admin_")."/user/cashflow?t=".$type."&uid=".$_GET['uid']);?>
   
  </div>
</div>
</div>
</div>
  </body>
  </html>