<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>提示</title>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">

<link href="/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/weui.min.css?ttt" />
<style type="text/css">
.weui-msg__title{
  font-size:22px;
}
.weui-msg__desc{
  font-size:15px;
}
</style>
</head>
<body>
	
	<div class="page msg_success js_show">
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><?php if($status==2){ ?><i class="weui-icon-info weui-icon_msg"></i><?php }else{ ?><i class="weui-icon-success weui-icon_msg"></i><?php } ?></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title" ><?php echo $heading; ?></h2>
            <p class="weui-msg__desc"><?php echo $message;?></p>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <a href="<?php echo empty($url)?'javascript:history.go(-1);':$url;?>" class="weui-btn weui-btn_default">好的</a>
            </p>
        </div>
        <div class="weui-msg__extra-area">
            <div class="weui-footer">
                <p class="weui-footer__links">
                    <a href="javascript:void(0);" class="weui-footer__link">正在准备跳转...</a>
                    <?php if(empty($url)){ ?>
                    <script language="javascript">setTimeout("history.go(-1);", 10000);</script>  
                    <?php }else{ ?>
                    <script language="javascript">setTimeout("location.href='<?php echo $url; ?>'", 4500);</script> 
                    <?php } ?> 
                </p>

            </div>
        </div>
    </div>
</div>
</body>
</html>