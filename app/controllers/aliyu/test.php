<?php
    include "TopSdk.php";
    date_default_timezone_set('Asia/Shanghai'); 

   $c = new TopClient;
$c->appkey = "23632659";
$c->secretKey = "5a4f8bea4e97e6420829e8228b39aae9";
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req->setExtend("123456");
$req->setSmsType("normal");
$req->setSmsFreeSignName("注册验证");
$req->setSmsParam("{\"code\":\"1234\",\"product\":\"444\"}");
$req->setRecNum("15767641281");
$req->setSmsTemplateCode("SMS_46300200");
$resp = $c->execute($req);
print_r( $resp);
?>