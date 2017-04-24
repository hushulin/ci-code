<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="wap-font-scale" content="no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title><?php echo $title;?></title>
	<link rel="stylesheet" href="/css/weui.min.css" />
	<script src="/js/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<style>
*{
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    -webkit-touch-callout: none;
}
body{
    background:#fff;
    -webkit-font-smoothing: antialiased;
}
.account-top-view{
  background:#fe7b23;
  background-color:#fe7b23;
}
.water{
  background:#fe7b23;
}
th,td{
  text-align:center;
  font-weight:100;
  font-size:12px;
}
.table>thead>tr>th{
border-bottom: 0px;
padding:10px 0px;
}
.table>tbody>tr>td{
border-top: 1px solid #eee;
}
.yk span{
  font-weight:400;
  font-size:12px;
}
</style>
  <body>
  <section class="jz-wrapper jz-null-bottom">
  <div class="jz-head">
    <a href="###" id="account_icon_btn" class="pos-left head-show jz-my_head">
    <img src="<?php echo $userinfo['avatar'];?>" width="33" height="33" alt="">
    </a>
<span><?php echo $userinfo['nickname'];?> </span>

</div>
  <div class="account-top-view text-center">
        <p class="font-sm">已邀请好友</p>
        <p class="account-total" ><?php echo empty($people)?"0":$people;?></p>
  </div>
    
  <div class="water">
<div class="water-1"></div>
<div class="water-2"></div>
</div> 
<?php if($userinfo['rtype']==2){ ?>
      <center><div class="yk"><span>总盈亏:<?php echo $allyk;?></span>&nbsp;&nbsp;<span>月盈亏:<?php echo $allyk_m;?></span>&nbsp;&nbsp;<span>今日盈亏:<?php echo $allyk_d;?></span></div></center>  
         <?php } ?>

<table class="table">
        <thead>
          <tr>
            <th>用户名</th>  
            <th>余额</th>
            <?php if($userinfo['rtype']>=1){ ?>
            <th>总交易</th>
            <th>今日交易</th>
            <?php } ?>
            <th>注册时间</th>
          </tr>
        </thead>
        <tbody>
         <?php foreach($list as $row){ ?>
         <tr>
         <td style="width:50px;overflow:hidden;text-overflow:ellipsis;"><?php echo empty($row['nickname'])?$row['tel']:$row['nickname'];?></td>
        <td><?php $query=$this->db->query('select * from st_balance where type=1 and uid='.$row['id']);
        echo $query->row_array()['balance'];
        ?></td>
        <?php if($userinfo['rtype']>=1){ ?>
            <td><?php $query=$this->db->query('select sum(amount) as amount from st_tran_log where ptype=1 and userid='.$row['id']);
        echo $query->row_array()['amount'];
        ?></td>
            <td><?php $query=$this->db->query("select sum(amount) as amount from st_tran_log where ptype=1 and userid=".$row['id']." and  DATE_FORMAT(FROM_UNIXTIME(time),'%Y-%m-%d')='".date('Y-m-d',time())."'");
        echo empty($query->row_array()['amount'])?'0.00':$query->row_array()['amount'];
        ?></td>
            <?php } ?>
         <td><?php echo date('Y-m-d H:i:s',$row['time']);?></td>
         </tr>
         
         <?php } ?>
        </tbody>
      </table>
</section>
  </body>
  <?php include "bottombar.php" ?>
 </html>
	