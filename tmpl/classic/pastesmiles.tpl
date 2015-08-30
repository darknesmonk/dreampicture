  <script type="text/javascript" language="JavaScript" >
   var smdiv;
  function toSmiles(data)
  {
  if(data=="sqlerr") {showst('Невозможно получить смайлы, ошибка БД.','red');}
  smdiv.innerHTML=data;
  }
  
  function getsm()
  {
   smdiv=document.getElementById('smiles');
  if(!smdiv.style.display) {fadeOut(smdiv,100); return false;}
  if(smdiv.innerHTML=='')
  {
  var newimg=new Image();
  newimg.src='{HTTPSERVER}/img/loading.gif';
  newimg.style.border='0px';
  smdiv.appendChild(newimg);
    fadeIn(smdiv,0);
    sendRequest('/?act=pastesmiles','page=1','POST',18);
  }
  else
  {
fadeIn(smdiv,75);
  }
  
  }
  function newpagesm(t,p)
  {
  sendRequest('/?act=pastesmiles','page='+p,'POST',18);
  var newimg=new Image();
  newimg.src='/img/loading1.gif';
  newimg.style.border='0px';
 t.parentNode.replaceChild(newimg,t);
  }
  
  function img(text)
  {
  form = document.{FORM};
  if(form.{TEXT}.value=='Сообщение') form.{TEXT}.value='';
document.getElementById('smiles').style.display='none';
form.{TEXT}.value += text;
form.{TEXT}.focus();
  }
  </script>
<div align="center" class="text2"><a href="javascript://" onclick="getsm()">Смайлики 
<img src="/img/smiles/icon_smi.gif" border="0" alt="Смайлики" title="Открыть смайлики"></a></div>
<div id="smiles" style="display: none; visibility: hidden;" align="center"></div>