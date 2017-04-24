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
  .panel .table td{
  font-size:14px;
  }
  .panel .table{
  border-bottom:1px solid #ddd;
  }
  .form-control{
      padding: 5px 8px;
  }
      @media (min-width: 768px){
  .col-sm-1 {
    width: 9%;
  }
  }
  .col-sm-1 {
  padding:0px 2px;
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
  <form action="recharge/tosave" method="post">
<div class="form-group">

<label class="pull-left" style="line-height:35px">最低充值:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="minrecharge"  value="<?php echo $minrecharge;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">元起</span>

 <label class="pull-left" style="line-height:35px;margin-left:50px">充值:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="r_cashback1"  value="<?php echo $r_cashback1;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">元以上</span>
    <label class="pull-left" style="line-height:35px">赠送:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="r_cashback2"  value="<?php echo $r_cashback2;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">%</span>
    <label class="pull-left" style="line-height:35px;margin-left:30px;">流水达:</label> 
 <div class="col-sm-1">
 <input type="text" class="form-control" name="cashmultiple"  value="<?php echo $cashmultiple;?>" id="inputtitle">
    </div><span class="pull-left" style="line-height:35px;">倍可提现</span>
    <div class="col-sm-2" style="width:15%">
    <button type="submit" class="btn btn-info">修改</button>
    </div><!--/col-sm-3-->
    
    </div>
  </form>
  </div><!--/alert-->
  <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">充值记录</div>

  <!-- Table -->
  <table class="table">
   <thead>
          <tr>
            <th>用户</th>
            <th>充值金额</th>
            <th>到账金额</th>
            <th>微信交易号</th>
            <th>是否人工充值</th>
            <th>充值时间</th>
          </tr>
        </thead>
        <?php foreach($rechargelist as $list){$i++;
        if($i%2==0){
        $is_complex=true;
        }else{
        $is_complex=false;
        }
         ?>
        <tr style="background-color:<?php echo $is_complex?'#eee':'#fff';?>">
        <td><a href="user/edituser?uid=<?php echo $list['userid'];?>"><?php echo empty($list['nickname'])?$list['tel']:$list['nickname'];?></a></td>
        <td><?php echo $list['amount'];?></td>
        <td><?php echo $list['actual'];?></td>
        <td><?php echo $list['transaction_id'];?></td>
        <td><?php echo $list['is_human']==1?'<font color=red>是</font>':'否';?></td>
        <td><?php echo date("Y-m-d H:i:s",$list['time']);?></td>
        
        </tr>
        <?php } ?>
  </table>
  <?php getPageHtml(empty($_GET['page'])?1:$_GET['page'],$pages,"/index.php/".config_item("admin_")."/recharge?")?>
</div>

   </div>
   </div>
  </div>
   </div>
  </body>
  </html>