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
  <div class="jz-head">
    <a href="###" id="account_icon_btn" class="pos-left head-show jz-my_head">
    <img src="<?php echo $userinfo['avatar'];?>" width="33" height="33" alt="">
    </a>
<span><?php echo $userinfo['nickname'];?>  邀请ID：<?php echo $userinfo['id'];?></span>
<a href="/index.php/me/recharge" id="screen" class="font-sm pos-right">充值</a>
</div>
  <div class="account-top-view text-center">
        <p class="font-sm">余额(元)</p>
        <p class="account-total"><?php echo $balance1;?></p>
        <!--
        <?php if($setting['open_virtual']==1){?>
        <p class="font-sm">模拟盘余额(元)</p>
        <p class="acount-profit font-xl"><?php echo $balance2;?></p>
        <?php } ?>
        -->
    </div>
  <div class="water">
<div class="water-1"></div>
<div class="water-2"></div>
</div>
<div class="me-btn-group">
      <a href="/index.php/me/recharge"><button class="me-btn-red">充值</button></a><a href="/index.php/me/cash"><button class="me-btn-default">提现</button></a>
      </div>
      <hr />
      <ul class="me-list">
      <a href="/index.php/branding" style="color:red"><li><i class="fa fa-gift" style="color:red" aria-hidden="true"></i>邀好友，得奖励<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></li></a>
      <a href="/index.php/branding/myfriend"><li><i class="fa fa-user-circle" aria-hidden="true"></i>直属好友<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></li></a>
      <a href="/index.php/me/userinfo"><li><i class="fa fa-vcard-o" aria-hidden="true"></i>个人信息<i class="fa fa-angle-right pull-right" aria-hidden="true"></i><span class="pull-right"><?php echo $isReal?'已认证':'未认证';?></span></li></a>
      <a href="/index.php/me/tranlog?t=<?php echo $_GET['t'];?>"><li><i class="fa fa-exchange" aria-hidden="true"></i>交易记录<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></li></a>
      <a href="/index.php/me/cashflow"><li><i class="fa fa-dollar" aria-hidden="true"></i>资金流水<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></li></a>
      <a href="/index.php/me/userset"><li><i class="fa fa-gear" aria-hidden="true"></i>账号设置<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></li></a>
      </ul>
</section>

  </body>
  <?php include "bottombar.php" ?>
 </html>
	