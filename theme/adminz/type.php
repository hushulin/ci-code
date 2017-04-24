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
 <form action="type/do_save" method="post">
 
 <?php foreach($typelist as $type){ ?>
 <div class="form-group">
 <label class="pull-left" style="line-height:35px">排序</label> 
 <div class="col-sm-2">
      <input type="text" class="form-control" id="inputtitle<?php echo $type['id']?>" name="<?php echo $type['id']?>['order_']" value="<?php echo $type['order_'];?>" >
    </div>
    <div class="col-sm-3">
      <input type="text" class="form-control"  value="<?php echo $type['name'];?>" id="inputtitle" readonly>
    </div>
    <div class="col-sm-2"> <a href="/index.php/<?php echo config_item("admin_");?>/type/is_rest?id=<?php echo $type['id']?>">
    <?php if($type['is_rest']==0){ ?>
   <button type="button" class="btn btn-warning">休市</button>
    <?php }else{ ?>
    <button type="button" class="btn btn-success pull-left">开市</button>
    <?php } ?>
    </a>
    </div>
    <div class="col-sm-2">
    <a href="/index.php/<?php echo config_item("admin_");?>/type/is_close?id=<?php echo $type['id']?>">
    <?php if($type['is_close']==0){ ?>
    <button type="button" class="btn btn-danger">关闭</button>
    <?php }else{ ?>
    <button type="button" class="btn btn-success">开启</button>
    <?php } ?>
    </a>
    </div>
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