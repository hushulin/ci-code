  <!--栏目菜单-->
  <style>
  .nav{
  width:256px;
  float:left;
  color:#353535;
  font-size:14px;
  height:100%;
  border-right:1px solid #eee;
  }
  .nav i{
  height:25px;width:25px;
  display:block;float:left;
  margin-right:25px;
  font-size:23px;
  color:#a4a4a4;
  text-align:center;
  }
  .nav .list-group-item {
    padding-left:35px;
    margin-bottom:10px;
  }
  a.list-group-item{
    color:#353535;
  }
  .list-group-item {
  border:0;
  }
  .list-group-item:first-child{
      border-top-left-radius: 0px;
    border-top-right-radius: 0px;
  }
  .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus{
  background-color: transparent;
  color:#09bb07;
  }
  </style>
  <div class="nav">
  <div class="list-group">
  <a href="/index.php/<?php echo config_item("admin_");?>" class="list-group-item <?php if($active=="index"){ ?>active<?php } ?>">
    <i style="background: url(/images/base_z_@all330206.png) 0 -696px no-repeat;"></i>后台首页
  </a>
  <a href="/index.php/<?php echo config_item("admin_");?>/setting" class="list-group-item <?php if($active=="setting"){ ?>active<?php } ?>"><i style="background: url(/images/base_z_@all330206.png) 0 -836px no-repeat;"></i>站点设置</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/user" class="list-group-item <?php if($active=="user"){ ?>active<?php } ?>"><i style="background: url(/images/base_z_@all330206.png) 0 -752px no-repeat;"></i>用户管理</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/type" class="list-group-item <?php if($active=="type"){ ?>active<?php } ?>"><i style="background: url(/images/base_z_@all330206.png) 0 -808px no-repeat;"></i>资产类型</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/timetype" class="list-group-item <?php if($active=="timetype"){ ?>active<?php } ?>"><i class="fa fa-tachometer" aria-hidden="true"></i>时间类型</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/branding" class="list-group-item <?php if($active=="branding"){ ?>active<?php } ?>"><i class="fa fa-user-plus" aria-hidden="true"></i>推广设置</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/recharge" class="list-group-item <?php if($active=="recharge"){ ?>active<?php } ?>"><i class="fa fa-dollar" aria-hidden="true"></i>充值管理</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/cash" class="list-group-item <?php if($active=="cash"){ ?>active<?php } ?>"><i style="background: url(/images/base_z_@all330206.png) 0 -864px no-repeat;"></i>提现管理</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/tran" class="list-group-item <?php if($active=="tran"){ ?>active<?php } ?>"><i style="background: url(/images/base_z_@all330206.png) 0 -780px no-repeat;"></i>交易管理</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/contact" class="list-group-item <?php if($active=="contact"){ ?>active<?php } ?>"><i style="background: url(/images/base_z_@all330206.png) 0 -892px no-repeat;"></i>客服信息</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/ad" class="list-group-item <?php if($active=="ad"){ ?>active<?php } ?>"><i style="background: url(/images/base_z_@all330206.png) 0 -724px no-repeat;"></i>广告管理</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/wc" class="list-group-item <?php if($active=="wc"){ ?>active<?php } ?>"><i style="background: url(/images/icon_developer_apply2a4e1c.png)no-repeat;background-size:100%"></i>微信设置</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/manager" class="list-group-item <?php if($active=="manager"){ ?>active<?php } ?>"><i style="background: url(/images/base_z_@all330206.png) 0 -752px no-repeat;"></i>管理设置</a>
  <a href="/index.php/<?php echo config_item("admin_");?>/doexit" class="list-group-item"><i class="fa fa-hand-o-left" aria-hidden="true"></i>退出登录</a>
</div>
  </div>