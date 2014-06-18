function addEv(elem,type,handle)
{
handler=function (e)
{
	if (!e.target) {
	e.target = e.srcElement;
	};
	handle(e);
};
	if (elem.addEventListener)
	elem.addEventListener(type, handler, true)
	else if (elem.attachEvent)
	elem.attachEvent("on" + type, handler);
};
function getStyle(el, cssprop){
    if (window.getComputedStyle) 
    {//Normal
        if (cssprop == 'float') cssprop = 'cssFloat';
	    var css=window.getComputedStyle(el, '');
        return css[cssprop];
    }
    else
    {
        if (el.currentStyle)
        {//IE
            if (cssprop == 'float') cssprop = 'styleFloat';
            return el.currentStyle[cssprop];
        }
    }
};
function trim(str)
{
	var regB=/^\s+/;
	var regE=/\s+$/;
	var str1=str.replace(regE,"");
	var str2=str1.replace(regB,"");
	return str2;
};
function set4UA(obj)
{
	var patt=null;
	for (prop in obj)
	{
		patt=new RegExp(prop,"i");
		if (navigator.userAgent.search(patt)!=-1)
		{
			return obj[prop];
		};
	};
	return obj["default"];
};
function remEv(elem,type,handle)
{
	if (elem.removeEventListener)
	elem.removeEventListener(type, handler,true)
	else if (elem.detachEvent)
	elem.detachEvent("on" + type, handler);
};
function bindReady(handler){
	var called = false
	function ready() { // (1)
		if (called) return
		called = true
		handler()
	}
	if ( document.addEventListener ) { // (2)
		document.addEventListener( "DOMContentLoaded", function(){
			ready()
		}, false )
	} else if ( document.attachEvent ) {  // (3)

		// (3.1)
		if ( document.documentElement.doScroll && window == window.top ) {
			function tryScroll(){
				if (called) return
				if (!document.body) return
				try {
					document.documentElement.doScroll("left")
					ready()
				} catch(e) {
					setTimeout(tryScroll, 0)
				}
			}
			tryScroll()
		}

		// (3.2)
		document.attachEvent("onreadystatechange", function(){

			if ( document.readyState === "complete" ) {
				ready()
			}
		})
	}

	// (4)
    if (window.addEventListener)
        window.addEventListener('load', ready, false)
    else if (window.attachEvent)
        window.attachEvent('onload', ready)
    /*  else  // (4.1)
        window.onload=ready
	*/
};
function sendZapros(url,data,func)
{
	try{request=new XMLHttpRequest();}catch(trymicrosoft){try{request=new ActiveObject("Msxm12.XMLHTTP");}catch(othermicrosoft){try {request=new ActiveObject("Microsoft.XMLHTTP");}catch(failed){request=null;}}};
	request.open("POST",url,true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	var proc=func;
	request.onreadystatechange=function (){if(request.readyState==4){	proc(request.responseText);}};
	request.send(data);
};
function in_array(el,arr)
{
	for (var eA in arr)
	{
		if(el==arr[eA])
		{
			
			return true;
		}
	};
	return false;
};
function _(id)
{
	return document.getElementById(id);
};
function bilet1()
{
	//отправляет запрос на места для прямого билета
	var point1=_("inp1").value;
	var point2=_("inp2").value;
	if(!in_array(point1,oTT[0]))
	{
		alert("Выберите пункт отправления из выпадающего списка");
		_("inp1").focus();
		return false;
	};
	if(!point2)
	{
		alert("Выберите пункт прибытия из выпадающего списка");
		_("inp2").focus();
		return false;
	}; 
	var date1=_("inp3").value;
	if(date1)
	{
		sendZapros('/routedat/getplaces/?point1='+encodeURI(point1)+'&point2='+encodeURI(point2)+'&date='+date1+'','',test);
	}else
	{
		alert("Выберите дату отправления");
		_("inp3").focus();
	};
};
function bilet2()
{
	//отправляет запрос на места для обратного билета
	var point1=_("inp8").value;
	var point2=_("inp9").value;
	if(!point1)
	{
		alert("Выберите пункт отправления из выпадающего списка");
		_("inp8").focus();
		return false;
	};
	if(!point2)
	{
		alert("Выберите пункт прибытия из выпадающего списка");
		_("inp9").focus();
		return false;
	}; 
	var date1=_("inp3").value;
	var date2=_("inp10").value;
	if(date2)
	{
		/*if(date2<date1)
		{
			alert("Дата возвращения не может быть раньше даты отправления: "+date1);
			return false;
		};*/
		sendZapros('/routedat/getplaces/?point1='+encodeURI(point1)+'&point2='+encodeURI(point2)+'&date='+date2+'','',test2);
	}else
	{
		alert("Выберите дату отправления");
		_("inp10").focus();
	};
};
function getF1()
{
	//отображает обратный билет
	var func=function (e)
				{
					var inp=document.getElementById("inp8");
					var point1=_("inp1").value;
					var point2=_("inp2").value;
					if(!point1)
					{
						alert("Выберите пункт отправления из выпадающего списка");
						return false;
					};
					if(!point2)
					{
						alert("Выберите пункт прибытия из выпадающего списка");
						return false;
					}; 
					_("inp8").value=_("inp2").value;
					_("inp9").value=_("inp1").value;
					_("treys1").style.display="none";
					_("treys2").style.display="block";
					_("inpplaces2").value=_("inpplaces1").value;
					
				}
	return func;
};
function outPrice()
{
	//var strPlaces=_('inpplaces1').value;
	var numPlaces=_('inpplaces1').value;
	var price=numPlaces*aTarifs[1];
	if(_('check2').checked)
	{
		_('rticketstr').style.display='none';
		_('rticketitog').style.display='none';
		
		
	}else
	{
	
		//есть обратный билет
		price+=_('inpplaces2').value*aTarifs[2];
		
		
	};
	
	var oText=document.createTextNode(price + " грн.");
	_("outprice").appendChild(oText);
	
};
function getF2()
{
	//отображает личные данные
	var tT=document.getElementById("persona");
	var func=function (e)
				{
					
					_("treys2").style.display="none";
					_("persona").style.display="block";
				
				}
	return func;
};
function getF3()
{
	//отображает итог
	var tT=_("resume");
	
	function checkPersonalData()
	{
		var dFIO=_("inp5").value;
		//var patt1=new RegExp("[\\sа-яА-Я-]*");
		//var aMatches=patt1.exec(dFIO);
		if(dFIO=="")
		{
			alert("Заполните поле ФИО");
			return false;
		}
		else
		{
			dFIO=trim(_("inp7").value);
			patt1=/[0-9+()-]*/;
			aMatches=patt1.exec(dFIO);
			if((dFIO=="")||(aMatches[0]!=dFIO))
			{
				alert("В поле Телефон недопустимые символы");
				return false;
			}
			else
			{
				dFIO=trim(_("inp6").value);
				patt1=/[_а-яА-Яa-zA-Z0-9\.-]*@[_а-яА-Яa-zA-Z0-9\.-]*/;
				aMatches=patt1.exec(dFIO);
				if((dFIO=="")||(aMatches[0]!=dFIO))
				{
					alert("В поле email недопустимые символы");
					return false;
				}
				else
				{
					return true;
				};
			};
		};
		
	};
	
	function showData(idinp,idspan)
					{
						var oTextN=document.createTextNode(_(idinp).value);
						_(idspan).appendChild(oTextN);
					
					}
	var func= function (e)
				{
					if(checkPersonalData())
					{
					_('persona').style.display='none';
					_('resume').style.display="block";
					outPrice();
					showData("inp1","rpoint1");
					showData("inp2","rpoint2");
					showData("inp3","rdate1");
					showData("inpplaces1","rplaces1");
					showData("inp8","rpoint3");
					showData("inp9","rpoint4");
					showData("inp10","rdate2");
					showData("inpplaces2","rplaces2");
					showData("inp5","rfio");
					showData("inp7","rphone");
					showData("inp6","remail");
					};
				}
	return func;
};
function getF4()
{
	function getFieldValue(id)
	{
		var inp=document.getElementById(id);
		if(inp.value)
		{
			return inp.name+"="+encodeURI(inp.value)+"&";
		}else
		{
			return "";
		}
	};
	function proc2(text)
	{
		var oText=document.createTextNode(text+" Ваш счет действителен в течение 48 часов после заказа. По истечении срока неоплаченные места будут выставлены на продажу.");
		var oOut=_("outmessage");
		oOut.appendChild(oText);
		var butt=_("checkbutt4");
		butt.style.display="none";
		
	};
	return function()
	{
		var strData="";
		strData+=getFieldValue("inp1");
		strData+=getFieldValue("inp2");
		strData+=getFieldValue("inp3");
		strData+=getFieldValue("inp5");
		strData+=getFieldValue("inp6");
		strData+=getFieldValue("inp7");
		strData+=getFieldValue("inp8");
		strData+=getFieldValue("inp9");
		strData+=getFieldValue("inp10");
		strData+=getFieldValue("inpplaces1");
		strData+=getFieldValue("inpplaces2");
		strData+=getFieldValue("id_reys1");
		strData+=getFieldValue("id_reys2");
		strData+=getFieldValue("id_route1");
		strData+=getFieldValue("id_route2");
		strData+=getFieldValue('id_kod');
		var check2=document.getElementById("check2");
		if(check2.hasAttribute("checked"))
		{
			strData+="rticket=1&";
		}
		else
		{
			strData+="rticket=0&";
		};
		strData+="act=getdata";
		//strData=strData.slice(0,-1);
		sendZapros("/mainform/getdata",strData,proc2);
		return true;
	};
};

function getOneWayTicket(id1,id2)
{
	var okno=_(id1);
	var blind=_(id2);
	var funcDop=getF1();
	function initButton()
	{
		var but1=_("but-yes");
		addEv(but1,"click",yes);
		but1=_("but-no");
		addEv(but1,"click",no);
	};
	initButton();
	function show()
				{
					var sSize=screenSize();
					var x0=sSize.w/2-150;
					var y0=sSize.h/2-100+document.body.scrollTop;
					okno.style.top=y0+"px";
					okno.style.left=x0+"px";
					okno.style.display="block";
					blind.style.top=document.body.scrollTop;
					blind.style.display="block";
				};
	function hide()
				{
					okno.style.display="none";
					blind.style.display="none";
					
					
				};
	function no()
				{
					var inp=document.getElementById("check2");
					inp.setAttribute("checked","on");
					toPersona();
					hide();
				};
	function yes()
				{
					var inp=document.getElementById("check2");
					inp.checked=false;
					if(inp.hasAttribute("checked"))
					{
						inp.removeAttribute("checked");
					};
					funcDop();
					hide();
				};			
	return {"show":show,
			"hide":hide,
			"check":function checkOneWayTicket(e)
					{
						if(e.target.checked)
						{
							show();
						}else
						{
							hide();
						};
						
					}
			}
};


function inpReset(id)
{
	var inp=document.getElementById(id);
	inp.value="";
	
};
function inpSetValue(id,value)
{
	var inp=document.getElementById(id);
	inp.value=value;
};
function resetForm()
{
	var aIds=new Array("inp1","inp2","inp3","inp5","inp6","inp7","inp8","inp9","inp10","inpplaces1","inpplaces2");
	for (var i = 0; i < aIds.length; i++)
	{
		inpReset(aIds[i]);
	};
	inpSetValue("id_route1",-1);
	inpSetValue("id_route2",-1);
	inpSetValue("id_reys1",-1);
	inpSetValue("id_reys2",-1);
	_("treys2").style.display="none";
	_("resume").style.display="none";
	_("persona").style.display="none";
	_("treys1").style.display="block";
	location.reload();
	
};
function toPersona()
{
	_("treys1").style.display="none";
	_("treys2").style.display="none";
	_("persona").style.display="block";
};
function test(text)
{
	//отображает автобус для прямого билета
	//alert(text);
	eval(text);
		if(tarif1)
		{
			var inpRoute=document.getElementById("id_route1");
			inpRoute.value=idRoute;
			inpRoute=document.getElementById("id_reys1");
			inpRoute.value=idReys;
			
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
		if(tarif1)
		{
			var inpRoute=document.getElementById("id_route2");
			inpRoute.value=idRoute;
			inpRoute=document.getElementById("id_reys2");
			inpRoute.value=idReys;
			
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