<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash extends CI_Controller {

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
    $data['title']="提现管理-后台管理";
    $data['active']="cash";
    $setting=$this->getsetting();
    $data['cashfee']=$setting['cashfee'];
    $data['cashmin']=$setting['cashmin'];
    $data['cashtimes']=$setting['cashtimes'];
    $query=$this->db->query("select st_cash_log.*,st_user.* from st_cash_log left join st_user on st_cash_log.uid=st_user.id  order by st_cash_log.time desc");
    $data['pages']=ceil($this->db->affected_rows()/10);
    $page=empty($_GET['page'])?1:$_GET['page'];
    $query=$this->db->query("select st_cash_log.*,st_user.*,st_user.id as uid,st_cash_log.id as cid from st_cash_log left join st_user on st_cash_log.uid=st_user.id  order by st_cash_log.time desc limit ".(($page-1)*10).",10");
    $data['cashlist']=$query->result_array();
		$this->load->view(config_item("admin_").'/cash',$data);
	}
	public function tosave(){
	$data['cashfee']=$_POST['cashfee'];
	$data['cashtimes']=$_POST['cashtimes'];
	$data['cashmin']=$_POST['cashmin'];
	if(!isset($data['cashfee'])){
	show_message("请填写数据");
	exit;
	}
	$this->db->update('setting',$data);
	show_message("设置更新成功","",1);
	}
	public function toreview(){
	$id=$_GET['id'];
	if(empty($id)){
	show_message("参数错误");
	exit;
	}
	$this->db->where('id',$id);
	if($this->db->update('st_cash_log',array('status'=>1))){
	show_message("审核成功",'',1);
	exit;
	}else{
	show_message("审核出错，请重试");
	exit;
	}
	
	}
	
	public function cancelreview(){
	$id=$_GET['id'];
	if(empty($id)){
	show_message("参数错误");
	exit;
	}
	$query=$this->db->query("select * from st_cash_log where id=".$id);
	$cashLog=$query->row_array();
	if($cashLog['status']==-1){
	$this->db->query("UPDATE st_balance SET balance = balance-".$cashLog['amount']." WHERE uid = ".$cashLog['uid']." and type=1");
	}
	$this->db->where('id',$id);
	if($this->db->update('st_cash_log',array('status'=>0))){
	show_message("取消成功",'',1);
	exit;
	}else{
	show_message("取消出错，请重试");
	exit;
	}
	
	}
	public function refusereview(){
	$id=$_GET['id'];
	if(empty($id)){
	show_message("参数错误");
	exit;
	}
	$this->db->where('id',$id);
	if($this->db->update('st_cash_log',array('status'=>-1))){
	$query=$this->db->query("select * from st_cash_log where id=".$id);
	$cashLog=$query->row_array();
	//$this->db->where('uid',$cashLog['uid']);
	//$this->db->where('type',1);
	//$this->db->update('st_balance',array('balance'=>));
	$this->db->query("UPDATE st_balance SET balance = balance+".$cashLog['amount']." WHERE uid = ".$cashLog['uid']." and type=1");
	show_message("拒绝提现成功",'',1);
	exit;
	}else{
	show_message("拒绝出错，请重试");
	exit;
	}
	
	}

}
