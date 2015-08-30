<div style="background-color: #f1f1f1; padding: 2px; font-size: 10px" align="left"><a href="javascript: void(0)" onclick="bbhidvis()">[-Показать/Скрыть панель форматирования-]</a></div>
<div id="bbpanel" align="left" style="background-color: #fefefe; padding: 5px; border: 1px #999 solid; display: none">
 <div class="text2" style="font-weight: bold">Панель форматирования: <font style="color: red" id="bbst"></font></div>
 <input type="button"  value="К" onclick="paste('[i]','[/i]')" title="Наклонен." style="font-style: italic; width:70px; " class="but" onmouseover="this.style.borderColor='red'" onmouseout="this.style.borderColor=''">
  <input type="button"  value="Ж" onclick="paste('[b]','[/b]')"  title="Жирный" style="font-weight: bold; width:70px; " class="but" onmouseover="this.style.borderColor='red'" onmouseout="this.style.borderColor=''">
  <input type="button"  value="П"  onclick="paste('[u]','[/u]')"  title="Подчеркнутый" style="text-decoration: underline; width:70px; " class="but" onmouseover="this.style.borderColor='red'" onmouseout="this.style.borderColor=''">
  <input type="button"  value="З" onclick="paste('[s]','[/s]')"  title="Зачеркнутый" style="text-decoration: line-through; width:70px; " class="but" onmouseover="this.style.borderColor='red'" onmouseout="this.style.borderColor=''">
  <input type="button"  value="Цитата" onclick="paste('[quote]','[/quote]')"  style="width:70px; "  class="but" onmouseover="this.style.borderColor='red'" onmouseout="this.style.borderColor=''"> {ADMINFILE}
  <br>
   <input type="button"  value="Код" onclick="paste('[code]','[/code]')"  style="width:70px; "  class="but" onmouseover="this.style.borderColor='red'" onmouseout="this.style.borderColor=''">
      <input type="button"  value="Ссылка" onclick="paste('[url=',']описание файла[/url]')"  style="width:70px; " class="but" onmouseover="this.style.borderColor='red'" title="Может быть заблокировано" onmouseout="this.style.borderColor=''">
   <input type="button"  value="Рис." onclick="paste('[img]','[/img]')"  style="width:70px;" class="but" onmouseover="this.style.borderColor='red'" onmouseout="this.style.borderColor=''">
        	<input type="button"  value="Влево" onclick="paste('[left]','[/left]')"  style="width:70px; " class="but" onmouseover="this.style.borderColor='red'" onmouseout="this.style.borderColor=''">
        	<input type="button"  value="Центр" onclick="paste('[center]','[/center]')"  style="width:70px; " onmouseover="this.style.borderColor='red'" class="but" onmouseout="this.style.borderColor=''">
    	<input type="button"  value="Вправо" onclick="paste('[right]','[/right]')"  style="width:70px; " onmouseover="this.style.borderColor='red'" class="but" onmouseout="this.style.borderColor=''">
	<br>
&nbsp;<select name="color" onChange="document.{FORM}.{TEXT}.focus();paste('[color='+this.form.color.options[this.form.color.selectedIndex].value+']','[/color]');this.selectedIndex=0;"  style="cursor: pointer">
<option style="color:black;" selected>Цвет шрифта</option>
<option style="color:darkred;"  value="darkred" >Тёмно-красный</option>
<option style="color:red;"  value="red" >Красный</option>
<option style="color:orange;"  value="orange" >Оранжевый</option>
<option style="color:brown;"  value="brown" >Коричневый</option>
<option style="color:yellow;"  value="yellow" >Жёлтый</option>
<option style="color:green;"  value="green" >Зелёный</option>
<option style="color:olive;"  value="olive" >Оливковый</option>
<option style="color:cyan;"  value="cyan" >Голубой</option>
<option style="color:blue;"  value="blue" >Синий</option>
<option style="color:darkblue;"  value="darkblue" >Тёмно-синий</option>
<option style="color:indigo;"  value="indigo" >Индиго</option>
<option style="color:violet;"  value="violet" >Фиолетовый</option>
<option style="color:white;" value="#FFFAFA"  >Белый</option>
<option style="color:black;"  value="black" >Чёрный</option>
	</select>
	&nbsp;<select name="font" onChange="document.{FORM}.{TEXT}.focus();paste('[font='+this.form.font.options[this.form.font.selectedIndex].value+']','[/font]');this.selectedIndex=0;"  style="cursor: pointer">
<option style="color:black;" selected>Шрифт</option>
<option style="font-family: arial" value="arial">Arial
<option style="font-family: verdana" value="verdana">Verdana
<option style="font-family: georgia" value="georgia">Georgia
<option style="font-family:'comic sans ms'" value="'comic sans ms'">Comic Sans Ms
<option style="font-family: tahoma" value="tahoma">Tahoma
<option style="font-family: impact" value="impact">Impact
	</select>
    	&nbsp;<select name="size" onChange="document.{FORM}.{TEXT}.focus();paste('[size='+this.form.size.options[this.form.size.selectedIndex].value+']','[/size]');this.selectedIndex=0;"  style="cursor: pointer">
 <option style="color:black;" selected>Размер шрифта</option>
 <option value="10">10px
<option value="12">12px
<option value="14">14px
<option value="16">16px
<option value="18">18px
<option value="20">20px
<option value="22">22px
<option value="24">24px
<option value="26">26px
<option value="28">28px
<option value="30">30px
<option value="32">32px
<option value="35">35px
<option value="38">38px
<option value="40">40px
<option value="45">45px
<option value="48">48px
<option value="52">52px
</select>
&nbsp;<select name="bgcolor" onChange="document.{FORM}.{TEXT}.focus();paste('[bgcolor='+this.form.bgcolor.options[this.form.bgcolor.selectedIndex].value+']','[/bgcolor]');this.selectedIndex=0;"  style="cursor: pointer">
<option style="color:black;" selected>Заливка</option>
<option style="color:darkred;"  value="darkred" >Тёмно-красный</option>
<option style="color:red;"  value="red" >Красный</option>
<option style="color:orange;"  value="orange" >Оранжевый</option>
<option style="color:brown;"  value="brown" >Коричневый</option>
<option style="color:yellow;"  value="yellow" >Жёлтый</option>
<option style="color:green;"  value="green" >Зелёный</option>
<option style="color:olive;"  value="olive" >Оливковый</option>
<option style="color:cyan;"  value="cyan" >Голубой</option>
<option style="color:blue;"  value="blue" >Синий</option>
<option style="color:darkblue;"  value="darkblue" >Тёмно-синий</option>
<option style="color:indigo;"  value="indigo" >Индиго</option>
<option style="color:violet;"  value="violet" >Фиолетовый</option>
<option style="color:white;"   >Белый</option>
<option style="color:black;"  value="black" >Чёрный</option>
</select>
</div>