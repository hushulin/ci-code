<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>线上支付</title>
    <script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
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
<?php 
$amount=$_GET['amount']; 
$typeid=$_GET['type'];
$userid=$_GET['uid'];
switch($typeid){case '0':$type='微信支付';break;case '1':$type= '支付宝支付';break;case '2':$type='银行卡支付';break;};
$pay_memberid = "11678";   //商户ID
	$pay_orderid = "11678".date("YmdHis");    //订单号
	$pay_amount = $amount;    //交易金额
	$pay_applydate = date("Y-m-d H:i:s");  //订单时间
	if($typeid==1){
	$pay_bankcode = "alipay";   //银行编码
	$tongdao="ShaoBeiZfb";
	}else if($typeid==0){
	$pay_bankcode = "WXZF";   //银行编码
	$tongdao="WftWx";
	}else if($typeid==2){
	$pay_bankcode = $_GET['bankcode'];
	}
	$pay_notifyurl = "http://".$_SERVER['HTTP_HOST']."/pay2/server.php";   //服务端返回地址
	$pay_callbackurl = "http://".$_SERVER['HTTP_HOST']."/pay2/page.php";  //页面跳转返回地址
	$Md5key = "BcCWdLbiCHiBMtMMWbvp6AMTwDGedn";   //密钥
	$tjurl = "http://zf.cnzypay.com/Pay_Index.html";   //提交地址
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
         $requestarray["pay_md5sign"] =$sign;
         if($typeid<2){
$post="pay_amount=".$pay_amount."&pay_applydate=".$pay_applydate."&pay_bankcode=".$pay_bankcode."&pay_callbackurl=".$pay_callbackurl."&pay_memberid=".$pay_memberid."&pay_notifyurl=".$pay_notifyurl."&pay_orderid=".$pay_orderid."&pay_md5sign=".$sign."&tongdao=".$tongdao."&pay_productname=充值&pay_reserved1=".$userid;
}else{
    $post="pay_amount=".$pay_amount."&pay_applydate=".$pay_applydate."&pay_bankcode=".$pay_bankcode."&pay_callbackurl=".$pay_callbackurl."&pay_memberid=".$pay_memberid."&pay_notifyurl=".$pay_notifyurl."&pay_orderid=".$pay_orderid."&pay_md5sign=".$sign."&pay_reserved1=".$userid;
}

/**
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
     */
    function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
    }
     

?>
    <ul class="me-list">
    <li><font color="#555">充值金额：</font><?php echo $amount;?>元</li>
    <li><font color="#555">支付方式：</font><?php echo $type;?></li>
    <li style="text-align:center"><?php $res =request_post($tjurl, $post);       
       $res=str_replace('Uploads/codepay','http://zf.cnzypay.com/Uploads/codepay',$res);
       $res=str_replace('/Pay_Index.html','http://zf.cnzypay.com/Pay_Index.html',$res);
      //echo  htmlspecialchars($res);
  
       //preg_match($patten,$res,$result);  
       
       print_r($res);
      
        
       
        ?><br>
        <?php if($typeid==1){ ?>
        <font color=red>请长按保存，在支付宝扫一扫选择相册打开图片</font>
        <?php }else{ ?>
        <font color=red>第一步长按图片保存，第二步打开微信扫一扫 从相册选择刚刚保存的二维码 充值完成。</font>
        <?php } ?>
        </li>
    </ul>

</body>
</html>