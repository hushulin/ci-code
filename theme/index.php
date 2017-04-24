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
	<link rel="stylesheet" href="/css/weui.min.css?ttt" />
	<script src="/js/jquery-1.11.3.min.js?<?php echo time();?>"></script>
	<script src="/js/idangerous.swiper.min.js"></script>
	<script src="/js/TouchSwipe.js"></script>
	<script src="/js/jquery.color.js"></script>
	<script src="//cdn.bootcss.com/highstock/5.0.2/highstock.js"></script>
	
	<title><?php echo $setting['title'];?></title>
  <link rel="stylesheet" type="text/css" href="/css/style.css?<?php echo time();?>" />
<script>
var ptype=<?php echo $ptype;?>;
</script>
</head>
<style>
html {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
    font-size: 62.5%;
}
.newest .table tr th{
  color:#666;
  font-weight:300;
}
.newest .table tr td{
  color:#666;
  font-weight:300;
}
.table tr th{
padding: 15px 0px;
text-align:center;
}
.table>tbody>tr>td{
 padding:10px 0;
}
.table tr td{
text-align:center;
}
.mytran table tr th{
  color:#bbb;
}
.mytran table tr td{
color:#555;
text-align:center;
}
.table>tbody>tr>td{
border-top: 1px solid #eee;
}
.table>thead>tr>th{
border-bottom: 0px;
padding:10px 0px;
}
index,
body,
html {
	width: 100%;
	height: 100%;
	/*myself*/
 
	font-family: "Microsoft YaHei", "Helvetica Neue", Arial, HelveticaNeue, Helvetica, "BBAlpha Sans", sans-serif;/*liang*/
	font-weight: normal;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-box-align: center;
	color: #666666;
	/*myself*/
}

body{
    -webkit-font-smoothing: antialiased;
    -webkit-text-size-adjust: none;
    text-size-adjust: none;
    font-size: 14px;
    line-height: 1.4;
}
*{
box-sizing: border-box;
}


p,
li {   
	font-size: 1.2rem;
	color: #434343
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
#top_ad{
  height:3.5rem !important;
  margin-top:0;
}
#top_ad .swiper-slide{
  width:100%;
  border-radius:0;
  margin:0;
  border:0;
  padding:0;
}
#top_ad{
  width:100% !important;
  overflow:hidden;
}

</style>
<body>
<div class="wrap">
<div class="index">
<?php if($topad){ ?>
<div id="top_ad">
<div class="swiper-wrapper">
<?php foreach($topad as $row){ ?>
    <div class="swiper-slide"><a href="<?php echo $row['url'];?>"><img src="<?php echo $row['img'];?>" width="100%" height="100%" /></a></div>
    <?php } ?>
  </div>
</div>
<script> 
var topadSwiper = new Swiper('#top_ad',{
autoplay : 5000,
speed:500,
initialSlide:0,
})

</script>
<?php } ?>
<div class="userinfo">
  <div class="info-detail left" id="balance_" style="float:left;background: url('<?php echo $userinfo['avatar'];?>') left no-repeat;background-size: 4rem 4rem;"><span class="a-u"><?php echo $ptype==1?'余额(元)':'模拟资金(元)';?></span><em class="a-d" id="money"><?php echo $balance;?></em>
  </div>
  <a href="/index.php/me/recharge" class="charge-btn tocharge"></a>
<!--<a href="?t=<?php echo $ptype==1?'2':'1';?>"><div class="info-detail <?php echo $ptype==1?'right':'shipan';?>" id="mycoupon"></div></a>-->
</div>

<div class="switch-product" id="tabs"><ul class="product_switch clearfix" id="product_switch">
<?php 
$first_type=array_shift($type);
?>
<li <?php if($first_type['is_close']!==1){?>class="sw_active"<?php } ?> id="change_<?php echo $first_type['nickname'];?>" type="<?php echo $first_type['nickname'];?>"><a href="javascript:void(0);" id="change_<?php echo $first_type['nickname'];?>" type="<?php echo $first_type['nickname'];?>"><?php echo $first_type['name'];?></a></li>
<?php foreach($type as $t){ ?>
<li data-isrest="<?php echo $t['is_rest']?>" id="change_<?php echo $t['nickname'];?>" type="<?php echo $t['nickname'];?>"><a href="javascript:void(0);" data-isrest="<?php echo $t['is_rest']?>" id="change_<?php echo $t['nickname'];?>" type="<?php echo $t['nickname'];?>"><?php echo $t['name'];?></a></li>
<?php } ?>

</ul></div>
<!--显示当前种类信息-->
<div class="priceline">
<ul class="price">
<li style="width:35%"><span><span id="typeshow"> </span>实时价</span><br><p id="nowprice">￥0</p></li>
<li><span>最低价</span><p id="minprice" class="tc_green">￥0</p></li>
<li><span>最高价</span><p id="maxprice" class="tc_firebrick">￥0</p></li>
<li style="border:0"><span>时间</span><p class="timeshow">00:00:00</p></li>
</ul>
</div>
<!--选择模式开始-->
<div class="swiper-container" id="options">
<div class="swiper-wrapper">
<?php  $i=0; foreach($timetype as $time){ ?>
<div class="swiper-slide" id="swiper-slide<?php echo $i;?>" profit="<?php echo $time['profit'];?>" index="<?php echo $time['time'];?>"><a href="javascript:void(0);"><h3>决胜时间</h3><h4><span><?php echo $time['time'];?></span> 秒</h4><h5>收益比例：<?php echo $time['profit'];?>%</h5></a></div>
<?php $i++; } ?>

</div>
</div>
<a class="default" href="#" id="btn1" style="display:none">提示当前活动块</a>
<ul class="buy-choose clearfix"><li onclick="buyshow(0)"><a href="javascript:void(0);" class="up">买涨</a></li><li onclick="buyshow(1)"><a href="javascript:void(0);" class="down">买跌</a></li></ul></div>

<div id="k-chart">
</div>
<ul class="time" id="select_period"><li data-desc="1分钟" data-min="1" class="first on">1分</li><li data-desc="5分钟" data-min="5">5分</li><li data-desc="15分钟" data-min="15">15分</li><li data-desc="30分钟" data-min="30" class="last">30分</li></ul>
<!--选项卡开始-->
<nav class="page_nav">
	<a class="cur" onclick="page_nav1(this,1,<?php echo $ptype;?>)" href="javascript:void(0)">最新交易</a>
	<a class="" onclick="page_nav1(this,3,<?php echo $ptype;?>)" href="javascript:void(0)">持仓订单</a>
	<a class="" onclick="page_nav1(this,2,<?php echo $ptype;?>)" href="javascript:void(0)">交易记录</a>
</nav>
<div class="navshow">
<div class="newest">
<table class="table table-condensed">
    <thead>
        <tr>
          <th>买入时间</th>
          <th>买入资产</th>
          <th>买入方向</th>
          <th>买入量</th>
        </tr>
   </thead>
   <tbody>
   <!---->
  </tbody>
  </table>
</div>
<div class="position" style="display:none;margin-bottom:50px;">
<table class="table table-condensed">
    <thead>
        <tr>
          <th>下单时间</th>
          <th>资产类型</th>
          <th>买入量</th>
          <th>买入方向</th>
          <th>执行价格</th>
          <th>订单状态</th>
        </tr>
   </thead>
   <tbody>
   <!---->
  </tbody>
  </table>
</div>
<div class="mytran" style="display:none;margin-bottom:50px;">
<table class="table table-condensed">
    <thead>
        <tr>
          <th>资产类型</th>
          <th>涨/跌</th>
          <th>到期时间</th>
          <th>买入金额</th>
          <th>盈利情况</th>
          <th>订单状态</th>
        </tr>
        
   </thead>
   <tbody>
   
   </tbody>
   </table>
   <center><a href="/index.php/me/tranlog" style="color:#666;">查看更多历史记录</a></center>
</div></div>
<!--选项卡结束-->

</div>
</div>
<div id="full" ><!--onclick="closebuyshow()"--> 
</div>
<div id="buyshow">
<div class="modal-header">
    <button type="button" class="close" onclick="closebuyshow()" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">确认购买</h4>
</div>
<div class="modal-body">
            <center><label>购买:</label><span id="buymoney">200</span><label>元</label> <label>预期收益:</label><span id="buymoneyed"></span><label>元</label></center>
            <ul class="money-select"><li data="2000"><p>2000</p></li><li data="1000"><p>1000</p></li><li data="500"><p>500</p></li><li class="mo" data="200"><p>200</p></li><li data="100"><p>100</p></li><li data="50"><p>50</p></li><li class="not"><p>其他</p><input type="number" value="" id="input_money"></li></ul>
            <table>
            <tbody>
            <tr>
            <td style="border-right: 1px dashed #ccc;">资产类型: <span class="type"></span></td>
            <td>结算周期: <span class="timetype"></span></td>
            </tr>
            <tr>
            <td style="border-right: 1px dashed #ccc;">订单方向: <span class="direction"></span></td>
            <td>当前价格: <span class="nowprice">0</span></td>
            </tr>
            <tr>
            <td style="border-right: 1px dashed #ccc;">手续费:<span>2%</span></td>
            </tr>
            </tbody>
            </table>
          </div>
          <input id="">
<div class="modal-footer">
<span style="float:left;margin-top:5px;" class="timeshow"></span>
            <button type="button" class="buyshowbtn btn-default" data-dismiss="modal" onclick="closebuyshow()">取消</button>
            <button type="button" id="confirmbuy" class="buyshowbtn btn-primary">确认购买</button>
          </div>
</div>


<div id="xieyi">
<div class="modal-header">
   
    <h4 class="modal-title">公告</h4>
</div>
<div class="modal-body" style="height:200px;overflow-y:scroll">
                                            <center>风险揭示书</center>


<p>尊敬的客户：</p>
<p>“恒益”贵金属产品现货电子交易业务，是一项兼具创新性和投资者教育功能的现货交易业务。“恒益”贵金属产品交易业务采用的交易模式，具有潜在收益和潜在风险均不确定等特点，对客户的投资风险承受能力、理解投资风险的程度、风险控制能力以及投资经验有较高的要求。</p>
<p>本风险揭示书（以下简称“揭示书”）旨在向客户充分揭示“恒益”贵金属产品交易业务风险，仅为客户评估和确定自身的风险承受能力提供参考。本揭示书披露了“恒益”贵金属产品交易过程中可能发生的各种风险因素，但是并没有完全包括所有关于“恒益”贵金属产品交易业务的风险。鉴于贵金属产品交易业务风险的存在，客户在正式进行交易前，应仔细阅读本揭示书，确保自己已经充分理解“恒益”贵金属产品交易业务有关交易的性质、规则和风险，客户应依据其自身的投资经验、投资目标、财务状况以及自身承担风险能力等因素自行决定是否参与“恒益”贵金属产品交易业务。</p>
<p>若客户对于本揭示书有不理解或不清晰的地方，应该及时咨询。</p>
<p>一、温馨提示</p>
<p>（一）“恒益”贵金属产品交易业务是一项兼具创新性和投资者教育功能的贵金属产品现货交易业务，具有潜在收益和潜在风险均不确定的特点，不适合使用养老金、债务资金（如金融机构贷款或私人借款）等资金开展或参与。</p>
<p>“恒益”贵金属产品交易业务采用的交易模式，寓教于乐，投资者应以学习贵金属产品现货交易知识和投资技能为主，切勿沉迷其中，且不应将其作为主要投资手段和渠道。投资者若想从事贵金属产品现货投资，建议自然人客户参与“恒益”贵金属产品交易业务的资金不超过其可支配收入的30%。</p>
<p>未满18周岁或超过60周岁的自然人不得参与“恒益”贵金属产品交易业务。</p>
<p>（二）“恒益”贵金属产品交易业务只适合于满足以下全部条件的客户：
<p>1、具有完全民事行为能力的自然人，或依法注册成立且合法存续的企业法人或其他经济组织；</p>
<p>2、能够充分理解有关“恒益”贵金属产品交易业务的一切风险，并且具有一定的风险承受能力；</p>
<p>3、因“恒益”贵金属产品交易业务造成其交易资金部分或全部损失的，仍不会改变其正常生活方式或影响其正常生产经营状况；</p>
<p>4、有一定的金融产品投资经验；</p>
<p>5、对投资市场有充分认识，懂得一些投资技巧；</p>
<p>6、已阅读规则制度，理解并接受规则制度的相关规定。</p>
<p>二、相关的风险揭示</p>
<p>（一）客户开展或参与的“恒益”贵金属产品交易业务，是指客户与会员之间的交易。客户应当自行对所开展或参与的“恒益”贵金属产品交易业务承担亏损风险。作为交易平台提供方，仅依据相关交易规则和相关协议为客户、会员提供相关服务。在任何情况下，均不参与与客户之间、与会员之间的现货交易，不承担交易合同项下的任何义务。在任何时候，均不是客户、会员两者或其中任一的代理人、共同行为人或连带责任人。</p>
<p>（二）即使客户进行了止损委托交易，但市场条件剧烈变动可能使委托不能按客户设定价格被执行，从而无法将损失控制在客户拟定的范围之内。</p>
<p>（三）如会员主动申请退市或被强制退市而导致其被终止入市交易资格或取消会员资格的，客户应当办理相关后续手续。此情形下，客户可以自行将其交易账户及其待履行合约转移至其他会员或申请注销其交易账户。如客户在规定的期限内未采取措施，则其交易账户及待履行合约可能被强制转移至第三方会员，客户应独自承担由此导致的一切风险。</p>
<p>(四)客户还应注意到“恒益”贵金属产品交易业务可能存在的下列潜在风险，并自行承担有关风险及损失：</p>
<p>1、政策风险</p>
<p>国家法律、法规以及政策的变化，紧急措施的出台，相关监管部门监管措施的实施，交易规则及各项管理办法、实施细则的修改等原因，均可能会对客户的“恒益”贵金属产品交易业务产生影响，客户必须承担由此导致的损失。</p>
<p>2、价格波动的风险</p>
<p>贵金属产品作为一种特殊的具有投资价值的商品，其价格受多种因素的影响（如国际经济形势、外汇汇率、相关市场走势、供求关系、政治局势和能源价格等），这些因素对贵金属产品价格的影响机制非常复杂，客户在实际操作中难以全面把握，因而存在出现“恒益”贵金属产品交易决策失误的可能性，如果不能有效控制风险，则可能遭受较大的损失，客户必须独自承担由此导致的一切损失。</p>
<p>3、交易成本风险</p>
<p>“恒益”贵金属产品交易过程中，和会员可能会基于其提供的服务而按照一定标准向客户收取一定金额的手续费，客户应当同意和认可收取的交易手续费并将其作为参与“恒益”贵金属产品交易的必要交易成本。</p>
<p>4、技术风险</p>
<p>“恒益”贵金属产品交易业务是通过电子通讯技术和互联网技术来实现的，有关通讯服务及软、硬件服务由不同的供应商提供，可能会存在品质和稳定性方面的风险；无法控制电讯信号的品质和稳定性，也不能保证交易软件客户端的设备配置或网络连接的品质和稳定性以及互联网传送和接收的实时性，该等通讯或网络故障的发生将可能导致的某些服务被中断或延时；另外，客户的电脑系统可能被病毒或网络黑客攻击，从而使客户的“恒益”贵金属产品交易决策无法正确或及时执行。上述不确定因素的出现，可能会对客户的“恒益”贵金属产品交易业务产生影响，客户应充分了解并承担由此造成的全部损失。</p>
<p>5、交易风险</p>
<p>（1）客户应了解冠东的“恒益”贵金属产品交易业务可能导致快速的盈利或亏损。若交易的方向与行情的波动相反，且当市场价格波动超出交易合同中规定的任何一方指定的容忍范围（具体表现包括触及买方下跌风控点位或卖方的价格上涨风控点位）时，其待履行合约可能会被会员被动中止，客户必须承担由此造成的全部损失。</p>
<p>（2）“恒益”交易系统商品报价仅作为买卖双方参考，双方成交价格应以系统实时记录的成交价为准。报价亦可能会与其他市场的商品价格存在微弱的差距，并不能保证上述报价与其他市场保持完全的一致性。</p>
<p>（3）客户在“恒益”交易系统内，通过网上终端所提交的市价交易申请一经成交，即不可撤回或撤销，客户必须接受这种下单方式可能带来的风险。</p>
<p>（4）禁止会员及其工作人员对客户作出任何获利保证，代理客户从事“恒益”贵金属产品交易，或与客户分享收益或共担交易风险。客户应知晓所有针对“恒益”贵金属产品交易业务的任何获利保证或不会发生亏损、分享收益、共担风险的承诺均为不可能或者是没有根据的误导，客户对此应当予以拒绝，否则，由此造成的交易风险概由客户自行承担。</p>
<p>（5）客户的交易申请必须建立在自主决定的基础之上。会员及其工作人员提供的任何关于市场的分析、预测、信息、建议或指导，仅供客户参考，既不构成会员及其工作人员对客户作出的投资要约，亦不构成任何的承诺，客户若据此作出投资决策，由此而造成的交易风险由客户自行承担。</p>
<p>（6）在电子交易的过程中，有可能出现偶然性的明显的错误报价，可能事后会对错价及错价产生的货值增减盈亏作出纠正，由此而造成的交易风险由客户自行承担。</p>
<p>6、不可抗力风险</p>
<p>任何因不能预见、不能避免、不能克服的客观情况，包括但不限于地震、台风、水灾、火灾、战争、暴乱、流行病、政府管制、政策法规的修改变更或监管要求的调整，以及供电、电信及通信设备中断、设备故障、通讯故障、互联网系统故障及通过互联网未经许可的存取、盗窃交易敏感性数据、恶意攻击交易系统、计算机病毒入侵等事件，均构成“恒益”贵金属产品交易业务项下的不可抗力事件，任何不可抗力事件的发生都有可能会对客户的交易产生影响，客户应该充分理解并承担由于不可抗力事件的发生所造成的全部损失。</p>
<p>三、交易系统功能风险提示</p>
<p>目前提供的“恒益”交易系统中的风控点位设置功能可能会存在以下风险：在客户使用该功能时，由于客户设置的价格波动容忍范围较小，若交易的方向与行情的波动相反，且当市场价格波动超出交易合同中规定的任何一方指定的容忍范围（具体表现包括触及买方下跌风控点位或卖方的价格上涨风控点位）时，其待履行合约可能会被会员被动中止，客户必须承担由此造成的全部损失。</p>
<p>四、特别提示</p>
<p>（一）客户在参与“恒益”贵金属产品交易业务之前务必详尽地了解贵金属产品投资的基本知识和相关风险以及有关的业务规则等信息，依法合规从事“恒益”贵金属产品交易业务。</p>
<p>（二）与现有的国内其他贵金属产品交易市场相比，在交易模式、交易规则等方面存在着一定的区别。为了确保市场“公开、公平、公正”和健康稳定地发展，将采取更加严格的措施，强化市场的监管。请客户务必密切地关注有关于该市场的公告、风险提醒等信息，及时了解市场风险状况，做到理性投资，切忌盲目跟风。</p>
<p>（三）客户在申请入市交易之前，应当根据相关规则制度的要求，完整并且如实地提供开户和入市交易所需要的资料和信息，不得采取弄虚作假等手段规避有关的要求，否则，由此而造成的一切后果（包括但不限于因此拒绝为其提供入市交易服务等）由客户自行承担。</p>
<p>（四）本揭示书所述风险揭示事项仅为列举性质，未能详尽地列明有关“恒益”贵金属产品交易业务的所有风险因素，客户在开展或参与“恒益”贵金属产品交易业务之前，还应认真地对其它可能存在的风险因素有所了解和掌握。</p>
<p>（五）我们诚挚希望和建议客户，本着寓教于乐的目的，从风险承受能力等自身实际情况出发，审慎地决定是否开展或参与“恒益”贵金属产品交易业务，合理地配置自己的金融资产。</p>
<p>本人/本机构已认真阅读本揭示书的所有内容，并完全理解和同意全部内容，自愿承担因开展或参与“恒益”贵金属产品交易业务的全部风险，以及由此带来的一切可能的损失。</p>



          </div>
         
<div class="modal-footer">
<div class="weui-cells weui-cells_checkbox pull-left" style="margin-top:0">
        <label class="weui-cell weui-check__label" for="s12" style="padding: 5px 15px;">
                <div class="weui-cell__hd">
                    <input type="checkbox" name="checkbox1" checked="checked" class="weui-check" id="s12">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p>阅读之后请务必勾选</p>
                </div>
            </label>
            </div>
            <button type="button" id="confirmbuy" class="buyshowbtn btn-primary" onclick="$('#xieyi').hide()">我知道了</button>
          </div>
</div>

<script>
$("#xieyi").show();
</script>

<!--倒计时弹框-->
<div id="countdown">
<div class="modal-header">
    <button type="button" class="close" onclick="closecountdown()" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">即将揭晓</h4>
</div>
<div class="modal-body">
<div class="data_box">
<div class="left_bg"></div>
<div class="right_bg"></div>
<div class="market_all">

                    <div class="market_" id="market_cny">
                        <div class="data_info">
                            <div class="title">倒计时</div>
                            <div class="timeshow2">0</div>
                        </div>
                        <hr>
                        <ul class="data_tab clear_fix">
                            <li>执行价格</li>
                            <li>当前价格</li>
                        </ul>
                        <ul class="data_tab clear_fix">
                            <li class="startprice">0</li>
                            <li ><span class="nowprice">0</span></li>
                        </ul>
                        
                        <ul style="margin-top:10px" class="data_tab clear_fix">           
                            <li>订单方向</li>
                            <li>结果预测</li>
                        </ul>
                        <ul class="data_tab clear_fix">
                            <li class="direction">0</li>
                            <li class="yresult">0</li>
                        </ul>
                    </div>
                      
</div>
                     <!--<center><button class="c-btn-default">关闭</button></center>-->
                    </div>
                   
                </div>
</div>
</div>
<div id="tips">该资产已休市</div>
<script src="/js/iscroll.js"></script>
<script src="//cdn.bootcss.com/socket.io/1.7.2/socket.io.min.js"></script>
<script src="/js/common.js?1"></script>
<script>
gettran(<?php echo $ptype;?>);
</script>
<?php include "bottombar.php" ?>
</body>
</html>