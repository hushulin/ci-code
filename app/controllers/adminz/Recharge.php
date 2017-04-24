<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recharge extends CI_Controller {

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
     $data['title']="充值管理-后台管理";
     $data['active']="recharge";
     $data['r_cashback1']=$this->getsetting()['r_cashback1'];
     $data['r_cashback2']=$this->getsetting()['r_cashback2'];
     $data['minrecharge']=$this->getsetting()['minrecharge'];
     $data['cashmultiple']=$this->getsetting()['cashmultiple'];
     $page=empty($_GET['page'])?1:$_GET['page'];
     $query=$this->db->query("select st_user.*,st_recharge_log.* from st_recharge_log left join st_user on st_recharge_log.userid=st_user.id  order by st_recharge_log.time desc");
     $data['pages']=ceil($this->db->affected_rows()/15)==0?1:ceil($this->db->affected_rows()/15);
     $query=$this->db->query("select st_user.*,st_recharge_log.* from st_recharge_log left join st_user on st_recharge_log.userid=st_user.id order by st_recharge_log.time desc limit ".(($page-1)*15).",15");
     $data['rechargelist']=$query->result_array();
     $this->load->view(config_item("admin_").'/recharge',$data);
	}
	public function tosave(){
	$minrecharge=$_POST['minrecharge'];
	$r_cashback1=$_POST['r_cashback1'];
	$r_cashback2=$_POST['r_cashback2'];
	$cashmultiple=$_POST['cashmultiple'];
	$set_data=array(
	'minrecharge'=>$minrecharge,
	'r_cashback1'=>$r_cashback1,
	'r_cashback2'=>$r_cashback2,
	'cashmultiple'=>$cashmultiple
	);
	$this->db->update('setting',$set_data);
	show_message("保存成功",'',1);
	}
	

}
