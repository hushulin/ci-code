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
        ////����������������
       $context = stream_context_create($parm);
$result= file_get_contents("http://hq.sinajs.cn/etag.php?_=".time()."&list=hf_CL",false,$context);
$res=explode('"',$result);
$res=explode(',',$res[1]);
 // $resuilt=json_decode($resuilt);
  //$res=object_array($resuilt);
  $formatted = sprintf("%.2f", rand(-5,5)/100);
  $lastprice=$res[0]+$formatted ;
mysql_query("INSERT INTO st_type (type, price,time) 
VALUES ('USOil', ".sprintf("%.2f",$lastprice).", ".time().")");  //ԭ��
echo date("Y-m-d H:i:s",time())."-".$res[0]."\n";

$outtime=strtotime(date("Y-m-d H:i:s")."-1 hour");
mysql_query("DELETE FROM st_type WHERE time<".$outtime." or price=0");
//echo date("Y-m-d H:i:s",time())."-".$res['EURUSD']['bid']."\n";
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