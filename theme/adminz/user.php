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
  .btn-group>a .btn:first-child:not(:last-child):not(.dropdown-toggle) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.btn-group>a .btn:first-child {
    margin-left: 0;
}
.btn-group>a .btn, .btn-group-vertical>a .btn {
    position: relative;
    float: left;
}
.col-sm-9{
    padding-left:5px;
    padding-right: 5px;
}
.alert{
    padding:10px;
}
.form-group {
    padding-bottom: 0px;
}
.col-md-*{
    padding-right:5px;
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
  <div class="row">
  <form action>
  <div class="col-md-3">
  <div class="form-group">
 <label class="pull-left" style="line-height:35px">昵称:</label> 
 <div class="col-sm-9">
    <input type="text" class="form-control" name="nickname"  value="<?php echo $_GET['nickname'];?>" id="inputtitle">  
    </div>
  </div>
  </div>
  <div class="col-md-4">
  <div class="form-group">
 <label class="pull-left" style="line-height:35px">真实姓名:</label> 
 <div class="col-sm-9">
    <input type="text" class="form-control" name="name"  value="<?php echo $_GET['name'];?>" id="inputtitle">  
    </div>
  </div></div>
  <div class="col-md-4">
  <div class="form-group">
 <label class="pull-left" style="line-height:35px">手机号码:</label> 
 <div class="col-sm-9">
    <input type="text" class="form-control" name="tel"  value="<?php echo $_GET['tel'];?>" id="inputtitle">  
    </div>
  </div>
  </div>
  <div class="col-md-1">
  <button type="submit" class="btn btn-info">搜索</button>
  </div>
  </form>
  </div>
  </div>
 <ul class="media-list">
 
 <?php foreach($userlist as $user){ ?>
 <li class="media">

      <img style="border-radius:4px;" class="pull-left" src="<?php echo $user['avatar'];?>" height="40"  alt="...">

    <div class="media-body">
      <h4 class="media-heading"><?php echo empty($user['nickname'])?$user['tel']:$user['nickname'];?><span class="label label-warning" style="font-size:10px;">余额:￥<?php echo $user['balance'];?></span></h4>
      <?php echo $user['tel'];?>  
    </div>
    <div class="btn-group pull-right">
  <button type="button" class="btn btn-default" onclick='window.location.href="/index.php/<?php echo config_item("admin_");?>/user/edituser?uid=<?php echo $user['id']?>"'>编辑资料</button>
  <button type="button" class="btn btn-default" onclick="userid=<?php echo $user['id'];?>;"  data-toggle="modal" data-target="#myModal" >充值</button>
  <button type="button" class="btn btn-danger" onclick='if(confirm("确定删除?")){window.location.href="/index.php/<?php echo config_item("admin_");?>/user/deluser?uid=<?php echo $user['id']?>"}'>删除</button>
   <button type="button" class="btn btn-default" onclick='window.location.href="/index.php/<?php echo config_item("admin_");?>/user/cashflow?uid=<?php echo $user['id']?>"'>资金流水</button>
  </div> 
  </li>
 
 <?php } ?>
 </ul> 
<?php getPageHtml(empty($_GET['page'])?1:$_GET['page'],$pages,"/index.php/".config_item("admin_")."/user?nickname=".$_GET['nickname']."&tel=".$_GET['tel']);?>
   </div>
   </div>
  </div>
  <!--充值框-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">用户充值</h4>
      </div>
      <div class="modal-body">
      <center>
        <div class="row">
  <div class="col-lg-6">
    <div class="input-group">
    
      <div class="input-group-btn">
        <select class="btn btn-default dropdown-toggle" id="recharge-type">
        <option value ="1">实体</option>
        <option value ="2">虚拟</option>
        </select>
      </div><!-- /btn-group -->
      <input type="text" class="form-control" id="amount" style="height:35px" placeholder="0.00"> 
      
    </div><!-- /input-group -->
   
  </div><!-- /.col-lg-6 -->
  <span class="label label-info pull-right" style="margin-top:10px;">负数可减去余额，如-35则减去35元</span>
  </div>
  </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" id="torecharge" class="btn btn-primary">确认充值</button>
      </div>
    </div>
  </div>
</div>
<script>
var userid=0;
$("#torecharge").click(function(){
$.ajax({url:'/index.php/<?php echo config_item("admin_"); ?>/user/torecharge',type:'POST',dataType:'json',async:false,data:{amount:$("#amount").val(),type:$("#recharge-type").val(),uid:userid},success:function(data){
  data=eval(data);
  alert(data.msg);
  if(data.status==1){
  window.location.reload();
  }
}});

});
</script>
  </body>
  </html>