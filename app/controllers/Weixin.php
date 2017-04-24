<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weixin extends ST_Controller {

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
        $this->load->model('Common');
        $this->load->library('session');
        
    }
	public function index()
	{
/*
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $echostr = $_GET["echostr"];
    $token = "admina";

    // 1）将token、timestamp、nonce三个参数进行字典序排序
    $tmpArr = array($nonce,$token,$timestamp);
    sort($tmpArr,SORT_STRING);

    // 2）将三个参数字符串拼接成一个字符串进行sha1加密
    $str = implode($tmpArr);
    $sign = sha1($str);

    // 3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
    if ($sign == $signature) {
      echo $echostr;
      exit;
    }
*/
	//---------- 接 收 数 据 ---------- //
 
 
$postStr= $GLOBALS["HTTP_RAW_POST_DATA"];//获取POST数据
 
        //用SimpleXML解析POST过来的XML数据
        $postObj= simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
        $fromUsername= $postObj->FromUserName;//获取发送方帐号（OpenID）
        $toUsername= $postObj->ToUserName;//获取接收方账号
        $keyword= trim($postObj->Content);//获取消息内容
        $eventKey=trim($postObj->EventKey);//获取事件Key;
        $event=trim($postObj->Event);//获取事件
        $time= time(); //获取当前时间戳
        $type=$postObj->MsgType;//消息类型
        //echo $keyword;
 
      //---------- 返 回 数 据 ---------- //
 
      //返回消息模板
        
        $textTpl= "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
       <FuncFlag>0</FuncFlag>
</xml>"; //文本消息XML
        
        $PicText="<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA[图文标题]]></Title> 
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[https://www.baidu.com/img/bdlogo.png]]></PicUrl>
<Url><![CDATA[www.baidu.com]]></Url>
</item>

</Articles>
</xml> ";//图文消息XML        
        $msgType="text"; //消息类型 
        //菜单回复内容 
        $query=$this->db->query("select * from st_wcmenu where type=2"); 
        $r=$query->result_array();
        foreach($r as $row){
        if($row['name']==$eventKey){
         $contentStr=$row['text'];
        $resultStr= sprintf($textTpl,$fromUsername,$toUsername,$time,$msgType,$contentStr);
        echo $resultStr; //输出结果
        exit;
        }
        }
        //
        if($type=="event"&&$event=='SCAN')//如果为事件并扫描发送图文消息
        {
        $rp=explode(":",$eventKey);
        if($rp[0]=='qrscene_rpid'){  //带有推广id
        $this->db->query("select * from st_user where openid='".$fromUsername."'");
        $is_user=$this->db->affected_rows();
        if($is_user==0){
        $data['rpid']=$rp[1];
        $data['openid']=$fromUsername;
        $this->db->insert('user',$data);
        }
        $resultStr=sprintf($PicText,$fromUsername,$toUsername,$time,$rp[1]);
        }
        }elseif($type=="event"&&$event=="subscribe"){  //关注事件
        $rp=explode(":",$eventKey);
        if($rp[0]=='qrscene_rpid'){  //带有推广id
        $this->db->query("select * from st_user where openid='".$fromUsername."'");
        $is_user=$this->db->affected_rows();
        if($is_user==0){
        $data['rpid']=$rp[1];
        $data['openid']=$fromUsername;
        $this->db->insert('user',$data);
        }
        $resultStr=sprintf($PicText,$fromUsername,$toUsername,$time,$rp[1]);
        }
        $contentStr=$this->getsetting()['gztext'];
        $resultStr= sprintf($textTpl,$fromUsername,$toUsername,$time,$msgType,$contentStr);
        echo $resultStr; //输出结果
        }else
        {
        $resultStr= sprintf($textTpl,$fromUsername,$toUsername,$time,$msgType,$contentStr);
        }
          //echo $resultStr; //输出结果
	}
	
}
