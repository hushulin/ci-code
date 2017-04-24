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
    height:100%;
}
html{
    height:100%; 
}
.explain .text {
    margin-top: 30px;
    margin-top: 20px;
    float: left;
    color: #dddddd;
    padding:15px;
}
</style>
  <body>
  <div class="mobile_wrap">
		<div class="balance">
        	<h2>余额<i><?php echo $balance;?></i>元</h2>
        </div>
   <div class="recharge-active">
   <h1>
        	充<b></b>元 <!--<i>返现<span></span>元</i>--></h1>
           <!-- <h2>单笔满<?php echo $setting['r_cashback1'];?>元<i><?php echo $setting['r_cashback2'];?>%赠金</i></h2>-->
            <ul>
            	<li>
                	<p><i>5000</i>元</p>
                    <!--<span><?php echo 5000>=$setting['r_cashback1']?'返'. $setting['r_cashback2'].'%':'不返';?>
                    </span>-->
                </li>
                <li>
                	<p><i>2000</i>元</p>
                   <!-- <span><?php echo 2000>=$setting['r_cashback1']?'返'. $setting['r_cashback2'].'%':'不返';?></span>-->
                </li>
                <li>
                	<p><i>1000</i>元</p>
                    <!--<span><?php echo 1000>=$setting['r_cashback1']?'返'. $setting['r_cashback2'].'%':'不返';?></span>-->
                </li>
                <li>
                
                	<p><i>800</i>元</p>
                   <!-- <span><?php echo 800>=$setting['r_cashback1']?'返'. $setting['r_cashback2'].'%':'不返';?></span>-->
                </li>
                <li class="slct">
                	<p><i>500</i>元</p>
                   <!-- <span><?php echo 500>=$setting['r_cashback1']?'返'. $setting['r_cashback2'].'%':'不返';?></span>-->
                </li>
                <li>
                	<p><i>300</i>元</p>
                   <!-- <span><?php echo 300>=$setting['r_cashback1']?'返'. $setting['r_cashback2'].'%':'不返';?></span>-->
                </li>
                <li>
                	<p><i>200</i>元</p>
                    <!--<span><?php echo 200>=$setting['r_cashback1']?'返'. $setting['r_cashback2'].'%':'不返';?></span>-->
                </li>
                <li>
                	<p><i>100</i>元</p>
                    <!--<span><?php echo 100>=$setting['r_cashback1']?'返'. $setting['r_cashback2'].'%':'不返';?></span>-->
                </li>
                <li class="not">
                	<p>其它金额</p>
                    <input type="number" value="" id="input_money">
                </li>
            </ul>
        </div>     
        <div class="prompt" id="top">
        	<p>提示：微信充值秒到账。不限支付金额，若提示订单超出单笔限额，请核实您账户及网银的每日消费限额。</p>
        	 <div class="weui-cells weui-cells_checkbox" style="border-radius:5px;">
            <label class="weui-cell weui-check__label" for="s11">
                <div class="weui-cell__hd">
                    <input type="radio" class="weui-check" name="paytype" value="0" id="s11" checked="checked">
                    <i class="weui-icon-checked"></i>
                </div>
                
                <div class="weui-cell__bd">
                    <p style="color:#333">微信充值</p>
                </div>
            </label>
            
        </div>
<style>
 .banklist div {
    width: 190px;
    height: 50px;
    line-height: 50px;
    float: left;
    margin-left: 5px;
    margin-top: 15px;
    text-align: right;
}
 .banklist div img {
    width: 150px;
    height: 35px;
    cursor: pointer;
}
}
input[type=radio], input[type=checkbox] {
    margin: 4px 0 0;
    margin-top: 1px \9;
    line-height: normal;
}
input[name=bankname]{
        -webkit-appearance: radio;
}
img {
    vertical-align: middle;
}
inpuy
</style>
        
            <input class="but_sub" type="submit" value="马上充值" id="torecharge">
           
            <span><input type="checkbox"><i></i>我已阅读并同意《用户充值协议》，知悉充值金额满足要求即可提现。<a onclick="show()">查看协议详情</a></span>
        </div>
        <div class="explain" style="display:none">
        	<div class="text">
            	<p>尊敬的用户、为保障您的合法权益，请您在参加充返活动前仔细阅读本协议。在您点击“马上充值”按钮后，我们默认您已经知悉如下活动条款。</p>
				<p>一、活动内容</p>
                <p>单笔充值<?php echo $setting['r_cashback1'];?>元以下，不享受返现；</p>
                <p>单笔充值<?php echo $setting['r_cashback1'];?>元以上，享受<?php echo $setting['r_cashback2'];?>%返现；</p>
</p>
            </div>
       

        	<div class="text">
				<p>二.余额构成</p>
                <p>您实际支付的充值本金加上返现金额会构成您的账户余额（人民币）。</p>
                <p>例：单笔充值100，返现100，则账户余额为200。</p>
            </div>			
        	<div class="text">
				<p>三.充值余额使用规则</p>
                <p>余额可用于在网站中进行各类投资。无任何限制。</p>
            </div>	
        	<div class="text">
				<p>四.充值余额提现规则</p>
                <p>每笔充值余额提现，需达到充值余额<?php echo $setting['cashmultiple'];?>倍以上交易流水，即可全部提现，提现10分钟之内到账。</p>
            </div>				
        	<div class="text">
				<p>六.特别声明</p>
                <p>1.请您根据自己的投资情况进行充值，充值次数不设任何限制；</p>
                <p>2.充返活动福利仅提供给正当、合法使用网站客户。每位参与者的账号、手机设备号、身份证号和微信号都必须是唯一的，任意信息与其他用户重复都不能参加该活动； 活动中，一旦发现作弊行为，我们有权取消相关账户活动返现金额、追回作弊所得（对应赠送奖品）、回收账号使用权，并保留取消作弊人后续参与任何活动的权利，必要时会追究其法律责任；
</p>
                <p>3.本次活动最终解释权归官方所有。</p>
            </div>			  
    </div>

</div>
<script>
function show(){
    if($('.explain').css('display')=='none'){
    $('.explain').show()
    }else{
    $('.explain').hide()
    }
}
$('.recharge-active ul li:not(.not)').click(function() {
        $(this).addClass('slct').siblings().removeClass('slct');
        //var text=$(this).find('i').text();
        //$('.recharge-active h1 b').text(text);
        $('.recharge-active h2').show();
        $('.recharge-active ul li.not input').fadeOut();
    })
$('.recharge-active ul li.not').click(function() {
        $(this).find('input').show().select();
        $("#input_money").val("");
        $('.recharge-active ul li:not(.not)').removeClass('slct');
    }); 
	$('.recharge-active ul li:not(.other)').click(function() {
        //$(this).addClass('slct').siblings().removeClass('slct');
        var text = $(this).find('i').text();
        $('.recharge-active h1 b').text(text);
        if(parseFloat(text) < <?php echo $setting['r_cashback1'];?>){
            $('.recharge-active h1 i').text('不返现');
            }else{
            $('.recharge-active h1 i').html('返现<span>' + parseFloat(text)*<?php echo ($setting['r_cashback2']/100);?> + '</span>元');
            }
        //$('.recharge-active h1 i').html('返现<span>' + text*<?php echo ($setting['r_cashback2']/100);?> + '</span>元');
        //$('.recharge-active h2').hide();
    });
    
    $('#input_money').click(function() {
            $('.recharge-active h1 b').html('0');
            $('.recharge-active h1 i').text('不返现');
    });
 $('#input_money').on('input propertychange',
    function() {
        $(".slct").removeClass("slct");
        money = $("#input_money").val();
		if(money<0){
			
            $('.recharge-active h1 b').text('<?php echo $setting['minrecharge'];?>');
            if(<?php echo $setting['minrecharge'];?> < <?php echo $setting['r_cashback1'];?>){
            $('.recharge-active h1 i').text('不返现');
            }else{
            $('.recharge-active h1 i').html('返现<span>' + <?php echo $setting['minrecharge'];?>*<?php echo ($setting['r_cashback2']/100);?> + '</span>元');
            }
            $("#input_money").val('<?php echo $setting['minrecharge'];?>');
		}else if (money < <?php echo $setting['r_cashback1'];?>) {
            $('.recharge-active h1 b').text(money);
            $('.recharge-active h1 i').text('不返现');
        } else {
            $(".slct").removeClass("slct");
            $('.recharge-active h1 b').text(money);
            $('.recharge-active h1 i').html('返现<span>' + money*<?php echo ($setting['r_cashback2']/100);?> + '</span>元');
        }
    });
    $("#torecharge").click(function(){
    
    amount=$('.recharge-active h1 b').html();
    if(amount<<?php echo $setting['minrecharge'];?>){
    wxalert("最低充值为"+<?php echo $setting['minrecharge'];?>+"元起",'好');
    return false;
    }
    window.location.href='/pay2/jsapi.php?amount='+amount+'&uid='+<?php echo $_SESSION['userid'];?>+'&type='+$("input[name=paytype]:checked").attr('value')+'&bankcode='+$("input[name=bankname]:checked").attr('value');
  
    })
   $("input[name=paytype]").change(function() { 
   if($("input[name=paytype]:checked").attr('value')=='2'){
    $('.banklist').show();
    }else{
    $('.banklist').hide();
    }
   });
    $(".recharge-active ul li.slct").trigger("click");
</script>
<div style="display:none">
<?php echo $setting['statistics'];?>
</div>
  </body>
 </html>
	