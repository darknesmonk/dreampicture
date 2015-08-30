<div style="padding: 5px" align="center">
<br><?if(DPadmin){?>
<div align="right"> <a href="javascript://" onclick="fadeIn(ge('cats'),50)"> Добавить каталог</a></div>
<div align="center" style="display: none" id="cats">
<form  method="post" name="cats" action="/admin.php?act=cats">
<input type="text" value="Название категории" name="name" maxlength="50" size="60" /> <br>
<input type="text" value="Ключевые слова" name="keywords" maxlength="200" size="60" /> <br>
<input type="hidden"  value="newcat" name="type" /> 
<textarea cols="1" rows="1" style="width: 500px; height: 150px"  name="des">Описание категории</textarea> <br>
<input type="reset" value="Очистить"> <input type="submit" value="Создать"> 
</form>
</div>
<?
}
$key=1;
foreach($fotos as $l)
{
$imgs=explode("|",$l['thumbs']);
$catdate=correctdate (false,false,'all',$l['catref']);
$dcatid=(int)$l['catid'];
?><div class="catos" onmouseover="$(this).css({border: '2px #FF6600 double'})" onmouseout="$(this).css({border:'2px #99FF88 double'})" align="center" >
	<a href="/category/<?=$dcatid?>/" title="<?=$l['catdes']?>">
<h4 align="right"><?=$l['catname']?> (<?=$l['catfotos']?>)</h4>
<div align="right" style="font-size: 12px;padding: 3px"><?=$catdate?> </div> 
	<?foreach($imgs as $key=>$l1) 
	{
		if(!$key) {$src='i'.$l1;?>	<img id="<?print $src?>" class="bigimg" src="/thumb<?=$l1?>.jpg"> <br><? continue;}
	?><img class="smallimg" src="/thumb<?=$l1?>.jpg" onmouseover="fth('<?print $src?>',this)"><?
	}?>
	</a><?if(DPadmin){?><form  action="/admin.php?act=delcat" method="POST" name="del" onsubmit="if(!confirm('Точно удалить каталог <?=$l['catname']?>?')) return false">
	<input type="hidden"  name="type" value="cat" />
	<input type="hidden"  name="id" value="<?=$dcatid?>" />
	<input type="submit" value="Удалить" />
	</form>
	<?}?>	</div><?
$key++;
}
?></div>
<br clear="all">