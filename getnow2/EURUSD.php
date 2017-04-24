<?php
set_time_limit(0);
date_default_timezone_set('Asia/Shanghai');
ini_set('date.timezone','Asia/Shanghai');
function mysql_(){
$con=mysql_connect("localhost","root","adminaz");
if (!$con)
  {
  echo 'Could not connect: ' . mysql_error();
  }
  mysql_select_db("nzong", $con);
  }
  do{
  $ip=array('183','116','106','120','202','117');
$ch=curl_init();
$random=rand(0,5);
$ip1=$ip[$random];
$ip2=rand(15,215);
$ip3=rand(15,215);
$ip4=rand(15,215);
$header = array( 
'CLIENT-IP:'.$ip1.'.'.$ip2.'.'.$ip3.'.'.$ip4, 
'X-FORWARDED-FOR:'.$ip1.'.'.$ip2.'.'.$ip3.'.'.$ip4, 
); 
curl_setopt($ch, CURLOPT_URL, "http://copy.formaxmarket.com/Forex/quotes?syms=EURUSD&_=");
curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.158888800.95 Safari/537.36 SE 2.X MetaSr 1.0");
//curl_setopt($ch, CURLOPT_HEADER, 0);
//执行并获取HTML文档内容
$output = curl_exec($ch);
//释放curl句柄
curl_close($ch);
$resuilt=json_decode($output);
  $res=object_array($resuilt);
mysql_query("INSERT INTO st_type (type, price,time) 
VALUES ('EURUSD', ".sprintf("%.5f",$res['EURUSD']['bid']).", ".time().")");  //欧兑美
$outtime=strtotime(date("Y-m-d H:i:s")."-1 hour");
mysql_query("DELETE FROM st_type WHERE time<".$outtime." or price=0");
echo date("Y-m-d H:i:s",time())."-".$res['EURUSD']['bid']."\n";
if(mysql_error()){
   mysql_close($con);
   $con=mysql_();
   echo "Reconnect\n";
   sleep(2);
  }
usleep(800000);
}while(true);
function object_array($array) {  
    if(is_object($array)) {  
        $array = (array)$array;  
     } if(is_array($array)) {  
         foreach($array as $key=>$value) {  
             $array[$key] = object_array($value);  
             }  
     }  
     return $array;  
}
 mysql_close($con); 
?>