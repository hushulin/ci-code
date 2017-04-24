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
  <script src="/js/kindeditor-min.js"></script>
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
  <div style="width:800px;margin:0 auto;">
  <div class="alert alert-danger" role="alert">首页顶部广告</div>
  <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>广告图片</th>
          <th>广告链接</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($list as $key=>$row){ ?>
        <tr>
          <td width="30"><?php echo $key+1;?></td>
          <td width="200"><img width="150px" src="<?php echo $row['img'];?>"></td>
          <td><?php echo $row['url'];?></td>
          <td width="50"><a href="ad/delad?id=<?php echo $row['id'];?>">删除</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <br>
    <div class="row">
    <form action="ad/newad" method="post" enctype="multipart/form-data">
    <div class="input-group ">
  <span class="input-group-addon">上传图片</span>
  <input type="file" class="form-control" name="file" required="required" placeholder="本地图片">
</div>
<br>
    <div class="input-group">
  <span class="input-group-addon">链接</span>
  <input type="text" class="form-control" name="url"  value="#" required="required" placeholder="#">
  </div><br>
    <button type="submit" class="btn btn-primary">新建广告</button>
    </form>
    </div>
   </div>
   </div>
  </div>

  </body>
  </html>