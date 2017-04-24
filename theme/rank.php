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
	<link rel="stylesheet" href="/css/weui.min.css" />
	<script src="/js/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<style>
*{
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    -webkit-touch-callout: none;
}
body{
    background:#fff;
    -webkit-font-smoothing: antialiased;
}
.btn-group, .btn-group-vertical {
    position: relative;
    display: inline-block;
    vertical-align: middle;
    color:#000;
    margin-top:10px;
}
.btn-group>.rbtn:first-child:not(:last-child):not(.dropdown-toggle) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.btn-group>.rbtn:first-child {
    margin-left: 0;
}
.btn-group>.rbtn:last-child:not(:first-child), .btn-group>.dropdown-toggle:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
.btn-group .rbtn+.rbtn, .btn-group .rbtn+.btn-group, .btn-group .btn-group+.rbtn, .btn-group .btn-group+.btn-group {
    margin-left: -1px;
}
.btn-group>.rbtn, .btn-group-vertical>.rbtn {
    position: relative;
    float: left;
}
.btn-default2 {
    text-shadow: 0 1px 0 #fff;
    background-image: -webkit-linear-gradient(top,#fff 0,#e0e0e0 100%);
    background-image: -o-linear-gradient(top,#fff 0,#e0e0e0 100%);
    background-image: -webkit-gradient(linear,left top,left bottom,from(#fff),to(#e0e0e0));
    background-image: linear-gradient(to bottom,#fff 0,#e0e0e0 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe0e0e0', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    background-repeat: repeat-x;
    background-color:#fff;
    border-color: #dbdbdb;
    border-color: #ccc;
}
.rbtn {
    display: inline-block;
    padding: 6px 18px;
    margin-bottom: 0;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid #efefef;
    border-radius: 4px;
    color:#999;
}
.firstthree{
  width:255px;
  margin:0 auto;
  margin-top:30px;
  height:130px;
  background:#fff;
  text-align:center;
}
.i-frist,.i-second,.i-third{
  border-radius:5px;
}
.frist,.second,.third{ 
  float:left;
}


.i-second,.i-third{
  height:60px;
  width:60px;
}
.second,.third{
  margin-top:20px;
  width:58px;
}
.frist{
margin-top:8px;
  width:120px;
}

.i-frist{
  height:80px;
  width:80px;
  margin:0 20px;
}
.me-list li img{
  height:50px;
  width:50px;
  border-radius:5px;
  float:left;
  margin-right:10px;
}
.me-list li{
  line-height:50px;
  margin:0;
}
.me-list li span{
  float:left;
  font-weight:600;
  font-size:18px;
  color:#bbb;
  margin-right:10px;
}
.frist p{
  color:#FF7F00;
  font-weight:600;
  font-size:18px;
}
.second label,.third label{
display:inline-block;
width:50px;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
font-size:15px;
}
.frist label{
display:inline-block;
width:80px;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
font-size:15px;
}
.me-list li label{
  float:right;
  font-size:20px;
}
.me-list li b{
display:inline-block;
width:48%;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
}
 b{
  font-weight:600;
}
.btn-active{
  color:#333;
}
</style>
  <body>
  <section class="jz-wrapper jz-null-bottom">
  <center><div class="btn-group">
  <button type="button" class="rbtn btn-default2 <?php if($_GET['s']==1||empty($_GET['s'])){echo 'btn-active';}?>" onclick="location.href='?s=1'">盈利榜</button>
  <button type="button" class="rbtn btn-default2 <?php if($_GET['s']==2){echo 'btn-active';}?>" onclick="location.href='?s=2'">推广榜</button>
  </div>
  </center>
  <div class="firstthree">
  <div class="second"><img class="i-second" src="<?php echo $second['avatar'];?>" />
  <p>#2</p>
  <label><b><?php echo $second['nickname'];?></b></label>
  <p><?php echo sprintf('%.2f',$second['amount']);?></p>
  </div>
  <div class="frist"><img class="i-frist" src="<?php echo $first['avatar'];?>" />
  <p>#1</p>
  <label><b><?php echo $first['nickname'];?></b></label>
  <p><?php echo sprintf('%.2f',$first['amount']);?></p>
  </div>
  <div class="third"><img class="i-third" src="<?php echo $third['avatar'];?>" />
  <p>#3</p>
  <label><b><?php echo $third['nickname'];?></b></label>
  <p><?php echo sprintf('%.2f',$third['amount']);?></p>
  </div>
  </div>
  <ul class="me-list" style="clear:both">
  <?php foreach($list as $key=>$row){ ?>
  <li><span style="display:block;width:30px;float:left;text-align:center">#<?php echo $key+4;?></span><img src='<?php echo $row['avatar'];?>' /> <b><?php echo $row['nickname'];?></b><label><?php echo sprintf('%.2f',$row['amount']);?></label></li>
  <?php } ?>
  </ul>
  </section>
  <?php if($_GET['s']==2){ ?>
  <style>
  .to_branding{
    height:50px;
    width:50px;
    line-height:50px;
    border-radius:50%;
    background:#ff944c;
    border:1px solid #FF7F00;
    position:fixed;
    bottom:130px;
    color:#fff;
    right:30px;
    font-size:12px;
    text-align:center;
  }
  </style>
  <div class="to_branding" onclick="location.href='/index.php/branding'">
  去推广
  </div>
  <?php }?>
  </body>
  <?php include "bottombar.php" ?>
 </html>
	