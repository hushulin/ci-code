<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branding extends CI_Controller {

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
     $data['title']="推广管理-后台管理";
     $data['active']="branding";
     $data['setting']=$this->getsetting();
     $query=$this->db->query('select * from st_reward_setting order by id asc');
     $data['rewardlist']=$query->result_array();
		$this->load->view(config_item("admin_").'/branding',$data);
	}
	public function tosave(){
    $rewardtype=@$_POST['rewardtype'];
    $data['rewardtype']=$rewardtype;
    if($this->db->update('setting',$data)){
    show_message("保存成功","",1);
    }else{
    show_message("保存失败");
    }
	}
	public function delreward(){
	$id=$_GET['id'];
	if($this->db->delete('reward_setting', array('id' => $id))){
	show_message("删除成功","",1);
	}else{
	show_message("删除失败");
	}
	}
	public function tonewreward(){
	$data['reward']=$_POST['reward'];
	$data['time']=time();
	if($this->db->insert('reward_setting',$data)){
	$r_data['status']=1;
	$r_data['msg']="新建成功";
	echo json_encode($r_data);
	}else{
	$r_data['status']=0;
	$r_data['msg']="新建失败";
	echo json_encode($r_data);
	}
	}
	public function editreward(){
	$reward=$_POST['reward'];
	foreach($reward as $key=>$row){
	$data['reward']=$row;
	$this->db->where('id',$key);
	$this->db->update('reward_setting',$data);
	}
	show_message("保存成功","",1);
	}

}
