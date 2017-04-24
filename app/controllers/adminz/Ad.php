<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ad extends CI_Controller {

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
     $data['title']="广告管理-后台管理";
     $data['active']="ad";
     $data['list']=$this->db->query('select * from st_topad where 1')->result_array();
		$this->load->view(config_item("admin_").'/ad',$data);
	}
	public function delad(){
	$id=$_GET['id'];
	if(!empty($id)){
	$this->db->where('id', $id);
  $this->db->delete('topad');
  show_message("删除成功",'',1);
	}
	}
	public function newad(){
	$file=$_POST['file'];
	$url=$_POST['url'];
	if(empty($url)){
	show_message("请把信息填写完整");
	exit;
	}
  if (($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg")|| ($_FILES["file"]["type"] == "image/png"))
  {
  switch($_FILES["file"]["type"]){
  case 'image/gif':
  $hname='.gif';
  break;
  case 'image/jpeg':
  $hname='.jpg';
  break;
  case 'image/pjpeg':
  $hname='.jpg';
  break;
  case 'image/png':
  $hname='.png';
  break;
  }
  if ($_FILES["file"]["error"] > 0)
    {
  show_message("图片上传错误");
  exit;
    }
  else
    {
 
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "js/attached/" .time().$hname);
      $img="/js/attached/" .time().".".substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.')+1);
      $data=array('img'=>$img,'url'=>$url,'time'=>time());
      $this->db->insert('topad',$data);
       show_message("新建广告成功",'',1);
    }
  }
else
  {
 show_message("图片格式错误");
  exit;
  }

  }
	
	
}
