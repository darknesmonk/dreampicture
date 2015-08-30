var mainurl;
function amenu(reqs)
{
	if(mainurl==reqs) {window.scrollTo(0,0);  return false;}
	mainurl=reqs;
	$('#menu').css('background-image','url(/img/loading0.gif)');
	try {window.document.title="загружается...";} catch(e) {}
try{window.history.pushState(null,null,reqs);}catch(e){window.location.hash=reqs;}
$.ajax({type:"GET",url:reqs,data:"ajax=1",cache:false,async:true,dataType:"html",error:function(){alert("Повторите запрос еше раз...");  mainurl=0;},success:function(data){$("#ajaxcontent").html(data);  $('#menu').css('background-image','');}});
}
function mo (t)
{
$(t).css({background:'url(/img/folder2.gif) #e1dcff no-repeat 100% 50%'});
}
function mu(t)
{
$(t).css({background:''})
}

function add_favorite(a){tit=document.title;url=document.location;try{window.external.AddFavorite(url,tit);}
catch(e){try{window.sidebar.addPanel(tit,url,"");}
catch(e){if(typeof(opera)=="object"){a.href=url;a.title=tit;a.rel="sidebar";return true;}
else{alert('Нажмите Ctrl-D чтобы добавить страницу в закладки');}}}
return false;}


function rawurlencode(str){str=(str+'').toString();str=encodeURIComponent(str).replace(/!/g,'%21').replace(/'/g,'%27').replace(/\(/g,'%28').replace(/\)/g,'%29').replace(/\*/g,'%2A');return str;}
	
function scroll(element)
{clearTimeout(stimer);var l=element.scrollTop;element.scrollTop+=jump;if(element.scrollTop>l)
{stimer=setTimeout(function(){scroll(element);},30);}}

function ctrlEnter(event,formElem,mode)
{if(((event.ctrlKey)||mode)&&((event.keyCode==0xA)||(event.keyCode==0xD)))
{formElem.click();}}


function trim(s1){try{s1=str.replace(/\s+$/g,'');}catch(e){}
return s1;}

function strstr(haystack,needle,bool){var pos=0;pos=haystack.indexOf(needle);if(pos==-1){return false;}else{if(bool){return haystack.substr(0,pos);}else{return haystack.slice(pos);}}}

function share42(f,u,t){if(!u)u=location.href;if(!t)t=document.title;u=encodeURIComponent(u);t=encodeURIComponent(t);var s=new Array('"#" onclick="window.open(\'http://twitter.com/share?text='+t+'&url='+u+'\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0\');return false" title="Добавить в Twitter"','"#" onclick="window.open(\'http://vkontakte.ru/share.php?url='+u+'\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=554, height=421, toolbar=0, status=0\');return false" title="Поделиться В Контакте"','"http://www.feedburner.com/fb/a/emailFlare?loc=ru_RU&itemTitle='+t+'&uri='+u+'" title="Отправить на e-mail другу"');for(i=0;i<s.length;i++)document.write('<a rel="nofollow" style="display:inline-block;vertical-align:bottom;width:32px;height:32px;margin:0 6px 6px 0;outline:none;background:url('+f+'icons.png) -'+32*i+'px 0" href='+s[i]+' target="_blank"></a>');};
	
function rand(min,max)
{return Math.floor(Math.random()*(max-min+1))+min;}

function ge(d)
{return document.getElementById(""+d);}

function fadeIn(element,opacity){var reduceOpacityBy=10;var rate=50;if(element.style.display=='none')element.style.display='';if(element.style.visibility=='hidden')element.style.visibility='visible';if(opacity<100){opacity+=reduceOpacityBy;if(element.filters){try{element.filters.item("DXImageTransform.Microsoft.Alpha").opacity=opacity;}catch(e){element.style.filter='progid:DXImageTransform.Microsoft.Alpha(opacity='+opacity+')';}}else{element.style.opacity=opacity/100;}}
if(opacity<100){setTimeout(function(){if(opacity<=reduceOpacityBy){element.style.display='';}
fadeIn(element,opacity);},rate);}}

function fadeOut(element,opacity){var reduceOpacityBy=25;var rate=50;if(opacity>0){opacity-=reduceOpacityBy;if(element.filters){try{element.filters.item("DXImageTransform.Microsoft.Alpha").opacity=opacity;}catch(e){element.style.filter='progid:DXImageTransform.Microsoft.Alpha(opacity='+opacity+')';}}else{element.style.opacity=opacity/100;}}
if(opacity>0){setTimeout(function(){if(opacity<reduceOpacityBy+1){element.style.display='none';element.style.visibility='hidden';}
fadeOut(element,opacity);},rate);}}

function strip_tags( str ){
return str.replace(/<\/?[^>]+>/gi, '');
}
function fth(s,t,l,type)
{
if(ge(s).src!=t.src)
{
if(type=='link')ge('l'+s).href=ge(l).href;
ge(s).src=t.src;
fadeIn(ge(s),75);
}
}

function fullshow(s)
{
var d = ge('slideshow');
var i = document.slideshow;
if(s && d.style.display) { fadeIn(d,75); document.body.style.overflow='hidden'; } else { fadeOut(d,50); document.body.style.overflow='auto';  return true; }
i.src=s;
}

