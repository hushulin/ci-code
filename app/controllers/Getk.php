<?php
header('Content-type:text/json');
//header('Content-type: text/javascript');
defined('BASEPATH') OR exit('No direct script access allowed');

class Getk extends ST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
    {
        parent::__construct();
       $this->load->library('session');
        $this->load->model('Common');
        $this->Common->lottery();
    }
	public function index()
	{
	if($_GET['s']=="btc"){
   
	if(strlen($_GET['t'])==1){
	$json=file_get_contents("http://api.huobi.com/staticmarket/btc_kline_00".$_GET['t']."_json.js");
	}else{
	$json=file_get_contents("http://api.huobi.com/staticmarket/btc_kline_0".$_GET['t']."_json.js");
	}
	 //$r=array('msg'=>$json);
	$r=json_decode($json);
	$i=0;
	foreach($r as $a){
	
	$a[0]=substr($a[0],0,12);
	$y=substr($a[0],0,4);
	$m=substr($a[0],4,2);
	$d=substr($a[0],6,2);
	$h=substr($a[0],8,2);
	$f=substr($a[0],10,2);
	$a[0]=$y."/".$m."/".$d." ".$h.":".$f;
 //$a[0]=intval(strtotime($a[0]));
	//$a[0]=date('Y-m-d H:i:s');
	$z[$i]=array($a[0],$a[1],$a[2],$a[3],$a[4]);
	//array_unshift($t,$z[$i]);
	//array_push($z,array($a[0],$a[1],$a[2],$a[3],$a[4]));

	
	$i++;;
	}
	
	$t=array($z[272],$z[273],$z[274],$z[275],$z[276],$z[277],$z[278],$z[279],$z[280],$z[281],$z[282],$z[283],$z[284],$z[285],$z[286],$z[287],$z[288],$z[289],$z[290],$z[291],$z[292],$z[293],$z[294],$z[295],$z[296],$z[297],$z[298],$z[299]);
	$r2=array("msg"=>$t);
	echo json_encode($r2,JSON_UNESCAPED_SLASHES);
	}else{
	
	$ip=array('183','116','106','120','202','117');
$ch=curl_init();
$random=rand(0,5);
$ip1=$ip[$random];
$ip2=rand(15,215);
$ip3=rand(15,215);
$ip4=rand(15,215);
$header = array( 
'CLIENT-IP:'.$this->get_real_ip(), 
'X-FORWARDED-FOR:'.$this->get_real_ip(), 
); 
curl_setopt($ch, CURLOPT_URL, "http://copy.formaxmarket.com/Ajax/chart_data?symbol=".$_GET['s']."&period=".$_GET['t']."&simple=0&_=".time()*1000);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.158888800.95 Safari/537.36 SE 2.X MetaSr 1.0");
//curl_setopt($ch, CURLOPT_HEADER, 0);
//执行并获取HTML文档内容
$output = curl_exec($ch);
//释放curl句柄
curl_close($ch);
	
    //$json=file_get_contents("http://copy.formaxmarket.com/Ajax/chart_data?symbol=".$_GET['s']."&period=".$_GET['t']."&simple=0&_=".time()*1000);
    echo $output;
    }
    
	}
	public function newesttran(){
	$ptype=empty($_GET['t'])?1:intval(trim($_GET['t']));
	$query=$this->db->query("select st_tran_log.direction,st_tran_log.amount,st_type_setting.name,FROM_UNIXTIME(st_tran_log.time,'%H:%i:%s') as time from st_tran_log left join st_type_setting on st_tran_log.type=st_type_setting.nickname where st_tran_log.ptype=".$ptype." order by FROM_UNIXTIME(time,'%Y/%m/%d %H:%i:%s') desc limit 11");
	$tran=$query->result_array();
	echo json_encode($tran);
	}
	public function position(){
	$ptype=empty($_GET['t'])?1:intval(trim($_GET['t']));
	$query=$this->db->query("select st_tran_log.direction,st_tran_log.amount,st_type_setting.name,FROM_UNIXTIME(st_tran_log.time,'%m-%d %H:%i:%s') as time,st_tran_log.price,st_tran_log.profit from st_tran_log left join st_type_setting on st_tran_log.type=st_type_setting.nickname where st_tran_log.ptype=".$ptype." and st_tran_log.profit=0 and st_tran_log.userid=".$_SESSION['userid']." order by FROM_UNIXTIME(endtime,'%Y/%m/%d %H:%i:%s') desc ");
	$tran=$query->result_array();
	echo json_encode($tran);
	}
	public function metran(){
	
	$ptype=empty($_GET['t'])?1:intval(trim($_GET['t']));
	$query=$this->db->query("select st_tran_log.direction,st_tran_log.amount,st_type_setting.name,FROM_UNIXTIME(st_tran_log.endtime,'%m-%d %H:%i:%s') as time,st_tran_log.status,st_tran_log.profit from st_tran_log left join st_type_setting on st_tran_log.type=st_type_setting.nickname where st_tran_log.ptype=".$ptype." and st_tran_log.profit<>0 and st_tran_log.userid=".$_SESSION['userid']." order by FROM_UNIXTIME(endtime,'%Y/%m/%d %H:%i:%s') desc limit 10");
	$tran=$query->result_array();
	echo json_encode($tran);
	}
	
	
	public function myrecharge(){
	$ptype=empty($_GET['t'])?1:intval(trim($_GET['t']));
	$query=$this->db->query("select *,FROM_UNIXTIME(time,'%Y-%m-%d %H:%i:%s') as time from st_recharge_log where userid=".$_SESSION['userid']." and status=1 order by time desc");
	$rechargeLog=$query->result_array();
	echo json_encode($rechargeLog);
	}
	public function mycash(){
	$ptype=empty($_GET['t'])?1:intval(trim($_GET['t']));
	$query=$this->db->query("select *,FROM_UNIXTIME(time,'%Y-%m-%d %H:%i:%s') as time from st_cash_log where uid=".$_SESSION['userid']." order by time desc");
	$cashLog=$query->result_array();
	echo json_encode($cashLog);
	}
	
	/**
 *生成二维码 
**/
public function qrcode(){
  $url=urlencode($_GET['url']);
  $w=empty($_GET['w'])?150:$_GET['w'];
  $h=empty($_GET['h'])?150:$_GET['h'];
  $qrcode=file_get_contents("http://pan.baidu.com/share/qrcode?w=".$w."&h=".$h."&url=".$url);
  echo $qrcode;
}
function get_real_ip(){
$ip=false;
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
$ip = $_SERVER["HTTP_CLIENT_IP"];
}
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
for ($i = 0; $i < count($ips); $i++) {
if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
$ip = $ips[$i];
break;
}
}
}
return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

}
