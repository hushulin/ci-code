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
li{
  color:#666;
}
.me-list{
  margin-top:5px;
}
</style>
  <body>
  <ul class="me-list">
  <a href="/index.php/contact"><li><i class="fa fa-weixin" aria-hidden="true"></i>联系客服<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></li></a>
  <a href="/index.php/me/editpassword"><li><i class="fa fa-expeditedssl" aria-hidden="true"></i>修改密码<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></li></a>
  </ul>
  <center><button class="btn-to btn-4" onclick="location.href='/index.php/me/exitlogin'">退出登录</button></center>
  </body>
  <?php include "bottombar.php" ?>
 </html>
	