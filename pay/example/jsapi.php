
<?php 
session_start();
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
//require_once '../../app/config/database.php'; //数据库信息
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);




//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}
    //连接数据库
  $con = mysql_connect(WxPayConfig::DB_HOST,WxPayConfig::DB_USER,WxPayConfig::DB_PASSWORD);
  mysql_select_db("nzong", $con);
 //①、获取用户openid
  $tools = new JsApiPay();
//$openId = $tools->GetOpenid();
  $result=mysql_query('select * from st_setting where 1');
  $setting=mysql_fetch_array($result);
  $result=mysql_query('select * from st_user where id='.$_GET['uid']);
  $result=mysql_fetch_array($result);
  $openId=$result['openid'];
  mysql_close($con);
  $uid=$_GET['uid'];
  $amount=$_GET['amount'];
//$openId="oLNPTwy_kGpj94iqhzFzSyQd3YDA";
if($amount<$setting['minrecharge']){
header('Location:show_error.php?l='.$setting['minrecharge']);
exit;
}

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("充值");
$input->SetAttach($uid);
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($amount*100);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url(WxPayConfig::Notify_url);
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信线上支付</title>
    <script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				console.log(res.err_desc);
				if(res.err_msg=="get_brand_wcpay_request:ok"){
				location.href="show_message.php?m=<?php echo $amount;?>";
				}
				//NaNget_brand_wcpay_request:ok
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
				alert(value1 + value2 + value3 + value4 + ":" + tel);
			}
		);
	}
	/*
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	*/
	</script>
	<style>
	body{
	margin:0;
	}
	ul{
	list-style:none;
	margin:0;padding:0
	}
	.me-list{
    padding:15px;
}
.me-list li{
    border-bottom:1px solid #eee;
    padding:12px 0px;
    font-size:16px;
}

	</style>
</head>
<body>
    <ul class="me-list">
    <li><font color="#555">充值金额：</font><?php echo $amount;?>元</li>
    <li><font color="#555">支付方式：</font>微信支付</li>
    </ul>
	<div align="center">
		<button style="width:90%; height:40px; border-radius: 5px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" id="topay" type="button" onclick="callpay()" >立即支付</button>
	</div>
	<script>
	$(document).ready(function(){
	setTimeout('callpay()',500); 
	});
	</script>
</body>
</html>