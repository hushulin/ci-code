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

  </style>
  <body>
  <div style="min-width:1080px;">
  <?php include 'header.php';?>
  <div class="row">
  <?php $this->load->view(config_item("admin_").'/nav')?>
  <div class="content">
  <div style="width:600px;margin:0 auto;">
 <form action="timetype/do_save" method="post">
 
 <?php foreach($typelist as $type){ ?>
 <div class="form-group">
 <label class="pull-left" style="line-height:35px">排序</label> 
 <div class="col-sm-2">
      <input type="text" class="form-control" id="inputtitle<?php echo $type['id']?>" name="order<?php echo $type['id']?>['order_']" value="<?php echo $type['order_'];?>" >
    </div>
    <div class="col-sm-3">
      <input type="text" class="form-control"  value="<?php echo $type['time'];?>s" id="inputtitle" readonly>
    </div>
    <label class="pull-left" style="line-height:35px">盈利比例</label> 
    <div class="col-sm-3">
     <input type="text" class="form-control" name="<?php echo $type['id'];?>['profit']"  value="<?php echo $type['profit'];?>" id="inputtitle">
    </div>
    <label class="pull-left" style="line-height:35px">%</label> 
  </div>
 
 <?php } ?>
  
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