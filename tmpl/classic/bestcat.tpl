<div align="center" class="bluealpha"> 
 <div align="right" style="padding: 5px 10px 2px 2px; font-weight: bold;"> 
<?
	  if( $pages >2){
		  ?>
	 страницы: 
		  <?
for($i=1; $i<$pages; $i++)
{
	if($i==$page) {print " <span style=\"padding: 3px; color: red\">$i</span> "; continue;}
	?>
<a onclick="amenu(this.href);  return false" class="mini_block" href="/<?=$t?>/page/<?=$i?>/"><?=$i?></a> 
<?
}} else { if($t=="hd"){?><a href="?<?=$rnd?>">Еще хорошего качества!</a><?} else {?>1 страница<?} }
?>
</div>
<?
$key=1;
foreach($fotos as $l)
{
$sub=$l['subcatname'];
?> <div align="center" class="fotosthu">
	
	<a  target="_blank" href="<?=PAGESPATH.mainimg($l['fid'],$l['transurl'],"/")?>"><img onmouseover="$(this).css({border: '2px #bfb6fc solid', margin: '0px'})" onmouseout="$(this).css({border:'',margin: '2px'})"  title="<?=$l['fname']?>" alt="<?=$l['fname']?>" class="smallimg" src="<?=THUMBPATH.mainimg($l['fid'],$l['transurl'])?>"></a>
	</div>
<?
$key++;
}
?><br clear="all">
</div>
