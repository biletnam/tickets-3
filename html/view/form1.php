<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Заказ билетов</title>
<link rel="stylesheet" href="/css/main.css">
<!--[if IE]>
<link rel="stylesheet" href="/css/for-ie.css">
<![endif]-->
<script src="/js/places.js"></script>
<script src="/js/places2.js"></script>
<script src="/js/agencys.js"></script>

<script src="/js/points.js"></script>
<script src="/js/bindready.js"></script>
<script src="/js/kalendar.js"></script>
<script src="/js/koords.js"></script>
</head>
<body>
 <?php print($this->getScriptField("point1",$type));?>
<script>
var curHost=window.location.host;
var oAutoDop=null;
var oO=null;
var aTarifs=new Array();
function ready1()
{
	
	//oAutoDop=getAutoDop("inp1","inp2","inp8","inp9",oTT);
	var fFill=getSPoints('inp1','inp2','inp8','inp9','dinp1','dinp2','dinp8','dinp9',oTT[1],oTT[2]);
	var oWT=getOneWayTicket("onewayticket","blind");
	inp1=document.getElementById("check2");
	addEv(inp1,'click',oWT.check,true);
	
	inp1=document.getElementById("checkbutt1");
	//addEv(inp1,'click',getF1(),true);
	addEv(inp1,'click',oWT.show,true);
	
	inp1=document.getElementById("checkbutt2");
	addEv(inp1,'click',getF2(),true);
	inp1=document.getElementById("checkbutt3");
	addEv(inp1,'click',getF3(),true);
	inp1=document.getElementById("checkbutt4");
	addEv(inp1,'click',getF4(),true);
	
	inp1=document.getElementById("bb9");
	addEv(inp1,'click',resetForm,true);
	inp1=document.getElementById("bb10");
	addEv(inp1,'click',resetForm,true);
	inp1=document.getElementById("bb11");
	addEv(inp1,'click',resetForm,true);
	inp1=document.getElementById("bb12");
	addEv(inp1,'click',resetForm,true);
	
	inp1=document.getElementById("butt7");//кнопка выбрать места в прямом билете
	addEv(inp1,'click',bilet1,true);
	inp1=document.getElementById("butt8");//кнопка выбрать места в обратном билете
	addEv(inp1,'click',bilet2,true);
	inp1=document.getElementById("inp4");
	addEv(inp1,'change',getFdeti(),true);
	inp1=document.getElementById("but_for_agency");
	oO=getOkno("for_agency");
	addEv(inp1,"click",oO.show);
	
	createKalendar("inp3","tkalendar_inp3","inp1","inp2","avto1");
	createKalendar("inp10","tkalendar_inp10","inp8","inp9","avto2");
	
	var body=document.getElementsByTagName('body')[0];
	addEv(body,'click',hideAll);
	function hideAll()
	{
		var listAll=new Array('tkalendar_inp3','tkalendar_inp10','dinp1','dinp2','dinp8','dinp9');
		var oO=null;
		for (numO in listAll)
		{
			oO=_(listAll[numO]);
			oO.style.display="none";
		};
	};
	
};
bindReady(ready1);

</script>

<center>
<div class="main">

<img src="/pics/dnepropetrovsk-perevozki-krym.jpg" width="150" height="100" alt="dnepropetrovsk-perevozki-krym" align="left"><div><h2 style="margin:5px 0px 5px 0px">Бронирование билетов на курорты Украины</h2><p style="width:100%;font-size:13px;font-weight:900;text-shadow:none;color:#90b3c4;">Техническая поддержка: +380 (66) 577-58-58 Справочная служба: +380 (97) 291-44-70, +380 (95) 688-68-78</p><p style="margin:0px;width:100%;text-align:right"><!--<a href="http://777tur.com" target="_blanc" style="font-weight:900;color:#0045b6;text-decoration:none">Главная &laquo;777 тур&raquo;</a>--><input type="button" id="but_for_agency" value="для турагентств" style="margin-left:17px"></p></div>

<p style="margin:0px 0px 3px 0px"><b> (детям и студентам скидка 10%)</b>  </p>
<?php if(stripos($_SERVER["HTTP_USER_AGENT"],"msie")!==false){ print("<p style='color:red'>К сожалению, модуль не работает на некотрых версиях Internet Explorer. Пожалуйста, воспользуйтесь другим браузером. Например: Google Chrome, Mozilla Firefox, Opera</p>");}?>

<div id="okno">
<div id="podlozhka">
<table class="reys" id="treys1">
<FORM ACTION="<?php print($this->action);?>"METHOD="<?php print($this->method);?>" ENCTYPE="<?php print($this->enctype);?>">
<input type="hidden" name="act" value="getform">
<tr><td><?php 
print($this->fields["point1"]->getHtmlLabel()." ");
?></td><td class="seredina">&nbsp;</td><td><?php 
print($this->fields["point2"]->getHtmlLabel()." ");
?>
<input name="route1" type="hidden" id="id_route1">
<input name="reys1" type="hidden" id="id_reys1">
</td></tr>
<tr><td>
<?php
print($this->getHtmlField("point1",$type));?>
</td><td class="seredina">&nbsp;</td><td>
<?php
print($this->getHtmlField("point2",$type));
?></td></tr>
<tr>
<td style="text-align:right">
<?php
print($this->fields["date1"]->getHtmlLabel()." ");
print($this->getHtmlField("date1",$type));
?><br>
<input type="button" value="Очистить форму" style="margin-top:25px;" id="bb9">
</td><td class="seredina">&nbsp;</td>
<td>
<div style="width:29px;float:right">
<?php
print($this->fields["lgoty"]->getHtml($type));
?>
</div>
<div style="width:250px;float:right">
<?php
print($this->fields["lgoty"]->getHtmlLabel()." ");
?>
</div>


</td>
</tr><tr style="height:200px"><td colspan=3>&nbsp;</td></tr>

<tr><td COLSPAN=2 style="padding-top:15px;text-align:left"><input type="button" value="Выбрать места" id="butt7">&nbsp;&nbsp;&nbsp;&nbsp;  Тариф: <span id="outtarif1"></span>

</td><td style="text-align:right"><div id="cont-deti"><?php
print($this->fields["deti"]->getHtmlLabel()." ");
print($this->getHtmlField("deti",$type));
?></div>
</td>
</tr>
<tr><td COLSPAN=3 style="padding-top:15px;text-align:left">
<?php 
print($this->fields["places1"]->getHtmlLabel()." ");
print($this->getHtmlField("places1",$type));?> <input type="button" value="Все правильно" id="checkbutt1">
<div class="avtohelp"><div><div class="eplace-reserved"></div> - занятое место </div> <div><div class="eplace-free"></div> - свободное место</div> <div> <div class="eplace-booked"></div> - выбранное Вами место</div></div>
</td></tr>
<tr><td COLSPAN=3 style="height:220px;padding-top:15px;text-align:center">&nbsp;</td></tr>
</table>

<!--                обратный билет                   -->


<table class="reys" id="treys2">
<caption>Обратный билет</caption>
<tr><td><?php 
print($this->fields["point3"]->getHtmlLabel()." ");
?></td><td class="seredina">&nbsp;</td><td><?php 
print($this->fields["point4"]->getHtmlLabel()." ");
?></td></tr>
<tr><td>
<?php
print($this->getHtmlField("point3",$type));?>
</td><td class="seredina">&nbsp;</td><td>
<?php
print($this->getHtmlField("point4",$type));
?>
<input name="route2" type="hidden" id="id_route2">
<input name="reys2" type="hidden" id="id_reys2">

</td></tr>
<tr>
<td style="text-align:right">
<?php
print($this->fields["date2"]->getHtmlLabel()." ");
print($this->getHtmlField("date2",$type));
?>
<br>
<input type="button" value="Очистить форму" style="margin-top:25px;" id="bb10">
</td><td class="seredina">&nbsp;</td>
<td>
<div style="width:29px;float:right;margin-right:50px">

<?php
print($this->fields["rticket"]->getHtml($type));
?>
</div>
<div style="width:125px;float:right;">
<?php
print($this->fields["rticket"]->getHtmlLabel()." ");
?>
</td>
</tr>
<tr style="height:190px"><td colspan=3>&nbsp;</td></tr>
<tr><td COLSPAN=3 style="padding-top:15px;text-align:left"><input type="button" value="Выбрать места" id="butt8">&nbsp;&nbsp;&nbsp;&nbsp; Тариф: <span id="outtarif2"></span></td></tr>

<tr><td COLSPAN=3 style="padding-top:15px;text-align:left">
<?php 
print($this->fields["places2"]->getHtmlLabel()." ");
print($this->getHtmlField("places2",$type));?> <input type="button" value="Все правильно" id="checkbutt2">
<div class="avtohelp"><div><div class="eplace-reserved"></div> - занятое место </div> <div><div class="eplace-free"></div> - свободное место</div> <div> <div class="eplace-booked"></div> - выбранное Вами место</div></div>
</td></tr>

<tr><td COLSPAN=3 style="height:220px;padding-top:15px;text-align:center">&nbsp;</td></tr>
</table>


<!--                     Личные данные                    -->
 

<table id="persona"><caption>Личные данные</caption>
<tr><td class="left-col">
<?php
print($this->fields["fio"]->getHtmlLabel()." ");
?></td><td class="right-col"><?php
print($this->getHtmlField("fio",$type));
?>
</td></tr><tr><td class="left-col">
<?php
print($this->fields["phone"]->getHtmlLabel()." ");
?></td><td class="right-col"><?php
print($this->getHtmlField("phone",$type));
?>
</td></tr><tr><td class="left-col">
<?php
print($this->fields["email"]->getHtmlLabel()." ");
?></td><td class="right-col"><?php
print($this->getHtmlField("email",$type));
?>
</td></tr>
<tr><td colspan=2 style="text-align:center">
<input type="button" value="Все правильно" id="checkbutt3"> <input type="button" value="Очистить форму" id="bb11">

</td></tr>
</table>
</FORM>
<!--             Итог                        -->

<div id="resume" style="text-align:left;font-weight:900">
<div style="text-decoration:underline;width:100%;text-align:center;font-size:120%">Итог</div>
<div style="width:100%">Откуда: <span id="rpoint1"></span>, Куда: <span id="rpoint2"></span>, Когда: <span id="rdate1"></span>, Места: <span id="rplaces1"></span></div>
<div style="width:100%" id="rticketstr">Обратный билет:</div>
<div style="width:100%" id="rticketitog">Откуда: <span id="rpoint3"></span>, Куда: <span id="rpoint4"></span>, Когда: <span id="rdate2"></span>, Места: <span id="rplaces2"></span></div>
<div style="width:100%">ФИО: <span id="rfio"></span>, Телефон: <span id="rphone"></span>, Email: <span id="remail"></span></div>
<div style="width:100%">Стоимость билетов: <span id="outprice"></span></div>
<div style="width:100%" id="outmessage"></div>
<div style="width:100%;text-align:center"><input type="button" value="Заказать билет" id="checkbutt4"> <input type="button" value="Очистить форму" id="bb12"></div>
</div>




</div>

</div>

</div>
</center>
<div>

</div>

<script src="/js/avtobus.js"></script>
<div id="autodop1"></div>
<div id="blind"></div>
<div id="onewayticket"><div style="width:100%;font-size:200%;letter-spacing:3px;margin-bottom:25px">Вам нужен обратный билет?</div><div style="width:100%;text-align:center;margin-top:5px"><input type="button" value="Да" id="but-yes"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" value="Нет" id="but-no"></div></div>
<div id="for_agency">
<?php print($this->fields['kodagency']->getHtmlLabel()." ".$this->getHtmlField('kodagency',$type));?><br>
<input type="button" value="готово" onClick="oO.hide();">
</div>

<script>
function test(text)
{
	//отображает автобус для прямого билета
	//alert(text);
	eval(text);
		if(aPlaces)
		{
			var oI1=document.getElementById("inpplaces1");
			var but1=document.getElementById("checkbutt1");
			if(typeAvtobus==3)
			{var ttA="GAZEL";
			var tP=places1;
			}else
			{
			var ttA="MAN";
			var tP=places2;
			};
			avto1=createAvtobus(oI1,tP,ttA,"avto1",but1);

			avto1.initPlaces(aPlaces);
			var okno=document.getElementById("okno");
			/*if((navigator.userAgent.indexOf("Chrome")!=-1)||(navigator.userAgent.indexOf("Safari")!=-1))
					{
						okno.style.height="580px";
					}
					else
					{
						okno.style.height="570px";
					};
			*/
			okno.style.height=set4UA({"firefox":"820px","opera":"820px","chrome":"830px","safari":"830px","msie":"820px"});
			var inpRoute=document.getElementById("id_route1");
			inpRoute.value=idRoute;
			inpRoute=document.getElementById("id_reys1");
			inpRoute.value=idReys;
			var inp1=document.getElementById("inp1");
			inp1.setAttribute("readonly",1);
			inp1=document.getElementById("inp2");
			inp1.setAttribute("readonly",1);
			inp1=document.getElementById("inp3");
			inp1.onfocus=function (){return false;};
			var oText=document.createTextNode(tarif1+" грн.")
			var span=document.getElementById("outtarif1");
			aTarifs[1]=tarif1;
			while(span.firstChild)
			{
				span.removeChild(span.firstChild);
			};
			span.appendChild(oText);
			
		}else
		{
			alert("такого маршрута нет");
		}
	
};
function test2(text)
{
	//отображает автобус для обратного билета
	eval(text);
	//if(oAutoDop.fTestRoutes(document.getElementById("id_route1").value,idRoute))
	//{
		if(aPlaces)
		{
			var oI2=document.getElementById("inpplaces2");
			var but1=document.getElementById("checkbutt2");
			if(typeAvtobus==3)
			{var ttA="GAZEL";
			var tP=places1;
			}else
			{
			var ttA="MAN";
			var tP=places2;
			};
			avto2=createAvtobus(oI2,tP,ttA,"avto2",but1);
			avto2.initPlaces(aPlaces);
			var okno=document.getElementById("okno");
			/*if((navigator.userAgent.indexOf("Chrome")!=-1)||(navigator.userAgent.indexOf("Safari")!=-1))
					{
						okno.style.height="620px";
					}
					else
					{
						okno.style.height="600px";
					};
			*/
			okno.style.height=set4UA({"firefox":"870px","opera":"870px","chrome":"880px","safari":"880px","msie":"870px"});
			var inpRoute=document.getElementById("id_route2");
			inpRoute.value=idRoute;
			inpRoute=document.getElementById("id_reys2");
			inpRoute.value=idReys;
			var inp1=document.getElementById("inp8");
			inp1.setAttribute("readonly",1);
			inp1=document.getElementById("inp9");
			inp1.setAttribute("readonly",1);
			inp1=document.getElementById("inp10");
			inp1.onfocus=function (){return false;};
			var oText=document.createTextNode(tarif1+" грн.")
			var span=document.getElementById("outtarif2");
			aTarifs[2]=tarif1;
			while(span.firstChild)
			{
				span.removeChild(span.firstChild);
			};
			span.appendChild(oText);
		}else
		{
			alert("такого маршрута нет");
		}
	//};
};
var avto1=null;
var avto2=null;
</script>
</body>
</html>