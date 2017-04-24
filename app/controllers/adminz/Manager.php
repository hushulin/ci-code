<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

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
    $data['title']="管理员-后台管理";
    $data['active']="manager";
    $query=$this->db->query("select * from st_admin where 1");
    $data['manager']=$query->result_array();
    $this->load->view(config_item("admin_").'/manager',$data);
    }
   public function del(){
   $uid=intval($_POST['uid']);
   if(empty($uid)){
   $data['status']=0;
   $data['msg']="参数错误，请刷新重试";
   echo json_encode($data);
   exit;
   }
   $this->db->where('id',$uid);
   if($this->db->delete('admin')){
   $data['status']=1;
   $data['msg']="删除成功";
   if($uid==$_SESSION['adminid']){
   $_SESSION['is_Admin']=0;
   }
   echo json_encode($data);
   }else{
   $data['status']=0;
   $data['msg']="删除失败，请刷新重试";
   echo json_encode($data);
   }
   }
   public function add(){
   $username=trim($_POST['username']);
   $password=$_POST['password'];
   if(strlen($username)<5){
   $data['status']=0;
   $data['msg']="用户名长度必须大于5位";
   echo json_encode($data);
   exit;
   }
   if(strlen($password)<5){
   $data['status']=0;
   $data['msg']="密码长度必须大于5位";
   echo json_encode($data);
   exit;
   }
   $password=md5($password);
   $this->db->query("select * from st_admin where username='".$username."'");
   if($this->db->affected_rows()>0){
   $data['status']=0;
   $data['msg']="该用户已经存在";
   echo json_encode($data);
   exit;
   }
   $manage_data=array(
   'username' => $username,
   'password' => $password
   );
   if($this->db->insert('admin', $manage_data)){
    $data['status']=1;
    $data['msg']="新建账户「".$username."」成功";
    echo json_encode($data);
   }else{
   $data['status']=0;
    $data['msg']="新建账户「".$username."」失败，请刷新重试";
    echo json_encode($data);
   }
   }
   
   public function editpassword(){
   $uid=$_POST['uid'];
   $usedpassword=$_POST['usedpassword'];
   $newpassword=$_POST['newpassword'];
   if(empty($usedpassword)||empty($newpassword)){
   $data['status']=0;
   $data['msg']="信息不完整";
   echo json_encode($data);
   exit;
   }
   $this->db->query("select * from st_admin where id=".$uid." and password='".md5($usedpassword)."'");
   if($this->db->affected_rows()<=0){
   $data['status']=0;
   $data['msg']="旧密码错误";
   echo json_encode($data);
   exit;
   }
   $newpassword=md5($newpassword);
   $password_data=array(
   'password'=>$newpassword
   );
   $this->db->where('id',$uid);
   if($this->db->update('admin',$password_data)){
   $data['status']=1;
   $data['msg']="密码修改成功";
   if($uid==$_SESSION['adminid']){
   $_SESSION['is_Admin']=0;
   }
   echo json_encode($data);
   }else{
   $data['status']=0;
   $data['msg']="密码修改失败，请刷新重试";
   echo json_encode($data);
   }
   }
	
	
}
