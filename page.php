<?
define('IN_DP', true);
include("inc/func.php");
$id=((int)$_GET['fid'])?(int)$_GET['fid']:(int)$_GET['id']+1;
$db->q="SELECT * FROM  fotos  FORCE INDEX(subcategory)  LEFT JOIN subcategory ON fotos.subcategory = subcategory.subcatid LEFT JOIN category ON subcategory.catid=category.catid LEFT JOIN stats ON fotos.fid=stats.sfid WHERE fotos.fid=$id LIMIT 1";
$db->query();
list($img)=$db->fetch_a();
if($db->affected()==0) notfound();
$db->free();
$u=FULLPATH.mainimg($img['fid'],$img['transurl']);
$g=GREYPATH.mainimg($img['fid'],$img['transurl']);
$thu=THUMBPATH.mainimg($img['fid'],$img['transurl']);
$subcatid=(int)$img['subcatid'];
$catid=(int)$img['catid'];
$fid=(int)$img['fid'];
$views=(int)$img['viewers'];
$width_px=(int)$img['width_px'];
$height_px=(int)$img['height_px'];
$DP_keywords=$img['subcatkeywords'];
$DP_description=$img['subcatdes'];
$db->q="(SELECT * FROM  fotos  FORCE INDEX(subcategory)  LEFT JOIN subcategory ON fotos.subcategory = subcategory.subcatid LEFT JOIN category ON subcategory.catid=category.catid WHERE fotos.fid<$id AND  subcategory.subcatid = $subcatid  ORDER BY fotos.fid DESC LIMIT 3) UNION (SELECT * FROM  fotos  FORCE INDEX(subcategory)  LEFT JOIN subcategory ON fotos.subcategory = subcategory.subcatid LEFT JOIN category ON subcategory.catid=category.catid WHERE fotos.fid>=$id AND subcategory.subcatid = $subcatid  ORDER BY fotos.fid ASC LIMIT 4) order by fid ASC";

$db->query();
$fotos=$db->fetch_a();
$num = $db->num_rows();
$db->free();

foreach($fotos as $key=>$line)
{
if($line['fid']==$fid) break;
}
$prev=$fotos[$key-1];
$next=$fotos[$key+1];
$title=($img['subcatname'])?$img['catname']." &gt; ".$img['subcatname']." &gt; ".$img['fname']:$img['catname']." &gt; ".$img['fname'];
ob_start();
if(!$ajaxcontent) include ("tmpl/".curtempl."/gen.tpl");
$canonical=$next_page="http://".$host."/pages/$fid/";
include ("tmpl/".curtempl."/page.tpl");
$head = ob_get_contents();
ob_end_clean ();
if(!$ajaxcontent) include ("inc/head.php");
print $head;
if(!$ajaxcontent) include ("tmpl/".curtempl."/footer.tpl"); else  {$title=str_replace("&gt;",">",$title);?>
	<script type="text/javascript" language="JavaScript">
try {window.document.title="Dream Picture - <?=$title?>";} catch(e) {}
</script>
	<?}
?>