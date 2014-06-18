function getSPoints(idInp1,idInp2,idInp3,idInp4,idDpoint1,idDpoint2,idDpoint3,idDpoint4,aT1,aT2)
{
	var tD1=_(idDpoint1);
	var tD2=_(idDpoint2);
	var tD3=_(idDpoint3);
	var tD4=_(idDpoint4);
	var inp1=_(idInp1);
	var inp2=_(idInp2);
	var inp3=_(idInp3);
	var inp4=_(idInp4);
	var aTowns1=aT1;
	var aTowns2=aT2;
	function get1Point(idInp,dT)
	{
		var inp=_(idInp);
		var tDiv=dT;
		addEv(inp,"click",function (){
			tDiv.style.display='block';
			return false;
		});

		addEv(tDiv,"click",function (e){
			if(e.target.tagName=="P"||e.target.tagName=="p")
			{
				inp.value=e.target.firstChild.nodeValue;
				tDiv.style.display='none';
		
			};
			return false;
		});
		
	};
	//get1Point(idInp2,tD2);
	//get1Point(idInp3,tD3);
	//get1Point(idInp4,tD4);
	addEv(inp2,"click",function (){
			tD2.style.display='block';
			var avto=_("avto1");
			if(avto)
			{
				avto.parentNode.removeChild(avto);
			};
		});

	addEv(tD2,"click",function (e){
			if(e.target.tagName=="P"||e.target.tagName=="p")
			{
				inp2.value=e.target.firstChild.nodeValue;
				tD2.style.display='none';
			}
		});
	addEv(inp3,"click",function (){
			tD3.style.display='block';
			var avto=_("avto2");
			if(avto)
			{
				avto.parentNode.removeChild(avto);
			};
		});

	addEv(tD3,"click",function (e){
			if(e.target.tagName=="P"||e.target.tagName=="p")
			{
				inp3.value=e.target.firstChild.nodeValue;
				tD3.style.display='none';
			}
		});
	addEv(inp4,"click",function (){
			tD4.style.display='block';
			var avto=_("avto2");
			if(avto)
			{
				avto.parentNode.removeChild(avto);
			};
		});

	addEv(tD4,"click",function (e){
			if(e.target.tagName=="P"||e.target.tagName=="p")
			{
				inp4.value=e.target.firstChild.nodeValue;
				tD4.style.display='none';
			}
		});
	
	addEv(inp1,"click",function (){
			tD1.style.display='block';
			var avto=_("avto1");
			if(avto)
			{
				avto.parentNode.removeChild(avto);
			};
		});

	addEv(tD1,"click",function (e){
			if(e.target.tagName=="P"||e.target.tagName=="p")
			{
				inp1.value=e.target.firstChild.nodeValue;
				tD1.style.display='none';
			}
			if(in_array(inp1.value,aTowns1))
			{
				delList(tD2,0);
				delList(tD3,0);
				delList(tD4,1);
				delList(tD1,1);
			
			}
			else
			{
				if(in_array(inp1.value,aTowns2))
				{
					delList(tD2,1);
					delList(tD3,1);
					delList(tD4,0);
					delList(tD1,0);
					
				}
				
			};
		});
		//get0Point(idInp1,tD1);
		function delList(tD,num)
		{
			var listDiv=tD.getElementsByTagName('div');
			if(listDiv.length>1)
			{
				tD.removeChild(listDiv[num]);
			};
		};
		
	
	return function ()
		{
			inp3.value=inp2.value;
			inp4.value=inp1.value;
		};
}