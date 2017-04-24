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
  padding-bottom:15px;
  }
  @media (min-width: 768px){
  .col-sm-1 {
    width: 11%;
  }
  }
  .form-control{
      padding: 5px 8px;
      }
  .media-body label{
      font-size:15px;
      color:#333;
      margin-right:20px;
  }
  .media-body label span{
      color:#f50;
  }
  .media-list .btn-group{
  margin-top:-40px;
  }
  h4 span.label{
  font-size:8px;
  font-weight:400;
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
  <form action="cash/tosave" method="post">
<div class="form-group">
 <label class="pull-left" style="line-height:35px">手续费:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="cashfee"  value="<?php echo $cashfee;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">%</span>
    <label class="pull-left" style="line-height:35px;margin-left:30px">最大提现次数:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="cashtimes" value="<?php echo $cashtimes;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">次/每天(0不限)</span>
    <label class="pull-left" style="line-height:35px;margin-left:30px">最低提现:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="cashmin"  value="<?php echo $cashmin;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">元</span>
    <div class="col-sm-2">
    <button type="submit" class="btn btn-info">修改</button>
    </div><!--/col-sm-3-->
  </div>
  </form>
  </div><!--/alert-->
  <ul class="media-list">
  <?php foreach($cashlist as $list){ ?>
  <li class="media">
    <a class="media-left" href="user/edituser?uid=<?php echo $list['uid'];?>">
      <img src="<?php echo $list['avatar']?>" alt="..." height="45" />
    </a>
    <div class="media-body">
      <h4 class="media-heading"><?php echo $list['nickname']?> <span class="label label-primary"><b>姓名:</b> <?php echo $list['name']; ?>&nbsp;&nbsp;<?php if($list['paytype']==1){ ?><b>支付宝：</b><?php echo $list['alipay'];?><?php }elseif($list['paytype']==2){ ?><b>卡号：</b><?php echo $list['alipay'];?><?php } ?>| <b>开户行：<?php echo $list['bankname'];?></b></span> </h4><?php if($list['status']==0){ ?><span class="label label-warning">待审核</span><?php }else{ ?><span class="label label-success">已审核</span><?php } ?>
      <label>提现金额:<span>￥<?php echo $list['amount'];?></span></label>
      <label>服务费:<span>￥<?php echo $list['fee'];?></span></label>
      <label>应到账:<span style="color:#c40000;">￥<?php echo $list['amount']-$list['fee'];?></span></label>
    </div>
    <div class="btn-group pull-right">
    <?php if($list['status']==0){ ?>
 <button type="button" class="btn btn-danger" onclick="reviewed(<?php echo $list['cid'];?>)">审核</button>
 <button type="button" class="btn btn-default" onclick="refusereview(<?php echo $list['cid'];?>)">拒绝</button>
 <?php }elseif($list['status']==-1){ ?>
 <button type="button" class="btn alert-danger">已拒</button>
 <button type="button" class="btn btn-default" onclick="cancelreview(<?php echo $list['cid'];?>)">取消</button>
  <?php }else{ ?>
  <button type="button" class="btn alert-success">已提</button>
  <button type="button" class="btn btn-default" onclick="cancelreview(<?php echo $list['cid'];?>)">取消</button>
  <?php } ?>
  
  <button type="button" class="btn btn-default" onclick='window.location.href="/index.php/<?php echo config_item("admin_");?>/user/cashflow?uid=<?php echo $list['id']?>"'>资金流水</button>
</div>
  </li>
  <?php } ?>
</ul>
<?php getPageHtml(empty($_GET['page'])?1:$_GET['page'],$pages,"/index.php/".config_item("admin_")."/cash?");?>
   </div>
   </div>
  </div>
   </div>
   <script>
   function reviewed(id){
   if(confirm("确定要通过该提现？"))
 {
 window.location.href='cash/toreview?id='+id;
 }
   }
    function cancelreview(id){
   if(confirm("确定要取消该提现？"))
 {
 window.location.href='cash/cancelreview?id='+id;
 }
   }
   function refusereview(id){
   if(confirm("确定要取消该提现？"))
 {
 window.location.href='cash/refusereview?id='+id;
 }
   }
   </script>
  </body>
  </html>