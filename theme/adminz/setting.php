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
 <form action="setting/do_save" method="post">
  <div class="form-group">
    <label for="inputtitle" class="col-sm-2 control-label">网站名称</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="title" value="<?php echo $setting['title'];?>" id="inputtitle" placeholder="title">
    </div>
  </div>
  <div class="form-group">
    <label for="inputentity" class="col-sm-2 control-label">注册送实币</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="s_entity" value="<?php echo $setting['s_entity'];?>" id="inputentity" placeholder="0.00">
    </div>
  </div>
  <div class="form-group">
    <label for="inputvirtual" class="col-sm-2 control-label">注册送虚币</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="s_virtual" value="<?php echo $setting['s_virtual'];?>" id="inputvirtual" placeholder="0.00">
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="open_virtual" value="1" <?php if($setting['open_virtual']){ ?>checked="checked"<?php } ?> > 开启虚拟盘
        </label>
      </div>
    </div>
  </div>
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_close" value="1" <?php if($setting['is_close']){ ?>checked="checked"<?php } ?> > 关闭网站
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="textareaclose_notice" class="col-sm-2 control-label">关闭通知</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="textareaclose_notice" name="close_notice" rows="3"><?php echo $setting['close_notice'];?></textarea>
    </div>
  </div>
  <div class="form-group" style="margin:60px 0;">
    <label for="textareaclose_statistics" class="col-sm-2 control-label">统计代码</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="textareaclose_statistics" name="statistics" rows="3"><?php echo $setting['statistics'];?></textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">保存修改</button>
    </div>
  </div>
   </form>
   </div>
   </div>
  </div>
  </body>
  </html>