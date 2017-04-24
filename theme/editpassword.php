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
  <ul class="me-list">
  <li>
  <span style="display:block;width:85px;line-height:45px" class="pull-left">旧密码</span><input class="input-li" id="usedpassword"  type="password" placeholder="旧密码">
  </li>
<li>
  <span style="display:block;width:85px;line-height:45px" class="pull-left">新密码</span><input class="input-li" id="newpassword"  type="password" placeholder="新密码">
</li>
<li>
  <span style="display:block;width:85px;line-height:45px" class="pull-left">确认新密码</span><input class="input-li" id="newpassword2"  type="password" placeholder="确认新密码">
</li>
 <center> <button id="setpassword" class="btn-to">确认修改密码</button></center>
</ul>

  </section>
<script>
  $("#setpassword").click(function(){
  if($("#usedpassword").val()==""){
  wxalert("请输入旧密码",'好');
  return false;
  }
  if($("#newpassword").val()==""){
  wxalert("请输入新密码",'好');
  return false;
  }
  if($("#newpassword").val()!==$("#newpassword2").val()){
  wxalert("两次输入的新密码不相同，请检查",'好');
  return false;
  }
  
    $.ajax({url:'/index.php/me/setpassword',type:'POST',data:{newpassword:$("#newpassword").val(),usedpassword:$("#usedpassword").val()},dataType:'json',async: false,success:function(data){
    datas=eval(data);
    wxalert(datas.msg,'好');
    if(datas.status==1){
    window.location.href='/index.php/me';
    }
    }});
  });
</script>
  </body>
  <?php include "bottombar.php" ?>
 </html>
	