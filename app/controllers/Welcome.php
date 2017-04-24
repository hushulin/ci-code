<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends ST_Controller {

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
        $this->load->model('Common');
        $this->load->library('session');
        /*登录*/
        if(is_weixin()&&empty($_SESSION['userid'])){
        $this->Common->oauth();
        $_SESSION['isLogin']=1;
        $openid=$this->Common->getOpenid($_GET['code']);
        $_SESSION['userid']=$this->Common->checkopenid($openid,$_GET['code']);
        $this->db->where('id',$_SESSION['userid']);
        $this->db->update('user',array('lastip'=>get_onlineip(),'lasttime'=>time()));
        
        }
        if(!empty($_SESSION['userid'])){
        $this->Common->is_reg($_SESSION['userid']);
        }
        $this->Common->isLogin();
        /**/
        $this->Common->lottery();
        
        $data['ptype']=empty($_GET['t'])?1:intval(trim($_GET['t']));
        if($this->getsetting()['open_virtual']==0&&$data['ptype']==2){
        show_message("虚拟盘已关闭","/");
        }
    }
    public function index()
    {
    $ptype=empty($_GET['t'])?1:intval(trim($_GET['t']));
    if(!empty($_GET['t'])&&$_SESSION['ptype']!==$ptype){
    $_SESSION['ptype']=empty($_GET['t'])?1:intval(trim($_GET['t']));
    }
    $data['ptype']=empty($_SESSION['ptype'])?1:$_SESSION['ptype'];
     if($data['ptype']!=1&&$data['ptype']!=2){ //实体虚拟盘
     show_error("参数错误",500,"提示信息");
     exit;
     } 
     $query=$this->db->query("select * from st_balance where uid=".$_SESSION['userid']." and type=".$data['ptype']." limit 1");
     $result=$query->result_array();
     $data['balance']=$result[0]['balance'];
    $query=$this->db->query("select * from st_type_setting where is_close=0 order by is_rest,order_ asc");
    $type=$query->result_array();
    $data['type']=$type;
    $query=$this->db->query("select * from st_timetype order by order_ asc");
    $timetype=$query->result_array();
    $data['userinfo']=$this->db->query("select * from st_user where id=".$_SESSION['userid'])->row_array();
    $data["timetype"]=$timetype;
    $data["active"]="home";
    $query=$this->db->query('select img,url from st_topad where 1');
    $data['topad']=$query->result_array();
		$this->load->view('index',$data);
	}

	
	
}
