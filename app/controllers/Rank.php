<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rank extends ST_Controller {

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
     $data['title']="排行榜";
      $s=empty($_GET['s'])||$_GET['s']==1?'st_tran_log':'st_reward_log';
      $ts=empty($_GET['s'])||$_GET['s']==1?'profit':'amount';
     $data["active"]="rank";
    // if($s=='st_tran_log'){$p=' and tran.ptype=1 ';}  //排名榜只显示实盘
    $query=$this->db->query('select user.nickname,sum('.$ts.') as amount,user.avatar from '.$s.' as tran left join st_user as user on tran.userid=user.id where tran.'.$ts.'>0'.$p.' group by tran.userid order by sum('.$ts.') desc limit 10');
    $data['list']=$query->result_array();
    $data['first']=array_shift($data['list']);
    $data['second']=array_shift($data['list']);
    $data['third']=array_shift($data['list']);
		$this->load->view('rank',$data);
	}
	
}
