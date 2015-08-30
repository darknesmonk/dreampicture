<script type="text/javascript" language="JavaScript" >
 var t;
 function paste(s1,s2)
   {
var bbst = document.getElementById("bbst");
 try {
if(document.selection.createRange().text!=='') {
	document.selection.createRange().text=s1+document.selection.createRange().text + s2;
	}
else { clearTimeout(t); bbst.innerHTML='сначало выделите текст.'; fadeIn(bbst,0); 
t = setTimeout(function() {fadeOut(bbst,100);},5000);}
} catch(e) {
 try 
 {
var start = document.{FORM}.{TEXT}.selectionStart;
var end = document.{FORM}.{TEXT}.selectionEnd;
s = document.{FORM}.{TEXT}.value.substr(start,end-start);
  if(s=='') {clearTimeout(t); bbst.innerHTML='сначало выделите текст.';
  fadeIn(bbst,0); t = setTimeout(function() {fadeOut(bbst,100);},5000);
return false;}
 document.{FORM}.{TEXT}.value = document.{FORM}.{TEXT}.value.substr(0, start) + s1 + s + s2 + document.{FORM}.{TEXT}.value.substr(end);
 }
 catch(e){
 document.{FORM}.{TEXT}.value+=s1+'замените этот текст'+s2; clearTimeout(t); bbst.innerHTML='ваш браузер не понмиает выделение текста, вставьте нужный текст между тегами'; fadeIn(bbst,0); t = setTimeout(function() {fadeOut(bbst,100);},5000);}}
 document.{FORM}.{TEXT}.focus();
}
function bbhidvis()
{
var bb = document.getElementById("bbpanel");
if(bb.style.display) {fadeIn(bb,0);} else {fadeOut(bb,100);}
}
</script>