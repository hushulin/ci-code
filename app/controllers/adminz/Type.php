<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type extends CI_Controller {

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
     $data['title']="资产类型-后台管理";
     $data['active']="type";
     //$_SESSION['is_Admin']=0;
     $query=$this->db->query("select * from st_type_setting  order by is_close,is_rest,order_ asc");
     $type=$query->result_array();
     $data['typelist']=$type;
		$this->load->view(config_item("admin_").'/type',$data);
	}
	
	public function do_save(){
	$datas=$_POST;
  
	foreach($datas as $key=>$d){
	$data['order_']=$d[0];
	$this->db->where('id='.$key);
	$this->db->update('type_setting', $data);
	}
	show_message("修改成功","",1);
	/*
	if($this->db->update('type_setting', $data)){
	
	}else{
	show_message("修改失败");
	}
	*/
	}
	public function is_rest(){
	$id=$_GET['id'];
	$query=$this->db->query("select is_rest from st_type_setting where id=".$id);
	$result=$query->row_array();
	$this->db->where('id='.$id);
	if($result["is_rest"]==0){
	$data['is_rest']=1;
	$this->db->update('type_setting', $data);
	}else{
	$data['is_rest']=0;
	$this->db->update('type_setting', $data);
	}
	show_message("修改成功","",1);
	}
	public function is_close(){
	$id=$_GET['id'];
	$query=$this->db->query("select is_close from st_type_setting where id=".$id);
	$result=$query->row_array();
	$this->db->where('id='.$id);
	if($result["is_close"]==0){
	$data['is_close']=1;
	$this->db->update('type_setting', $data);
	}else{
	$data['is_close']=0;
	$this->db->update('type_setting', $data);
	}
	show_message("修改成功","",1);
	}
	
}
