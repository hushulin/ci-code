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
	<title>登录</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <script src="/js/jquery-1.11.3.min.js"></script>
</head>
  <style>
  .login-frame{
  width:400px;
  margin:0 auto;
  margin-top:150px;
  border-radius:5px;
  padding:15px 20px;
  }
  #verify_code{
  width:70%;
  }
  </style>
  <body>
  <div class="container">
  <div  class="text-center login-frame bg-danger">
  <h2>后台管理系统</h2>
  <form action="/index.php/<?php echo config_item("admin_");?>/login/do_login" method="post">
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">用户名</div>
      <input class="form-control" name="username" type="text" placeholder="username">
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">密&nbsp;&nbsp;&nbsp;码</div>
      <input class="form-control" name="password" type="password" placeholder="password">
    </div> 
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">验证码</div>
      <input type="text" placeholder="请输入图形验证码" maxlength="4" class="codeImgInp form-control" id="verify_code" name="verify_code">
       <img src="/index.php/<?php echo config_item("admin_");?>/captcha/get_code?<?php echo time();?>" alt="图形验证码" class="codeImg" height="32" id="verify" title="点击刷新"> 
    </div> 
  </div>
  
  <button type="submit" class="btn btn-default btn-lg" id="loginbutton">登录</button>
  </div>
  </form>
  </div>
  <script>
   $("#verify").click(function(){
  $("#verify").attr("src","/index.php/captcha/get_code?"+Math.random());
  });
  </script>
  </body>
  </html>