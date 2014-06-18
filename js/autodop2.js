
function getAutoDop(idInp1,idInp2,idInp3,idInp4,oTownsI)
{
	var inp1=document.getElementById(idInp1);
	var inp2=document.getElementById(idInp2);
	var inp3=document.getElementById(idInp3);
	var inp4=document.getElementById(idInp4);
	
	var oTowns=oTownsI;
	var contDiv=document.getElementById("autodop1");
	var podlozhka=document.getElementById("podlozhka");
	var num1=0;
	var testNum1=1;
	var num2=2;
	var num3=2;
	var num4=1;
	
	function fAutoDop(aT1,inp0,oDiv)
	{
		var tTowns = aT1;
		var podlozhka=document.getElementById("podlozhka");
		while (oDiv.firstChild)
		{
			oDiv.removeChild(oDiv.firstChild);
		};
		if(inp0.value.length>0)
		{
			var num=0;
			text1=inp0.value;
			numT=text1.length;
			var patt1=new RegExp(text1,"i");
			for (numTown in tTowns)
			{
				textTown=tTowns[numTown];
				
				if(textTown.search(patt1)===0)
				{
					oDiv2=document.createElement("div");
					oSpan=document.createElement("span");
					oSpan.setAttribute("class","sp1");
					oText=document.createTextNode(textTown.substring(0,numT));
					oSpan.appendChild(oText);
					oDiv2.appendChild(oSpan);
					oSpan=document.createElement("span");
					oSpan.setAttribute("class","sp2");
					oText=document.createTextNode(textTown.slice(inp0.value.length));
					oSpan.appendChild(oText);
					oDiv2.appendChild(oSpan);
					oDiv2.onclick=(function (){var oDiv3=oDiv2; return function (){var childs=oDiv3.childNodes;inp0.value=childs[0].firstChild.nodeValue+childs[1].firstChild.nodeValue;oDiv3.parentNode.style.display="none";};})();
					oDiv.appendChild(oDiv2);
					num++;
					if(numT==textTown.length)
					{
						num=0;
					}
				}
			}
			if(num)
			{
				oDiv.style.display="block";
				var aKoords=absPosition(inp0);
				var okno=document.getElementById("okno");
				var bKoords=absPosition(okno);
				var cKoords=absPosition(podlozhka);
				if(navigator.userAgent.indexOf("Chrome")!=-1)
				{
					heightO=207;
				
				}
				else
				{
					heightO=200;
				};
				var x0=aKoords.x*1;//-bKoords.x;
				sdvig=40;
				var sdvig=set4UA({"firefox":40,"opera":40,"chrome":40,"safari":40,"msie":25,'default':40});
				var y0=aKoords.y*1+sdvig;//+heightO-bKoords.y;//-cKoords.y;
				oDiv.style.left=x0+"px";
				var y0=y0;
				oDiv.style.top=y0+"px";
				
			}else
			{
				oDiv.style.display="none";
			}
		}else
		{
			oDiv.style.display="none";
		};
	};


	/*inp1.addEventListener("keyup",function (e)
				{
					fAutoDop(oTowns[0],e.target,contDiv);
				},true);
	inp2.addEventListener("focus",function(e)
				{
					
					if(in_array(inp1.value,oTowns[1]))
					{
						num2=2;
						num3=2;
						num4=1;
						testNum1=1;
					};
					if(in_array(inp1.value,oTowns[2]))
					{
						num2=1;
						num3=1;
						num4=2;
						testNum1=2;
						initKalendar("june_06_inp3",new Array(15,16,19,22,23,26,29,30));
						initKalendar("july_07_inp3",new Array(3,6,7,10,13,14,17,20,21,24,27,28,31));
						initKalendar("august_08_inp3",new Array(7,10,11,14,17,18,21,24,25,28,31));
						
						initKalendar("june_06_inp10",new Array(15,18,21,22,25,28,29));
						initKalendar("july_07_inp10",new Array(2,5,6,9,12,13,16,19,20,23,26,27,30));
						initKalendar("august_08_inp10",new Array(2,3,6,9,10,13,16,17,20,23,24,27,30,31));
					};
					if(!(in_array(inp1.value,oTowns[1])||in_array(inp1.value,oTowns[2])))
					{
						alert("Выберите пункт отправления из выпадающего списка");
					};
				},true);
	inp2.addEventListener("keyup",function (e)
				{
					fAutoDop(oTowns[num2],e.target,contDiv);
				},true);
	inp3.addEventListener("keyup",function (e)
				{
					fAutoDop(oTowns[num3],e.target,contDiv);
				},true);
	inp4.addEventListener("keyup",function (e)
				{
					fAutoDop(oTowns[num4],e.target,contDiv);
				},true);*/
	addEv(inp1,"keyup",function (e)
				{
					fAutoDop(oTowns[0],e.target,contDiv);
				});
	addEv(inp2,"focus",function(e)
				{
					
					if(in_array(inp1.value,oTowns[1]))
					{
						num2=2;
						num3=2;
						num4=1;
						testNum1=1;
					};
					if(in_array(inp1.value,oTowns[2]))
					{
						num2=1;
						num3=1;
						num4=2;
						testNum1=2;
						initKalendar("june_06_inp3",new Array(19,22,23,26,29,30));
						initKalendar("july_07_inp3",new Array(3,6,7,10,13,14,17,20,21,24,27,28,31));
						initKalendar("august_08_inp3",new Array(7,10,11,14,17,18,21,24,25,28,31));
						
						initKalendar("june_06_inp10",new Array(18,21,22,25,28,29));
						initKalendar("july_07_inp10",new Array(2,5,6,9,12,13,16,19,20,23,26,27,30));
						initKalendar("august_08_inp10",new Array(2,3,6,9,10,13,16,17,20,23,24,27,30,31));
					};
					if(!(in_array(inp1.value,oTowns[1])||in_array(inp1.value,oTowns[2])))
					{
						alert("Выберите пункт отправления из выпадающего списка");
					};
				});
	addEv(inp2,"keyup",function (e)
				{
					fAutoDop(oTowns[num2],e.target,contDiv);
				});
	addEv(inp3,"keyup",function (e)
				{
					fAutoDop(oTowns[num3],e.target,contDiv);
				});
	addEv(inp4,"keyup",function (e)
				{
					fAutoDop(oTowns[num4],e.target,contDiv);
				});
	return {"fTest":function (numI)
				{
					switch(numI)
					{
						case 1:
							return in_array(inp1.value,oTowns[testNum1]);
						break;
						case 2:
							return in_array(inp2.value,oTowns[num2]);
						break;
						case 3:
							return in_array(inp3.value,oTowns[num3]);
						break;
						case 4:
							return in_array(inp4.value,oTowns[num4]);
						break;
					}
				},
			"fTestRoutes":function (id1,id2)
				{
					if((testNum1==1)&&((id1*1+1)!=id2)||(testNum1==2)&&((id1*1-1)!=id2))
					{
						inp3.value=inp2.value;
						inp4.value=inp1.value;
						return false;
					}
					else
					{
						return true;
					};
				}
				
			};
};
