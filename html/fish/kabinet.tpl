<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>{TITLE}</title>
<link rel='stylesheet' href='/css/kabinet.css'>
<script src="/js/bindreadykab.js"></script>
<script src="/js/koords.js"></script>
<script>
var oTool=getFManager();
var curCell=null;
	
function paidOk(text)
{
	if(text.substr(0,2)=="OK")
	{
		var oSpan=_("sp"+text.slice(3));
		oSpan.removeChild(oSpan.firstChild);
		var oText=document.createTextNode("1");
		oSpan.appendChild(oText);
		var oBut=_("butt"+text.slice(3));
		oBut.style.display="none";
	}else
	{
		alert("Ошибка");
	};
};
function ready0()
{
	
	addEv(_("bFreePlace"),"click",oTool.fClick2);
	addEv(_("bChangeAvto"),"click",oTool.fClick1);
	addEv(_("bAddReys"),"click",addReys);
	var aTables=document.getElementsByTagName("table");
	for (var i in aTables)
	{
		if(aTables[i].id&&(aTables[i].id.slice(0,9)=="tkalendar"))
		{
			addEv(aTables[i],"click",getFReyses(aTables[i].id,oTool));
		};
	};
};
function getFManager()
{
	var out=null;
	function fAnswerReady(text)
		{
			if(out)
			{
				var aSups=out.getElementsByTagName("sup");
				if(aSups.length)
				{
					aSups[0].removeChild(aSups[0].firstChild);
					var oText=document.createTextNode(text);
					aSups[0].appendChild(oText);
				};
			}
			else
			{
				console.error("out is null");
			};
		};
	return {"fClick1":function(e)
				{
					sendZapros('/kabinet/putchangeavtobus','idroute='+_('idroute').value+'&date='+_('datereys').value,fAnswerReady);
				},
			"fClick2":function(e)
				{
					sendZapros('/kabinet/putfreeplaces','idroute='+_('idroute').value+'&date='+_('datereys').value+'&places='+_('places').value,fAnswerReady);
				},
			"setOut":function (obj)
				{
					out=obj;
				}
		}
};
function getFReyses(id,objMan)
{
	var idKalend=id;
	var oManTool=objMan;
	return function (e)
	{
		//alert(e.target.tagName);
		var okno=_("okno");
		var sSize=screenSize();
		var x0=sSize.w/2-300;
		var y0=sSize.h/2-200+document.body.scrollTop;
		okno.style.top=y0+"px";
		okno.style.left=x0+"px";
		okno.style.display="block";
		var num="";
			var month="";
		switch(e.target.tagName)
		{
			
			case "TD":
				date=e.target.getElementsByTagName("span")[0].firstChild.nodeValue;
				var aTemp=e.target.parentNode.parentNode.parentNode.id.split("_");
				oManTool.setOut(e.target);
				month=aTemp[1];
				curCell=e.target;
			break;
			case "SUP":
				date=e.target.parentNode.getElementsByTagName("span")[0].firstChild.nodeValue;
				var aTemp=e.target.parentNode.parentNode.parentNode.parentNode.id.split("_");
				oManTool.setOut(e.target.parentNode);
				month=aTemp[1];
				curCell=e.target.parentNode;
			break;
			case "SPAN":
				date=e.target.firstChild.nodeValue;
				oManTool.setOut(e.target.parentNode);
				var aTemp=e.target.parentNode.parentNode.parentNode.parentNode.id.split("_");
				month=aTemp[1];
				curCell=e.target.parentNode;
			break;
			
		};
		if(date.length==1)
		{
			date="0"+date;
		};
		_("datereys").value="2013-"+month+"-"+date;
		_("idroute").value=idKalend.slice(9);
		var oA=document.createElement("a");
		oA.href="/kabinet/getreysdata/?date=2013-"+month+"-"+date+"&idroute="+idKalend.slice(9);
		oA.target="_blank";
		var oText=document.createTextNode("Данные рейса");
		oA.appendChild(oText);
		if(_("forlinks").firstChild)
		{
			_("forlinks").removeChild(_("forlinks").firstChild);
		};
		_("forlinks").appendChild(oA);
	};
};
function addReys()
{
	sendZapros("/kabinet/putaddreys",'idroute='+_('idroute').value+'&date='+_('datereys').value+"&typeavto="+_("inptypeavto").value,addedReys);
	
};
function addedReys(text)
{
	eval(text);
	if(oAnswer)
	{
		if(oAnswer.kod!=="0")
		{
			alert(oAnswer.message);
		}
		else
		{
			
			curCell.className="day-act";
			var oSup=document.createElement("sup");
			var oText=document.createElement("br");
			curCell.insertBefore(oText,curCell.firstChild);
			oText=document.createTextNode(oAnswer.message);
			oSup.appendChild(oText);
			curCell.insertBefore(oSup,curCell.firstChild);
		};
	}
	else
	{
		console.error("oAnswer is null");
	};
};
function funcT(text)
{
	alert(text);
};
bindReady(ready0);
</script>
</head>
<body>
<ul class="mainmenu"><li><a href="/kabinet/getroutedata">Управление рейсами</a></li><li><a href="/kabinet/getbooks">Управление заказами</a></li></ul>
{CONTENTS}
<div id="okno">номер маршрута: <input id="idroute" readonly="on"> дата:<input id="datereys" readonly="on"><br> места:<input id="places"> <input type="button" value="Освободить места" id="bFreePlace"><br><input type="button" value="Изменить тип автобуса" id="bChangeAvto"><br>
<select name="typeavto" id="inptypeavto">
<option value="0">Автобус</option>
<option value="3">Маршрутка</option>
</select>
<input type="button" value="Добавить рейс" id="bAddReys">
<br><br><input type="button" value="закрыть" onClick="_('okno').style.display='none'"><div id="forlinks"></div></div>

</body>
</html>