<html>
<head>
<title>充值中心</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<script src="/js/jquery-1.11.3.min.js"></script>
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
img {
    vertical-align: middle;
}
</style>
</head>
<body>
<div class="banklist"><div><input type="radio" name="bankname" value="BOB"> <img src="bankimg/BOB.gif" alt="北京银行"></div><div><input type="radio" name="bankname" value="ICBC"> <img src="bankimg/ICBC.gif" alt="中国工商银行"></div><div><input type="radio" name="bankname" value="CEB"> <img src="bankimg/CEB.gif" alt="中国光大银行"></div><div><input type="radio" name="bankname" value="GDB"> <img src="bankimg/GDB.gif" alt="广发银行"></div><div><input type="radio" name="bankname" value="HXB"> <img src="bankimg/HXB.gif" alt="华夏银行"></div><div><input type="radio" name="bankname" value="CCB"> <img src="bankimg/CCB.gif" alt="中国建设银行"></div><div><input type="radio" name="bankname" value="BCM"> <img src="bankimg/BCM.gif" alt="交通银行"></div><div><input type="radio" name="bankname" value="CMSB"> <img src="bankimg/CMSB.gif" alt="中国民生银行"></div><div><input type="radio" name="bankname" value="ABC"> <img src="bankimg/5414c87492ad8.gif" alt="中国农业银行"></div><div><input type="radio" name="bankname" value="PAB"> <img src="bankimg/5414c0929a632.gif" alt="平安银行"></div><div><input type="radio" name="bankname" value="BOS"> <img src="bankimg/BOS.gif" alt="上海银行"></div><div><input type="radio" name="bankname" value="SPDB"> <img src="bankimg/SPDB.gif" alt="上海浦东发展银行"></div><div><input type="radio" name="bankname" value="SDB"> <img src="bankimg/SDB.gif" alt="深圳发展银行"></div><div><input type="radio" name="bankname" value="CIB"> <img src="bankimg/CIB.gif" alt="兴业银行"></div><div><input type="radio" name="bankname" value="PSBC"> <img src="bankimg/PSBC.gif" alt="中国邮政储蓄银行"></div><div><input type="radio" name="bankname" value="CMBC"> <img src="bankimg/CMBC.gif" alt="招商银行"></div><div><input type="radio" name="bankname" value="BOC"> <img src="bankimg/BOC.gif" alt="中国银行"></div><div><input type="radio" name="bankname" value="CNCB"> <img src="bankimg/CNCB.gif" alt="中信银行"></div><div><input type="radio" name="bankname" value="HKYH"> <img src="bankimg/58232d474964a.png" alt="汉口银行"></div><div><input type="radio" name="bankname" value="QSYH"> <img src="bankimg/58232d761bfb8.png" alt="齐商银行"></div><div><input type="radio" name="bankname" value="TAYH"> <img src="bankimg/58232db13b039.png" alt="泰安银行"></div><div><input type="radio" name="bankname" value="ZZYH"> <img src="bankimg/58232dd156049.png" alt="枣庄银行"></div></div>
<script>

$(function(){
 $("input[name=bankname]").click(function(){
  showCont();
 });
});
function showCont(){
$("input[name=pay_bankcode]").attr('value',$("input[name=bankname]:checked").attr('value'));

}
</script>
<?php
	$pay_memberid = "10106";   //商户ID
	$pay_orderid = "10106".date("YmdHis");    //订单号
	$pay_amount = "0.2";    //交易金额
	$pay_applydate = date("Y-m-d H:i:s");  //订单时间
	$pay_bankcode = "WXZF";   //银行编码
	$pay_notifyurl = "http://mp.bjxiuyun.com/pay2/server.php";   //服务端返回地址
	$pay_callbackurl = "http://mp.bjxiuyun.com/pay2/page.php";  //页面跳转返回地址
	
	$Md5key = "FNGcUrSKFJX8LqRWwfPcQRxbTjxUSu";   //密钥
	//$Md5key =md5($pay_memberid.$pay_orderid.$pay_amount.$pay_applydate.$pay_bankcode.$pay_notifyurl.$pay_callbackurl);
	$tjurl = "http://www.wanjio.com/Pay_Index.html";   //提交地址
	
	$requestarray = array(
            "pay_memberid" => $pay_memberid,
            "pay_orderid" => $pay_orderid,
            "pay_amount" => $pay_amount,
            "pay_applydate" => $pay_applydate,
            "pay_bankcode" => $pay_bankcode,
            "pay_notifyurl" => $pay_notifyurl,
            "pay_callbackurl" => $pay_callbackurl
        );
		
	    ksort($requestarray);
        reset($requestarray);
        $md5str = "";
        foreach ($requestarray as $key => $val) {
            $md5str = $md5str . $key . "=>" . $val . "&";
        }
		//echo($md5str . "key=" . $Md5key."<br>");
        $sign = strtoupper(md5($md5str . "key=" . $Md5key)); 
		$requestarray["pay_md5sign"] = $sign;
		
        $str = '<form id="Form1" name="Form1" method="post" action="' . $tjurl . '">';
        foreach ($requestarray as $key => $val) {
            $str = $str . '<input type="hidden" name="' . $key . '" value="' . $val . '">';
        }
        //$str = $str . '<input type="hidden" name="reserved2" value="RongBaoWx" >';
        $str = $str . '<input type="hidden" name="tongdao" value="RongBaoWx" >';
		$str = $str . '<input type="submit" value="提交">';
        $str = $str . '</form>';
        $str = $str . '<script>';
        //$str = $str . 'document.Form1.submit();';
        $str = $str . '</script>';
        exit($str);
?>
</body>
</html>
