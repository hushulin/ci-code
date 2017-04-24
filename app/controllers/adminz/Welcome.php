<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
     $data['title']="后台管理";
     $data['active']="index";
     $this->db->query('select * from st_user');
     $data['alluser']=$this->db->affected_rows();
     $query=$this->db->query("select sum(amount) as amount from st_tran_log where userid<>0 and ptype=1");
     $data['allamount']=$query->row_array()['amount'];
     $query=$this->db->query("select sum(amount) as amount from st_cash_log where status=1 and uid<>0");
     $data['allcash']=$query->row_array()['amount'];
     $query=$this->db->query("select sum(amount) as amount from st_recharge_log where is_human=0");
     $data['allrecharge']=$query->row_array()['amount'];
      $query=$this->db->query("select sum(reward) as reward from st_reward_log");
     $data['allreward']=$query->row_array()['reward'];
     $query=$this->db->query("select sum(amount) as amount  from st_tran_log where profit>0 and ptype=1");
     $t_amount=$query->row_array()['amount'];
     $query=$this->db->query("select sum(profit) as profit from st_tran_log where profit<>0 and ptype=1");
     $t_profit=$query->row_array()['profit'];
     $data['allyk']=0-($t_profit-$t_amount);
    $this->db->query("select * from st_user where DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
     $data['alluser_d']=$this->db->affected_rows();
     $query=$this->db->query("select sum(amount) as amount from st_tran_log where userid<>0 and ptype=1 and  DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
     $data['allamount_d']=$query->row_array()['amount'];
     $query=$this->db->query("select sum(amount) as amount from st_cash_log where status=1 and uid<>0 and  DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
     $data['allcash_d']=$query->row_array()['amount'];
     $query=$this->db->query("select sum(amount) as amount from st_recharge_log where is_human=0 and DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
     $data['allrecharge_d']=$query->row_array()['amount'];
      $query=$this->db->query("select sum(reward) as reward from st_reward_log where DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
     $data['allreward_d']=$query->row_array()['reward'];
     $query=$this->db->query("select sum(amount) as amount  from st_tran_log where profit>0 and ptype=1 and DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
     $t_amount=$query->row_array()['amount'];
     $query=$this->db->query("select sum(profit) as profit from st_tran_log where profit<>0 and ptype=1 and DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
     $t_profit=$query->row_array()['profit'];
     $data['allyk_d']=0-($t_profit-$t_amount);
      if(empty($data['allyk_d'])){
     $data['allyk_d']="0.00";
     }
     if(empty($data['allcash_d'])){
     $data['allcash_d']="0.00";
     }
     if(empty($data['allamount_d'])){
     $data['allamount_d']="0.00";
     }
     if(empty($data['alluser_d'])){
     $data['alluser_d']="0";
     }
     if(empty($data['allrecharge_d'])){
     $data['allrecharge_d']="0.00";
     }
     if(empty($data['allreward_d'])){
     $data['allreward_d']="0.00";
     }
     //$_SESSION['is_Admin']=0;
     for($x=0;$x<12;$x++){  //用户数
     $query=$this->db->query("select count(*) as count from st_user where DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',strtotime('-'.(11-$x).' days'))."'");
     $data['usernum'][$x]=$query->row_array()['count'];
     }
     for($x=0;$x<12;$x++){  //推广额
     $query=$this->db->query("select sum(reward) as count from st_reward_log where DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',strtotime('-'.(11-$x).' days'))."'");
     $data['rewardnum'][$x]=$query->row_array()['count'];
     if(empty($data['rewardnum'][$x])){
     $data['rewardnum'][$x]="0.00";
     }
     }
     for($x=0;$x<12;$x++){  //提现额
     $query=$this->db->query("select sum(amount) as count from st_cash_log where status=1 and DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',strtotime('-'.(11-$x).' days'))."'");
     $data['cashnum'][$x]=$query->row_array()['count'];
     if(empty($data['cashnum'][$x])){
     $data['cashnum'][$x]="0.00";
     }
     }
     for($x=0;$x<12;$x++){  //充值额
     $query=$this->db->query("select sum(amount) as count from st_recharge_log where status=1 and is_human=0 and DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',strtotime('-'.(11-$x).' days'))."'");
     $data['rechargenum'][$x]=$query->row_array()['count'];
     if(empty($data['rechargenum'][$x])){
     $data['rechargenum'][$x]="0.00";
     }
     }
     for($x=0;$x<12;$x++){  //交易额
     $query=$this->db->query("select sum(amount) as count from st_tran_log where ptype=1 and userid<>0 and DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',strtotime('-'.(11-$x).' days'))."'");
     $data['trannum'][$x]=$query->row_array()['count'];
     if(empty($data['trannum'][$x])){
     $data['trannum'][$x]="0.00";
     }
     }
		$this->load->view(config_item("admin_").'/index',$data);
	}

}
