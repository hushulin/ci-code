<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timetype extends CI_Controller {

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
     $data['title']="时间类型-后台管理";
     $data['active']="timetype";
     //$_SESSION['is_Admin']=0;
     $query=$this->db->query("select * from st_timetype order by order_ asc");
     $type=$query->result_array();
     $data['typelist']=$type;
		$this->load->view(config_item("admin_").'/timetype',$data);
	}
	
	public function do_save(){
	$datas=$_POST;
	foreach($datas as $key=>$d){
	if(strpos($key,'order')!==false){
	$data['order_']=$d[0];
	$id=substr($key,5,1);
	$this->db->where('id='.$id);
	}else{
	$data['profit']=$d[0];
	$this->db->where('id='.$key);
	}
	$this->db->update('timetype', $data);
	}
	show_message("修改成功","",1);

	/*
	if($this->db->update('timetype', $data)){
	
	}else{
	show_message("修改失败");
	}
	*/
	}
	
}
