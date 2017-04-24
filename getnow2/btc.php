<?php
set_time_limit(0);
date_default_timezone_set('Asia/Shanghai');
ini_set('date.timezone','Asia/Shanghai');
  function mysql_(){
  $con=mysql_connect("localhost","root","adminaz",strval(rand(1,9999)));
  if (!$con)
  {
  echo 'Could not connect: ' . mysql_error();
  }
  mysql_select_db("nzong", $con);
  return $con;
  }
  $con=mysql_();
  do{
  $resuilt= file_get_contents("https://www.okcoin.cn/api/v1/ticker.do?symbol=btc_cny");
  $resuilt=json_decode($resuilt);
  $res=object_array($resuilt);

  mysql_query("INSERT INTO st_type (type, price, max, min,time) 
VALUES ('btc', ".sprintf("%.2f",$res['ticker']['last']).", ".sprintf("%.2f",$res['ticker']['high']).",".sprintf("%.2f",$res['ticker']['low']).",".$res['date'].")");  //±ÈÌØ±Ò
  
  echo date("Y-m-d H:i:s",$res['date'])." - ".$res['date']."\n";


$outtime=strtotime(date("Y-m-d H:i:s")."-1 hour");
mysql_query("DELETE FROM st_type WHERE time<".$outtime." or price=0");
//echo date("Y-m-d H:i:s",time())."-".$res['EURUSD']['ask']."\n";
if(mysql_error()){
   mysql_close($con);
   $con=mysql_();
   echo "Reconnect\n";
   sleep(2);
  }
usleep(400000);
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