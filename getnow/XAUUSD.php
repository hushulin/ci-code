<?php
set_time_limit(0);
date_default_timezone_set('Asia/Shanghai');
ini_set('date.timezone','Asia/Shanghai');
function mysql_(){
mysql_close($con);
$con=mysql_connect("localhost","root","adminaz");
if (!$con)
  {
  echo 'Could not connect: ' . mysql_error();
  }
  mysql_select_db("nzong", $con);
  }
  do{
  $parm=array(
        "http"=>array(
                "method"=>"GET",
                "timeout"=>2
                ),
        );
        ////创建数据流上下文
$context = stream_context_create($parm);
$resuilt= file_get_contents("http://copy.formaxmarket.com/Forex/quotes?syms=XAUUSD&_=".time(),false,$context);
  $resuilt=json_decode($resuilt);
  $res=object_array($resuilt);
  $formatted = sprintf("%.2f", rand(-20,30)/100);
  $lastprice=$res['XAUUSD']['bid']+$formatted ;
  if($lastprice>0.5){
mysql_free_result(mysql_query("INSERT INTO st_type (type, price,time) 
VALUES ('XAUUSD', ".sprintf("%.5f",$lastprice).", ".time().")"));  //黄金
echo date("Y-m-d H:i:s",time())."-".$res['XAUUSD']['bid']."\n";

$outtime=strtotime(date("Y-m-d H:i:s")."-1 hour");
mysql_query("DELETE FROM st_type WHERE time<".$outtime." or price=0");
//echo date("Y-m-d H:i:s",time())."-".$res['EURUSD']['bid']."\n";
if(mysql_error()){
   mysql_close($con);
   $con=mysql_();
   echo "Reconnect\n";
   sleep(2);
  }
usleep(1000000);
}
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