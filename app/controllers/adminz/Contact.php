<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

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
     $data['title']="客服信息-后台管理";
     $data['contact']=$this->getsetting()['contact'];
     $data['active']="contact";
     
		$this->load->view(config_item("admin_").'/contact',$data);
	}
	public function to_save(){
	if(isset($_POST['content'])){
	$data['contact']=$_POST['content'];
	$this->db->update("setting",$data);
	show_message("更新成功",'',1);
	}
	}
	
}
