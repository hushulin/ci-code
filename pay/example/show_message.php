<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>充值结果</title>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">

<link href="/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/weui.min.css?ttt" />
<style type="text/css">
.weui-msg__title{
  font-size:22px;
}
</style>
</head>
<body>
	
	<div class="page msg_success js_show">
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title" >充值成功</h2>
            <h1>￥<?php echo sprintf('%.2f',floatval(@$_GET['m']));?></h1>
        </div>
        
        <div class="weui-msg__extra-area">
            <div class="weui-footer">
                <p class="weui-footer__links">
                    <a href="javascript:void(0);" class="weui-footer__link">正在准备跳转...</a>
                    <script language="javascript">setTimeout("location.href='/';", 3500);</script>   
                </p>

            </div>
        </div>
    </div>
</div>
</body>
</html>