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
  <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" />
  <script src="/js/jquery-1.11.3.min.js"></script>
  <script src="/js/tab.min.js"></script>
</head>
  <style>
  .wc_previwe  .nav-menu .nav-menu-wx .nav-group .nav-group-item a:hover,.wc_previwe  .nav-menu .nav-menu-wx .nav-group .nav-group-item a:focus{
  text-decoration:none;
  }
  .wc_previwe  .nav-menu .nav-group-item{
  border:1px solid #fff;
  }
  .wc_previwe  .nav-menu .nav-group-item:hover{
  border:1px solid #ccc;
  }
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
  margin-left:50px;
  float:left;
  }
  .form-group{
  padding-bottom:15px;
  }
  .panel .table td{
  font-size:14px;
  }
  .panel .table{
  border-bottom:1px solid #ddd;
  }
   @media (min-width: 768px){
  .col-sm-1 {
    width: 11%;
  }
  }
  .wc_previwe{
  border-radius:18px;
  border:1px solid #e5e5e5;
  width:350px;
  position: relative;
  padding-bottom: 100px;
  }
  .wc_previwe .app-header {
    height: 70px;
    background: url(/images/iphone_head.png) center center no-repeat;
}

.wc_previwe .app-content {
    width: 322px;
    margin: 0 auto;
    padding-bottom: 11px;
    border: 1px solid #c5c5c5;
    min-height: 200px;
    background-color: #f9f9f9;
    border-bottom: 0;
}
.wc_previwe .app-content {
    border-bottom: 1px solid #c5c5c5;
    min-height: 380px;
    position: relative;
    background: #fff;
    
}
 .wc_previwe .title {
    position: relative;
}
.wc_previwe .title h1{
    margin: 0;
    padding: 18px 60px 0 60px;
    height: 64px;
    line-height: 46px;
    font-size: 16px;
    color: #fff;
    text-align: center;
    background: url(/images/titlebar.png) no-repeat;
    cursor: pointer;
    left: -1px;
    right: -1px;
}
.wc_previwe:after {
    content: "";
    position: absolute;
    bottom: 20px;
    left: 145px;
    width: 60px;
    height: 60px;
    border: 1px solid #ddd;
    border-radius: 100%;
}
.wc_previwe .nav-menu .nav-menu-wx .nav-group {
    width: 100%;
    float: left;
}
.wc_previwe .nav-menu .nav-menu-wx.has-nav-3 .nav-group-item {
    width: 33.3%;
}
.wc_previwe .nav-menu .nav-menu-wx .nav-group .nav-group-item {
    position: relative;
    float: left;
    display: block;
    height: 100%;
    line-height: 44px;
    text-align: center;
    border-left: 1px solid #e5e5e5;
}
.wc_previwe .nav-menu .nav-menu-wx {
    background: #FAFAFA;
    border-top: 1px solid #e5e5e5;
}
.wc_previwe  .nav-menu .nav-menu-wx .nav-group .nav-group-item a {
    color: #333;
    text-shadow: 0 0 2px #f5f5f5;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height:44px;
}
.wc_previwe .nav-menu .nav-menu-wx .nav-group i {
    color: #888;
    display: inline-block;
    width: 12px;
    height: 12px;
    line-height: 14px;
    text-align: center;
    font-size: 14px;
    margin-right: 5px;
}
.wc_previwe .nav-menu .nav-menu-wx dl {
    display: block;
    position: absolute;
    z-index: 220;
    bottom: 40px;
    left: 50%;
    width: 85px;
    margin-left: -45px;
    min-height: 40px;
    background: #fff;
    border: 1px solid #afaeaf;
    border-radius: 5px;
    -webkit-box-shadow: inset 0 0 3px #fff;
}
.wc_previwe .nav-menu .nav-menu-wx dl:before, .conditionMenu .app .nav-menu .nav-menu-wx dl:after {
    content: "";
    display: inline-block;
    position: absolute;
    z-index: 240;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 0;
    border: 8px solid red;
    border-color: #afaeaf transparent transparent transparent;
    margin-left: -8px;
    margin-bottom: -16px;
}
.wc_previwe .nav-menu .nav-menu-wx dl dd:last-of-type {
    background: none;
}
.wc_previwe .nav-menu .nav-menu-wx dl dd {
    margin: 0;
    line-height: 40px;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.wc_previwe .nav-menu .nav-menu-wx, .conditionMenu .app .nav-menu .nav-menu-app, .conditionMenu .app .nav-menu .nav-menu-cart {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    color: #333;
    text-align: center;
}
.wc_previwe .nav-menu .nav-menu-wx dl dd+dd {
    border-top: 1px solid #ddd;
}
ul, ol {
    padding: 0;
    margin: 0;
}
  </style>
  <body>
  <div style="min-width:1080px;">
  <?php include 'header.php';?>
  <div class="row">
  <?php $this->load->view(config_item("admin_").'/nav')?>
  <div  class="content" style="width:800px;">
  
      <div>

  <!-- Nav tabs -->
  
  <ul class="nav nav-tabs" style="float:none;width:100%;border-right:0" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">关注回复</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">微信菜单</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    <br />
    <div class="alert alert-success" role="alert"><strong>提示！</strong>用户关注后自动回复的信息设置，仅支持文字回复！</div>
    <form action="/index.php/<?php echo config_item("admin_");?>/wc/to_gztext" method="post">
     <textarea id="gztext" class="form-control" rows="3" name="gztext" placeholder="回复文字"><?php echo $setting['gztext'];?></textarea>
     <br />
    <button type="submit" class="btn btn-info">立即保存</button>
    </form>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
    
    
    <h3>微信菜单设置</h3>
  <div class="wc_previwe" style="float:left">
  <div class="app-header"></div>
  <div class="app-content">
				<div class="inner">
					<div class="title">
						<h1><span class="ng-binding">默认菜单</span></h1>
					</div>
				</div>
<div class="nav-menu">
					<div class="js-quickmenu nav-menu-wx clearfix has-nav-3" >
						<ul class="nav-group designer-x ui-sortable">
						<?php foreach($list as $item){ ?>
							<li class="nav-group-item js-sortable ng-scope" >
								<?php $rlist=$this->Common->getsubset($item['id']);?>
								<a href="javascript:void(0);" title="拖动排序" class="ng-binding" onclick="showInput('<?php echo $item['name'];?>',<?php echo $item['type'];?>,'<?php echo $item['url'];?>','<?php echo $item['text'];?>',<?php echo $item['id'];?>,<?php echo $item['rid'];?>,<?php echo $item['level'];?>,<?php if($rlist){echo "1";}else{echo "0";};?>)">
									<i class="fa fa-minus-circle" ></i>
									<?php echo $item['name'];?>
								</a>
								<dl class="designer-y ui-sortable">
								<?php
								 foreach($rlist as $row){ ?>
								<dd  class="ng-scope">
										<input type="hidden">
										<a href="javascript:void(0)" onclick="showInput('<?php echo $row['name'];?>',<?php echo $row['type'];?>,'<?php echo $row['url'];?>','<?php echo $row['text'];?>',<?php echo $row['id'];?>,<?php echo $row['rid'];?>,<?php echo $row['level'];?>)"  class="ng-binding"><?php echo $row['name'];?></a>
									</dd>
									<?php }
									if(count($rlist)<5){
									 ?>
								<dd  class="js-not-sortable ng-scope">
										<a href="javascript:void(0)" onclick="showInput('',0,'','',0,<?php echo $item['id'];?>,0)" ><i class="fa fa-plus"></i></a>
									</dd><!-- end ngIf: but.sub_button.length < 5 -->
									<?php } ?>
								</dl>
							</li>
							<?php } ?>
							<?php for($i=0;$i<(3-count($list));$i++){ ?>
							<li class="nav-group-item js-sortable ng-scope">
						
								<a href="javascript:void(0);" title="拖动排序" class="ng-binding" onClick="showInput()">
									<i class="fa fa-plus"></i>
									添加菜单
								</a>
								
							</li><!-- end ngRepeat: but in context.group.button -->
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
  </div>
   
    <div class="menu-right" style="float:right;width:435px">
   <div class="alert alert-success" role="alert" >
      <strong>提示!</strong> 父级菜单最多三个，子级五个。
    </div>
    <form action="/index.php/<?php echo config_item("admin_");?>/wc/to_save" method="post">
    <div class="form-group" id="form" style="display:none">
    <input type="hidden" name="mid" id="mid" value="0" />
    <input type="hidden" name="rid" id="rid" value="0" />
    <input type="hidden" name="level" id="level" value="0" />
    <div class="input-group">
      <div class="input-group-addon">名称</div>
      <input class="form-control" name="name" type="text" placeholder="菜单名称">
    </div>
 
    <div id="radio" class="radio">
  <label>
    <input type="radio" name="type" id="type1" value="1">
   链接
  </label> 
  <label>
    <input type="radio" name="type" id="type2" value="2">
    文字
  </label>
  </div>
    <div class="input-group" id="url">
      <div class="input-group-addon">链接</div>
      <input class="form-control" type="text" name="url" placeholder="链接地址">
    </div>
    <br />
    <textarea id="text" class="form-control" rows="3" name="text" placeholder="回复文字"></textarea>
    <br />
    <button type="submit" class="btn btn-info">立即保存</button>
    <a href="" id="delmenu"><button type="button" class="btn btn-danger" >删除菜单</button> </a>
    <a href="/index.php/<?php echo config_item("admin_");?>/wc/menu"><button type="button" class="btn btn-success pull-right" >发布到微信</button></a>
    </div>
    </form>
    <div class="alert alert-danger" role="alert">添加或修改先保存再发布，发布后可能需等待一个小时左右微信才会更新。</div>
    </div>
    
    </div>
  </div>

</div>
  
 <br> 
  
  

  </div>
 
  </div>
 
  </div>
   </div>
   
    <script>
    function showInput(name,type,url,text,mid,rid,level,f){
    $("#form").show();
    $("input[name='name']").val(name);
   $("textarea[name='text']").html(text);
   $("input[name='url']").val(url);
   $("#delmenu").prop('href','/index.php/<?php echo config_item("admin_");?>/wc/delmenu?id='+mid);
    if(type==null||type==0){
    type=1;
    }
    if(mid==null||mid==0){
    $("#delmenu").hide();
    }else{
    $("#delmenu").show();
    }
    if(type==1){
    $('#url').show();
    $('#text').hide();
    $('#type2').prop('checked',false);
    $('#type1').prop("checked",true);
    }else if(type==2){
    $('#text').show();
    $('#url').hide();
    $('#type1').prop('checked',false);
    $('#type2').prop("checked",true);
    }
    console.log(type);
    $("#mid").val(mid);
    $("#rid").val(rid);
    $("#level").val(level);
    console.log(f);
    if(f==1){
    $("#radio").hide();
    $("#url").hide();
    $("#text").hide();
    }else{
    $("#radio").show();
    }
    }
    $(":radio").click(function(){
    if($(this).val()==1){
    $('#url').show();
    $('#text').hide();
    }else if($(this).val()==2){
    $('#text').show();
    $('#url').hide();
    }
    
    });
    </script>
  </body>
  </html>