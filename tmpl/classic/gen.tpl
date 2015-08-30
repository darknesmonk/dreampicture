<div align="center">
<div align="center" id="menu">
<a href="/" class="menu_link" title="Главная страница Dream Picture">Главная страница</a>
<a href="/best/" class="menu_link" title="Только лучшие рисунки сайта - по просмотрам">Лучшие картинки</a>
<a href="/hd/" class="menu_link" title="Высококачественные рисунки в HD Формате (16:9) ">HD качество</a>
<a href="/new/" class="menu_link" title="Новинки Dream Picture">Новые</a>
<a href="/category/" class="menu_link" title="Отсортированный каталог по категориям" >Каталог</a>
<!-- <a href="/" class="menu_link" title="Добавить свой рисунок на сайт" style="border: 0px">Добавить рисунок</a> -->
</div>
<div align="center" id="gen">
<div style="float:left;padding-right: 10px"><img  title="Dream Logo" width="332" height="128" src="/img/logo.png"></div>
<div style="height: 70px;padding: 28px" align="left">
<div style="float: left; font-size: 18px; color: #000;padding-right: 20px"><a href="/"><img alt="Dream Picture" title="Dream Picture - Лучшие обои, картинки" border="0" width="356" height="89" src="/img/dp.png"></a>
</div>
<div style="padding: 15px 0px 5px 50px "><form name="search" action="http://dreampicture.ru/search/" method="GET" >
<input type="hidden" name="searchid" value="1986449" />
<input type="hidden" name="l10n" value="ru" />
<input type="hidden" name="reqenc" value="" />
<input type="text" size="25" value="<?if($text) print $text; else print "слово";?>" onfocus="if(this.value=='слово')this.value=''" name="text"> <input type="submit" value="Поиск" style="cursor: pointer"></form></div>
<div style="padding:8px; text-shadow: 0px 0px 2px #000">Коллекция красивых картинок, обоев. </div>
<div style="position: absolute; z-index: 1; margin-top: -25px">
<a href="javascript://" onclick="$.ajax({type:'GET',url:'/?act=fly',dataType:'script'})" title="КЛИКНИ!"><img  style="border: 0" width="70" height="50" src="/img/babochka.png"></a></div>
</div>
<div class="main_index" align="left">
<div class="navisrc" align="left">
<div align="center" style="font-size: 20px; float: left; text-shadow: 0px 0px 1px #0011ff; margin-top: -5px"><a title="Отсортированный каталог по категориям" href="/category/">Каталог</a></div>
<?
$cn=$fotos[0]['catname'];
$scn=$fotos[0]['subcatname'];
$ac=$fotos[0]['catfotos'];
$asc=$fotos[0]['subcatfotos'];
?>
<div style="padding-left: 160px">
<div style="float: right"><?if($stats['sday']){?>Сегодня: <font color="red">+(<?=$stats['sday']?>)</font>;<?}?> Всего: (<?=$stats['sall']?> - <?=$stats['GB']?>ГБ.)  <?if(DPadmin){?><a href="/admin.php?act=update">Обновить галерею</a> | <a href="/admin.php?act=logout">Выйти</a> <?}?></div>
<a class="navilink" title="Главная страница Dream Picture" href="/"> Главная</a>
<?if($act || $id){ if($act!="others" && $act!="search")$canonical .="category/"; ?> &gt; <a  title="Отсортированный каталог по категориям" class="navilink" href="/category/"> Каталог (<?=$stats['sall']?>)</a> <?}?>
<?if($cn && $catid){ $canonical .=($page<2 || $subcatid)?"$catid/":"$catid/page/$page/" ;?>  &gt; <a title="<?=$fotos[0]['catdes'];?>" class="navilink" href="/category/<?=$catid?>/"><?=$cn?> (<?=$ac?>)</a>  <?}?>
<?if($scn && $subcatid){ $canonical .=($page<2)?"sub/$subcatid/":"sub/$subcatid/page/$page/"; ?> &gt; <a title="<?=$fotos[0]['subcatdes'];?>"  class="navilink" href="/category/<?=$catid?>/sub/<?=$subcatid?>/"> <?=$scn?> (<?=$asc?>) </a> <?}?>
</div>
</div>
<div class="cat">
<div style="padding: 15px 0px 0px 25px; margin:5px">
<?

foreach($catos as $l)
{
if($l['catid'] == $catid)  { ?>
	<a title="<?=$l['catdes']?>" href="/category/<?=$l['catid']?>/" class="block_link" style="color:#EF1500;">&nbsp;&nbsp;&#187; <?=$l['catname']?></a>

	<? continue; }
?>
<a title="<?=$l['catdes']?>" href="/category/<?=$l['catid']?>/" class="block_link" onmouseover="mo(this)" onmouseout="mu(this)">&#171; <?=$l['catname']?></a>
<?}?>
</div>
</div> 
<div id="ajaxcontent" style="min-height: 600px; float: right; border-left: 1px #f3d4dc solid; width: 965px">