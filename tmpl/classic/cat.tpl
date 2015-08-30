<div style="padding: 5px;" align="left">
<?
if($subcatid && DPadmin){
?>
<script type="text/javascript" src="/swf/swfupload.js"></script>
<script type="text/javascript" src="/swf/handlers.js"></script>
<script type="text/javascript" language="JavaScript">
	function flashupload () {
swfu = new SWFUpload({
upload_url: "/add_foto.php",
				post_params: {"sub":"<?=$subcatid?>"},
file_size_limit : "10 MB",
file_types : "*.jpg;*.jpeg;*.png;*.gif",
file_types_description : "JPG Images; PNG Image; GIF Image",
file_upload_limit : 0,
swfupload_preload_handler : preLoad,
swfupload_load_failed_handler : loadFailed,
file_queue_error_handler : fileQueueError,
file_dialog_complete_handler : fileDialogComplete,
upload_progress_handler : uploadProgress,
upload_error_handler : uploadError,
upload_success_handler : uploadSuccess,
upload_complete_handler : uploadComplete,
button_image_url : "",
button_placeholder_id : "spanButtonPlaceholder",
button_width: 150,
button_height: 19,
button_text : '<span>[Обзор фотографий...]</span>',
button_text_style : '.upp {font-size: 13px; font-weight: bold;}',
button_text_top_padding: 0,
button_text_left_padding: 0,
button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
button_cursor: SWFUpload.CURSOR.HAND,
flash_url : "/swf/swfupload.swf",
flash9_url : "/swf/swfupload_fp9.swf",
custom_settings : {
upload_target : "divFileProgressContainer",
thumbnail_height:2000,
thumbnail_width:2000,
thumbnail_quality: 80
},
debug: false
});
};
</script>
<div align="center" style="display: none" id="movediv">
<form  method="post" name="move" action="/admin.php?act=move">
<select name="id" style="width: 450px; margin: 5px" onchange="this.form.submit()">
	<option value="" selected>Выберите</option>
	<?
	$n="";
	foreach($catslist as $l){
		if(empty($l['subcatname'])) continue;
		if($n!=$l['catname']) {$n=$l['catname']; ?>	<optgroup label="<?=$l['catname']?>"> </optgroup><?}
		?><option value="<?=$l['subcatid']?>"><?=$l['subcatname']?></option><?}?>
</select>
<br>
<textarea cols="1" rows="1" style="width: 500px; height: 50px" name="fotos"></textarea> <br>
</form>
</div>
<div align="right" > <a href="javascript://" onclick="flashupload ()" id="spanButtonPlaceholder">Добавить фотографии</a></div>
	<div id="divFileProgressContainer" style="color: black; border: 1px #f8f8f8 solid" align="center"></div>
<?}elseif(DPadmin){?>
<div align="right"> <a href="javascript://" onclick="fadeIn(ge('cats'),50)"> Добавить подкатолог</a></div>
<div align="center" style="display: none" id="cats">
<form  method="post" name="cats" action="/admin.php?act=cats">
<input type="text" value="Название подкатегории" name="name" maxlength="50"   size="60" /> <br>
<input type="text" value="Ключевые слова" name="keywords" maxlength="200" size="60" /> <br>
<input type="hidden"  value="newsubcat" name="type" /> 
<input type="hidden"  value="<?=$catid?>" name="catid" /> 
<textarea cols="1" rows="1" style="width: 500px; height: 150px"  name="des">Описание подкатегории</textarea> <br>
<input type="reset" value="Очистить"> <input type="submit" value="Создать"> 
</form>
</div>
<?}?><div class="redalpha" align="center">
<?
$key=0;
foreach($subcats as $l)
{
if(!$l['subcatfotos'] && !DPadmin) continue;
	$key++;
if($l['subcatid']==$subcatid) { ?><span style="padding: 5px">&#8594; <a title="<?=$l['subcatdes']?>" href="/category/<?=$catid?>/sub/<?=$l['subcatid']?>/" style="color: red"><?=$l['subcatname']?> (<?=$l['subcatfotos']?>)</a></span><?continue; } 
?><span style="padding: 5px;">&bull; <a title="<?=$l['subcatdes']?>" href="/category/<?=$catid?>/sub/<?=$l['subcatid']?>/"><?=$l['subcatname']?></a><?if(DPadmin){?>
	<form  style="display: inline" action="/admin.php?act=delcat" method="POST" name="del<?=$l['subcatid']?>" onsubmit="return false">
	<input type="hidden"  name="type" value="subcat" />
	<input type="hidden"  name="id" value="<?=$l['subcatid']?>" /> 
	</form> -	(<a href="javascript://" onclick="if(confirm('Точно удалить каталог <?=$l['subcatname']?>?')) document.del<?=$l['subcatid']?>.submit()">удалить</a>) <?}?></span> <?
}
if(!$key){?>Без подкаталогов<?} ?>
</div>
<div class="bluealpha"> 
	  <div align="right" style="padding: 5px 10px 2px 2px; font-weight: bold "> 
<?
	$c=($subcatid)?$fotos[0]['subcatfotos']:$fotos[0]['catfotos'];
	$pages=ceil($c/maxonepage)+1;

	  if( $pages >2){
		  ?>страницы: <?
		  $page1=($page>1)?$page-1:$page;
$page2=($page<$pages-9)?$page1+9:$pages;
		  
for($i=$page1; $i<$page2; $i++)
{
	if($i==$page) {print "<span style=\"padding: 3px; color: red\">$i</span>"; continue;}
	?><a onclick="amenu(this.href);  return false"  class="mini_block" title="Перейти к  странице <?=$i?>" href="/category/<?=$catid?><?if($subcatid) print "/sub/$subcatid";?>/page/<?=$i?>/"><?=$i?></a><?
}
} else {?>1 страница<?}
?>
</div>
<div id="thumbnails">
<?
$key=1;
foreach($fotos as $l)
{
$sub=$l['subcatname'];
?> <div align="center" class="fotosthu" id="img<?=$l['fid']?>">
	
	<a href="<?=PAGESPATH.mainimg($l['fid'],$l['transurl'],"/")?>"><img onmouseover="$(this).css({border: '2px #bfb6fc solid', margin: '0px'})" onmouseout="$(this).css({border:'',margin: '2px'})"  title="<?=$l['fname']?>" alt="<?=$l['fname']?>" class="smallimg" src="<?=THUMBPATH.mainimg($l['fid'],$l['transurl'])?>"></a>
	
	<?if(DPadmin){?>
	<div style="position: absolute; z-index: 1; margin-top: -20px; background-color: white" >&nbsp;
		<?if($subcatid){?><a href="javascript://" style="font-size: 10px" onclick="movetocat(<?=$l['fid']?>)" > пом </a> &nbsp;|<?}?>&nbsp; <a href="javascript://" style="font-size: 10px" onclick="dela(<?=$l['fid']?>)" > удал </a>
	&nbsp;
	</div>
		<?}?>
	</div>
<?
$key++;
}
?>
</div>
<br clear="all">
</div>
<div style="padding: 10px 10px 10px 50px"><?=$cdes?></div>
</div>