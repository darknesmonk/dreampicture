<?
if (!defined('IN_DP')) forbid(); 
class parser 
{
public $vars = array();
public $template;
public $dir="tmpl/";
function get_tpl($tpl_name)
{
global $curtempl;
	$tpl_name=$this->dir."$curtempl/$tpl_name";
if(empty($tpl_name) || !file_exists($tpl_name))
{
newhtml("Ошибка","Шаблон $tpl_name не найден");
}
ob_start();
include($tpl_name);
$this->template = ob_get_contents();
ob_end_clean ();
}
function move($block,$data=false,$os=1)
{
if(!$data) $data=$this->template;
preg_match("/<!--".$block."-->(.*)<!--".$block."-->/isU",$data,$out);
return $out[$os];
}
function replace($block,$ext="", $data=false)
{
if(!$data) $data=$this->template;
$this->template=preg_replace("/<!--".$block."-->(.*)<!--".$block."-->/isU",$ext,$data);
return true;
}
function set_tpl($key,$var)
 {
$this->vars["{".$key."}"] =$var;
}
function tpl_parse()
{
foreach($this->vars as $find => $replace)
{
$this->template = str_replace($find, $replace, $this->template);
}
unset($this->vars);
}
}
class db
{
protected $host;
protected $name;
protected $pass;
public $db_connect_id;
public $q;
function connect($host,$name,$pass)
{
$this->host=$host;
$this->name=$name;
$this->pass=$pass;
$this->db_connect_id=mysql_connect($this->host,$this->name,$this->pass) or $this->sqlerr($this->db_connect_id);
mysql_select_db($this->name) or $this->sqlerr($this->db_connect_id);
}
function sqlerr($id)
{
global $PHP_SELF,$ip;
if(!mysql_error()) return false;
$e="[$ip]=".$PHP_SELF."- ".mysql_errno($id).": ".mysql_error($id);
//die($e);
forbid();
}
function query()
{
$denied=array
(
'SHOW',
'TABLES',
'DATABASE',
'DROP',
'REPLACE',
'%27',
'%2527',
'%60',
'CREATE'
);
$this->q=str_ireplace($denied,' ',$this->q);
$this->q = mysql_query($this->q,$this->db_connect_id) or $this->sqlerr($this->db_connect_id);
}
function affected()
{
return mysql_affected_rows($this->db_connect_id) or $this->sqlerr($this->db_connect_id);
}
function num_rows()
{
return mysql_num_rows($this->q);
}
function insert_id()
{
return mysql_insert_id($this->db_connect_id);
}
function fetch_a()
{
$result = array();
while ($res=mysql_fetch_assoc($this->q))
{
$result[]=$res;
}
return $result;
}
function fetch_n()
{
$result = array();
while ($res=mysql_fetch_row($this->q))
{
$result[]=$res;
}
return $result;
}
function fetch_b()
{
$result = array();
while ($res=mysql_fetch_array($this->q,"MYSQL_BOTH"))
{
$result[]=$res;
}
return $result;
}
function free()
{
mysql_free_result($this->q) or $this->sqlerr($this->db_connect_id);
}
function sres($row=0)
{
	return mysql_result($this->q,$row);
}
function __desctruct()
{
mysql_close($this->db_connect_id);
}
}
?>