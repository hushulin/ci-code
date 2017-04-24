<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 截取中英混排字符串
 * @param (string) $string
 * @param (int) $length
 * @param (string) $dot
 * @param (string) $charset
 */
function sb_substr( $string, $length, $dot = '..', $charset='utf-8' ) {
	$slen = strlen($string);
    if( $slen <= $length ) {
        return $string;
    }
	if( function_exists( 'mb_substr' ) ) {
		return mb_substr( $string, 0, $length, $charset ) . $dot;
	}
    $strcut = '';
    if(strtolower($charset) == 'utf-8') {
        $n = $tn = $noc = 0;
        while($n < $slen) {
            $t = ord($string[$n]);
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 1;
            } elseif(224 <= $t && $t < 239) {
                $tn = 3; $n += 3; $noc += 1;
            } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 1;
            } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 1;
            } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 1;
            } else {
                $n++;
            }
            if($noc >= $length) {
                break;
            }
        }
        if($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
    } else {
        for($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
        }
    }
    
    return $strcut.$dot;
}
/*
 *是否在微信浏览器打开
 */
function is_weixin(){ 
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
    }   
    return false;
}

/**
 * 清除HTML标记
 *
 * @param	string	$str
 * @return  string
 */
function cleanhtml($str)
{
	$str = strip_tags($str);
	$str = htmlspecialchars($str);
	$str=preg_replace("/\s+/"," ", $str); //过滤多余回车
	 $str = preg_replace("/ /","",$str);
	 $str = preg_replace("/&nbsp;/","",$str);
	 $str = preg_replace("/　/","",$str);
	 $str = preg_replace("/\r\n/","",$str);
	 $str = str_replace(chr(13),"",$str);
	 $str = str_replace(chr(10),"",$str);
	 $str = str_replace(chr(9),"",$str);
	return $str;
}


function get_domain($url=''){
	$host=$url?$url:@$_SERVER[HTTP_HOST]; 
	$host=strtolower($host); 
	if(strpos($host,'/')!==false){ 
		$parse = @parse_url($host); 
		$host = $parse['host']; 
	}
	$topleveldomaindb=array('com','edu','gov','int','mil','net','org','biz','info','pro','name','museum','coop','aero','xxx','idv','mobi','cc','me','cn','tv','in','hk','de','us','tw');
	$str=''; 
	foreach($topleveldomaindb as $v){ 
		$str.=($str ? '|' : '').$v;
	} 
	$matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
	if(preg_match("/".$matchstr."/ies",$host,$matchs)){ 
		$domain=$matchs['0'];
	}else{ 
		$domain=$host; 
	}
	return $domain; 
}

	//无编辑器的过滤
	/*function filter_check ($data)
	{
		$pattern="/<pre>(.*?)<\/pre>/si";
		preg_match_all ($pattern, $data, $matches);
		foreach( $matches[1] as $val ){
			@$replace[] = htmlspecialchars($val);
		}
		$data = str_replace($matches[1], @$replace, $data);
		if(!$matches[1]){
			$data = nl2br($data);
		}
		$data = str_replace('</p><br />','</p>',$data);
		return $data = strip_tags($data,"<p> <font> <img> <b> <strong> <br> <pre> <br /> <span>");
	}*/
//无编辑器的过滤
function filter_check ($str)
{
	
	$pattern="/<pre[^>]*>(.*?)<\/pre>/si";
	preg_match_all($pattern, $str, $matches);
	$str=htmlspecialchars_decode($str);
	$str=stripslashes($str);
	if($matches[1]){
		foreach($matches[1] as $v){
			$replace[]= addslashes(htmlspecialchars(trim($v)));
		}
		$str = str_replace($matches[1], $replace, $str);
	} else{
		$str=strip_tags($str,"<img> <pre> <a> <font> <span> <em>");
	}
	$str = nl2br($str);
	
	return $str;
}

//过滤
function filter_code($str)
{
	$str=htmlspecialchars_decode($str);
	$pattern="/<pre[^>]*>(.*?)<\/pre>/si";
	preg_match_all($pattern, $str, $matches);
	if($matches[1]){
		foreach($matches[1] as $v){
			$replace= trim(htmlentities($v));
			$str = str_replace($v, $replace, $str);
		}
		$str =strip_tags($str,"<img> <pre> <a> <font> <span> <em> <p> <b>");
	}else{
		$str =strip_tags($str,"<img> <pre> <a> <font> <span> <em> <p> <b>");
		$str = trim(nl2br($str));
	}
	return $str;
}
	/**
  * 获取分页的HTML内容
  * @param integer $page 当前页
  * @param integer $pages 总页数
  * @param string $url 跳转url地址    最后的页数以 '&page=x' 追加在url后面
  * 
  * @return string HTML内容;
  */
 function getPageHtml($page, $pages, $url){
  //最多显示多少个页码
   $_pageNum = 10;
  //当前页面小于1 则为1
  $page = $page<1?1:$page;
  //当前页大于总页数 则为总页数
  $page = $page > $pages ? $pages : $page;
  //页数小当前页 则为当前页
  $pages = $pages < $page ? $page : $pages;

  //计算开始页
  $_start = $page - floor($_pageNum/2);
  $_start = $_start<1 ? 1 : $_start;
  //计算结束页
  $_end = $page + floor($_pageNum/2);
  $_end = $_end>$pages? $pages : $_end;

  //当前显示的页码个数不够最大页码数，在进行左右调整
  $_curPageNum = $_end-$_start+1;
  //左调整
  if($_curPageNum<$_pageNum && $_start>1){  
   $_start = $_start - ($_pageNum-$_curPageNum);
   $_start = $_start<1 ? 1 : $_start;
   $_curPageNum = $_end-$_start+1;
  }
  //右边调整
  if($_curPageNum<$_pageNum && $_end<$pages){ 
   $_end = $_end + ($_pageNum-$_curPageNum);
   $_end = $_end>$pages? $pages : $_end;
  }

  $_pageHtml = '<center><nav><ul class="pagination pagination-lg">';
  /*if($_start == 1){
   $_pageHtml .= '<li><a title="第一页">«</a></li>';
  }else{
   $_pageHtml .= '<li><a  title="第一页" href="'.$url.'&page=1">«</a></li>';
  }*/
  if($page>1){
   $_pageHtml .= '<li><a  title="上一页" href="'.$url.'&page='.($page-1).'">«</a></li>';
  }else{
  $_pageHtml .= '<li class="disabled"><a  title="上一页" href="javascript:void(0)">«</a></li>';
  }
  for ($i = $_start; $i <= $_end; $i++) {
   if($i == $page){
    $_pageHtml .= '<li class="active"><a>'.$i.'</a></li>';
   }else{
    $_pageHtml .= '<li><a href="'.$url.'&page='.$i.'">'.$i.'</a></li>';
   }
  }
  /*if($_end == $pages){
   $_pageHtml .= '<li><a title="最后一页">»</a></li>';
  }else{
   $_pageHtml .= '<li><a  title="最后一页" href="'.$url.'&page='.$pages.'">»</a></li>';
  }*/
  if($page<$_end){
   $_pageHtml .= '<li><a  title="下一页" href="'.$url.'&page='.($page+1).'">»</a></li>';
  }else{
  $_pageHtml .= '<li  class="disabled"><a  title="下一页" href="javascript:void(0)">»</a></li>';
  }
  $_pageHtml .= '</ul></nav></center>';
  echo $_pageHtml;
 }
//$str=stripslashes($str);
/*发送邮件*/
function send_mail($to,$subject,$message)
{
	$ci	= &get_instance();
	$config['protocol']=$ci->config->item('protocol');
	$config['smtp_host']=$ci->config->item('smtp_host');
	$config['smtp_user']=$ci->config->item('smtp_user');
	$config['smtp_pass']=$ci->config->item('smtp_pass');
	$config['smtp_port']=$ci->config->item('smtp_port');
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	
	$ci->load->library('email',$config);
	$ci->email->from($config['smtp_user'],'');
	$ci->email->to($to);
	$ci->email->subject($subject.'-'.$ci->config->item('site_name'));
	$ci->email->message($message);
	if($ci->email->send()){
		return true;
	} else
	{
		return false;
	}
}
/**
 *判断中文名字
**/
function isChineseName($name){
	if(preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',$name)){
		return true;
	}else{
		return false;
	}
}
/**
 *判断身份证号码是否真实
**/
function isIdCard($id) {
if(strlen($id)==18){
return TRUE; 
}
/*
    $id = strtoupper($id); 
  $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/"; 
  $arr_split = array(); 
  if(!preg_match($regx, $id)) 
  { 
    return FALSE; 
  } 
  if(15==strlen($id)) //检查15位 
  { 
    $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/"; 
 
    @preg_match($regx, $id, $arr_split); 
    //检查生日日期是否正确 
    $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4]; 
    if(!strtotime($dtm_birth)) 
    { 
      return FALSE; 
    } else { 
      return TRUE; 
    } 
  } 
  else      //检查18位 
  { 
    $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/"; 
    @preg_match($regx, $id, $arr_split); 
    $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4]; 
    if(!strtotime($dtm_birth)) //检查生日日期是否正确 
    { 
      return FALSE; 
    } 
    else 
    { 
      
        return TRUE; 
      
    } 
  } 
  */
}


	function auto_link_pic($str, $type = 'both', $popup = FALSE)
	{
		if ($type != 'email')
		{
			if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches))
			{
				$pop = ($popup == TRUE) ? " target=\"_blank\" " : "";

				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['6'][$i]))
					{
						$period = '.';
						$matches['6'][$i] = substr($matches['6'][$i], 0, -1);
					}
					$img_ext = array('jpg','png','gif','jpeg');
					$file_ext=strtolower(end(explode(".",$matches['0'][$i])));
					if(in_array($file_ext,$img_ext)){
						$str = str_replace($matches['0'][$i],
											$matches['1'][$i].'<img src="http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'" alt="">'.
											$period, $str);
					} else {
						$str = str_replace($matches['0'][$i],
											$matches['1'][$i].'<a href="http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'"'.$pop.'>http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'</a>'.
											$period, $str);
					}
				}
			}
		}

		if ($type != 'url')
		{
			if (preg_match_all("/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $str, $matches))
			{
				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['3'][$i]))
					{
						$period = '.';
						$matches['3'][$i] = substr($matches['3'][$i], 0, -1);
					}

					$str = str_replace($matches['0'][$i], safe_mailto($matches['1'][$i].'@'.$matches['2'][$i].'.'.$matches['3'][$i]).$period, $str);
				}
			}
		}

		return $str;
	}


	function br2nl($text)
	{
		return preg_replace('/<br\\s*?\/??>/i', '', $text);
	}
function xss_clean($input_str) {
    $return_str = str_replace( array('<','>',"'",'"',')','('), array('&lt;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
    $return_str = str_ireplace( '%3Cscript', '', $return_str );
    return $return_str;
}

function xss_clean3($str)
{

if (isset($str)){
	$str = trim($str);  //清理空格
	$str = strip_tags($str);   //过滤html标签
	$str = htmlspecialchars($str);   //将字符内容转化为html实体
	$str = addslashes($str);
	return $str;
}


}
/*
 * XSS filter 
 *
 * This was built from numerous sources
 * (thanks all, sorry I didn't track to credit you)
 */

function xss_clean1($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
}

	function randkey($length)
	{
		 $pattern='1234567890abcdefghijklmnopqrstuvwxyz$#&^@!';
		 $key='';
		 for($i=0;$i<$length;$i++)
		 {
		   $key.= $pattern{mt_rand(0,35)};    //生成php随机数
		 }
		 return $key;
	}

function get_url_content($url)
{
	if(function_exists('file_get_contents')){
		return file_get_contents($url);
	} elseif(function_exists('curl_init')){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($ch);
	}
}

/*生成盐salt*/

function get_salt($length=-6){
	return substr(uniqid(rand()), $length);
}

/*生成密码*/

function password_dohash($password,$salt)
{
	$salt=$salt?$salt:get_salt();
	return md5(md5($password).$salt);
}
/*返回信息*/
function show_message($message='', $url='', $status = 2, $heading='提示信息', $time = 2500)
{

    include APPPATH.'errors/show_message.php';
    exit;
}
function show_error2($message='', $url='', $status = 2, $heading='提示信息', $time = 2500)
{

    include APPPATH.'errors/show_error.php';
    exit;
}



////获得本地真实IP
function get_onlineip() {
/*
    $ip_json = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=myip");
    $ip_arr=json_decode(stripslashes($ip_json),1);
    if($ip_arr['code']==0)
    {
        return $ip_arr['data']['ip'];
    }
    */
   return strval($_SERVER["REMOTE_ADDR"]);
     
}
/*补全代码*/
function closetags($html) { 
	// 不需要补全的标签 
	$arr_single_tags = array('meta', 'img', 'br', 'link', 'area'); 
	// 匹配开始标签 
	preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result); 
	$openedtags = $result[1]; 
	// 匹配关闭标签 
	preg_match_all('#</([a-z]+)>#iU', $html, $result); 
	$closedtags = $result[1]; 
	// 计算关闭开启标签数量，如果相同就返回html数据 
	$len_opened = count($openedtags); 
	if (count($closedtags) == $len_opened) { 
		return $html; 
	} 
	// 把排序数组，将最后一个开启的标签放在最前面 
	$openedtags = array_reverse($openedtags); 
	// 遍历开启标签数组 
	for ($i = 0; $i < $len_opened; $i++) { 
		// 如果需要补全的标签 
		if (!in_array($openedtags[$i], $arr_single_tags)) { 
		// 如果这个标签不在关闭的标签中 
			if (!in_array($openedtags[$i], $closedtags)) { 
			// 直接补全闭合标签 
				$html .= '</' . $openedtags[$i] . '>'; 
			} else { 
				unset($closedtags[array_search($openedtags[$i], $closedtags)]); 
			} 
		} 
	} 
	return $html; 
}

function strip_url_tags($str)
{
	$str=preg_replace("/<a[^>]*href=[^>]*>|<\/[^a]*a[^>]*>/i","\\2",$str);
	return $str;
}
function decode_format($content)
{
	$STB= &get_instance();
	$STB->load->helper('security');
	$content=strip_url_tags(strip_image_tags($content));
	return $content;
}
function get_tree_array(&$data, $parentId=0)
{
    $category = array();
    foreach ($data as $key=>$value)
    {
        if ($value['pid'] == $parentId)
        {
            unset($data[$key]);
            $value['child'] = category($data, $value['id']);
            $category[] = $value;
        }
    }
    return $category;
}
function get_tree(&$data, $parentId=0)
{
	global $str;
    $str .= '<ul>';
    foreach ($data as $key=>$value)
    {
        if ($value['pid'] == $parentId)
        {
            unset($data[$key]);
            $str.="<li>|--<a href='/'>".$value['name'].'</a></li>';
            get_tree($data, $value['id']);
        }
    }
    $str .= '</ul>';
    return $str;
}

function url($type='',$num='',$any='')
{
	$STB = &get_instance();
	return $STB->router->url($type,$num,$any);
}

//生成友好时间形式
function  friendly_date( $from ){
	static $now = NULL;
	$now == NULL && $now = time();
	! is_numeric( $from ) && $from = strtotime( $from );
	$seconds = $now - $from;
	$minutes = floor( $seconds / 60 );
	$hours   = floor( $seconds / 3600 );
	$day     = round( ( strtotime( date( 'Y-m-d', $now ) ) - strtotime( date( 'Y-m-d', $from ) ) ) / 86400 );
	if( $seconds == 0 ){
		return '刚刚';
	}
	if( ( $seconds >= 0 ) && ( $seconds <= 60 ) ){
		return "{$seconds}秒前";
	}
	if( ( $minutes >= 0 ) && ( $minutes <= 60 ) ){
		return "{$minutes}分钟前";
	}
	if( ( $hours >= 0 ) && ( $hours <= 24 ) ){
		return "{$hours}小时前";
	}
	if( ( date( 'Y' ) - date( 'Y', $from ) ) > 0 ) {
		return date( 'Y-m-d', $from );
	}
	
	switch( $day ){
		case 0:
			return date( '今天H:i', $from );
		break;
		
		case 1:
			return date( '昨天H:i', $from );
		break;
		
		default:
			//$day += 1;
			return "{$day} 天前";
		break;
	}
}

	function str_len($str)
	{
	    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
	 
	    if ($length)
	    {
	        return strlen($str) - $length + intval($length / 3) * 2;
	    }
	    else
	    {
	        return strlen($str);
	    }
	}

if(!function_exists('array_column')){
    function array_column($input, $columnKey, $indexKey=null){ 
        $columnKeyIsNumber      = (is_numeric($columnKey)) ? true : false; 
        $indexKeyIsNull         = (is_null($indexKey)) ? true : false; 
        $indexKeyIsNumber       = (is_numeric($indexKey)) ? true : false; 
        $result                 = array(); 
        foreach((array)$input as $key=>$row){ 
            if($columnKeyIsNumber){ 
                $tmp            = array_slice($row, $columnKey, 1); 
                $tmp            = (is_array($tmp) && !empty($tmp)) ? current($tmp) : null; 
            }else{ 
                $tmp            = isset($row[$columnKey]) ? $row[$columnKey] : null; 
            } 
            if(!$indexKeyIsNull){ 
                if($indexKeyIsNumber){ 
                    $key        = array_slice($row, $indexKey, 1); 
                    $key        = (is_array($key) && !empty($key)) ? current($key) : null; 
                    $key        = is_null($key) ? 0 : $key; 
                }else{ 
                    $key        = isset($row[$indexKey]) ? $row[$indexKey] : 0; 
                } 
            } 
            $result[$key]       = $tmp; 
        } 
        return $result; 
    } 
}

function is_today($time)
{
	$date = date('Y-m-d',$time);
	$today = date('Y-m-d');
	if($date==$today){
		return TRUE;
	}else{
		return FALSE;
	}

}



/* End of file function_helper.php */
/* Location: ./system/helpers/function_helper.php */