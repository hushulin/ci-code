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
	<link rel="stylesheet" href="/css/weui.min.css" />
	<script src="/js/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<style>
*{
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    -webkit-touch-callout: none;
}
body{
    background:#fff;
    -webkit-font-smoothing: antialiased;
}
span.recharge-total{
float:left;
margin-left:10px;
color:#fff;
}

span.cash-total{
float:right;
margin-right:10px;
color:#fff;
}
th,td{
  text-align:center;
  font-weight:100;
  font-size:12px;
}
.table>thead>tr>th{
border-bottom: 0px;
padding:10px 0px;
}
.table>tbody>tr>td{
border-top: 1px solid #eee;
}
</style>
  <body>
  <section class="jz-wrapper jz-null-bottom">
  <div class="jz-head">
    <a href="###" id="account_icon_btn" class="pos-left head-show jz-my_head">
    <img src="<?php echo $userinfo['avatar'];?>" width="33" height="33" alt="">
    </a>
<span><?php echo $userinfo['nickname'];?> </span>
<!--<a href="/index.php/me/tranlog?t=<?php echo $ptype==1?'2':'1';?>" id="screen" class="font-sm pos-right"><?php echo $ptype==1?'切换模拟盘':'切换实盘';?></a>-->
</div>
  <div class="account-top-view text-center">
        <p class="font-sm">余额(元)</p>
        <p class="account-total" ><?php echo $balance1;?></p>
        <span class="recharge-total" style="text-align:left"><p>今日交易：<?php echo $daycount;?>笔</p><p>今日盈利：<?php echo sprintf("%.2f",$dayamount);?>元</p></span>
        <span class="cash-total" style="text-align:left"><p>累计交易：<?php echo $count;?>笔</p><p>累计流水：<?php echo sprintf("%.2f",$amount);?>元</p></span>
    </div>
    
  <div class="water">
<div class="water-1"></div>
<div class="water-2"></div>
</div>

      <table class="table">
        <thead>
          <tr>
            <th>到期时间</th>
            <th>资产类型</th>
            <th>涨/跌</th>
            <th>买入金额</th>
            <th>盈利情况</th>
            <th>订单状态</th>
          </tr>
        </thead>
        <tbody>
         <?php foreach($list as $row){ ?>
         <tr>
         <td><?php echo date('m-d H:i:s',$row['endtime']);?></td>
         <td><b><?php echo $row['name'];?></b></td>
         <td><b><?php echo $row['direction']==1?'买跌':'买涨';?><b></td>
         <td><?php echo $row['amount'];?></td>
         <?php 
         if($row['status']==0){
         $status="平局";
         }elseif($row['status']==1){
          $status="<font color=red>盈利</font>";
         }else{
         $status="<font color=green>亏损</font>";
         }
         if($row['profit']==0){
         $profit="平局";
         }elseif($row['profit']>0){
          $profit='<font color=red>+'.sprintf('%.2f',$row['profit']).'</font>';
         }else{
         $profit='<font color=green>'.sprintf('%.2f',$row['profit']).'</font>';
         }
         ?>
         <td><?php echo $profit;?></td>
         
         <td><?php echo $status;?></td>
         </tr>
         <?php } ?>
        </tbody>
      </table>
</section>
  </body>
  <?php include "bottombar.php" ?>
 </html>
	