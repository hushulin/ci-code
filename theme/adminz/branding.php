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
	<link href="/images/favicon218877.ico" rel="Shortcut Icon">
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <script src="/js/jquery-1.11.3.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</head>
  <style>
  *{
  font-family:'Microsoft YaHei';
  }
  body{
  margin:0px;
  padding:0;
  font-size:12px;
  }
  .row{
  margin:0px;
  }
  .content{
  margin-left:100px;
  float:left;
  }
  /*
  .form-group{
  padding-bottom:15px;
  }*/
 .reward{
  width:30px;
  text-align:right;
  padding-right:5px
 }
 #reward{
 width:50px;
 text-align:right;
 height:24px;
 }
 
  </style>
  <body>
  <div style="min-width:1080px;">
  <?php include 'header.php';?>
  <div class="row">
  <?php $this->load->view(config_item("admin_").'/nav')?>
  <div class="content">
  <div style="width:800px;margin:0 auto;">
  <div class="alert alert-info" role="alert" style="overflow:auto">
  <form action="branding/tosave" method="post">
  <div class="form-group pull-left">
  <label class="pull-left" style="line-height:25px">奖励类型:</label> 
    &nbsp;&nbsp;&nbsp;
   <input type="radio" style="line-height:35px" <?php if($setting['rewardtype']==0){echo 'checked'; }?> name="rewardtype" value="0" /> 充值金额

   <input type="radio" style="line-height:35px"  <?php if($setting['rewardtype']==1){echo 'checked'; }?> name="rewardtype" value="1" /> 交易金额
  </div><!--/form-group-->

    <div class="col-sm-3">
    <button type="submit" class="btn btn-info">修改</button>
    </div><!--/col-sm-3-->
    </form>
  </div><!--/alert-->
  <form action="branding/editreward" method="post">
  <table class="table table-hover">
      <thead>
        <tr>
          <th>级别</th>
          <th>奖励比率</th>
          <th width="20%">操作</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($rewardlist as $key=>$row){ ?>
        <tr>
          <td>#<?php echo $key+1;?>级</td>
          <td><input name="reward[<?php echo $row['id']?>]" type="text" class="reward" value="<?php echo $row['reward'];?>" />%</td>
          <td><a href="branding/delreward?id=<?php echo $row['id'];?>">删除</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <button type="submit" class="btn btn-danger">保存修改</button>
    
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">新建代理级</button>
    </form>
   </div>
   </div>
  </div>
   </div>
   <!--新建框-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">新建代理级</h4>
      </div>
      <div class="modal-body">
      <table class="table table-hover">
      <thead>
        <tr>
          <th>级别</th>
          <th>奖励比率</th>
        </tr>
      </thead>
      <tbody>
      <tr>
      <td>
      #<?php echo empty($rewardlist)?intval($key)+1:intval($key)+2;?>
      </td>
      <td>
      奖励：<input type="text" id="reward" placeholder="0.00"> %
      </td>
      </tr>
      </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" id="tonewreward" class="btn btn-primary">新建</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('#tonewreward').click(function(){
 $.ajax({url:'/index.php/<?php echo config_item("admin_"); ?>/branding/tonewreward',type:'POST',dataType:'json',async:false,data:{reward:$("#reward").val()},success:function(data){
  data=eval(data);
  alert(data.msg);
  if(data.status==1){
  window.location.reload();
  }
}});
  });
</script>
  </body>
  </html>