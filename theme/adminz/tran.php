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
  <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" />
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
  padding-bottom:15px;
  }
  .panel .table td{
  font-size:14px;
  }
  .panel .table{
  border-bottom:1px solid #ddd;
  }
   @media (min-width: 768px){
  .col-sm-1 {
    width: 11%;
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
  <form action="tran/tosave" method="post">
<div class="form-group">
 <label class="pull-left" style="line-height:35px">最低购买:</label> 
 <div class="col-sm-2">
 <input type="text" class="form-control" name="minbuy"  value="<?php echo $minbuy;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">元</span>
    <div class="col-sm-3">
    <button type="submit" class="btn btn-info">修改</button>
    </div><!--/col-sm-3-->
  </div>
  </form>
  </div><!--/alert-->
  <div class="alert alert-danger" role="alert">
  <form action="tran/tosave" method="post">
  <div class="form-group">
  <label class="pull-left" style="line-height:35px">实盘盈率:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="shiwin"  value="<?php echo $shiwin;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">%</span>
    <label class="pull-left" style="line-height:35px;margin-left:35px;">虚拟盘盈率:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="xuwin"  value="<?php echo $xuwin;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">%</span>
    <div class="col-sm-3">
    <button type="submit" class="btn btn-info">修改</button>
    </div><!--/col-sm-3-->
    </div><!--form-group-->
    <p class="pull-right">
    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> 等于 0 不干预
    </p>
  </form>
  </div><!--/alert-->
  <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">交易记录 <?php if($ptype==1){echo '<a href="?ptype=2">切换到虚拟盘交易</a>';}else{echo '<a href="?ptype=1">切换到实盘交易</a>';}?></div>

  <!-- Table -->
  <table class="table">
   <thead>
          <tr>
            <th>用户</th>
            <th>资产类型</th>
            <th>涨跌</th>
            <th>选择时间</th>
            <th>购买时间</th>
            <th>金额</th>
            <th>盈利情况</th>
          </tr>
        </thead>
        <?php foreach($tranlist as $list){ ?>
        <tr>
        <td><a href="user/edituser?uid=<?php echo $list['userid'];?>"><?php echo empty($list['nickname'])?$list['tel']:$list['nickname'];?></a></td>
        <td><?php echo $this->Common->getTypename($list['type']);?></td>
        <td><?php echo $list['direction']==1?'<font color="#3c763d">跌</font>':'<font color="#a94442">涨</font>';?></td>
        <td><?php echo $list['timetype'];?> 秒</td>
        <td><?php echo date("Y-m-d H:i:s",$list['time']);?></td>
        <td>￥<?php echo $list['amount'];?></td>
        <td><?php if($list['status']==-1){echo '亏';}elseif($list['status']==1){echo '盈';}else{echo '平';};?></td>
        </tr>
        <?php } ?>
  </table>
  <?php getPageHtml(empty($_GET['page'])?1:$_GET['page'],$pages,"/index.php/".config_item("admin_")."/tran?ptype=".$_GET['ptype']);?>
</div>

   </div>
   </div>
  </div>
   </div>
  </body>
  </html>