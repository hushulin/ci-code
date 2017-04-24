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
  <script src="/js/bootstrap.min.js"></script>
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
  .media-list .btn-group{
  margin-top:-40px;
  }
  .input-group{
  margin:15px;
  }

  </style>
  <body>
  <div style="min-width:1080px;">
  <?php include 'header.php';?>
  <div class="row">
  <?php $this->load->view(config_item("admin_").'/nav')?>
  <div class="content">
  <div style="width:800px;margin:0 auto;">
  <div class="alert alert-info" role="alert">
  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newManager">新建账号</button>
  </div>
 <ul class="media-list">
 
 <?php foreach($manager as $user){ ?>
 <li class="media">
    <div class="media-body">
      <h3 class="media-heading"><?php echo $user['username'];?></h3>
      <b>最后登录:<?php echo date("Y-m-d H:i:s",$user['lasttime']);?></b>
      &nbsp;&nbsp;
      <b>登录IP:<?php echo $user['lastip'];?></b>  
    </div>
    <div class="btn-group pull-right">
  <button type="button" class="btn btn-default" onclick="userid=<?php echo $user['id']?>;" data-toggle="modal" data-target="#editPassword" id="editpassword">修改密码</button>
   <button type="button" class="btn btn-danger delID" onclick="userid=<?php echo $user['id']?>;" >删除帐号</button>
  </div> 
  </li>
 <?php } ?>
 </ul> 
      </div>
    </div>
  </div>
</div>
<script>
var userid=0;
$(function(){
$(".delID").click(function(){
$.ajax({url:'/index.php/<?php echo config_item("admin_"); ?>/manager/del',type:'POST',dataType:'json',async:false,data:{uid:userid},success:function(data){
  data=eval(data);
  alert(data.msg);
  if(data.status==1){
  window.location.reload();
  }
}});

});

$("#tonewmanage").click(function(){
  if($("#username").val()==""||$("#password").val()==""||$("#password2").val()==""){
  alert("请输入完整的信息");
  return false;
  }
  if($("#password").val()!==$("#password2").val()){
  alert("两次密码输入不同");
  return false;
  }
  $.ajax({url:'/index.php/<?php echo config_item("admin_"); ?>/manager/add',type:'POST',dataType:'json',async:false,data:{username:$("#username").val(),password:$("#password").val()},success:function(data){
  data=eval(data);
  alert(data.msg);
  if(data.status==1){
  window.location.reload();
  }
}});

});
  $("#toeditpassword").click(function(){
  if($("#usedpassword").val()==""||$("newpassword").val()==""||$("newpassword2").val()==""){
  alert("请输入完整的信息");
  return false;
  }
  if($("#newpassword").val()!==$("#newpassword2").val()){
  alert("两次新密码输入不同");
  return false;
  }
  $.ajax({url:'/index.php/<?php echo config_item("admin_"); ?>/manager/editpassword',type:'POST',dataType:'json',async:false,data:{uid:userid,usedpassword:$("#usedpassword").val(),newpassword:$("#newpassword").val()},success:function(data){
  data=eval(data);
  alert(data.msg);
  if(data.status==1){
  window.location.reload();
  }
}});
  });

});
</script>
<!-- 新建账号 -->
<div class="modal fade" id="newManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">新建管理账号</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">用&nbsp;户&nbsp;名</span>
          <input type="text" id="username" class="form-control" placeholder="Username">
          </div>
          <div class="input-group">
          <span class="input-group-addon">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</span>
          <input type="password" id="password" class="form-control" placeholder="password">
          </div>
          <div class="input-group">
          <span class="input-group-addon">确认密码</span>
          <input type="password" id="password2" class="form-control" placeholder="password">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="tonewmanage">新建账号</button>
      </div>
    </div>
  </div>
</div>
<!-- 修改密码 -->
<div class="modal fade" id="editPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">修改管理密码</h4>
      </div>
      <div class="modal-body">
          <div class="input-group">
          <span class="input-group-addon">&nbsp;&nbsp;&nbsp;&nbsp;旧密码</span>
          <input type="password" id="usedpassword" class="form-control" placeholder="password">
          </div>
          <div class="input-group">
          <span class="input-group-addon">&nbsp;&nbsp;&nbsp;&nbsp;新密码</span>
          <input type="password" id="newpassword" class="form-control" placeholder="password">
          </div>
          <div class="input-group">
          <span class="input-group-addon">确认密码</span>
          <input type="password" id="newpassword2" class="form-control" placeholder="password">
          </div>
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="toeditpassword">修改密码</button>
      </div>
    </div>
  </div>
</div>

  </body>
  </html>