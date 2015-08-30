<?
if (!defined('IN_DP')) forbid(); 
require("inc/vars.php");
require("inc/classes.php");
if($_COOKIE['asid']) define("asid",chrep($_COOKIE['asid'])); else define("asid",false);
$parser = new parser();
function updategal()
{
global $db;
$db->q="UPDATE subcategory SET subcatfotos=(SELECT COUNT(*) FROM fotos WHERE subcategory=subcatid)";
 $db->query();
$db->q="UPDATE category as t1, (SELECT COUNT(*) as c, category.catid as cc  FROM  fotos  FORCE INDEX(subcategory)  LEFT JOIN subcategory ON fotos.subcategory = subcategory.subcatid LEFT JOIN category ON subcategory.catid=category.catid  GROUP BY category.catid ) as t2 SET t1.catfotos=t2.c WHERE t1.catid=t2.cc";
 $db->query();
 $db->q="UPDATE category LEFT JOIN subcategory ON category.catid = subcategory.catid LEFT JOIN fotos ON fotos.subcategory=subcategory.subcatid SET thumbs=CONCAT((SELECT fid FROM fotos WHERE subcategory=subcategory.subcatid ORDER BY RAND() LIMIT 1),'|',(SELECT fid FROM fotos WHERE subcategory=subcategory.subcatid ORDER BY RAND() LIMIT 1),'|',(SELECT fid FROM fotos WHERE subcategory=subcategory.subcatid ORDER BY RAND() LIMIT 1),'|',(SELECT fid FROM fotos WHERE subcategory=subcategory.subcatid ORDER BY RAND() LIMIT 1))";
 $db->query();
 $db->q="UPDATE timestat SET GB=((SELECT SUM(kbsize) as k FROM ffolders)/1024)/1024, sall=(SELECT COUNT(*) FROM fotos), tsid=1 LIMIT 1";
 $db->query();
}

function updatetimestat()
{
global $db;
$db->q="UPDATE timestat USE INDEX (lastupdate) SET sday=0, lastupdateday=NOW() WHERE lastupdateday<=ADDDATE(NOW(), INTERVAL -1 DAY) AND tsid=1 LIMIT 1";
$db->query();
if ($db->affected()==0) return 1;
updategal();
$db->q="UPDATE timestat USE INDEX (lastupdate) SET sweek=0, lastupdateweek=NOW() WHERE lastupdateweek<=ADDDATE(NOW(), INTERVAL -7 DAY) AND tsid=1 LIMIT 1";
$db->query();
if ($db->affected()==0) return 1;
$db->q="UPDATE timestat USE INDEX (lastupdate) SET smonth=0, lastupdatemonth=NOW()  WHERE lastupdatemonth<=ADDDATE( NOW() , INTERVAL -1
MONTH) AND tsid=1 LIMIT 1";
$db->query();
return 1;
} 
function notfound()
{
sendpic("Рисунок_не_найден","img/notsuch.jpg",0,2);
exit;
}
function forbid()
{
sendpic("ГЕНИАЛЬНО!","img/genius.jpg",0,3);
exit;
}
function updatestat($id)
{
 global $db,$ip;
$db->q="SELECT lastip FROM stats USE INDEX (sfid) WHERE sfid=$id LIMIT 1";
$db->query();
if($db->affected()==0)
{
$db->q="INSERT INTO stats SET sfid=$id, viewers=1,lastview=NOW(), lastip='$ip'";
$db->query();
}
else
{
$db->q="UPDATE stats USE INDEX (sfid) SET viewers=viewers+1, lastview=NOW(), lastip='$ip' WHERE sfid=$id LIMIT 1";
$db->query();
$db->free();
}
}
function get_file_etag($filename)
{
  return sprintf('%x-%x-%x', fileinode($filename), filesize($filename), filemtime($filename) );
}
function sendpic($name,$url,$type=false, $header=1)
{
	global $protocol;
   if(!$type) $type=substr($url,strpos($url,".")+1);
	$name=trim($name);
	$url=trim($url);
    $fd = fopen($url, "rb");  
	switch($header)
	{
	case 1: header($protocol. ' 200 OK'); break;
	case 2: header( $protocol . ' 404 Not Found'); break;
	case 3: header( $protocol . ' 403 Forbidden'); break;
	}
     $fsize = filesize($url);
	header('Date: ' . date('D, d M Y H:i:s') . ' GMT'); 
    header('Content-Type: image/jpeg; name='.$name.'.'.$type.'');
	header('Content-Length: '.$fsize);
	header('Cache-Control: max-age=1468800');
	header('Content-Disposition: inline; filename='.$name.'.'.$type.'');  
	header('Connection: close');
	header('Pragma: public');
	header('Expires: 0' );
    header('Accept-Ranges: bytes'); 
    header('ETag: "'.get_file_etag($url).'"');
   fpassthru($fd); 
    fclose($fd);
flush();
	exit;
}
function mainimg($id,$name,$type=".jpg")
{
return "{$id}{$type}";
}

function codegen($f,$t=false,$type='dir')
{
global $HTTPSERVER;
switch($type)
{
case 'dir': return  $HTTPSERVER.$f;break;
case 'bc': return  "[IMG]{$HTTPSERVER}{$f}[/IMG]"; break;
case 'bct': return  "[URL={$HTTPSERVER}{$f}][IMG]{$HTTPSERVER}{$t}[/IMG][/URL]"; break;
case 'ht': return "<img src=&quot;{$HTTPSERVER}{$f}&quot; border=&quot;0&quot;>"; break;
case 'htt': return "<a href=&quot;{$HTTPSERVER}{$f}&quot; target=&quot;_blank&quot; ><img src=&quot;{$HTTPSERVER}{$t}&quot; border=&quot;0&quot; ></a>"; break;
case 'p': return  "{$HTTPSERVER}{$f}"; break;
} 
}
function imgname()
{
return randsym()."_".rand(1000,9999).date("dHmysi");
}
function reloadfolders()
{
global $db;
  $globalfolder="dreamfolder".rand(1000,9999)."_".randsym().rand(11,99)."_".date("dmY");
 $folder=randsym().rand(100,999)."_".date("sydmih");
$db->q="SELECT * FROM ffolders  FORCE INDEX(kbsize) WHERE kbsize<".mlkb."";
$db->query();
if($db->num_rows() < ff || $db->affected()==0){
 $dir=fotodir.$globalfolder;
if(!mkdir($dir,0777) || !is_dir($dir)) die ("Невозможно создать новую папку: $dir");
$dir .="/$folder";
if(!mkdir($dir,0777) || !is_dir($dir)) die ("Невозможно создать новую папку: $dir");
$db->q="ALTER TABLE ffolders ALTER mainfolder SET default '$globalfolder', ALTER ffolder SET default '$folder'";
 $db->query();
$db->q="INSERT INTO ffolders SET mainfolder='$globalfolder', ffolder='$folder'";
$db->query();
return $db->insert_id();
}
$db->q="SELECT mainfolder,ffid FROM ffolders FORCE INDEX(files)  WHERE files % ".mlf." = 0 AND files<>0 AND blocked='0' AND kbsize <> 0 LIMIT 1";
$db->query();
if($db->affected()!=0)
{
$sql=$db->fetch_a();
$res=$sql[0];
$globalfolder=$res['mainfolder'];
$ffid=$res['ffid'];
if(!$globalfolder) die("Нет главной папки");
$dir=fotodir.$globalfolder."/".$folder;
if(!mkdir($dir,0777) || !is_dir($dir)) die ("Невозможно создать новую папку: $dir");
 $db->q="UPDATE ffolders SET blocked='1' WHERE ffid=$ffid LIMIT 1";
 $db->query();
$db->q="INSERT INTO ffolders SET mainfolder='$globalfolder', ffolder='$folder'";
$db->query(); 
return $db->insert_id();
}
$db->q="SELECT ffid FROM ffolders FORCE INDEX(kbsize,files)  WHERE blocked='0' order by RAND() LIMIT 1";
$db->query(); 
return $db->sres();
}


function bots($list=false)
{
global $url,$ref,$ip,$db,$useragent;
$bnames=array
(
'Googlebot'=>'Google',
'Yahoo!'=>'Yahoo!', 
'MSNBot'=>'MSN', 
'Teoma'=>'Ask', 
'Scooter'=>'AltaVista', 
'ia_archiver'=>'Alexa', 
'Lycos'=>'Лукос', 
'Yandex'=>'Яндекс', 
'Rambler'=>'Рамблер', 
'Mail.Ru'=>'Мэйл.ру', 
'Aport'=>'Апорт', 
'WebAlta'=>'Вебальта', 
'bingbot'=>'Bing', 
'MJ12bot'=>'Majestic12',
'SearchBot'=>'SearchBot',
'Ezooms'=>'eZOOM',
'stat.cctld.ru'=>'CCTLD',
'sitebot'=>'SiteBot',
'purebot'=>'Purebot',
'turnitinbot'=>'TurnitinBot',
'dotbot'=>'DotBot',
'bot'=>'Неизвестный бот'
);
if ($list) return $bnames;
$logos=array
(
'Googlebot'=>'google.gif',
'Yahoo!'=>'yahoo.gif', 
'MSNBot'=>'msn.gif', 
'Teoma'=>'ask.gif', 
'Scooter'=>'altavista.gif', 
'ia_archiver'=>'alexa.gif', 
'Lycos'=>'lycos.gif', 
'Yandex'=>'yandex.gif', 
'Rambler'=>'rambler.gif', 
'Mail.Ru'=>'mail.ru.gif', 
'Aport'=>'aport.gif', 
'WebAlta'=>'webalta.gif',
'bingbot'=>'bing.gif',
'MJ12bot'=>'majestic12.gif',
'SearchBot'=>'bot.gif',
'Ezooms'=>'ezoom.gif',
'stat.cctld.ru'=>'stat.cctld.ru.gif',
'sitebot'=>'sitebot.gif',
'purebot'=>'purebot.gif',
'turnitinbot'=>'turnitin.gif',
'dotbot'=>'dotbot.gif',
'bot'=>'bot.gif'
);
foreach ($bnames as $k=>$l)
{ 
if(stristr($useragent,$k)) 
{ 
$db->q="INSERT INTO bots SET bname='$l', buagent='$k', blogo='".$logos[$k]."', blastagent='$useragent', bdatetime=NOW(), blastpage='$url', blastrefer='$ref', bip='$ip'"; 
$db->query();
break; 
} 
}
return true;
}



function chrep($str,$type=1)
{
$ls=Array();
$li=Array();
switch($type)
{
case "1":
$ls=array("'","\\r","\\n","\"","<",">");
$li=array("&prime;","&nbsp;","[br]","&quot;","&lt;","&gt;");
break; 
case "2":
$ls=array("'","\\r","\\n");
$li=array("&prime;","&nbsp;","<br>"); 
break;
case "3":
$ls=array("[br]");
$li=array("\n"); 
break; 
}

$str = str_replace($ls, $li, mysql_escape_string($str));

$str=stripslashes($str);

return $str; 
}



function BBcode($texto){
   $a = array(
       "#(^|[\n ])((http|https|ftp|ftps)://[\w\#$%&~/.\-;:=,?@\[\]\(\)+]*)#sie",
      "/\[i\](.*?)\[\/i\]/is",
      "/\[b\](.*?)\[\/b\]/is",
      "/\[u\](.*?)\[\/u\]/is",
      "/\[s\](.*?)\[\/s\]/is",
      "/\[quote\](.*?)\[\/quote\]/is",
      "/\[code\](.*?)\[\/code\]/is",
      "/\[img\](.*?)\[\/img\]/is",
		"/\[center\](.*?)\[\/center\]/is",
        "/\[right\](.*?)\[\/right\]/is",
        "/\[left\](.*?)\[\/left\]/is",
      "/\[color=(.*?)\](.*?)\[\/color\]/is",
      "/\[bgcolor=(.*?)\](.*?)\[\/bgcolor\]/is",
      "/\[font=(.*?)\](.*?)\[\/font\]/is",
      "/\[url=(.*?)\](.*?)\[\/url\]/is",
     "/\[url](.*?)\[\/url\]/is",
      "/\[size=(.*?)\](.*?)\[\/size\]/is",
       "/\[br]/is",
       "#\[added\](.*?)\[/added\]#sie",
   );
   $b = array(
	   "'\\1<a href=\"'.trim('\\2').'\" target=\"_blank\" title=\"'.trim('\\2').'\">'.trim('\\2', 20).(strlen('\\2')>30?substr('\\2', strlen('\\2')-10, strlen('\\2')):'').'</a>'",
      "<i>$1</i>",
      "<b>$1</b>",
      "<u>$1</u>",
      "<s>$1</s>",
      "<blockquote>$1</blockquote>",
      "<pre>$1</pre>",
      "<img src=\"$1\" style=\"border: 0px\">",
	   "<div align=\"center\">$1</div>",
       "<div align=\"right\">$1</div>",
       "<div align=\"left\">$1</div>",
      "<span style=\"color: $1\">$2</span>",
      "<span style=\"background-color: $1; padding: 5px\">$2</span>",
      "<span style=\"font-family: $1\">$2</span>",
      "<noindex><a href=\"$1\" target=\"_blank\">$2</a></noindex>",
       "<noindex><a href=\"$1\" target=\"_blank\">$1</a></noindex>",
      "<span style=\"font-size:$1px\">$2</span>",
      "<br />",
      "'<blockquote><b>добавлено:</b> '.correctdate(false,false,'all','\\1').'</blockquote>'"
   );
   $texto = preg_replace($a, $b, $texto);
   $texto = nl2br($texto);
   return $texto;
}
function insert_bbcode($form,$text)
{
 global $adm_auth_data;
$parser = new parser();

$afile="";
if($adm_auth_data) $afile=' <input type="button"  value="Добавить файл" onclick="filewin(\'/admintools.php?option=addfile\')" class="but" style="width:130px; cursor: pointer" onmouseover="this.style.borderColor=\'red\'" onmouseout="this.style.borderColor=\'\'">';
$parser->get_tpl('bbpanel.tpl');
$parser->set_tpl("FORM",$form);
$parser->set_tpl("TEXT",$text);
$parser->set_tpl("ADMINFILE",$afile);
$parser->tpl_parse();
$panel = $parser->template;
$parser->get_tpl('bbscript.tpl');
$parser->set_tpl("FORM",$form);
$parser->set_tpl("TEXT",$text);
$parser->tpl_parse();
$script = $parser->template;
 return $panel.$script;
}



function smalltext($text,$url,$max=120,$type=1)
{
if(strlen(strip_tags($text))>$max)
{
$text=strip_tags($text);
$text= substr($text,0,$max);
return "$text... <a href=\"$url\" style=\"font-size: 10px\" title=\"далее\">&raquo;&raquo;&raquo;</a>";
}
else
{
switch($type)
{
case 1: return $text; break;
case 2: return ""; break;
}
}
}

function spam($mess, $name)
{
 global $db;
 $db->q="SELECT sword FROM spam FORCE INDEX (sword)";
$db->query();
 $sql = $db->fetch_a();
 $db->free();
	foreach($sql as $res)
	{
     $line=trim($res['sword']);
	if (strstr(strtolower($name),$line) || strstr(strtolower($mess), $line))  return $line; 
	}
return false;
}

function smiles($act,$m,$form,$text) {

global $db;
$parser = new parser();
 switch($act)
 {
  case "rew": 
  $db->q="SELECT * FROM smiles ORDER BY 0+id ASC";
$db->query();
  if($db->affected()==0) return false;
  
$sql = $db->fetch_a();
    $db->free();
  
foreach($sql as $sm)
  {
if(strstr($m,$sm['code'])): $m=str_replace($sm['code'],"<img alt=\"".$sm['des']."\" title=\"".$sm['des']."\" src=\"/img/smiles/".$sm['src'].".gif\" >",$m); endif ;
  }
  
 break;

  case "ins":
$parser->get_tpl('pastesmiles.tpl');
$parser->set_tpl("TEXT",$text);
$parser->set_tpl("FORM",$form);
$parser->set_tpl("HTTPSERVER",$HTTPSERVER);
$parser->tpl_parse();
return $parser->template;
 break;
 default: $m=false;
  }
  return $m;
}

function translit ($russian) {
$lettersRus = array ('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','ъ','Ы','ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ы','э','ю','я',' ','|'); 

$lettersLat = array ('A','B','V','G','D','E','Yo','Zh','Z','I','J','K','L','M','N','O','P','R','S','T','U','F','H','C','Ch','Sh','Shc','"','Y','`','Ye','Yu','Ya','a','b','v','g','d','e','yo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','shc','y','ye','yu','ya','_','_'); 
$russian = str_replace ($lettersRus, $lettersLat, $russian); 
return $russian; 
}

function transliturl ($russian) {
$lettersRus = array ('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','ъ','Ы','ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ы','э','ю','я',' ','|','.','&#8211;','!','?',',',':','/','\\','ь'); 

$lettersLat = array ('A','B','V','G','D','E','Yo','Zh','Z','I','J','K','L','M','N','O','P','R','S','T','U','F','H','C','Ch','Sh','Shc','','Y','','Ye','Yu','Ya','a','b','v','g','d','e','yo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','shc','y','ye','yu','ya','_','','','-','','','','','','',''); 
$russian = str_replace ($lettersRus, $lettersLat, $russian); 
return $russian; 
}
function declension($number, $words) { 
    $number = abs($number) % 100; 
    $n = $number%10;
     if ($number > 10 && $number < 20 || $number==0) return $words[2];
    if ($n > 1 && $n < 5) return $words[1];
    if ($n == 1) return $words[0];
    return $words[2];
}

function RemoveDir($path)
{
	if(file_exists($path) && is_dir($path))
	{
		$dirHandle = opendir($path);
		while (false !== ($file = readdir($dirHandle))) 
		{
			if ($file!='.' && $file!='..')// исключаем папки с назварием '.' и '..' 
			{
				$tmpPath=$path.'/'.$file;
				chmod($tmpPath, 0777);
				
				if (is_dir($tmpPath))
	  			{  // если папка
					RemoveDir($tmpPath);
			   	} 
	  			else 
	  			{ 
	  				if(file_exists($tmpPath))
					{
						// удаляем файл 
	  					unlink($tmpPath);
					}
	  			}
			}
		}
		closedir($dirHandle);
		
		// удаляем текущую папку
		if(file_exists($path))
		{
			rmdir($path);
		}
	}
	else
	{
		echo "Удаляемой папки не существует или это файл!";
	}
}

function ChmDir($path)
{
	if(file_exists($path) && is_dir($path))
	{
		$dirHandle = opendir($path);
		while (false !== ($file = readdir($dirHandle))) 
		{
			if ($file!='.' && $file!='..')// исключаем папки с назварием '.' и '..' 
			{
				$tmpPath=$path.'/'.$file;
				chmod($tmpPath, 0777);
				
				if (is_dir($tmpPath))
	  			{  // если папка
					chmod($tmpPath,0777);
			   	} 
	  			else 
	  			{ 
	  				if(file_exists($tmpPath))
					{
						// удаляем файл 
	  					chmod($tmpPath,0777);
					}
	  			}
			}
		}
		closedir($dirHandle);
		
		// удаляем текущую папку
		if(file_exists($path))
		{
		 chmod($path,0777);
		}
	}
	else
	{
		echo "Удаляемой папки не существует или это файл!";
	}
}
function correctdate ($mdate,$ctime,$mode,$mdatetime=false,$correct=true) {
global $date,$time;
 if($mdatetime)
 {
 $mdatetime=explode(" ",$mdatetime);
 $mdate=$mdatetime[0];
 $ctime=$mdatetime[1];
 }

  if(empty($mdate) && empty($ctime)) return "нет даты";
 
$num = array('00','01','02','03','04','05','06','07','08','09','10','11','12');
$month = array('нет месяца','янв.','фев.','мар.','апр.','май.','июн.','июл.','авг.','сен.','окт.','ноя.','дек.');

if($mdate){
 $mdate=explode("-",$mdate);
 $d=explode("-",$date);
  if($mdate[0]==$d[0] && $mdate[1]==$d[1] && $correct) 
   {
    $mdate=($d[2]-$mdate[2]);
    switch($mdate)
    {
     case -2:$mdate="послезавтра"; break; // :-D
     case -1:$mdate="завтра"; break; // :-)
     case 0: 
      $mdate="сегодня";
     break;
       
      case 1: $mdate="вчера"; break;
       case 2: $mdate="позавчера"; break;
        default: 
    
     $mdate=($mdate<2)?"в этом месяце":$mdate." ".declension($mdate,array('день','дня','дней'))." назад";
    }
   }
   else {
 $mdate[0]=($mdate[0]==$d[0])?"":" ".$mdate[0]."г. ";
$mdate[1]=str_replace($num,$month,$mdate[1]);
 $mdate=$mdate[2]." ".$mdate[1].$mdate[0];
  }
}

if($ctime)
{
 $gt=explode(":",$time);
$ctime=explode(":",$ctime);
 $ctime=" в ".$ctime[0].":".$ctime[1];
}
switch($mode){
case "donly":  
 return $mdate; break;
case "tonly":
return $ctime; break; 
case "all":
return  $mdate.$ctime; 
default: return "нет режима";
}
}
function acceess()
{
global $u_id,$ip,$db;
$db->q="SELECT text FROM banlist ip WHERE ip='$ip' LIMIT 1";
$db->query();
 if($db->affected()==0) return false; 
$res=$db->sres();
 $db->free();
 header('Content-type: text/html; charset=windows-1251');
newhtml("Вы заблокированы","<div class=\"h\">Вы заблокированы. Причина: ".trim($res).". <br> обратитесь к администратору.</div>");
}
function randsym()
{
$simvol=rand(1,15);
switch ($simvol) {
case 1: $simvol="a"; break;
case 2: $simvol="b"; break;
case 3: $simvol="c"; break;
case 4: $simvol="d"; break;
case 5: $simvol="e"; break;
case 6: $simvol="f"; break;
case 7: $simvol="z"; break;
case 8: $simvol="x"; break;
case 9: $simvol="v"; break;
case 10: $simvol="n"; break;
case 11: $simvol="m"; break;
case 12: $simvol="u"; break;
case 13: $simvol="y"; break;
case 14: $simvol="t"; break;
case 15: $simvol="r"; break;
}
return $simvol;
}
function newhtml($title,$text)
{
$parser = new parser();
 $parser->get_tpl('newHTMLpage.tpl');
  $parser->set_tpl("TITLE",$title);
   $parser->set_tpl("TEXT",$text);
$parser->tpl_parse();
  $newbody=$parser->template;
 header("Content-type: text/html; charset=windows-1251");
 include ("inc/head.php");
 echo $head;
 echo $newbody;
 exit();
 return false;
}
function pagenotfound()
{
header( $protocol . ' 404 Not Found',0,2); exit;
}

include ("inc/db.php");
$db ->q ="SET NAMES cp1251";
$db->query();
$db->free();
acceess();
$db->q="SELECT dpadminpass, maxonepage, FULLPATH, THUMBPATH, GREYPATH, PAGESPATH, mlkb, mlf, ff, curtempl, keywords, description,  fotodir FROM params WHERE pid=1";
$db->query();
if($db->affected()==0) forbid();
list($params)=$db->fetch_a();
$db->free();
foreach($params as $key=>$const) { define($key,$const);} 
$DP_keywords=keywords;
$DP_description=description;
bots();
updatetimestat();
if(dpadminpass==asid) define('DPadmin',true); else define('DPadmin',false);
	if(DPadmin){
$db->q="SELECT * FROM subcategory LEFT JOIN category ON subcategory.catid=category.catid ORDER BY catname";
$db->query();
$catslist=$db->fetch_a();
$db->free();
   }
   $db->q=(DPadmin)?"SELECT * FROM category order by catfotos desc":"SELECT * FROM category FORCE INDEX(thumbs) WHERE thumbs<>'' order by catfotos desc";
$db->query();
$catos=$db->fetch_a();
$db->free();
$db->q="SELECT * FROM timestat WHERE tsid=1 LIMIT 1";
$db->query();
list($stats)=$db->fetch_a();
$db->free();
   $ajaxcontent=($_GET['ajax'])?true:false;
?>