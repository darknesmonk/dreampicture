<div style="display: table; padding: 5px 0px 0px 0px; width: 940px" align="center">
<div align="left" class="redalpha">
<div style="float: left">
<div class="mintext">Просмотров: <u><?=$views?></u> </div> 
</div> <div align="center"><?=substr($img['fname'],0,50)?> <?if(DPadmin){?> - <a href="javascript://" style="font-size: 10px" onclick="if(confirm('Точно удалить?')) dela(<?=$fid?>)" >Удалить</a> 
<form  method="post" name="move" action="/admin.php?act=move" style="display: inline">
<select name="id" style="width: 100px; margin: 5px" onchange="this.form.submit()">
<option value="" selected>Выберите</option>
	<?
	$n="";
	foreach($catslist as $l){
		if(empty($l['subcatname'])) continue;
		if($n!=$l['catname']) {$n=$l['catname']; ?>	<optgroup label="<?=$l['catname']?>"> </optgroup><?}
		?><option value="<?=$l['subcatid']?>"><?=$l['subcatname']?></option><?}?>
</select>
<input type="hidden" value="<?=$fid?>" name="fotos">
</form>
<?}?></div></div> 
<div class="bluealpha">
<div style="z-index: 10; position: absolute; width: 940px; background-image: url('/img/fotofolder.png'); padding-top: 10px" align="center"> 
<?if($next['fid']) { ?>
<div style="float: right"><a name="next" onclick="amenu(this.href);  return false" href="<?=PAGESPATH.mainimg($next['fid'],$next['transurl'],"/")?>">
<img class="navfotos" src="/img/arrowright.gif" border="0" width="40" height="40"> </a></div><?}?> 
<img title="ПЕРЕКЛЮЧЕНИЕ Ч/Б, ЦВЕТНОЙ" src="/img/grey_switch.png" style="cursor: pointer" onclick="if(document.bigimg.alt!='grey')  { document.bigimg.src='<?=$g?>'; document.bigimg.alt='grey'; } else  { document.bigimg.src='<?=$u?>';  document.bigimg.alt='<?=$img['fname']?>';}">
<?if($prev['fid']) { ?>
<div style="float: left"><a name="prev" onclick="amenu(this.href);  return false" href="<?=PAGESPATH.mainimg($prev['fid'],$prev['transurl'],"/")?>">
<img class="navfotos" src="/img/arrowleft.gif" border="0" width="40" height="40"></a></div><?}?>
</div>
<img title="<?=$img['fname']?>" alt="<?=$img['fname']?>" name="bigimg" class="catbigimg" style="height:550px;max-width: 900px;" src="<?=$u?>" onclick="fullshow(this.src)" id="img<?=$fid?>">
<div align="center" style="padding: 10px; font-weight: bold;  background: url('/img/fotofolder.png') 50% 50%; margin: 5px"> 
<div id="vk_like" style="float: right; margin-top: -45px; padding-right: 15px" ></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "button",pageUrl:'<?=$canonical?>'});
</script>
<div class="mintext">Добавлен: <u><?=correctdate (false,false,"all",$img['fdatetime'])?></u></div> -
<div class="mintext">Разрешение: <u><?=$width_px?>х<?=$height_px?></u></div> -
<div class="mintext">Размер: <u><?=$img['fsizekb']?>KB</u> </div>  -
<div class="mintext"><a href="javascript://" onclick="if(ge('codeimg').style.display) $(ge('codeimg')).css({display:'none'}).fadeIn(400); else $(ge('codeimg')).css({display:'none'}) ">Получить коды (HTML)</a>  
<div style="float: right">Скачать: <a href="<?=$u?>" target="_blank">Цветная</a>  <a href="<?=$g?>" target="_blank">Чёрно-белая</a></div>
</div>  
<div style="padding: 20px; display: none;" id="codeimg">
<form onsubmit="return false">
Прямая ссылка: <br> <input type="text" onclick="this.focus(); this.select()" size="100" value="<?=codegen($u)?>"> <br>
BBCODE увеличение по клику: <br> <input type="text" onclick="this.focus(); this.select()" size="100" value="<?=codegen($u,$thu,"bct")?>"> <br>
BBCODE большая картинка: <br> <input type="text" onclick="this.focus(); this.select()" size="100" value="<?=codegen($u,$thu,"bc")?>"> <br>
HTML увеличение по клику: <br> <input type="text" onclick="this.focus(); this.select()" size="100" value="<?=codegen($u,$thu,"htt")?>"> <br>
HTML большая картинка: <br> <input type="text" onclick="this.focus(); this.select()" size="100" value="<?=codegen($u,$thu,"ht")?>"> <br>
Ссылка на страницу: <br> <input type="text" onclick="this.focus(); this.select()" size="100" value="<?=codegen(PAGESPATH.mainimg($img['fid'],$img['transurl'],"/"),$thu,"p")?>"> <br>
</form>
</div>
</div>
<div style="height: 80px; width: 900px; overflow: hidden; white-space:nowrap;word-wrap: normal;" align="center">
<?
foreach($fotos as $l)
{
?> <a onclick="amenu(this.href);  return false" href="<?=PAGESPATH.mainimg($l['fid'],$l['transurl'],"/")?>"><img <?if($l['fid']==$fid) print "style=\"border: 5px green double\""?> title="<?=$l['fname']?>" alt="<?=$l['fname']?>" class="smallimg" src="<?=THUMBPATH.mainimg($l['fid'],$l['transurl'])?>"></a>
<?
}
?>
</div>
<hr>
<div align="center">
<div id="vk_comments"></div>
</div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 15, width: "800", attach: "*", pageUrl:'<?=$canonical?>'});
document.body.onkeydown = function() 
{
if (event.keyCode == 27)  {bigimg.click();} 
<?if($prev['fid']) { ?>if (event.keyCode == 37 ){prev.click();} <?}?>
<?if($next['fid']) { ?>if (event.keyCode == 39){next.click();} <?}?>
}
</script>
</div>
</div>