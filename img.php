<?
define('IN_DP', true);
include("inc/func.php");
$type=(int)$_GET['type'];
$up=false;
$id=((int)$_GET['fid'])?(int)$_GET['fid']:(int)$_GET['id']+1;

switch($type)
{
case 1: $type='full'; $up=true; break;
case 2: $type='thumb'; break;
case 3: $type='gray'; $up=true; break;
case 4:  notfound(); break;
case 5:  forbid(); break;
default: if(isset($_GET['id'])) {$type='full'; break;  $up=true;} forbid();  break;
}

$db->q="SELECT fid,fname, CONCAT('".fotodir."',mainfolder,'/',ffolder,'/',$type) as f FROM  fotos LEFT JOIN ffolders ON fotos.folderid=ffolders.ffid WHERE fid=$id LIMIT 1";
$db->query();
if($db->affected()==0) notfound();
list($res)=$db->fetch_a();
$id=(int)$res['fid'];
if($up) updatestat($id);
sendpic($res['fname'],$res['f']);
?>