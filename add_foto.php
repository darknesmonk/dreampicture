<?
define('IN_DP', true);
include("inc/func.php");
if(!DPadmin) forbid(); 
$dplogo='img/dp1.png';
$image2 = imagecreatefromPNG($dplogo);
imagesavealpha( $image2, true );
list($dpw, $dph) = getimagesize($dplogo);
$maxs="3400000";
$image=$_FILES['image'] or die ("no file");
$size_i=$image['size'];
$tmp_i=$image['tmp_name'];
$sub=(int)$_POST['sub'] or die ("no sub");
if($size_i>=$maxs || $size_i<1){die("Corupt");}
$name=iconv('UTF-8', 'windows-1251',$image['name']);
$name=chrep($name);
$name=substr($name,0,strpos($name,"."));
$size=(int)$image['size'];
$f=reloadfolders();
$db->q="SELECT * FROM ffolders WHERE ffid=$f limit 1";
$db->query();
$res=$db->fetch_a();
$db->free();
$res=$res[0];
$path=fotodir.$res['mainfolder']."/".$res['ffolder']."/";
$newname=imgname();
$full=$newname.".jpg";
$small=$newname."_thumb.jpg";
$gray=$newname."_gray.jpg";
list($width, $height) = getimagesize($tmp_i);
$nw=250;
$nh=188;
$wm = $width/$nw;
$hm = $height/$nh;
$h_height = $nh/2;
$w_height = $nw/2;
     $image_p = imagecreatetruecolor($nw, $nh);
	      $image_p2 = imagecreatetruecolor($width, $height);
	 
	 
$image = imagecreatefromjpeg($tmp_i) or die("Не рисунок");
sleep(2);
   if($nw<=$nh) {
        $adjusted_width = $width / $hm;
        $half_width = $adjusted_width / 2;
        $int_width = $half_width - $w_height;
 
        imagecopyresampled($image_p,$image,-$int_width,0,0,0,$adjusted_width,$nh,$width,$height);
    } else  {
        $adjusted_height = $height / $wm;
        $half_height = $adjusted_height / 2;
        $int_height = $half_height - $h_height;
        imagecopyresampled($image_p,$image,0,-$int_height,0,0,$nw,$adjusted_height,$width,$height);
    } 
	
	$ratiologo=($nw>$nh)?$nw/$nh:$nh/$nw;
	$dpcurw=ceil(($dpw*$ratiologo)/8);
	$dpcurh=ceil(($dph*$ratiologo)/8);
	$offsetx=$nw-$dpcurw;
	$offsety=$nh-$dpcurh;
	imagecopyresampled($image_p,$image2, $offsetx,$offsety , 0, 0,$dpcurw,$dpcurh,$dpw,$dph);
	
	
	$ratiologo=($width>$height)?$width/$height:$height/$width;
	$dpcurw=ceil(($dpw*$ratiologo)/7);
	$dpcurh=ceil(($dph*$ratiologo)/7);
	$offsetx=$width-$dpcurw;
	$offsety=$height-$dpcurh;
	
		imagecopyresampled($image_p2,$image, 0, 0, 0, 0,$width,$height,$width,$height);
	
	imagecopyresampled($image_p2,$image2, $offsetx,$offsety , 0, 0,$dpcurw,$dpcurh,$dpw,$dph);
	
$small1=$path.$small;
$full1=$path.$full;
$gray1=$path.$gray;

	$wc=ceil($width/10);
	$hc=ceil($height/2);
	
	$rgb=imageColorAt($image_p2,$wc,$hc);
	
	list($r,$g,$b)=array_values(imageColorsForIndex($image_p2,$rgb));




ImageJpeg($image_p,$small1,70) or die ('Не скопировался'); 
ImageDestroy($image_p); 


ImageJpeg($image_p2,$full1,80) or die ('Не скопировался'); 



imagefilter( $image_p2, IMG_FILTER_COLORIZE, 0,0,3);
imagefilter( $image_p2, IMG_FILTER_BRIGHTNESS,30);
imagefilter( $image_p2, IMG_FILTER_CONTRAST,-15);
imagefilter( $image_p2, IMG_FILTER_GRAYSCALE );
imagefilter( $image_p2, IMG_FILTER_GRAYSCALE);

ImageJpeg($image_p2,$gray1,70) or die ('Не скопировался'); 

ImageDestroy($image_p2); 
ImageDestroy($image); 

chmod($full1,0777);
chmod($small1,0777);
chmod($gray1,0777);
$kb=ceil(filesize($full1)/1024);
$kb1=ceil
(
$kb + (filesize($small1)/1024) + (filesize($gray1)/1024)
);

$transurl=strtolower(mysql_escape_string(transliturl(trim($name))));
$db->q="INSERT INTO fotos SET fdatetime=NOW(), folderid=$f, fname='$name', full='$full', thumb='$small', gray='$gray', fsizekb=$kb, ip='$ip', width_px=$width, height_px=$height, subcategory=$sub,transurl='$transurl', color_r=$r,color_g=$g,color_b=$b ";
$db->query();
$last=$db->insert_id();
$db->q="UPDATE ffolders SET files=files+3, kbsize=kbsize+$kb1 WHERE ffid=$f LIMIT 1";
$db->query();
unlink($tmp_i);
$db->free();
$db->q="UPDATE timestat SET GB=((SELECT SUM(kbsize) as k FROM ffolders)/1024)/1024, sday=sday+1, sweek=sweek+1, smonth=smonth+1, sall=(SELECT COUNT(*) FROM fotos), lastupdateday=NOW(), lastupdateweek=NOW(), lastupdatemonth=NOW() WHERE tsid=1 LIMIT 1";
$db->query();
$db->free();
$page=PAGESPATH.mainimg($last,$transurl,"/");
$thumb=THUMBPATH.mainimg($last,$transurl);
$db->q="UPDATE category, subcategory SET catref=NOW(), subcatref=NOW(), catfotos=catfotos+1, subcatfotos=subcatfotos+1 WHERE subcategory.subcatid=$sub AND category.catid=subcategory.catid";
$db->query();
$db->free();
$cont=
<<<CONT
<div align="center" class="fotosthu" id="img{$last}">
	<a href="$page"><img onmouseover="$(this).css({border: '2px #bfb6fc solid', margin: '0px'})" onmouseout="$(this).css({border:'',margin: '2px'})"  class="smallimg" src="$thumb"></a>
	<div style="position: absolute; z-index: 1; margin-top: -20px; background-color: white" >&nbsp;
		<a href="javascript://" style="font-size: 10px" onclick="movetocat($last)" > пом </a> &nbsp;|&nbsp; <a href="javascript://" style="font-size: 10px" onclick="dela($last)" > удал </a>
	&nbsp;
	</div>
	</div>
CONT;
echo iconv('windows-1251', 'UTF-8',$cont);
?>
