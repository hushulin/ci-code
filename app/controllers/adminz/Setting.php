<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

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
        if($_SESSION['is_Admin']!==1){
        header('Location: /index.php/'.config_item("admin_").'/login');
        }
    }
	public function index()
	{
     $data['title']="站点设置-后台管理";
     $data['active']="setting";
     //$_SESSION['is_Admin']=0;
     $query=$this->db->query("select * from st_setting where 1");
     $setting=$query->row_array();
     $data['setting']=$setting;
		$this->load->view(config_item("admin_").'/setting',$data);
	}
	
	public function do_save(){
	$data=$_POST;
	if(empty($data['open_virtual'])){
  $data['open_virtual']=0;
	}
	if(empty($data['is_close'])){
  $data['is_close']=0;
	}
	if($this->db->update('setting', $data)){
	show_message("修改成功","",1);
	}else{
	show_message("修改失败");
	}
	}
	
}
