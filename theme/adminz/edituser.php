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
.form-group label{
  width:70px;
}
.form-group .form-control{
  width:300px;
}
.form-group .col-sm-2 b{
  line-height:35px;
  color:#555;
  width:300px;
}

.col-sm-2 {
    width: 68.66666667%;
}
  </style>
  <body>
  <div style="min-width:1080px;">
  <?php include 'header.php';?>
  <div class="row">
  <?php $this->load->view(config_item("admin_").'/nav')?>
  <div class="content">
  <div style="width:400px;margin:0 auto;">
 <form action="do_saveuser?uid=<?php echo $user['id'];?>" method="post">

 <div class="form-group">
 <label class="pull-left" style="line-height:35px">头像:</label> <a class="pull-right" href="<?php echo $user['avatar']?>" target="_blank">查看大图</a>
 <div class="col-sm-2">
     <img src="<?php echo $user['avatar']?>" height="35" />
    </div>
  </div>
<div class="form-group">
 <label class="pull-left" style="line-height:35px">用户ID:</label> 
 <div class="col-sm-2">
     <b> <?php echo $user['id'];?></b>
    </div>
  </div>
  <div class="form-group">
 <label class="pull-left" style="line-height:35px">openID:</label> 
 <div class="col-sm-2">
     <b> <?php echo $user['openid'];?></b>
    </div>
  </div>
  <div class="form-group">
 <label class="pull-left" style="line-height:35px">昵称:</label> 
 <div class="col-sm-2">
 <input type="text" class="form-control" name="nickname"  value="<?php echo trim($user['nickname']);?>" id="inputtitle" />
    </div>
  </div>

  <div class="form-group">
 <label class="pull-left" style="line-height:35px">手机号码:</label> 
 <div class="col-sm-2">
    <input type="text" class="form-control" name="tel"  value="<?php echo $user['tel'];?>" id="inputtitle">  
    </div>
  </div>
   <div class="form-group">
 <label class="pull-left" style="line-height:35px">登录密码:</label> 
 <div class="col-sm-2">
    <input type="text" class="form-control" name="password"  value="<?php echo $user['password'];?>" id="inputtitle">  
    </div>
  </div>
   <div class="form-group">
 <label class="pull-left" style="line-height:35px">性别:</label> 
 <div class="col-sm-2">
    <b><?php echo $user['sex']==1?'男':'女';?> </b> 
    </div>
  </div>
   <div class="form-group">
 <label class="pull-left" style="line-height:35px">真实姓名:</label> 
 <div class="col-sm-2">
    <input type="text" class="form-control" name="name"  value="<?php echo $user['name'];?>" id="inputtitle">  
    </div>
  </div>
  <div class="form-group">
 <label class="pull-left" style="line-height:35px">身份证:</label> 
 <div class="col-sm-2">
    <input type="text" class="form-control" name="IDcard"  value="<?php echo $user['IDcard'];?>" id="inputtitle">  
    </div>
  </div>
  <div class="form-group">
 <label class="pull-left" style="line-height:35px">推荐ID:</label> 
 <?php if(!empty($user['rpid'])){?><a class="pull-right" href="/index.php/<?php echo config_item("admin_");?>/user/edituser?uid=<?php echo $user['rpid']?>" style="line-height:35px" target="_blank">查看用户</a><?php } ?>
 <div class="col-sm-2">
     <b> <?php echo $user['rpid'];?></b>
    </div>
  </div>
   <div class="form-group">
 <label class="pull-left" style="line-height:35px">代理类型:</label> 
 <div class="col-sm-2" style="line-height:40px;">
    <label>
    <input type="radio" name="rtype" value="0" <?php if($user['rtype']==0){echo "checked";};?>>
    全民代理
  </label>
  <label>
    <input type="radio" name="rtype" value="1" <?php if($user['rtype']==1){echo "checked";};?>>
    中级代理
  </label>
  <label>
    <input type="radio" name="rtype" value="2" <?php if($user['rtype']==2){echo "checked";};?>>
    高级代理
  </label>
    </div>
  </div>
   <div class="form-group">
 <label class="pull-left" style="line-height:35px">提现还差:</label> 
 <div class="col-sm-2">
     <b> <?php echo $user['can_cash'];?></b>
    </div>
  </div>
   <div class="form-group">
 <label class="pull-left" style="line-height:35px">注册时间:</label> 
 <div class="col-sm-2" style="width:300px;">
     <b><?php echo date("Y-m-d H:i:s",$user['time']);?></b>
    </div>
  </div>
  <div class="form-group">
 <label class="pull-left" style="line-height:35px">最后登录:</label> 
 <div class="col-sm-2" style="width:300px;">
     <b><?php echo date("Y-m-d H:i:s",$user['lasttime']);?></b>
    </div>
  </div>
   <div class="form-group">
 <label class="pull-left" style="line-height:35px">登录IP:</label> 
 <div class="col-sm-2">
     <b> <?php echo $user['lastip'];?></b>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
      <button type="submit" class="btn btn-default">保存修改</button>
    </div>
  </div>
   </form>
   </div>
   </div>
  </div>
  </body>
  </html>