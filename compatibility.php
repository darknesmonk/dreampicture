<?
define('IN_DP', true);
include("inc/func.php");
$name=chrep(trim($_GET['src']));
$name=substr($name,0,strpos($name,"."));
if(stristr($name,'_thumb')) {$name=str_ireplace("_thumb","",$name); $type='thumb'; } else $type='full';
$db->q="SELECT fname, fid, CONCAT('".fotodir."',mainfolder,'/',ffolder,'/',$type) as foto FROM oldurls FORCE INDEX(uname) LEFT JOIN fotos ON fotos.fid=oldurls.uid LEFT JOIN ffolders ON fotos.folderid=ffolders.ffid WHERE uname='$name' LIMIT 1";
$db->query();
if($db->affected()==0) notfound();
$res=$db->fetch_a();
$img=$res[0]['foto'];
$id=$res[0]['fid'];
updatestat($id);
sendpic($res[0]['fname'],$img);
?>