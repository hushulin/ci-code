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

</style>
  <body>
  <section class="jz-wrapper jz-null-bottom">
  <center>
  <div class="background-ico" style="height:120px;line-height:100px;padding:0">
  <font size="5">请填写您的身份信息</font>
  </div>
  <div class="margin-bottom">
   <div class="input-group margin-bottom-sm">
  <span class="input-group-addon" style="word-spacing:8px; letter-spacing: 3px;">真实姓名：</span>
  <input class="form-control" id="name" style="width:60%" type="text" placeholder="您的真实姓名">
</div>
<div class="input-group">
  <span class="input-group-addon">身份证号码：</span>
  <input class="form-control" id="idcard" style="width:60%" type="number" placeholder="您的身份证号码">
</div>
<p class="tips">提现只能到达已认证信息对应的银行卡或其他支付工具</p> 
  <button id="toreal">提交认证</button>
</div>
</center>
  </section>
<script>
  $("#toreal").click(function(){
    $.ajax({url:'/index.php/me/cheakreal',type:'POST',data:{name:$("#name").val(),idcard:$("#idcard").val()},dataType:'json',async: false,success:function(data){
    datas=eval(data);
    alert(datas.msg);
    if(datas.status==1){
    window.location.href='/index.php/me/userinfo';
    }
    }});
  });
</script>
  </body>
  <?php include "bottombar.php" ?>
 </html>
	