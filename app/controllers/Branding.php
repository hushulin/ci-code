<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branding extends ST_Controller {

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
        if($_SESSION['isLogin']!==1){
        header('Location: /index.php/login');
        }
    }
	public function index()
	{
	
    if(empty($_SESSION['userid'])){
        header('Location: /index.php/login');
        exit;
        }
     $data['title']="全民经纪人";
     $data["active"]="banding";
     $query=$this->db->query('select * from st_reward_setting order by id asc');
     $data['rewardlist']=$query->result_array();
     $query=$this->db->query('select count(*) as count from st_user where rpid='.$_SESSION['userid']);
     $data['people']=$query->row_array()['count'];
     $query=$this->db->query('select sum(reward) as count from st_reward_log where userid='.$_SESSION['userid']);
     $data['reward']=empty($query->row_array()['count'])?"0.00":$query->row_array()['count'];
     $query=$this->db->query("select * from st_user where id=".$_SESSION['userid']);
     $userinfo=$query->row_array();
     $data['picurl']='/brandingpic/bpic.php?ticket='.$this->Common->getqrcode($_SESSION['userid'])."&text=".$userinfo['nickname']." ".substr_replace($userinfo['tel'],'****',3,4);
     $this->load->view('branding',$data);
	}
	public function mylog(){
    $data['title']="邀请好友";
    $query=$this->db->query("select * from st_user where id=".$_SESSION['userid']);
    $data['userinfo']=$query->row_array();
    $query=$this->db->query('select count(*) as count from st_user where rpid='.$_SESSION['userid']);
     $data['people']=$query->row_array()['count'];
     $query=$this->db->query('select *,sum(st_reward_log.reward) as count from st_user left join st_reward_log on st_user.id=st_reward_log.from_uid where st_reward_log.userid='.$_SESSION['userid'].' group by st_user.id order by count desc');
     $data['list']=$query->result_array();
    $this->load->view('brandinglog',$data);
	}
public function myfriend(){
    $data['title']="邀请好友";
    
    /*下属用户盈亏*/
    $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit>0 and st_tran_log.ptype=1 and st_user.rpid=".$_SESSION['userid'] );
    $t_amount=$query->row_array()['amount'];
    $query=$this->db->query("select sum(st_tran_log.profit) as profit from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit<>0 and st_tran_log.ptype=1 and st_user.rpid=".$_SESSION['userid']);
    $t_profit=$query->row_array()['profit'];
    $data['allyk']=sprintf('%.2f',$t_profit-$t_amount);  //总盈亏
    $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit>0 and st_tran_log.ptype=1 and st_user.rpid=".$_SESSION['userid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m')='".date('Y-m',time())."'");
         $t_amount=$query->row_array()['amount'];
         $query=$this->db->query("select sum(st_tran_log.profit) as profit from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit<>0 and st_tran_log.ptype=1 and st_user.rpid=".$_SESSION['userid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m')='".date('Y-m',time())."'" );
        $t_profit=$query->row_array()['profit'];
       $data['allyk_m']=sprintf('%.2f',$t_profit-$t_amount);  //月盈亏
       $query=$this->db->query("select sum(st_tran_log.amount) as amount  from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit>0 and st_tran_log.ptype=1 and st_user.rpid=".$_SESSION['userid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
         $t_amount=$query->row_array()['amount'];
         $query=$this->db->query("select sum(st_tran_log.profit) as profit from st_tran_log left join st_user ON  st_user.id=st_tran_log.userid  where st_tran_log.profit<>0 and st_tran_log.ptype=1 and st_user.rpid=".$_SESSION['userid']." and DATE_FORMAT(FROM_UNIXTIME(st_tran_log.time),'%Y-%m-%d')='".date('Y-m-d',time())."'" );
        $t_profit=$query->row_array()['profit'];
        $data['allyk_d']=sprintf('%.2f',$t_profit-$t_amount);
    /**/
    $query=$this->db->query("select * from st_user where id=".$_SESSION['userid'].' and time<>0');
    $data['userinfo']=$query->row_array();
    $query=$this->db->query('select count(*) as count from st_user where rpid='.$_SESSION['userid']);
     $data['people']=$query->row_array()['count'];
     $query=$this->db->query('select * from st_user where rpid='.$_SESSION['userid'].' and time<>0 order by time desc');
     $data['list']=$query->result_array();
    $this->load->view('myfriend',$data);
	}
	
}
