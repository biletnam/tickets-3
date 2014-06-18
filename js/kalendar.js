function createKalendar(inpid,sourceid,idInpTest1,idInpTest2)
{
	//sourceid- id общей таблицы tkalendar_inp3
	var  inp0=_(inpid);
	var  sTable=_(sourceid);
	var okno=_("okno");
	var inp1=_(idInpTest1);
	var inp2=_(idInpTest2);
	var aTMounths=sTable.getElementsByTagName("table");
	var numTM=aTMounths.length;
		
	for (var j=0;j<numTM;j++)
	{
		addEv(aTMounths[j],"click", function (e)
		{
			if(e.target.className=="day-act")
			{
				id=e.target.parentNode.parentNode.parentNode.id;
				var aIds=id.split("_");
				var dDay=e.target.firstChild.nodeValue;
				if(dDay.length==1)
				{
					dDay="0"+dDay;
				};
				inp0.value=dDay+"."+aIds[1]+".2013";
				sTable.display="none";
				switch (aIds[2])
				{
					case "inp3":
						bilet1();
					break;
					case "inp10":
						bilet2();
					break;
				};
			};
			return true;
		});
	}
	
	
	addEv(inp0,'click',function (e)
	{
		if(!(in_array(inp1.value,oTT[0])))
		{
			alert("Выберите пункт отправления из выпадающего списка");
			return false;
		};
		if(!(in_array(inp2.value,oTT[0])))
		{
			alert("Выберите пункт прибытия из выпадающего списка");
			return false;
		};
		inp0.style.backgroundImage='url("/pics/ajax-loader.gif")';
		inp0.style.backgroundRepeat="no-repeat";
		inp0.style.backgroundPosition="center center";
		sendZapros('/routedat/getdates/?point1='+encodeURI(inp1.value)+'&point2='+encodeURI(inp2.value),'',getShowKalend(sTable,inp0));
		//sTable.style.display="block";
		
	});
	
	
};
function initKalendar(id,dates)
{
	var kTables=document.getElementById(id);
	var cellDays=kTables.getElementsByTagName("td");
	for (i in cellDays)
	{
		var node=cellDays[i];
		if(node.nodeName)
		{
			if(in_array(node.firstChild.nodeValue,dates))
			{
				node.setAttribute("class","day-act");
			
			}
			else
			{
				node.setAttribute("class","day-cell");
			};
		}
	};
};
function getShowKalend(iTableKalend,iInp)
{
	var oTableKalend=iTableKalend;
	var inp=iInp;
	var koordsI=absPosition(inp);
	var y0=koordsI.x-150;
	oTableKalend.style.left=y0+"px";
	y0=koordsI.y+40;
	oTableKalend.style.top=y0+"px";
	return function (text)
	{
		eval(text);
		if(oDates)
		{
			var aTMounths=oTableKalend.getElementsByTagName("table");
			var numTM=aTMounths.length;
			var numM=0;
			var aIds=new Array();
			for (var j=0;j<numTM;j++)
			{
				aIds=aTMounths[j].id.split("_");
				
				numM=aIds[1];
				//alert(aTMounths[j].id);
				initKalendar(aTMounths[j].id,oDates[numM]);
			};
			inp.style.backgroundImage='url("/pics/backinp1.png")';
			inp.style.backgroundRepeat="repeat-x";
			inp.style.backgroundPosition="0px 0px";
		
			oTableKalend.style.display='block';
		};
	};
};