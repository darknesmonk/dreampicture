<?
define('IN_DP', true);
include("inc/func.php");
if(!DPadmin) forbid(); 
$act=$_GET['act'];
switch($act)
{
case "logout":
setCookie("asid",false);
header("Location: /");
exit;
break;
case "update": 
updategal();
header("Location:  $ref?$rnd"); 
break;
case "delcat": 
$type=$_POST['type'];
$id=(int)$_POST['id'];
if($id<=1) die("Нельзя удалить каталог");
switch($type)
{
case "cat": 
$db->q="SELECT catid FROM subcategory WHERE catid=$id LIMIT 1";
$db->query();
$db->free();
if($db->affected()!=0) die("В каталоге есть подкаталоги");
$db->q="DELETE FROM category WHERE catid=$id LIMIT 1"; 
$db->query();
$db->free();
$db->q="SELECT catid FROM category ORDER BY catid DESC LIMIT 1";
$c=$db->sres(); $c++;
$db->query();
$db->free();
$db->q="ALTER TABLE category auto_increment=$c";
$db->query();
$db->free();
break;
case "subcat": 
$db->q="UPDATE category SET catfotos=catfotos-(SELECT COUNT(*) FROM fotos FORCE INDEX(subcategory) WHERE subcategory=$id) WHERE catid=(SELECT catid FROM subcategory FORCE INDEX(catid) WHERE subcatid=$id) LIMIT 1"; 
$db->query();
$db->free();
$db->q="DELETE FROM subcategory WHERE subcatid=$id LIMIT 1"; 
$db->query();
$db->free();
$db->q="UPDATE fotos FORCE INDEX(subcategory) SET subcategory=1 WHERE subcategory=$id"; 
$db->query();
$db->free();
$db->q="UPDATE category SET catfotos=(SELECT COUNT(*) FROM fotos WHERE subcategory=1) WHERE catid=1"; 
$db->query();
$db->free();
$db->q="SELECT subcatid FROM subcategory ORDER BY subcatid DESC LIMIT 1";
$c=$db->sres(); $c++;
$db->query();
$db->free();
$db->q="ALTER TABLE subcategory auto_increment=$c";
$db->query();
$db->free();
break;
default: forbid(); 
}
header("Location:  $ref?$rnd"); 
break;
case "cats":
$name=chrep(trim($_POST['name']));
$des=str_replace(array("\n\r","\r","\n"),"&nbsp;",trim($_POST['des']));
$des=chrep($des);

$keywords=chrep(trim($_POST['keywords']));
$type=$_POST['type'];
if(empty($name) || empty($des) || empty($keywords)) die ("не все поля заполнены!");
$keywords=explode(",",$keywords);
if(count($keywords)<3) die("Мало ключевых слов");
$keywords=implode(",",$keywords);
switch($type)
{
case "newcat": $db->q="INSERT INTO category SET catref=NOW(), catname='$name', catdes='$des', catkeywords='$keywords'"; break;
case "newsubcat": 
$id=(int)$_POST['catid'];
$db->q="INSERT INTO subcategory SET catid=$id, subcatref=NOW(), subcatname='$name', subcatdes='$des', subcatkeywords='$keywords'"; break;
default: forbid(); 
}
$db->query();
$db->free();
header("Location:  $ref?$rnd"); 
break;
case "del": 
$id=$_POST['id'];
if($id) {
$db->q="SELECT *, 
	CONCAT('$fotodir',mainfolder,'/',ffolder,'/',full) as f,
CONCAT('$fotodir',mainfolder,'/',ffolder,'/',thumb) as t,
CONCAT('$fotodir',mainfolder,'/',ffolder,'/',gray) as g	
FROM  fotos LEFT JOIN ffolders ON fotos.folderid=ffolders.ffid LEFT JOIN subcategory ON fotos.subcategory=subcategory.subcatid  LEFT JOIN category ON subcategory.catid=category.catid WHERE fid=$id LIMIT 1";
	$db->query();
	if($db->affected()==0)  { die ("alert('запрос не дал результата');");}
	list($r)=$db->fetch_a();
	
	if(!file_exists($r['f']) || !file_exists($r['t']) || !file_exists($r['g']) ) die ("alert('Файлы не найдены');");
	
	$id=$r['fid'];
$kb=ceil(filesize($r['f'])/1024);
$kb1=ceil
(
$kb + (filesize($r['t'])/1024) + (filesize($r['g'])/1024)
);
if($kb<1) die ("alert('Размер слишком маленький');");
	
chmod($r['f'],0777);
chmod($r['t'],0777);
chmod($r['g'],0777);
unlink($r['f']) or die ("alert('Не удалился файл');");
unlink($r['t']) or die ("alert('Не удалился файл');");
unlink($r['g']) or die ("alert('Не удалился файл');");
	
$sub=$r['subcategory'];
	$cat=$r['catid'];
$folderid=(int)$r['folderid'];
	$db->q="UPDATE ffolders SET files=files-3, kbsize=kbsize-$kb1, blocked='0' WHERE ffid=$folderid LIMIT 1";
	$db->query();
		if($db->affected()==0)  {die ("alert('Папки не обновились');");}
	
			$db->q="DELETE FROM fotos WHERE fid=$id LIMIT 1";
	$db->query();
	if($db->affected()==0)  {die ("alert('С таблицы не удалился');");}
				
	$db->q="DELETE FROM oldurls WHERE uid=$id LIMIT 1";
	$db->query();

		
	$db->q="DELETE FROM stats WHERE sfid=$id LIMIT 1";
	$db->query();
		
	$db->q="UPDATE subcategory SET subcatfotos=subcatfotos-1 WHERE subcatid=$sub LIMIT 1";
	$db->query();
	
	$db->q="UPDATE category SET catfotos=catfotos-1 WHERE catid=$cat LIMIT 1";
	$db->query();
	
	$db->q="UPDATE timestat SET sall=sall-1 WHERE tsid=1";
	$db->query();
?>
$("#img<?=$id?>").css({display:""}).fadeOut(300);
<?
	exit;}
break;
case "move": 
$fotos=trim($_POST['fotos']);
$subcatid=(int)$_POST['id'];
if(empty ($fotos) || !$subcatid) die("Пусто");
$fotos=explode(",",$fotos);


$all=count($fotos);


$db->q="UPDATE subcategory, category SET subcatfotos=subcatfotos-$all, catfotos=catfotos-$all WHERE 
subcategory.subcatid=(SELECT subcategory FROM fotos WHERE fid=".$fotos[0]." LIMIT 1) AND category.catid=subcategory.catid";
$db->query();
$db->free();



foreach ($fotos as $l)
{
$l=(int)$l;
$db->q="UPDATE fotos SET subcategory=$subcatid WHERE fid=$l LIMIT 1";
$db->query();
$db->free();
}



$db->q="UPDATE subcategory, category SET subcatfotos=subcatfotos+$all, catfotos=catfotos+$all WHERE subcategory.subcatid=$subcatid  AND category.catid=subcategory.catid";
$db->query();
$db->free();




header("Location:  $ref?$rnd"); 
break;
}

?>