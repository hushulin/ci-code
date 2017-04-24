<?php
class Common extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('captcha');
        $this->load->library('session');
    }
    public function captcha(){
    
    $vals = array(
    'img_path'  => './captcha/',
    'img_url'   => '/captcha/',
    'font_path' => './path/to/fonts/texb.ttf',
    'img_width' => '150',
    'img_height'    => 80,
    'expiration'    => 7200,
    'word_length'   => 4,
    'font-size' => 100,
    'img_id'    => 'Imageid',
    'pool'      => '0123456789',

    // White background and border, black text and red grid
        'colors' => array(
        'background' => array(255, 255, 255),
        'border' => array(255, 255, 255),
        'text' => array(0, 0, 0),
        'grid' => array(255, 40, 40)
    )
);

  $cap = create_captcha($vals);
  $_SESSION['captcha']=$cap['word'];
  return $cap['image'];
    }
 /*
  *δ��¼��ת
  */
  public function isLogin(){
  if($_SESSION['isLogin']!==1){
        header('Location: /index.php/login?code='.$_GET['code']);
        exit;
     }
  }
  /*
   * ΢����Ȩ
   */
   public function oauth(){
        if(empty($_GET['code'])&&is_weixin()){
        header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".config_item('appid')."&redirect_uri=http://".$_SERVER['HTTP_HOST']."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect");
        exit;
        }
   }
   
   /*
    *���openid�Ƿ��Ѿ�����,���½�,����uid
    */
    public function checkopenid($oid,$code){
    
    if(empty($oid)){
    header("Location: /index.php");
    exit;
    }
    
    $query=$this->db->query("select * from st_user where openid='".$oid."'");
    $row=$query->row_array();
    if(!$row){
    $userinfo=$this->getwxuserinfo($oid);
    $data['openid']=$userinfo->openid;
    $data['nickname']=$userinfo->nickname;
    $data['avatar']=$userinfo->headimgurl;
    $data['sex']=intval($userinfo->sex);
    $data['country']=$userinfo->country;
    $data['province']=$userinfo->province;
    $data['city']=$userinfo->city;
    $this->db->insert('user',$data);
    $userid=$this->db->insert_id();
    return $userid;
    }elseif(empty($row['nickname'])||empty($row['avatar'])){
    $userinfo=$this->getwxuserinfo($oid);
    $data['openid']=$userinfo->openid;
    $data['nickname']=$userinfo->nickname;
    $data['avatar']=$userinfo->headimgurl;
    $data['sex']=intval($userinfo->sex);
    $data['country']=$userinfo->country;
    $data['province']=$userinfo->province;
    $data['city']=$userinfo->city;
    $this->db->where('id',$row['id']);
    $this->db->update('user',$data);
    }
    return $row['id'];
    }
    
    /*
     *����Ƿ�ע��
     */
     public function is_reg($id=0){
     $query=$this->db->query("select * from st_user where id=".$id);
     $row=$query->row_array();
     if(empty($row['tel'])||empty($row['password'])){
      header('Location: /index.php/register?code='.$_GET['code']);
        exit;
     }
     }
     
     /**
      *��ȡ����΢�Ŷ�ά��
      **/
      public function getqrcode($uid){
      do{
      //��ʼ��
    $curl = curl_init();
    //����ץȡ��url
    if($data['errcode']==40001){
    curl_setopt($curl, CURLOPT_URL, 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->getAccessToken(1));
    }else{
    curl_setopt($curl, CURLOPT_URL, 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->getAccessToken());
    }
    //����ͷ�ļ�����Ϣ��Ϊ���������
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //���û�ȡ����Ϣ���ļ�������ʽ���أ�������ֱ�������
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //����post��ʽ�ύ
    curl_setopt($curl, CURLOPT_POST, 1);
    //����post����
    $post_data ='{"action_name": "QR_LIMIT_STR_SCENE","action_info": {"scene":{"scene_str":"rpid:'.$uid.'"}}}';
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    //ִ������
    $data = curl_exec($curl);
    $result=$data;
    //�ر�URL����
    curl_close($curl);
    //echo $data;
    //��ʾ��õ�����
    $data=json_decode($data,true);
    //$data="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$data['ticket'];
   }while($data['errcode']==40001);
    return $data['ticket'];
      }
   
   /*
    *��ȡ΢���û�����
    */
    public function getwxuserinfo($oid,$code){
    $url="https://api.weixin.qq.com/sns/userinfo?access_token=".$_SESSION['access_token']."&openid=".$oid."&lang=zh_CN";
    $result=file_get_contents($url);
    return json_decode($result);
    }
   
   /*
    *��ȡ΢���û�openid
    */
    public function getOpenid($code){
    $obj_res=json_decode(file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".config_item('appid')."&secret=".config_item('appSecret')."&code=".$code."&grant_type=authorization_code"));
    //$this->db->where("id",1);
    //$data=array('access_token' => $obj_res->access_token,'time'=>time());
    // $this->db->update('access_token',$data);
    $_SESSION['access_token']=$obj_res->access_token;
    return $obj_res->openid;
    }
   
       
    /*
     *��ȡ΢��ACCESS_TOKEN
     */
  public function getAccessToken($y=0){
      $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".config_item("appid")."&secret=".config_item("appSecret");
     
      $query=$this->db->query("select * from st_access_token where id=1");
      $result=$query->row_array();
      $time=$result['time']+7000;
      if($time<time()||empty($result['access_token'])||$y==1){
      $result=file_get_contents($url);
      $obj_res=json_decode($result);
      $this->db->where("id",1);
      $this->db->update('access_token',array("access_token"=>$obj_res->access_token,'time'=>time()));
      return $obj_res->access_token;
      }else{
      return $result['access_token'];
      }

}


  public function getTypename($nickname){
  $query=$this->db->query("select name from st_type_setting where nickname='".$nickname."'");
  return $query->row_array()['name'];
  }
  /*
   *��δ�����Ŀ���
   */
  public function lottery(){
   //���δ�����Ŀ���
    $query=$this->db->query("select * from st_tran_log where profit=0 and userid=".$_SESSION['userid']." and endtime<=".time());
    $setting=$this->db->query("select * from st_setting where 1")->row_array();
    $not=$query->result_array();
    foreach($not as $row){
    $query=$this->db->query("select * from st_balance where type=".$row['ptype']." and uid=".$_SESSION['userid']);
    $b_result=$query->result_array();
    $balance=$b_result[0]['balance']; //��ѯ���
    $winpro=$row['ptype']==1?$setting['shiwin']:$setting['xuwin'];
	if($winpro!=0){  //�����趨�ĸ���
	$rand=rand(1,100);
	$data['rand']=$rand;
	if($rand<=$winpro){  //�н�
	$timetype=$row['timetype'];
	$query=$this->db->query("select profit from st_timetype where time=".$timetype);
	$profit=$query->row_array()['profit'];
	$data['win']=1;
	$data['profit']=sprintf('%.2f',$row['amount']+(($profit/100)*$row['amount']));  //����
	$balance_data=array(
	'balance' => $balance+$data['profit']
	);
	$this->db->where('type', $row['ptype']);
	$this->db->where('uid', $_SESSION['userid']);
	$this->db->update('balance', $balance_data);
	$data['balance']=$balance_data['balance'];
	}elseif($rand>=95&&$rand<=100){  //�ٷ�֮0.5ƽ��
	$data['win']=0;
	$data['startprice']=$row['price'];
	$data['endprice']=$row['price'];
	$data['profit']=$row['amount'];	
	$balance_data=array(
	'balance' => $balance+$data['profit']
	);
	$this->db->where('type', $row['ptype']);
	$this->db->where('uid', $_SESSION['userid']);
	$this->db->update('balance', $balance_data);
	$data['balance']=$balance_data['balance']; //���ص�ǰ���
	//ƽ�ֲ�������
	}else{   //δ�н�
	$data['win']=-1;
	$data['profit']=sprintf('%.2f',0-$row['amount']);
	$data['balance']=$balance; //���ص�ǰ���
	}
	$temp=explode('.',$row['price']);
	
	if($temp[1]){
	$temp=strlen($temp[1]);
	}else{
	$temp=0;
	}
	$xiaoshu=floatval($xiaoshu=sprintf("%0.".$temp."f",0)."1");
	$zrand=rand(1,5);
	$h_price=explode('.',$row['price'])[1]*$xiaoshu;
	if(($row['direction']==2&&$data['win']==1)||($row['direction']==1&&$data['win']==-1)){
	$lastprice=sprintf('%.'.$temp.'f',$row['price']+$h_price*$zrand);
	$data['info']=$row['direction']."|".$data['win']."|".$h_price*$zrand;
	}elseif($data['win']==0){
	$lastprice=$row['price'];
	}else{
	$lastprice=sprintf('%.'.$temp.'f',$row['price']-$h_price*$zrand);
	}
	$data['lastprice']=$lastprice;   //���۸�
	}else{  //����Ԥ
    
    $query=$this->db->query("select * from st_type where type='".$row['type']."' and time<=".$row['endtime']." order by time desc limit 1"); 
    $typeresult=$query->row_array();// ��ѯ����ʱ��۸�
    if(($row['direction']==2&&$typeresult['price']>$row['price'])||($row['direction']==1&&$typeresult['price']<$row['price'])){
    $timetype=$row['timetype'];
    $query=$this->db->query("select profit from st_timetype where time=".$timetype);
    $profit=$query->row_array()['profit'];
    $data['win']=1;
    $data['profit']=sprintf('%.2f',$row['amount']+(($profit/100)*$row['amount']));  //����
    $balance_data=array(
    'balance' => $balance+$data['profit']
     );
     $this->db->where('type', $row['ptype']);
     $this->db->where('uid', $_SESSION['userid']);
     $this->db->update('balance', $balance_data);
    }elseif($typeresult['price']==$row['price']){
    $data['win']=0;
    $data['profit']=$row['amount'];
    $balance_data=array(
    'balance' => $balance+$data['profit']  
    );
    //ƽ�ְѿ۵��Ļ���ȥ
    $this->db->where('type', $row['ptype']);
    $this->db->where('uid', $_SESSION['userid']);
    $this->db->update('balance', $balance_data);
    }else{
    $data['win']=-1;
    $data['profit']=sprintf('%.2f',0-$row['amount']);
    }
    }//
    $data['lastprice']=$typeresult['price'];
    $updata = array(
    'lastprice' => $typeresult['price'],
    'status' => $data['win'],
    'profit' => $data['profit']
    );
     $this->db->where('id', $row['id']);
     $this->db->update('tran_log', $updata);
    }
  
  }
  
  
  /**
   *�ƹ㽱�� N��
   *$uid int //�û�id
   *$amount float //��� 
   **/
   public function brandingreward($uid,$amount=0,$msg="��˵��"){
   $query=$this->db->query('select reward from st_reward_setting where 1');
   $rewardcount=$this->db->affected_rows();
   if($rewardcount==0){
   return false;
   }
   $reward=$query->result_array();
   $userid=$uid;
   for($x=0;$x<$rewardcount;$x++){
   $query=$this->db->query('select * from st_user where id='.$userid);
   $agent[$x]=$query->row_array()['rpid'];
   
   $userid=$agent[$x];
   if(empty($agent[$x])){
   unset($agent[$x]);
   break;
   }else{
   //���뽱����¼
   $data=array(
   'userid'=> $agent[$x], //�����û���
   'from_uid' => $uid,
   'reward' => sprintf('%.2f',$amount*($reward[$x]['reward']/100)),
   'amount' => $amount,
   'stage' =>($x+1),
   'msg' => $msg,
   'time' => time()
   );
   $this->db->insert('reward_log',$data);
   $query=$this->db->query("select balance from st_balance where type=1 and uid=".$agent[$x]);
   $balance=$query->row_array()['balance'];
   $b_data['balance']=$balance+sprintf('%.2f',$amount*($reward[$x]['reward']/100));
   $this->db->where('type',1);
   $this->db->where('uid',$agent[$x]);
   $this->db->update('balance',$b_data);
   }
   }
   
   }
   function getsubset($id){ //ȡ�¼��˵�
	$list=$this->db->query('select * from st_wcmenu where rid='.$id)->result_array();
	return $list;
	}

}
?>