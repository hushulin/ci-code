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
html {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
    font-size: 62.5%;
}
body{
    background:#fff;
    -webkit-font-smoothing: antialiased;
}
@media screen and (min-width: 360px) and (max-width: 374px) {
	html {
		font-size: 70.3%;
	}
}
@media screen and (min-width: 375px) and (max-width: 383px) {
	html {
		font-size: 73.24%;
	}
}
@media screen and (min-width: 384px) and (max-width: 399px) {
	html {
		font-size: 75%;
	}
}
@media screen and (min-width: 400px) and (max-width: 413px) {
	html {
		font-size: 78.125%;
	}
}
@media screen and (min-width: 414px) and (max-width: 431px) {
	html {
		font-size: 80.86%;
	}
}
@media screen and (min-width: 432px) and (max-width: 479px) {
	html {
		font-size: 84.375%;
	}
}


@media screen and (min-width: 480px)and (max-width: 639px) {
	html {
		font-size: 93.75%;
	}
}
@media screen and (min-width: 640px){
	html {
		font-size: 125%;
	}
}
</style>
  <body>
  <div class="branding-body">
  <div class="top-banner">
        <img src="/images/yaoqing.png" class="banner">
</div>
<div class="action-info">
              <?php foreach($rewardlist as $key=>$row){ ?>
                <div class="info-d">
                    <div class="pic-d"></div>
                    <p><?php echo $key+1;?>级代理：好友每次<span class="col-y1"><?php echo $setting['rewardtype']==0?'充值':'交易'; ?></span></p>
                    <p>您都获得<span class="col-y1 fn16"><?php echo $row['reward'];?>%返利</span></p>
                </div>
                <?php } ?>
            </div>
<div class="card-con">
                <p class="fn16 col-fe"><span class="dot"></span>好友已为您赚取返利</p>
                <div class="card-money">
                    <span class="symbol">￥</span>

                    <span><?php echo $reward;?></span>
                </div>
                <div class="card-fd">
                    <a href="/index.php/branding/mylog"> <span class="dot"></span> 我邀请的好友数：<span class="col-y3"><?php echo $people;?>人，详情 </span> <span class="arrow-r"></span></a>
                </div>
                
            </div>
            <div class="rp">
            <h3>邀请链接</h3>
            <input id="rpa" readonly value="http://<?php echo $_SERVER['HTTP_HOST'];?>/index.php/register?rp=<?php echo $_SESSION['userid'];?>" />
            <p>长按上面链接复制</p>
            </div>
            <div class="rule-con">
        <h3>如何成为全民经纪人？</h3>
        <p>1. 点击“生成邀请图片”按钮，将您的图片名片保存到手机后，发送给好友。好友使用微信扫一扫关注公众号并注册，您马上成为好友的经纪人，好友<?php echo $setting['rewardtype']==0?'充值':'交易'; ?>后您即可获得<?php echo $setting['rewardtype']==0?'充值':'交易'; ?>返利。</p>
        <!--<p>2.点击“立即邀请”按钮，分享到微信群或朋友圈，邀请好友注册并投资决胜六十秒。</p>-->
		<!--<p>2.邀请同一好友，可自动同时参与“赢返利现金”、“拿iphone 6s”两个活动。</p>-->
    </div>
            <div class="qrcode" style="width:100%">
            <a name="qrcode"> </a>
          
            </div>
            <div id="full-pic">
            长按图片保存<br/><br/>
             <img id="b_pic"  src="" width="55%" />
            </div>
            <div class="footer-btn-b fixed-btn-f">
    <a href="#qrcode" id="give-btn" data-is-login="1">生成邀请图片</a>
          </div>
          </div>
          <div style="display:none">
          <?php echo $setting['statistics'];?>
          </div>
          <style>
          .rp{
          text-align:center;
          }
          .rp a{
          display:block;
          margin-top:15px;
          font-size:15px;
          }
          .rp input{
          padding:10px 5px;
          border:1px solid #eee;
          width:80%;
          font-size:14px;
          color:#777;
          }
          #full-pic{
          width:100%;
          height:100%;
          text-align:center;
          position:fixed;
          background:#000;
          top:0;
          left:0;
          opacity:0.85;
          padding-top:8%;
          z-index:999;
          font-size:18px;
          display:none;
          }
          .rule-con {
              color: #666;
              padding: 25px 10px 80px;
           }
           .rule-con h3 {
              padding-bottom: 20px;
              text-align: center;
              font-size: 1.5em;
            }
            .rule-con p {
                padding-left: 13px;
                text-indent: -13px;
                font-size: 15px;
                line-height: 2em;
                }
          </style>
          <script>
          function setClipboardText(){

        return window.clipboardData.setData("text",$('#rpa').val());
        
};
          var picurl='<?php echo $picurl;?>';
          $('#give-btn').click(function(){
          $("#b_pic").attr('src',picurl);
          $("#full-pic").show();
          });
          $('#full-pic').click(function(){
          $("#full-pic").hide();
          });
          </script>
</body>
</html>