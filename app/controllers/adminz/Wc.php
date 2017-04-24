<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wc extends CI_Controller {

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
        if($_SESSION['is_Admin']!==1){
        header('Location: /index.php/'.config_item("admin_").'/login');
        }
    }
	public function index()
	{
     $data['title']="微信设置-后台管理";
     $data['active']="wc";
      $data['list']=$this->db->query('select * from st_wcmenu where rid=0')->result_array();
     $data['setting']=$this->db->query('select * from st_setting where 1')->row_array();
      
		$this->load->view(config_item("admin_").'/wc',$data);
	}
	public function to_gztext(){
	$gztext=@$_POST['gztext'];
	if(empty($gztext)){
	 show_message("请输入回复内容后重试");
	 exit;
	}
	$data['gztext']=$gztext;
  $this->db->where('id', 1);
  $this->db->update('setting', $data);
  show_message("更新内容成功","",1);
	}
	public function to_save(){
	$name=$_POST['name'];
	$id=@$_POST['mid'];
	$url=@$_POST['url'];
	$text=@$_POST['text'];
	$type=$_POST['type'];
	$rid=@$_POST['rid'];
	$level=@$_POST['level'];
	if(empty($rid)){
	$rid=0;
	}
	if(empty($level)){
	$level=0;
	}
	if(empty($id)){
	//新建
	$data=array(
	'rid'=>$rid,
	'level'=>$level,
	'type'=>$type,
	'name'=>$name,
	'url'=>$url,
	'text'=>$text,
	'time'=>time()
	);
	$this->db->insert('wcmenu', $data);
	}else{
	//更新
	$data=array(
	'rid'=>$rid,
	'level'=>$level,
	'type'=>$type,
	'name'=>$name,
	'url'=>$url,
	'text'=>$text,
	'time'=>time()
	);
	$this->db->where('id', $id);
$this->db->update('wcmenu', $data);
	}
	Header("Location: /index.php/".config_item("admin_")."/wc/"); 
	}
	public function delmenu(){
	if(@$_GET['id']){
	$this->db->where('id',$_GET['id']);
  $this->db->delete('wcmenu');
  $this->db->where('rid',$_GET['id']);
  $this->db->delete('wcmenu');
	}
	Header("Location: /index.php/".config_item("admin_")."/wc/"); 
	}
	public function menu(){
	/*$data = '{
     "button":[
     {
          "type":"view",
          "name":"开始交易",
          "url":"http://test.taojin8.org"
      }]
}';*/
    $query=$this->db->query('select * from st_wcmenu where rid=0');
    $f_menu=$query->result_array();
    $fi=0;
    foreach($f_menu as $f){
    $menu['button'][$fi]['name']=$f['name'];
    $s_menu=$this->Common->getsubset($f['id']);
    if($s_menu){
    $si=0;
    foreach($s_menu as $s){
    $menu['button'][$fi]['sub_button'][$si]['name'] =$s['name'];
    if($s['type']==1){
    $menu['button'][$fi]['sub_button'][$si]['type'] = 'view';
    $menu['button'][$fi]['sub_button'][$si]['url'] = $s['url'];
    }else{
    $menu['button'][$fi]['sub_button'][$si]['type'] = 'click';
    $menu['button'][$fi]['sub_button'][$si]['key'] = $s['name'];
    }
    $si++;
    }
    }else{
     if($f['type']==1){
    $menu['button'][$fi]['type'] = 'view';
    $menu['button'][$fi]['url'] = $f['url'];
    }else{
    $menu['button'][$fi]['type'] = 'click';
    $menu['button'][$fi]['key'] =$f['name'];
    }
    }
    $fi++;
    }
    $data = json_encode($menu,JSON_UNESCAPED_UNICODE);

	$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->Common->  getAccessToken(1));
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $tmpInfo = curl_exec($ch);
  if (curl_errno($ch)) {
  show_message("发布失败，请重试");
  }

  curl_close($ch);
  show_message("已成功发布到微信","",1);
	}
	
	
	
}
