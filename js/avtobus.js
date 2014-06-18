function createAvtobus(iInput,iPlaces,typeAvto,id,button)
{
	var inp=iInput;
	var places=iPlaces;
	var type=typeAvto;
	var avto=_(id);
	if(avto)
	{
		avto.parentNode.removeChild(avto);
	};
	avto=document.createElement("div");
	var pTypes=new Array("free","reserved","reserved");
	var hButton=button;
	avto.id=id;
	function booking(event)
	{
		var strClass=event.target.className;
		var strId=event.target.id;
		if((strClass.indexOf("place")!=-1)&&(strId.slice(-2)!="p0"))
		{
			var text1=inp.value;
			switch(strClass)
			{
				case "place-free":
					if(text1!="")
					{
						inp.value+=",";
					};
					inp.value+=event.target.firstChild.nodeValue;
					event.target.className="place-booked";
					event.target.title="нажмите,чтобы отменить";
					button.style.display="inline";
				break;
				case "place-booked":
					text2=event.target.firstChild.nodeValue;
					var patt=new RegExp(","+text2+",");
					var textOut=text1.replace(patt,",");
					patt=new RegExp("(^|,)"+text2+"(,|$)");
					textOut=textOut.replace(patt,"");
					inp.value=textOut;
					event.target.setAttribute("class","place-free");
					if(textOut=="")
					{
						button.style.display="none";
					};
				break;
			}
		}
	};
	function createPlace(oPlace,pref)
	{
		var place=document.createElement("div");
		//place.setAttribute("class","place-"+oPlace.type);
		place.className="place-"+oPlace.type;
		if(oPlace.type=="free")
		{
			place.title="нажмите чтобы выбрать";
		};
		//place.setAttribute("id",pref+"_p"+oPlace.num);
		place.id=pref+"_p"+oPlace.num;
		//place.setAttribute("style","top:"+oPlace.y+"px;left:"+oPlace.x+"px;");
		place.style.top=oPlace.y+"px";
		place.style.left=oPlace.x+"px";
		if(!((oPlace.num==0)||(oPlace.type=="reserved")))
		{
			var numPlace=document.createTextNode(oPlace.num);
			place.appendChild(numPlace);
			//place.setAttribute("class","place-"+oPlace.type);
		};
		return place;
	};
	var koordsI=absPosition(inp);
	var podlozhka = document.getElementById("podlozhka");
	var koordsP=absPosition(podlozhka);
	var y0=koordsI.y-koordsP.y+100;
	var avtoClassName="avtobus";
	var dx=0;
	switch(typeAvto)
	{
		case "MAN":
		avtoClassName+=" big-avto";
		//var dx=250;
		break;
		case "GAZEL":
		avtoClassName+=" small-avto";
		//var dx=50;
		break;
	};
	var x0=koordsI.x-koordsP.x-dx;
	//avto.setAttribute("class",avtoClassName);
	avto.className=avtoClassName;
	//avto.setAttribute("style","position:absolute;top:"+y0+"px;left:"+x0+"px");
	avto.style.position="absolute";
	avto.style.top=y0+"px";
	avto.style.left=x0+"px";
	
	addEv(avto,"click",booking,true);
	var nP=1;
	for(nPlace in places)
	{
		nP=nPlace+1;
		tPlace={"x":places[nPlace].x,"y":places[nPlace].y,"num":nPlace,"type":places[nPlace].type};
		place=createPlace(tPlace,id);
		avto.appendChild(place);
		
	}
	if(inp==inp.parentNode.lastChild)
	{
		inp.parentNode.appendChild(avto);
	}
	else
	{
		inp.parentNode.insertBefore(avto,inp.nextSibling);
	};
	return {"show" : function ()
					{
						avto.style.display="block";
					},
			"hide":function()
					{
						avto.style.display="none";
					},
			"initPlaces":function (dPlaces)
					{
						inp.value="";
						var listC=avto.childNodes;
						var NNN=listC.length;
						for(var i=0;i<NNN;i++)
						{
							//alert(listC[i].firstChild);
							if(listC[i].firstChild)
							{
							var tText=listC[i].firstChild.nodeValue;
							if((1<=tText)&&(tText<56))
							{
								listC[i].setAttribute("class","place-"+pTypes[dPlaces[tText-1]]);
							}
							}
						}
					},
			"getObj":function ()
					{return avto;}
			}
			
			
};
