<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tran extends CI_Controller {

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
     $data['title']="交易管理-后台管理";
     $data['active']="tran";
     $data['minbuy']=$this->getsetting()['minbuy'];
     $data['shiwin']=$this->getsetting()['shiwin'];
     $data['xuwin']=$this->getsetting()['xuwin'];
     $page=empty($_GET['page'])?1:$_GET['page'];
     $ptype=empty($_GET['ptype'])?1:$_GET['ptype'];
     $data['ptype']=$ptype;
     $query=$this->db->query("select st_user.*,st_tran_log.* from st_tran_log left join st_user on st_tran_log.userid=st_user.id where ptype=".$ptype." and userid<>0 order by st_tran_log.time desc");
     $data['pages']=ceil($this->db->affected_rows()/15)==0?1:ceil($this->db->affected_rows()/15);
     $query=$this->db->query("select st_user.*,st_tran_log.* from st_tran_log left join st_user on st_tran_log.userid=st_user.id where ptype=".$ptype." and userid<>0 order by st_tran_log.time desc limit ".(($page-1)*15).",15");
     $data['tranlist']=$query->result_array();
     $this->load->view(config_item("admin_").'/tran',$data);
	}
	public function tosave(){
	if(isset($_POST['minbuy'])){
	$data['minbuy']=$_POST['minbuy'];
	}
	if(isset($_POST['xuwin'])){
	$data['xuwin']=$_POST['xuwin'];
	}
	if(isset($_POST['shiwin'])){
	$data['shiwin']=$_POST['shiwin'];
	}
	
	$this->db->update('setting',$data);
	show_message("设置更新成功","",1);
	}

}
