<?
define('IN_DP', true);
include("inc/func.php");
$act=$_GET['act'];

		$page=((int)$_GET['page']>=1)?(int)$_GET['page']:1;
        $l1=($page-1)*maxonepage;
switch($act)
{
case "admform":
$title="Администратор";
if(!empty($_POST['pass'])) 
{
$p=md5(trim($_POST['pass']));
sleep(2);
if($p!=dpadminpass) { die("Не верный пароль"); }
setCookie("asid",$p, time()+5184000);
header("Location: /");
exit;
}
ob_start();
include ("tmpl/".curtempl."/admin.tpl");
$cont = ob_get_contents();
ob_end_clean ();
break;
case "search": 
$text=strtolower(mysql_escape_string(trim(chrep($_GET['text']))));
$text=str_replace(array(".","?","!","-"," и "," или ","|",","),"",$text);
$canonical .="search/?searchq=$text";
$title="Поиск на сайте - $text";
ob_start();
include ("tmpl/".curtempl."/search.tpl"); 
$cont = ob_get_contents();
ob_end_clean ();
break;
case "fly": 
$db->q="SELECT * FROM  fotos  FORCE INDEX(subcategory)  WHERE fotos.fid >1000 ORDER BY RAND() LIMIT 1";
$db->query();
if($db->affected()==0) die('alert(":((((")');
list($img)=$db->fetch_a();
$u=FULLPATH.mainimg($img['fid'],$img['transurl']);
?>
fullshow('<?=$u?>');
<?exit; break;
case "cat":
$catid=(int)$_GET['catid'];
$subcatid=(int)$_GET['subcatid'];

if(!$subcatid && !$catid) { 
$title="Категории";
$db->q=(DPadmin)?"SELECT * FROM category ORDER BY catfotos DESC":"SELECT * FROM category FORCE INDEX(thumbs)  WHERE thumbs<>'' ORDER BY catfotos DESC";
$db->query();
$fotos=$db->fetch_a();
$db->free();
	
	ob_start();
	include ("tmpl/".curtempl."/catall.tpl"); 
$cont = ob_get_contents();
ob_end_clean ();
	
	break;}
	
if(!$catid) forbid(); 
	

	
$db->q=($subcatid)?"SELECT * FROM  fotos  FORCE INDEX(subcategory,fdatetime)  LEFT JOIN subcategory ON fotos.subcategory = subcategory.subcatid LEFT JOIN category ON subcategory.catid=category.catid WHERE category.catid=$catid AND subcategory.subcatid = $subcatid ORDER BY fdatetime ASC LIMIT $l1,".maxonepage:"SELECT * FROM  fotos  FORCE INDEX(subcategory,fdatetime)  LEFT JOIN subcategory ON fotos.subcategory = subcategory.subcatid LEFT JOIN category ON subcategory.catid=category.catid 
WHERE category.catid=$catid ORDER BY fdatetime ASC LIMIT $l1,".maxonepage;
$db->query();
$fotos=$db->fetch_a();
$db->free();
if($db->affected()==0 && !DPadmin)  pagenotfound();

$db->q="SELECT * FROM subcategory WHERE catid=$catid AND subcatname<>'' ORDER BY subcatname ASC";
$db->query();
$subcats=$db->fetch_a();
$db->free();
if($subcatid) {
$DP_keywords=$fotos[0]['subcatkeywords'];
$DP_description=$fotos[0]['subcatdes'];
$cdes=$fotos[0]['subcatdes']; 
$title=$fotos[0]['catname']." &gt; ".$fotos[0]['subcatname'];
} else { 
$DP_keywords=$fotos[0]['catkeywords'];
$DP_description=$fotos[0]['catdes'];
$cdes=$fotos[0]['catdes'];
$title=$fotos[0]['catname'];
}

		ob_start();
include ("tmpl/".curtempl."/cat.tpl");
$cont = ob_get_contents();
ob_end_clean (); 

break;
case "others":
$t=$_GET['type'];
$canonical .=($page<2)?"$t/":"$t/page/$page/" ;
switch($t)
{
case "best": 
$c=270;
$title="Лучшие картинки";
$db->q="SELECT * FROM  fotos FORCE INDEX(subcategory)  LEFT JOIN subcategory ON fotos.subcategory = subcategory.subcatid LEFT JOIN category ON subcategory.catid=category.catid LEFT JOIN stats ON fotos.fid=stats.sfid ORDER BY viewers DESC LIMIT $l1,".maxonepage;
break;
case "new":
$c=162;
$title="Новые";
$db->q="SELECT * FROM  fotos  FORCE INDEX(fdatetime)  ORDER BY fdatetime DESC LIMIT $l1,".maxonepage;
break;
case "hd":
$c=54;
$title="HD качество";
$db->q="SELECT * FROM  fotos  FORCE INDEX(width_px,height_px) WHERE (width_px/height_px)>1.6 AND width_px>1200 AND (width_px/height_px)<2 ORDER BY RAND() LIMIT $l1,".maxonepage;
break;
default: pagenotfound();
}


$db->query();
$fotos=$db->fetch_a();
if($db->affected()==0) pagenotfound();
$db->free();
$db->free();
$pages=ceil($c/maxonepage)+1;
ob_start();
include ("tmpl/".curtempl."/bestcat.tpl");
$cont = ob_get_contents();
ob_end_clean ();
break;
default: 
$title="Главная";
$db->q="SELECT * FROM  fotos  FORCE INDEX(subcategory)  
WHERE fotos.fid >1000
ORDER BY RAND() LIMIT 48";
$db->query();
$res=$db->fetch_a();
if($db->affected()==0)  pagenotfound();
$db->free();
$key=1;
$trkey=12;
$ctr=6;
$src1=false;
$src2=false;
$src3=false;

		ob_start();
include ("tmpl/".curtempl."/index.tpl");
$cont = ob_get_contents();
ob_end_clean ();


}
ob_start();
include ("tmpl/".curtempl."/gen.tpl");
$head = ob_get_contents();
ob_end_clean ();
if(!$ajaxcontent) include ("inc/head.php");
if(!$ajaxcontent) print $head;
print $cont;
if(!$ajaxcontent)  include ("tmpl/".curtempl."/footer.tpl"); else  {$title=str_replace("&gt;",">",$title);?>
	<script type="text/javascript" language="JavaScript">
try {window.document.title="Dream Picture - <?=$title?>";} catch(e) {}
</script>
	<?}
?>