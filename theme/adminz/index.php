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
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link href="/images/favicon218877.ico" rel="Shortcut Icon">
  <script src="/js/jquery-1.11.3.min.js"></script>
  <script src="//cdn.bootcss.com/highstock/5.0.2/highstock.js"></script>
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
  margin-left:10px;
   float:left;
  }
  </style>
  <body>
  <div style="min-width:1080px;">
  <?php include 'header.php';?>
  <div class="row">
  <?php $this->load->view(config_item("admin_").'/nav')?>
  <div class="content">
  <div style="width:1000px;margin:0 auto;">
  <div class="alert alert-danger" role="alert">
  <button class="btn btn-info" type="button">
    全网用户数 <span class="badge"><?php echo $alluser;?></span>
  </button>
  <button class="btn btn-success" type="button">
    全网交易额 <span class="badge"><?php echo $allamount;?></span>
  </button>
  <button class="btn btn-danger" type="button">
    全网提现额 <span class="badge"><?php echo $allcash;?></span>
  </button>
  <button class="btn btn-success" type="button">
    全网充值额 <span class="badge"><?php echo $allrecharge;?></span>
  </button>
  <button class="btn btn-danger" type="button">
    全网推广额 <span class="badge"><?php echo $allreward;?></span>
  </button>
  <button class="btn btn-danger" type="button">
    全网盈亏额 <span class="badge"><?php echo $allyk;?></span>
  </button>
  </div><!--/alert-->
    <div class="alert alert-danger" role="alert">
  <button class="btn btn-info" type="button">
    今日用户数 <span class="badge"><?php echo $alluser_d;?></span>
  </button>
  <button class="btn btn-success" type="button">
    今日交易额 <span class="badge"><?php echo $allamount_d;?></span>
  </button>
  <button class="btn btn-danger" type="button">
    今日提现额 <span class="badge"><?php echo $allcash_d;?></span>
  </button>
  <button class="btn btn-success" type="button">
    今日充值额 <span class="badge"><?php echo $allrecharge_d;?></span>
  </button>
  <button class="btn btn-danger" type="button">
    今日推广额 <span class="badge"><?php echo $allreward_d;?></span>
  </button>
  <button class="btn btn-danger" type="button">
    今日盈亏额 <span class="badge"><?php echo $allyk_d;?></span>
  </button>
  </div><!--/alert-->
</div>
<div id="usercontainer" style="min-width:400px;height:350px"></div>
  <div id="container" style="min-width:400px;height:350px;margin-bottom:100px;"></div>
  </div><!--/content-->
  
   </div>
  </div>
  <script>
  $(function () {
  var x=new Array();
  <?php for($x=0;$x<12;$x++){ ?>
  x[<?php echo $x;?>]='<?php echo date("Y-m-d",strtotime('-'.(11-$x).' days'));?>';
  <?php } ?>
    $('#usercontainer').highcharts({
        title: {
            text: '十二天用户曲线表',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        credits:{
     enabled:false // 禁用版权信息
          },
        xAxis: {
            categories: eval(x)
        },
        yAxis: {
            min:0,
            title: {
                text: ''
            },
            
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '用户数',
            data: [<?php foreach($usernum as $num){echo $num.",";}?>]
        }]
    });
  
  var z=new Array();
  <?php for($x=0;$x<12;$x++){ ?>
  z[<?php echo $x;?>]='<?php echo date("Y-m-d",strtotime('-'.(11-$x).' days'));?>';
  <?php } ?>
    $('#container').highcharts({
        title: {
            text: '十二天财务曲线表',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        credits:{
     enabled:false // 禁用版权信息
          },
        xAxis: {
            categories: eval(z)
        },
        yAxis: {
            title: {
                text: ''
            },

            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '推广额',
            data: [<?php foreach($rewardnum as $num){echo $num.",";}?>]
        }, {
            name: '提现额',
            data: [<?php foreach($cashnum as $num){echo $num.",";}?>]
        }, {
            name: '充值额',
            data: [<?php foreach($rechargenum as $num){echo $num.",";}?>]
        }, {
            name: '交易额',
            data: [<?php foreach($trannum as $num){echo $num.",";}?>]
        }]
    });
});
</script>
  </body>
  </html>