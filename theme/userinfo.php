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
</style>
  <body>
  <section class="jz-wrapper jz-null-bottom">
  <div class="background-ico">
  <center>
  <?php if($isReal){ ?>
  <i class="fa fa-address-card-o" aria-hidden="true"></i>
  <h3><i class="fa fa-check-circle-o" aria-hidden="true"></i> 已认证</h3>
  <?php }else{ ?>
  <i class="fa fa-address-card-o" aria-hidden="true"></i>
  <h3><i class="fa fa-info-circle" aria-hidden="true"></i> 未认证</h3>
  <?php } ?>
  </center>
  </div>
  <ul class="me-list">
  <?php if($isReal){ ?>
  <li>真实姓名<span class="pull-right"><?php echo $userinfo['name'];?></span></li>
  <li>身份证号码<span class="pull-right"><?php echo substr_replace($userinfo['IDcard'],'*******',7,7);?></span></li>
  <?php }else{ ?>
  <a href="/index.php/me/userreal"><li>实名认证<span class="pull-right" style="color:#3B95D3;margin-right:-15px;">去认证<i class="fa fa-angle-right" aria-hidden="true"></i></span></li></a>
  <?php } ?>
  <li>手机号码<span class="pull-right"><?php echo  substr_replace($userinfo['tel'],'****',3,4);?></span></li>
  <li>昵称<span class="pull-right"><?php echo $userinfo['nickname'];?></span></li>
  <li>性别<span class="pull-right"><?php echo $userinfo['sex']==1?'男':'女';?></span></li>
  <li>地区<span class="pull-right"><?php echo $userinfo['country']." ".$userinfo['province']." ".$userinfo['city'];?></span></li>
  </ul>
  </section>

  </body>
  <?php include "bottombar.php" ?>
 </html>
	