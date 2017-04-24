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
	<title>注册</title>
	<link rel="stylesheet" href="/css/weui.min.css" />
	<script src="/js/jquery-1.11.3.min.js"></script>

	<link rel="stylesheet" type="text/css" href="/css/style.css" />
	<style>
	.logintip{
	width:auto;
	}
	</style>
</head>
  <body>

  <img src="/images/banner.jpg" alt="banner图" class="banner">
  <div class="formDiv">

        <div class="bprderInp">

            <input id="username" type="tel" placeholder="请输入您的手机号" maxlength="11" class="phoneInp">

        </div>
<div class="bprderInp posRel">

            <input type="text" placeholder="请输入短信校检码" maxlength="4" name="pin" class="codeImgInp" id="pin"> 
           <button id="getpin" style="padding:10px 0;border-radius:5px;background:#f0f0f0;border:1px solid #eee;width:25%; position: absolute;right:5%;color:#333">获取验证码</button> 
          

        </div>
        <div class="bprderInp">

            <input id="password" type="password" placeholder="请输入6-16位交易密码" maxlength="16" class="passwordInp" >

        </div>

        <div class="bprderInp posRel">

            <input type="text" placeholder="请输入图形验证码" maxlength="4" class="codeImgInp" id="verify_code"> 
            <input id="openid" name="openid" type="hidden" value="">
            <img src="/index.php/captcha/get_code" alt="图形验证码" class="codeImg" id="verify" title="点击刷新">

        </div>
        <div class="bprderInp">

            <input id="rpid" type="text" placeholder="邀请ID(可不填)" <?php if(!empty($userinfo['rpid'])){ ?> value="<?php echo $userinfo['rpid']; ?>" name="rpid" readonly <?php }elseif(!empty($_GET['rpid'])){ ?> value="<?php echo intval($_GET['rpid']); ?>" name="rpid" readonly <?php } ?> maxlength="16" class="passwordInp" >

        </div>
       
    </div>
    <button class="submitBtn" id="btn_1" style="background-color: rgb(240, 68, 71);">立刻注册</button>
    <p class="logintip">已有账户请点击<a href="/index.php/login"><font color="red">这里登录</font></a></p>
  <script>
   var countdown=99; 
function settime() { 
obj=$('#getpin');
    if (countdown == 0) { 
        obj.removeAttr("disabled");
        obj.html("获取验证码"); 
        obj.css('background','#f0f0f0');
        countdown = 99; 
        return;
    } else { 
       obj.attr('disabled',"true");
        obj.html("重新发送(" + countdown + ")"); 
        obj.css('background','#eee');
        countdown--; 
    } 
setTimeout(function() { 
    settime() }
    ,1000) 
}
  $('#getpin').click(function(){
  if(checktel()){
  obj=$('#getpin');

  
  $.post('/index.php/register/cphone',{phone:$('#username').val()},function(flag){
 
            if(flag>=1){
                settime();
            }else{
                wxalert('发送失败('+flag+')！请重新发送。','好');
            }
        });
        }
  });
  $("#verify").click(function(){
  $("#verify").attr("src","/index.php/captcha/get_code?"+Math.random());
  });
  function checktel(){
  if($("#username").val().length!=11){
  wxalert("请输入正确的手机号!","确定");
  return false;
  }
  return true;
  }
  function checkpw(){
  if($("#password").val().length<6){
  wxalert("密码必须6位数以上!","确定");

  return false;
  }
  return true;
  }
  function checkcode(){
  if($("#verify_code").val().length<1){
  wxalert("请填写验证码!","确定");
  
  return false;
  }
  return true;
  }
  function checkrpid(){
  if($("#rpid").val().length<1){
  wxalert("请填写邀请人ID!","确定");
  
  return false;
  }
  return true;
  }
  
  $("#btn_1").click(function(){
  if(checktel()&&checkpw()&&checkcode()){
  $.post("/index.php/register/do_post",{"tel":$("#username").val(),"password":$("#password").val(),"code":$("#verify_code").val(),"pin":$("#pin").val(),"rpid":$("#rpid").val()},function(data){
  if(data==001){
  wxalert("注册成功","马上登录");
  window.location.href="/";
  }else if(data==401){
   wxalert("验证码输入错误","刷新验证码");
   $("#verify").attr("src","/index.php/captcha/get_code?"+Math.random());
  }else if(data==301){
  wxalert("请输入正确的手机号码","确定");
  }else if(data==201){
  wxalert("密码必须是6位数以上","确定");
  }else if(data==002){
  wxalert("发生未知错误,请重试","确定");
  }else if(data==501){
  wxalert("该手机已经注册过，你可以直接登录","确定");
  }else if(data==901){
  wxalert("邀请用户不存在","确定");
  }else if(data==601){
  wxalert("短信校检码错误","确定");
  }else{
  wxalert("发生未知错误,请重试"+data,"确定");
  }
  });
  }
  });
  //弹窗相关
$(function () {
    var dialog = unescape("%3Cdiv%20id%3D%22lly_dialog%22%20style%3D%22display%3A%20none%22%3E%0A%20%20%20%20%3Cdiv%20class%3D%22weui-mask%22%3E%3C/div%3E%0A%20%20%20%20%3Cdiv%20class%3D%22weui-dialog%22%3E%0A%20%20%20%20%20%20%20%20%3Cdiv%20class%3D%22weui-dialog__bd%22%20id%3D%22lly_dialog_msg%22%3E%3C/div%3E%0A%20%20%20%20%20%20%20%20%3Cdiv%20class%3D%22weui-dialog__ft%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Ca%20href%3D%22javascript%3A%3B%22%20class%3D%22weui-dialog__btn%20weui-dialog__btn_primary%22%20id%3D%22lly_dialog_btn%22%3E%3C/a%3E%0A%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%3C/div%3E%0A%3C/div%3E");
    $("body").append(dialog);
});

function wxalert(msg, btn, callback) {
    var $dialog = $('#lly_dialog');
    $dialog.fadeIn(200);
    $dialog.find("#lly_dialog_msg").html(msg);
    $dialog.find("#lly_dialog_btn").html(btn);
    $dialog.find("#lly_dialog_btn").off('click').on('click',function () {
        $dialog.fadeOut(200);
        if (callback) {
            callback();
        }
    });
}
  </script>
  <div style="display:none">
<?php echo $setting['statistics'];?>
</div>
  </body>
 </html>
	