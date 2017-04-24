<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weixin extends CI_Controller {

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
   
    $menu['button']['0']['name'] = '积分';

$menu['button']['0']['sub_button']['0']['type'] = 'view';
$menu['button']['0']['sub_button']['0']['name'] = '积分商城';
$menu['button']['0']['sub_button']['0']['url'] = 'xxx';

$menu['button']['0']['sub_button']['1']['type'] = 'view';
$menu['button']['0']['sub_button']['1']['name'] = '微商城';
$menu['button']['0']['sub_button']['1']['url'] = 'xxx';

$menu['button']['0']['sub_button']['2']['type'] = 'view';
$menu['button']['0']['sub_button']['2']['name'] = '优品专区';
$menu['button']['0']['sub_button']['2']['url'] = 'xxx';

$menu['button']['1']['name'] = '活动内容';

$menu['button']['1']['sub_button']['0']['type'] = 'view';
$menu['button']['1']['sub_button']['0']['name'] = '最新活动';
$menu['button']['1']['sub_button']['0']['url'] = 'xxx';

$menu['button']['1']['sub_button']['1']['type'] = 'view';
$menu['button']['1']['sub_button']['1']['name'] = '分享有礼';
$menu['button']['1']['sub_button']['1']['url'] = 'xx';

$menu['button']['1']['sub_button']['2']['type'] = 'view';
$menu['button']['1']['sub_button']['2']['name'] = '在线调研';
$menu['button']['1']['sub_button']['2']['url'] = 'xxx';

$menu['button']['1']['sub_button']['3']['type'] = 'view';
$menu['button']['1']['sub_button']['3']['name'] = '秒杀专区';
$menu['button']['1']['sub_button']['3']['url'] = 'xx';
echo json_encode($menu,JSON_UNESCAPED_UNICODE);
     $data['title']="微信配置-后台管理";
     $data['active']="weixin";
     $data['list']=$this->db->query('select * from st_topad where 1')->result_array();
		$this->load->view(config_item("admin_").'/weixin',$data);
	}
	
	public function menu(){
	$data = '{
     "button":[
     {
          "type":"view",
          "name":"开始交易",
          "url":"http://test.taojin8.org"
      }]
}';
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
  return curl_error($ch);
  }

  curl_close($ch);
  return $tmpInfo;
	}

}
