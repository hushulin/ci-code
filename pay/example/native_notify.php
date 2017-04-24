<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';
//require_once '../../app/config/database.php'; //数据库信息




//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class NativeNotifyCallBack extends WxPayNotify
{
	public function unifiedorder($openId, $product_id)
	{
		//统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("11");
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url(WxPayConfig::Notify_url);
		$input->SetTrade_type("NATIVE");
		$input->SetOpenid($openId);
		$input->SetProduct_id($product_id);
		$result = WxPayApi::unifiedOrder($input);
		Log::DEBUG("unifiedorder:" . json_encode($result));
		return $result;
	}
	
	public function NotifyProcess($data, &$msg)
	{
		//echo "处理回调";
		// 交易流水号 $data['transaction_id'];
		// 备注 $data['attach'];
		//$data['database']=$db['default']['hostname'];
		
		//连接数据库
    $con = mysql_connect(WxPayConfig::DB_HOST,WxPayConfig::DB_USER,WxPayConfig::DB_PASSWORD);
    mysql_select_db("nzong", $con);
    $result = mysql_query("SELECT * FROM st_setting where 1");
		$setting = mysql_fetch_array($result);
		$result = mysql_query("SELECT * FROM st_recharge_log where transaction_id='".$data['transaction_id']."'");
		$result = mysql_fetch_array($result);
		$data['result']=$result;
		$is_existe=$result;
		
		$data['is_existe']=$is_existe;
		
		if($is_existe==false){
		$amount=intval($data['total_fee'])/100;
		if($amount>=$setting['r_cashback1']){
		$actual=$amount+$amount*($setting['r_cashback2']/100);
		}else{
		$actual=$amount;
		}
		mysql_query("INSERT INTO st_recharge_log (amount,actual,userid,openid,status,is_human,time,transaction_id) VALUES (".$amount.",".$actual.",".intval($data['attach']).",'".$data['openid']."',1,0,".strtotime($data['time_end']).",'".$data['transaction_id']."')");
		$result = mysql_query("SELECT * FROM st_balance where type=1 and uid=".intval($data['attach']));
		$result = mysql_fetch_array($result);
		$balance=$result['balance'];
		mysql_query("UPDATE st_balance SET balance = balance+".$actual." WHERE uid = ".intval($data['attach'])." AND type=1");
		$data['error1']=mysql_error();
		mysql_query("UPDATE st_user SET can_cash = can_cash+".($actual*$setting['cashmultiple'])." WHERE id = ".intval($data['attach'])); //提现留底
		$data['error2']=mysql_error();
		}
		Log::DEBUG("call back:" . json_encode($data)."\n");
		mysql_close($con);
		
		if(!array_key_exists("openid", $data) ||
			!array_key_exists("product_id", $data))
		{
			$msg = "回调数据异常";
			return false;
		}
		 
		$openid = $data["openid"];
		$product_id = $data["product_id"];
		
		//统一下单
		$result = $this->unifiedorder($openid, $product_id);
		if(!array_key_exists("appid", $result) ||
			 !array_key_exists("mch_id", $result) ||
			 !array_key_exists("prepay_id", $result))
		{
		 	$msg = "统一下单失败";
		 	return false;
		 }
		
		$this->SetData("appid", $result["appid"]);
		$this->SetData("mch_id", $result["mch_id"]);
		$this->SetData("nonce_str", WxPayApi::getNonceStr());
		$this->SetData("prepay_id", $result["prepay_id"]);
		$this->SetData("result_code", "SUCCESS");
		$this->SetData("err_code_des", "OK");
		return true;
	}
}

Log::DEBUG("begin notify!");
$notify = new NativeNotifyCallBack();
$notify->Handle(true);
