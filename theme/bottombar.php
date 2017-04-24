<style>
.bottombar{
position:fixed;
bottom:0px;
width:100%;
height:55px;
border-top:1px solid #eee;
background:#fff;
}
.bottombar li{
padding-top:5px;
float:left;
width:33%;
text-align:center;
line-height:23px;
}
.bottombar li i{
font-size:20px;
/*width:18px;*/
}
.bottombar li p{
font-size:12px;
}
.bottombar li.active{
color:#3B95D3;
}
</style>
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" />
<div class="bottombar">
<ul>
<a href="/?t=<?php echo $ptype?>&code=<?php echo $_GET['code'];?>"><li <?php if(@$active=="home"){ ?>class="active"<?php } ?>><i class="fa fa-gg" aria-hidden="true"></i><p>交易</p></li></a>
<a href="/index.php/branding"><li <?php if(@$active=="rank"){ ?>class="active"<?php } ?>><i class="fa fa-rebel" aria-hidden="true"></i><p>全民经纪人</p></li></a>
<a href="/index.php/me?t=<?php echo $ptype?>&code=<?php echo $_GET['code'];?>"><li <?php if(@$active=="me"){ ?>class="active"<?php } ?>><i class="fa fa-user-o" aria-hidden="true"></i><p>我</p></li></a>
</ul>
</div>
<div style="display:none">
<?php echo $setting['statistics'];?>
</div>