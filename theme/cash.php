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
    background:#eee;
    -webkit-font-smoothing: antialiased;
}
li{
  color:#666;
}
.me-list{
  margin:15px 0px;
  background:#fff;
  padding:0 10px;
}
.weui-cell__hd i{
  float:left
}
.weui-cells{
  margin-top:0;
}
</style>
  <body>
  <ul class="me-list" style="border-bottom:1px solid #ddd">
  <form action="tocash" method="post">
  
  <li style="overflow:auto;border-bottom:0">
  <img class="pull-left" src="<?php echo $userinfo['avatar'];?>" height="45" /><span style="margin-left:5px;"><?php echo $userinfo['nickname'];?></span>
  <p style="margin-left:50px;font-size:13px;color:#888 ">余额：<?php echo $userinfo['balance'];?></p>
  </li>
  <div class="weui-cells weui-cells_checkbox">
  <!--
            <label class="weui-cell weui-check__label" for="s11">
                <div class="weui-cell__hd">
                    <input type="radio" class="weui-check" name="paytype" value="0" id="s11" checked="checked">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p>提现到微信钱包</p>
                </div>
            </label>
            -->
           
            <label class="weui-cell weui-check__label" for="s12">
                <div class="weui-cell__hd">
                    <input type="radio" name="paytype" value="1" class="weui-check" id="s12" checked="checked">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p>提现到支付宝</p>
                </div>
            </label>
            
            <label class="weui-cell weui-check__label" for="s13">
                <div class="weui-cell__hd">
                    <input type="radio" name="paytype" value="2" class="weui-check"   id="s13" >
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p>提现到银行卡</p>
                </div>
            </label>
        </div>
      <li id="alipay"><span style="display:block;width:55px;line-height:42px;font-size:16px;" class="pull-left">支付宝</span><input class="input-li" type="number" id="alipay_" name="alipay" placeholder="提现支付宝账号"  /></li>
        <li id="bankIDcard" style="display:none" ><span style="display:block;width:55px;line-height:42px;font-size:16px;" class="pull-left">卡号</span><input class="input-li" type="number" id="bankIDcard_" name="bankIDcard" placeholder="银行卡号"  /></li>
        <li id="bankname"  style="display:none"><span style="display:block;width:55px;line-height:42px;font-size:16px;" class="pull-left">开户行</span><input class="input-li" type="text" id="bankname_" name="bankname" placeholder="开户银行名称(具体到省市)"  /></li>
  <li><span style="display:block;width:45px;line-height:42px;font-size:16px;" class="pull-left">金额</span><input class="input-li" type="number" id="amount" name="amount" placeholder="提现金额<?php if($cashmin>0){ ?>必须大于<?php echo $cashmin."元"; } ?>"  /></li>
  <li style="border-bottom:0"><img src="/index.php/captcha/get_code"  class="pull-right" id="verify" title="点击刷新" /><input class="input-li" name="code" id="code" placeholder="请输入右边图形验证码"  /></li>
  </ul>
  <p class="tip">仅支持提现至实名认证信息办理的账户</p>
  <p class="tip red">每日提现最大次数为<?php echo $cashtimes;?>次<?php echo $setting['cashfee']>0?'，手续费为'.$setting['cashfee'].'%':'';?></p>
  <p class="tip">通过审核后，提现资金将在下一个工作日到账。</p>
  <center><button id="tocash" class="btn-to" type="submit">提交</button></center>
  </form>
  <script>
  $(".weui-check").change( 
  function(){
  if($(".weui-check:checked").val()==1){
  $('#alipay').show();
  $('#bankIDcard').hide();
  $('#bankname').hide();
  }else{
  $('#bankIDcard').show();
  $('#bankname').show();
  $('#alipay').hide()
  }
  }
  );
  /*
  $("#verify").click(function(){
  $("#verify").attr("src","/index.php/captcha/get_code?"+Math.random());
  });
  $("#tocash").click(function(){
  if(parseInt($("#amount").val())<=0||$("#amount").val()==""){
  wxalert("请输入正确的金额",'好');
  return false;
  }
  if($("#code").val()==""){
  wxalert("请输入验证码",'好');
  return false;
  }
 $.ajax({url:'/index.php/me/tocash',type:'POST',data:{amount:$("#amount").val(),code:$("#code").val()},dataType:'json',async: false,success:function(data){
    datas=eval(data);
    wxalert(datas.msg,'好');
    if(datas.status==1){
    //window.location.href='/index.php/me/userinfo';
    }
    }});
  });
  */
  </script>
  <div style="display:none">
  <?php echo $setting['statistics'];?>
  </div>
  </body>
 </html>
	