function getAutoDop(num)
{
	//if(num==0) var tTowns = aTowns0;
	//if(num==1) var tTowns = aTowns1;
	tTowns=aTownsT;
	var podlozhka=document.getElementById("podlozhka");
	return function (e)
			{
				var oDiv=document.getElementById("autodop1");
				while (oDiv.firstChild)
				{
					oDiv.removeChild(oDiv.firstChild);
				};
				if(e.target.value.length>0)
				{
					var num=0;
					text1=e.target.value;
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
							oText=document.createTextNode(textTown.slice(e.target.value.length));
							oSpan.appendChild(oText);
							oDiv2.appendChild(oSpan);
							oDiv2.onclick=(function (){var inp=e.target; var oDiv3=oDiv2; return function (){var childs=oDiv3.childNodes;inp.value=childs[0].firstChild.nodeValue+childs[1].firstChild.nodeValue;oDiv3.parentNode.style.display="none";};})();
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
						var aKoords=absPosition(e.target);
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
						var x0=aKoords.x*1-bKoords.x-5;
						var y0=aKoords.y*1+heightO-bKoords.y-cKoords.y;
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
};
