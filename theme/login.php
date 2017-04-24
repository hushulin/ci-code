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
	<link rel="stylesheet" href="/css/weui.min.css" />
	<script src="/js/jquery-1.11.3.min.js"></script>
	<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" />
	

	<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
  <body class="page-mobile">
  <div class="wrapper login-wrapper">
 <div class="wx-logo">
    </div>
    
    <div class="login-form def-m mb10">
        <ul class="com-columns span2">
            <li class="comc-item">
                <div class="com-formbox com-formbox1">
                    <label class="formbox-hd" for="username"><i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;</label>
                    <span class="formbox-bd"><input type="tel" id="username" name="tel" onkeyup="this.value=this.value.replace(/ /g,'')" maxlength="11" class="input-txt" placeholder="请输入手机号"></span>
                </div>
            </li>
            <li class="comc-item">
                <div class="com-formbox">
                    <label class="formbox-hd" for="password"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;</label>
                    <span class="formbox-bd"><input type="password" id="password" name="usrPwd" onkeyup="this.value=this.value.replace(/ /g,'')" maxlength="16" class="input-txt" placeholder="请输入交易密码"></span>
                </div>
            </li>
        </ul>
    </div>
    <!--登录按钮-->
  <div class="def-p com-btnbox mb10">
        <a href="javascript:void(0);" class="btn btn-1 btn-dis" id="login_btn">登录</a>
    </div>
     
    
</div>
<!--注册按钮--> 
<div class="login-btm">
        <a href="/index.php/register" class="btn" id="register_btn" >没有帐号？请注册</a>
    </div>
  </body>
  <script>
  function cheakusername(){
  if($("#username").val().length!=11){
  wxalert("请输入正确的手机号码","好");
  return false;
  }else{
  return true;
  }
  }
  function cheakpassword(){
  if($("#password").val().length<6){
  wxalert("请输入正确的密码","好");
  return false;
  }else{
  return true;
  }
  }
  $('#login_btn').click(function(){
  if(cheakusername()&&cheakpassword()){
   $.post("/index.php/login/do_login",{"username":$("#username").val(),"password":$("#password").val()},function(data){
   if(data==001){
  //wxalert("登录成功","好的");
  window.location.href="/";
  }else if(data==101){
  wxalert("帐号或密码输入错误，请检查","好");
  }else if(data==201){
  wxalert("密码输入错误，请检查","好");
  }else if(data==301){
  wxalert("手机输入错误，请检查","好");
  }else{
  wxalert("可能网络未连接，请检查","好");
  }}
  );
  }})
  </script>
  <div style="display:none">
  <?php echo $setting['statistics'];?>
  </div>
 </html>
	