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
<a href="/index.php/me/recharge" id="screen" class="font-sm pos-right">充值</a>
</div>
  <div class="account-top-view text-center">
        <p class="font-sm">余额(元)</p>
        <p class="account-total"><?php echo $balance1;?></p>
        <span class="recharge-total" >累计充值：<?php echo empty($rechargetotal)?'0.00':sprintf("%.2f",$rechargetotal);?></span>
        <span class="cash-total" >累计提现：<?php echo empty($cashtotal)?'0.00':sprintf("%.2f",$cashtotal);?></span>
    </div>
    
  <div class="water">
<div class="water-1"></div>
<div class="water-2"></div>
</div>
<div class="me-btn-group">
      <button class="c-btn-default pull-left <?php if($t==1){ ?>btn-red<?php } ?>" style="margin-left:5%;" onclick="moveactive($(this));getrecharge()">充值记录</button><button class="c-btn-default pull-right <?php if($t==2){ ?>btn-red<?php } ?>" style="margin-right:5%;" onclick="moveactive($(this));getcash()">提现记录</button>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>类型</th>
            <th>金额</th>
            <th>时间</th>
            <th>状态</th>
          </tr>
        </thead>
        <tbody>
         
        </tbody>
      </table>
</section>
<script>
function moveactive(obj){
  $(".me-btn-group button").removeClass('btn-red');
  obj.addClass("btn-red"); 
}
<?php if($t==1){ ?>
getrecharge();
<?php }else{ ?>
getcash();
<?php } ?>
function getrecharge()   //获取最新充值
  {
  $.getJSON("/index.php/getk/myrecharge",function(data){
  result=eval(data);
  var html="";
  result.forEach(function(e){
  html+='<tr><td>微信充值</td><td>'+e.amount+'</td><td>'+e.time+'</td><td>成功</td></tr>'
  $(".table tbody").html(html);
  })
  });
  }
  function getcash()   //获取最新提现
  {
  $.getJSON("/index.php/getk/mycash",function(data){
  result=eval(data);
  var html="";
  result.forEach(function(e){
  switch(parseInt(e.status)){
  case 0:
  status="审核中";
  break;
  case 1:
  status="已完成";
  break;
  case -1:
  status="失败";
  break;
  }
  html+='<tr><td>提现</td><td>'+e.amount+'</td><td>'+e.time+'</td><td>'+status+'</td></tr>';
  
  })
  $(".table tbody").html(html);
  });
  }
</script>
  </body>
  <?php include "bottombar.php" ?>
 </html>
	