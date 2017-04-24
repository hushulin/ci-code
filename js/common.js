var is_Known=0;
jQuery.fn.flash = function( color, duration )
{
  this.animate({backgroundColor: color }, duration / 2 );
  this.animate({backgroundColor: '#fff' }, duration / 2 );
}
  var mySwiper = new Swiper('#options', {
            paginationClickable: true,
            centeredSlides: true,
            slidesPerView:2,
            watchActiveIndex: true,
}); 
//
 $('.money-select li.not').click(function() {
        $(this).find('input').show().select();
        $("#buymoney").html("");
        $("#buymoney").html(amount);
        $("#buymoneyed").html(ed);
    });
$('#input_money').on('input propertychange',
    function() {
        $(".slct").removeClass("slct");
        amount= $("#input_money").val();
        ed=parseInt(amount)*(parseInt($("#swiper-slide"+mySwiper.activeIndex).attr("profit"))/100)+parseInt(amount);
        $("#buymoney").html(amount);
        $("#buymoneyed").html(ed);
        $(".money-select li.not").attr('data',amount);
    });
    
    //
//$('.swiper-wrapper').height("90px");
//$('.swiper-slide').height("90px");

      $('#btn1').click(function(){
      alert(mySwiper.activeIndex); 
      })
       var myscroll;
     //$('.swiper-slide').width($(".index").width()/3+160+"px");   

    function loaded(){
      myscroll=new iScroll("tabs",{hScrollbar:false,hideScrollbar:true,vScrollbar:false});
      }
 window.addEventListener("DOMContentLoaded",loaded,false);
    Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}   /*         
  timeshow();
  function timeshow()  {
  var time = new Date().Format("hh:mm:ss"); 
  $('#timeshow').html(time);
  setTimeout("timeshow()",1000);
  }   
  */
  function page_nav1(o,type,ptype){
  $("a").removeClass("cur");
  $(o).addClass("cur"); 
  if(type==1){
  $(".mytran").hide();
  $(".newest").show();
  $(".position").hide();
  gettran(ptype); //获取
  }else if(type==2){
  $(".newest").hide();
  $(".mytran").show();
  $(".position").hide();
 getmetran(ptype);
  }else if(type==3){
  $(".position").show();
  $(".newest").hide();
   $(".mytran").hide();
   getposition(ptype);
  }
  }
  function gettran(ptype)   //获取最新交易
  {
  $.getJSON("/index.php/getk/newesttran?t="+ptype,function(data){
  result=eval(data);
  var html="";
  result.forEach(function(e){
  if(e.direction==2){
  directionz	="买涨";
  hclass="danger";
  }else{
  directionz	="买跌";
  hclass="success";
  }
  html+='<tr class="'+hclass+'"><td>'+e.time+'</td><td>'+e.name+'</td><td>'+directionz+'</td><td>'+e.amount+'</td></tr>'
 
  })
   $(".newest table tbody").html(html);
  });}
  function getposition(ptype)   //获取持仓订单
  {
  $.getJSON("/index.php/getk/position?t="+ptype,function(data){
  result=eval(data);
  var html="";
    
  result.forEach(function(e){
  if(e.direction==2){
  directionz	="买涨";
  }else{
  directionz	="买跌";
  }
  html+='<tr><td><font color="#888">'+e.time+'</font></td><td>'+e.name+'</td><td><font color="#888">'+e.amount+'</font></td><td>'+directionz+'</td><td>'+e.price+'</td><td>未结算</td></tr>';

   })
    $(".position table tbody").html(html);
  });
 
  
  
  }
  function getmetran(ptype)   //获取我的交易
  {
  $.getJSON("/index.php/getk/metran?t="+ptype,function(data){
  result=eval(data);
  var html="";
  result.forEach(function(e){
  if(e.direction==2){
  directionz	="买涨";
  }else{
  directionz	="买跌";
  }
  if(parseInt(e.profit)>0){
  profit='+'+parseInt(e.profit).toFixed(2);
  }else{
  profit=parseInt(e.profit).toFixed(2);
  }
  switch(parseInt(e.status)){
  case 1:
  status="盈利";
  color="#F6292C";
  break;
  case 0:
  status="平局";
  color="#888";
  profit='0.00';
  break;
  case -1:
  status="亏损";
  color="#4cc32a";
  break;
  }
  
  html+='<tr><td>'+e.name+'</td><td>'+directionz+'</td><td><font color="#888">'+e.time+'</font></td><td><font color="#888">'+e.amount+'</font></td><td><font color="'+color+'">'+profit+'</font></td><td><font color="'+color+'">'+status+'</font></td></tr>'
  
  })
  $(".mytran table tbody").html(html);
  });}
  <!--行情表-->
function loadk(zcselect,t) {
    $.getJSON('/index.php/getk?s='+zcselect+'&t='+t, function (data) {
      var r=[];
      a="#F6292C",h="#4cc32a";  
      //alert(data.msg); 
      
      $.each(data.msg, function(i, item) {
      o=item[4]>item[1]?a:h;//linecolor
      var someDate = new Date(item[0]);
      var tms=Date.UTC(someDate.getFullYear(), someDate.getMonth(), someDate.getDate(), someDate.getHours(),someDate.getMinutes());
      console.log("i:"+data.msg.length);
      var dlen=0;
      if(data.msg.length==undefined){
      dlen=20;
      }else{
      dlen=data.msg.length-25;
      }
      if(i>dlen&&item[1]!=0){
      
      r.push({x:tms,open:item[1],high:item[2],low:item[3],close:item[4],lineColor:o});
      }
      //console.log(new Date(item[0]).toLocaleString()+"\n");
      //console.log(i);
      }
      )
        // create the chart
        $('#k-chart').highcharts("StockChart",
        {
        chart:{
         
            animation: false,
        
       events: {
      
                    load: function () {
                        // set up the updating of the chart each second
                        var series = this.series[0];
                         chart = $('#k-chart').highcharts();
                        
                    }
                }},
                
        series:[{animation: false,type:"candlestick",name:$(".sw_active").html(),data:r,color:h,upColor:a,lineWidth:1,lineColor:a,
         global: {useUTC: true},
        states:{hover:{lineWidth:0}}}],
        yAxis:{offset:60,labels:{formatter: function() {
                        return this.value.toFixed(5);
                    }}},
        xAxis:{labels:{step:0.5}} ,
        title:{text:null},
        credits:{enabled:!1},
        
        legend:{enabled:!1},rangeSelector:{enabled:!1},navigator:{enabled:!1},scrollbar:{enabled:!1}}
        );
    });
};
var nowselect=$(".sw_active").attr("type");
$("#typeshow").html($(".sw_active a").html().replace(/\s+/g,""));
loadk(nowselect,1);  //初始化行情表

setInterval(function () {loadk(nowselect,parseInt($("ul.time .on").attr('data-min')))
},50000);
function tips(){
    $("#tips").show();
    setTimeout('$("#tips").hide(100)',2500);
}
<!--行情表-->
$("#change_XAGUSD").click(function(){
//console.log($("#change_XAGUSD").attr("data-isrest"));
if($("#change_XAGUSD").attr("data-isrest")==1){
tips();
return false;
}
$("#typeshow").html($("#change_XAGUSD a").html().replace(/\s+/g,""));
$("li").removeClass("sw_active");
$("li#change_XAGUSD").addClass("sw_active");
nowselect="XAGUSD";
closetimeli();
loadk(nowselect,1);
socket.emit(nowselect, { my: 'data' });
clear(); 
});
$("#change_btc").click(function(){
if($("#change_btc").attr("data-isrest")==1){
tips();
return false;
}
$("#typeshow").html($("#change_btc a").html().replace(/\s+/g,"")); 
$("li").removeClass("sw_active");
$("li#change_btc").addClass("sw_active"); 
nowselect="btc";
closetimeli();
loadk(nowselect,1);
socket.emit(nowselect, { my: 'data' });
clear(); 
});
$("#change_EURUSD").click(function(){
//console.log($("#change_EURUSD").attr("data-isrest"));
if($("#change_EURUSD").attr("data-isrest")==1){
tips();
return false;
}
$("#typeshow").html($("#change_EURUSD a").html().replace(/\s+/g,""));  
$("li").removeClass("sw_active");
$("li#change_EURUSD").addClass("sw_active");
nowselect="EURUSD";
closetimeli();
loadk(nowselect,1);
socket.emit(nowselect, { my: 'data' }); 
clear(); 
});
$("#change_GBPUSD").click(function(){
if($("#change_GBPUSD").attr("data-isrest")==1){
tips();
return false;
}
$("#typeshow").html($("#change_GBPUSD a").html().replace(/\s+/g,"")); 
$("li").removeClass("sw_active");
$("li#change_GBPUSD").addClass("sw_active"); 
nowselect="GBPUSD";
closetimeli();
loadk(nowselect,1);
socket.emit(nowselect, { my: 'data' });
clear();  
});
$("#change_USDJPY").click(function(){
if($("#change_USDJPY").attr("data-isrest")==1){
tips();
return false;
}
$("#typeshow").html($("#change_USDJPY a").html().replace(/\s+/g,""));
$("li").removeClass("sw_active");
$("li#change_USDJPY").addClass("sw_active");
nowselect="USDJPY";
closetimeli();
loadk(nowselect,1);
socket.emit(nowselect, { my: 'data' });
clear();     
});
$("#change_USOil").click(function(){
if($("#change_USOil").attr("data-isrest")==1){
tips();
return false;
}
$("#typeshow").html($("#change_USOil a").html().replace(/\s+/g,""));  
$("li").removeClass("sw_active");
$("li#change_USOil").addClass("sw_active"); 
nowselect="USOil";
closetimeli();
loadk(nowselect,1);
socket.emit(nowselect, { my: 'data' });
clear();    
});
$("#change_XAUUSD").click(function(){
if($("#change_XAUUSD").attr("data-isrest")==1){
tips();
return false;
}
$("#typeshow").html($("#change_XAUUSD a").html().replace(/\s+/g,""));  
$("li").removeClass("sw_active");
$("li#change_XAUUSD").addClass("sw_active");  
nowselect="XAUUSD";
closetimeli();
loadk(nowselect,1);
socket.emit(nowselect, { my: 'data' });
clear(); 
});
function clear(){
$("#nowprice").html("￥0");
$("#minprice").html("￥0");
$("#maxprice").html("￥0");
}
var kj=0;
function sleep(numberMillis) { //休眠 单位:毫秒
   var now = new Date();
   var exitTime = now.getTime() + numberMillis;  
   while (true) { 
       now = new Date(); 
       if (now.getTime() > exitTime)    return;
    }
}
var startprice=0;
var lastprice=0;  //上一个价格
$("#confirmbuy").click(function(){

 $.ajax({url:"/index.php/confirmbuy",type:'POST',data:{type:nowselect,direction:direction,ptype:ptype, amount: amount,time:new Date().getTime(),timetype:function(){
 return $("#swiper-slide"+mySwiper.activeIndex).attr('index');
 /*
  switch (mySwiper.activeIndex){
  case 0:
   return 180;
    break;
  case 1:
    return 60;
    break;
   case 2:
    return 300;
    break;
  }*/
 }},dataType: 'json',async: false,error: function(msg){alert(msg.responseText)},success:function(data2){
 buyresult=eval(data2);
  getposition(ptype);
 if(buyresult.status==1){
 socket.emit('newtran',buyresult);
 $("#money").html(buyresult.balance.toFixed(2)); //更新余额
 $(".market_ .title").html("倒计时");
 is_Known=0;
 $("#countdown").show();
 $("#buyshow").hide();
 if(direction==1){
 $(".direction").html('<font color="green">买跌</font>');
 }else{
 $(".direction").html('<font color="red">买涨</font>');
 }
 //$("#full").hide();
  $('.startprice').html(buyresult.price);
  startprice=buyresult.price;
var i=0;
var timetype=buyresult.timetype;
//倒计时
$("#countdown .timeshow2").html(timetype);
countdowntimer=setInterval(function(){i++; 
$("#countdown .timeshow2").html(timetype-i);
//console.log(i+"log");
if(i+1>=timetype&&is_Known==0){
$(".market_ .timeshow2").html('<font color="red" size="6">计算中...</font>');
$(".market_ .yresult").html("等待结果");
}
if(i+1>=timetype&&is_Known==0){
$.getJSON("/index.php/confirmbuy/getresult?id="+buyresult.id,function(rdata){
//console.log(rdata);
if(rdata.status==1){ //计算结果
is_Known=1;
clearInterval(countdowntimer);
$(".market_ .title").html("结果");
if(rdata.win==1){
$(".market_ .timeshow2").html("<div class='top-13'><font size=5 color=red>盈 +"+rdata.profit+"</font></div>");
$(".market_ .yresult").html("<font color=red>盈</font>");
}else if(rdata.win==0){
$(".market_ .timeshow2").html("<div class='top-13'><font size=5>平局</font></div>");
$(".market_ .yresult").html("<font color=gray>平</font>");
}else if(rdata.win==-1){
$(".market_ .timeshow2").html("<div class='top-13'><font size=5 color=green>亏 "+rdata.profit+"</font></div>");
$(".market_ .yresult").html("<font color=green>亏</font>");
}
 $("#money").html(parseFloat(rdata.balance).toFixed(2)); //更新余额
$(".market_ .nowprice").html(rdata.lastprice);
$("#nowprice").html(rdata.lastprice);
chart = $('#k-chart').highcharts();
   if(typeof(chart)!="undefined"){
   var series = chart.series[0];
   
   var a="#F6292C",h="#4cc32a";
   
   var r=[];
   var someDate = new Date((new Date()).getTime());
   var tms=Date.UTC(someDate.getFullYear(), someDate.getMonth(), someDate.getDate(), someDate.getHours(),someDate.getMinutes());
   //series.removePoint(23);

  lastdata=series.points[23];
   //console.log(lastdata);
   console.log(series.points);
   o=rdata.lastprice>lastdata['open']?a:h;//linecolor
   r={x:tms,open:lastdata['open'],high:lastdata['high'],low:lastdata['low'],close:rdata.lastprice,lineColor:o};
   //series.addPoint(r, true,true);
   //chart.series[0].animation(false);
   chart.series[0].setVisible(false);
   chart.series[0].data[23].update(r);
   chart.series[0].setVisible(true, true);
  // console.log(r);
   chart.yAxis[0].removePlotLine("line-1");
   chart.yAxis[0].addPlotLine({value:parseFloat(rdata.lastprice),color:o,dashStyle:'longdashdot',width:1,id:'line-1',label:{useHTML:true,text:'<div class="priceGreenTipClass">'+$("#nowprice").html()+'</div>',x:55,y:1,align:'right'}});
   }
   /*
   kj=1;
   sleep(1000);
   kj=0;
   */
}

});
}


},1000);

 }else{
  closebuyshow();
 wxalert(buyresult.msg,"好");
 console.log(buyresult.msg);
 }
 }});

});




  
  var socket = io('http://120.25.72.224:1985');
  socket.on('news', function (data) {
    //console.log(data);
    //$("#show").html(data.hello);
    socket.emit(nowselect, { my: 'data1' });
  });
  
 
  
  socket.on('btc_results', function (data) {
  if(nowselect=="btc"){
  setTimeout("socket.emit('btc', { my: 'data1' })",300);
  blackdata(data,2);
  }
  });
  socket.on('EURUSD_results', function (data) {
  if(nowselect=="EURUSD"){
  setTimeout("socket.emit('EURUSD', { my: 'data1' })",300);
  blackdata(data,5);
  }
  });
  socket.on('XAUUSD_results', function (data) {
  if(nowselect=="XAUUSD"){
  setTimeout("socket.emit('XAUUSD', { my: 'data1' })",300);
 // console.log(data);
  blackdata(data,2);
  }
  });
  socket.on('XAGUSD_results', function (data) {
  if(nowselect=="XAGUSD"){
  setTimeout("socket.emit('XAGUSD', { my: 'data1' })",300);
  //console.log(data);
  blackdata(data,3);
  }
  });
  socket.on('GBPUSD_results', function (data) {
  if(nowselect=="GBPUSD"){
  setTimeout("socket.emit('GBPUSD', { my: 'data1' })",300);
  //console.log(data);
  blackdata(data,5);
  }
  });
  socket.on('USDJPY_results', function (data) {
  if(nowselect=="USDJPY"){
  setTimeout("socket.emit('USDJPY', { my: 'data1' })",300);
  //console.log(data);
  blackdata(data,3);
  }
  });
  socket.on('USOil_results', function (data) {
  if(nowselect=="USOil"){
  setTimeout("socket.emit('USOil', { my: 'data1' })",300);
  //console.log(data);
  blackdata(data,2);
  }
  
   });
   
   //最新交易
    socket.on('newtran_results', function (data) {
    if(data.ptype==ptype){
    var props = ["time","type","direction","amount"];
                 var objs = new Array();
                 
                 $(".newest tbody tr").each(function(){
                     var obj = new Object();
                     $(this).find("td").each(function(n){
                         obj[props[n]] = $(this).html();
                     });
                     objs.push(obj);
                 });
               if(objs.length>=11){
               objs.pop();
               } 
               var newdata={amount:new Number(data.amount).toFixed(2),direction:data.direction,time:data.times,type:data.type};
               objs.unshift(newdata);
               var html="";
               objs.forEach(function(e){
                if(e.direction=="买涨"){
                  e.direction=="买涨";
                    hclass="danger";
                      }else{
                  e.direction=="买跌";
                  hclass="success";
                  }
                html+='<tr class="'+hclass+'"><td>'+e.time+'</td><td>'+e.type+'</td><td>'+e.direction+'</td><td>'+e.amount+'</td></tr>'
                $(".newest table tbody").html(html);
  })
       // console.log(data);
        //console.log(objs);
   }
   //console.log(data);
   });
  function blackdata(data,w){
  if(kj==1){
  return;
  }
   chart = $('#k-chart').highcharts();
   if(typeof(chart)!="undefined"){
   var series = chart.series[0];
   
   var a="#F6292C",h="#4cc32a";
   
   var r=[];
   var someDate = new Date((new Date()).getTime());
   var tms=Date.UTC(someDate.getFullYear(), someDate.getMonth(), someDate.getDate(), someDate.getHours(),someDate.getMinutes());
   //series.removePoint(23);

  lastdata=series.points[23];
   //console.log(lastdata);
   console.log(series.points);
   o=data['price']>lastdata['open']?a:h;//linecolor
   r={x:tms,open:lastdata['open'],high:lastdata['high'],low:lastdata['low'],close:data['price'],lineColor:o};
   //series.addPoint(r, true,true);
   //chart.series[0].animation(false);
   chart.series[0].setVisible(false);
   chart.series[0].data[23].update(r);
   chart.series[0].setVisible(true, true);
  // console.log(r);
   chart.yAxis[0].removePlotLine("line-1");
   chart.yAxis[0].addPlotLine({value:parseFloat(data['price'].toFixed(w)),color:o,dashStyle:'longdashdot',width:1,id:'line-1',label:{useHTML:true,text:'<div class="priceGreenTipClass">'+$("#nowprice").html()+'</div>',x:55,y:1,align:'right'}});
   }
  $("#minprice").html(data['min'].toFixed(w));
  $("#maxprice").html(data['max'].toFixed(w));
  $("#nowprice").html(data['price'].toFixed(w));
  if(lastprice!==data['price'].toFixed(w)&&lastprice>data['price'].toFixed(w)){
  $("#nowprice").flash('#e1fbd6', 1000);
  if($("#countdown").is(":visible")==false&&is_Known==0){
  $("table .nowprice").flash('#e1fbd6', 1000);
  }
  }else if(lastprice!==data['price'].toFixed(w)&&lastprice<data['price'].toFixed(w)){
  $("#nowprice").flash('#ffe7e5', 1000);
  if($("#countdown").is(":visible")==false&&is_Known==0){
  $("table .nowprice").flash('#ffe7e5', 1000);

  }
  }

  if(is_Known==0){
  $(".nowprice").html(data['price'].toFixed(w));
  }

  console.log("is_Known:"+is_Known);
  lastprice=data['price'].toFixed(w);
  if($(".market_ .yresult").html()=='等待结果'){
  return;
  }
  if(startprice>data['price'].toFixed(w)&&direction==1&&$("#countdown").is(":visible")&&is_Known==0){
  $(".yresult").html('<font color="red">盈</font>');
  $(".nowprice").flash('#e1fbd6', 1000);

  }else if(startprice==data['price'].toFixed(w)&&$("#countdown").is(":visible")&&is_Known==0){
  $(".yresult").html('<font color="gray">平</font>');
  $(".nowprice").flash('#e1fbd6', 1000);

  }else if(startprice>data['price'].toFixed(w)&&direction==2&&$("#countdown").is(":visible")&&is_Known==0){
  $(".yresult").html('<font color="green">亏</font>');
   $(".nowprice").flash('#ffe7e5', 1000);

  }else if(startprice<data['price'].toFixed(w)&&direction==2&&$("#countdown").is(":visible")&&is_Known==0){
  $(".yresult").html('<font color="red">盈</font>');
  $(".nowprice").flash('#e1fbd6', 1000);

  }else if(startprice<data['price'].toFixed(w)&&direction==1&&$("#countdown").is(":visible")&&is_Known==0){
  $(".yresult").html('<font color="green">亏</font>');
   $(".nowprice").flash('#ffe7e5', 1000);

  }
  if(is_Known==0){
  $("td .nowprice").html(data['price'].toFixed(w));
  
  }
  //$(".timeshow").html(new Date(parseInt(data['time']) * 1000).toString().substr(16,5).replace("/[a-zA-Z]/g","")+":"+new Date().getSeconds());
  $(".timeshow").html(new Date().toString().substr(16,5).replace("/[a-zA-Z]/g","")+":"+new Date().getSeconds());
    //console.log(data);
    }
  var direction=0;  
  function buyshow(type){
  if(type==1){
  $(".down").css("z-index",9999);
  $(".up").css("z-index",0);
  }else if(type==0){
  $(".up").css("z-index",9999);
  $(".down").css("z-index",0);
  }
  $("#full").show();
  $("#buyshow").show();
  jinzhi=1;
  $(".mo").trigger("click");
  if(type==1){
  $("td .direction").html('<font color="green">买跌</font>');
  direction=1;
  }else{
  $("td .direction").html('<font color="red">买涨</font>');
  direction=2;
  }
  $("td .type").html($(".sw_active a").html().replace(/\s+/g,""));
  nowselect=$(".sw_active").attr("type");
  
  
   $("td .timetype").html($("#swiper-slide"+mySwiper.activeIndex+" h4").html());
   /*
  switch (mySwiper.activeIndex){
  case 0:
    $("td .timetype").html("180秒");
    break;
  case 1:
    $("td .timetype").html("60秒");
    break;
   case 2:
    $("td .timetype").html("300秒");
    break;
  }
  */
 } 
  var amount=0;
  function closebuyshow(){
  $("#buyshow").hide();
  $("#full").hide();
    $(".up").css("z-index",0);
  $(".down").css("z-index",0);
  jinzhi=0;
  }
  function closecountdown(){
  $("#countdown").hide();
  clearInterval(countdowntimer);
  jinzhi=0;
  is_Known=0;
  $("#full").hide();
  }
  
  var jinzhi=0;
  /*
  document.addEventListener("touchmove",function(e){
  if(jinzhi==1){  //禁止拖动
  e.preventDefault();
  e.stopPropagation();
  }
  },false); 
  */
  buytimeshow();
 function buytimeshow(){
 $("#buytimeshow").html(new Date().toString().substr(16,9).replace("/[a-zA-Z]/g",""));
 setTimeout("buytimeshow()",1000);
 }
 function closetimeli(){
 $("ul.time li").removeClass("on");
 $("ul.time li.first").addClass("on");
 }
 $("ul.time li").click(function(){
 loadk(nowselect,$(this).attr("data-min"));
 $("ul.time li").removeClass("on");
 $(this).addClass("on");
 });

 $(".money-select li:not(.not)").click(function(){
 $("#input_money").val("");
 $("#input_money").hide();
 $(".money-select li:not(.not)").removeClass("active");

 $(this).addClass("active");
 amount= $(this).attr("data");
 ed=$(this).attr("data")*(parseInt($("#swiper-slide"+mySwiper.activeIndex).attr("profit"))/100)+parseInt($(this).attr("data"));
 money=$(this).attr("data");
 $("#buymoney").html(money);
 $("#buymoneyed").html(ed);

 })


