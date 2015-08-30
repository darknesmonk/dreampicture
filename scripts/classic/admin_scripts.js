function dela(id)
{
$.ajax(
{
type:"POST",
url:"/admin.php?act=del",
data:"id="+id,
cache:false,
async:true,
dataType:"script",
error:function(){alert("Повторите запрос еше раз...");},
success:function(data){}})
}
function movetocat(id,t)
{
var f = document.move;
var ft = f.fotos;
var d = ge('movediv');
if(d.style.display) fadeIn(d,50);
var str = (ft.value.length>0)? ","+id:id;
ft.value +=str;
fadeOut(ge('img'+id),50);
}