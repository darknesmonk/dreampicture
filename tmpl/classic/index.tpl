<div align="center">
<div class="genin" style="line-height: 20px;"> 
Эта лучшая коллекция красивых графических рисунков для Вас! <br />
<header style="text-align: left; font-size: 14px">
<b>DreamPicture.ru</b> – Это <u><?=$stats['sall']?></u> качественных рисунков, обоев и пейзажов для Вас. <br/>Все рисунки разделены на категории и подкатегории с удобной навигацией и функциями такими как BBcode, цветные и черно-белые оригиналы, удобная адаптация на Ваш сайт. <br/> Для любителей HD Качество создана специальная директория.  <br/>Специальный учет просмотров рисунков, который позволяет выявить лучшие картинки. <br/> Любимые виджеты комментариев и «Мне нравится» от Вконтакте. <br/> Мы также рады видеть Вас в нашей группе Вконтакте <a rel="nofollow" target="_blank" href="http://vk.com/dreampicture_ru">http://vk.com/dreampicture_ru</a>. <br/> Удачи.
</header>
</div>
<hr>
<table style="background: url('/img/fotofolder.png') 50% 50%; border-radius:10px; " width="910px" border="0" cellpadding="1" cellspacing="0" align="center" >
<?
foreach($res as $l)
{

?>
	<? if($key<=3) {$src1='i'; ?>
	<td width="33%" colspan="3" ><a id="<?print 'l'.$src1.$key?>" href="<?=PAGESPATH.mainimg($l['fid'],$l['transurl'],"/")?>"><img alt="Рисунок" id="<?print $src1.$key?>" class="bigimg" onmouseover="$(this).css({border: '4px #bfb6fc solid', margin: '0px'})" onmouseout="$(this).css({border:'',margin: '4px'})" src="<?=THUMBPATH.mainimg($l['fid'],$l['transurl'])?>"></a> </td> 
 <?} else { if($key==4) print "<tr>"; ?> <td width="10%"><a id="l<?=$key?>" href="<?=PAGESPATH.mainimg($l['fid'],$l['transurl'],"/")?>"><img title="<?=$l['fname']?>" alt="Рисунок" onmouseover="$(this).css({border: '2px #bfb6fc solid', margin: '0px'}); fth('<?if($key<=$ctr) print $src1.'1'; 
	 elseif($key<=$ctr+3)  print $src1.'2'; elseif($key<=$ctr+6)  print $src1.'3'; else { print $src1.'1'; $ctr=$key+2;}?>',this,'l<?=$key?>','link')" onmouseout="$(this).css({border:'',margin: '2px'})" class="smallimg" src="<?=THUMBPATH.mainimg($l['fid'],$l['transurl'])?>"></a> </td>
<?if($key==$trkey ) {$trkey +=9; print "<tr>"; }  }
$key++;
}
?>
</table>
</div>