<?php
ini_set('date.timezone','Asia/Shanghai');
   
          $ReturnArray = array( // 返回字段
            "memberid" => $_REQUEST["memberid"], // 商户ID
            "orderid" =>  $_REQUEST["orderid"], // 订单号
            "amount" =>  $_REQUEST["amount"], // 交易金额
            "datetime" =>  $_REQUEST["datetime"], // 交易时间
            "returncode" => $_REQUEST["returncode"]
        );
      $userid=$_REQUEST["reserved1"];
        $Md5key = "BcCWdLbiCHiBMtMMWbvp6AMTwDGedn";
        //$sign = $this->md5sign($Md5key, $ReturnArray);
		$str = "交易成功！订单号：".$_REQUEST["orderid"].'|user:'.$userid;
                   file_put_contents("success.txt",$str."\n", FILE_APPEND);
		///////////////////////////////////////////////////////
		ksort($ReturnArray);
        reset($ReturnArray);
        $md5str = "";
        foreach ($ReturnArray as $key => $val) {
            $md5str = $md5str . $key . "=>" . $val . "&";
        }
        $sign = strtoupper(md5($md5str . "key=" . $Md5key)); 
		///////////////////////////////////////////////////////
        if ($sign == $_REQUEST["sign"]) {
            if ($_REQUEST["returncode"] == "00") {
            //连接数据库
    $con = mysql_connect('localhost','root','adminaz');
    mysql_select_db("nzong", $con);
    $result = mysql_query("SELECT * FROM st_setting where 1");
		$setting = mysql_fetch_array($result);
		$result = mysql_query("SELECT * FROM st_recharge_log where transaction_id='". $_REQUEST["orderid"]."'");
		$result = mysql_fetch_array($result);
		$data['result']=$result;
		$is_existe=$result;
		
		$data['is_existe']=$is_existe;
		
		if($is_existe==false){
		$amount=$_REQUEST["amount"];
		if($amount>=$setting['r_cashback1']){
		$actual=$amount+$amount*($setting['r_cashback2']/100);
		}else{
		$actual=$amount;
		}
		mysql_query("INSERT INTO st_recharge_log (amount,actual,userid,openid,status,is_human,time,transaction_id) VALUES (".$amount.",".$actual.",".intval($userid).",'no',1,0,".strtotime($_REQUEST["datetime"]).",'". $_REQUEST["orderid"]."')");
		$result = mysql_query("SELECT * FROM st_balance where type=1 and uid=".intval($userid));
		$result = mysql_fetch_array($result);
		$balance=$result['balance'];
		mysql_query("UPDATE st_balance SET balance = balance+".$actual." WHERE uid = ".intval($userid)." AND type=1");
		$data['error1']=mysql_error();
		mysql_query("UPDATE st_user SET can_cash = can_cash+".($actual*$setting['cashmultiple'])." WHERE id = ".intval($userid)); //提现留底
		$data['error2']=mysql_error();
		if($setting['rewardtype']==0){
	 file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/index.php/br/brandingreward?amount='.$amount."&uid=".$userid);
	}
		}
				   $str = "交易成功！订单号：".$_REQUEST["orderid"].'|user:'.$userid;
                   file_put_contents("success.txt",$str."\n", FILE_APPEND);
				   exit("ok");
            }
        }

?>