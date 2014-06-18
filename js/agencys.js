function getOkno(id)
{
	var okno=document.getElementById(id);
	var blind=document.getElementById("blind");
	return {"show":function (){
							var sSize=screenSize();
							var x0=sSize.w/2-150;
							var y0=sSize.h/2-100+document.body.scrollTop;
							okno.style.top=y0+"px";
							okno.style.left=x0+"px";
							okno.style.display="block";
							blind.style.top=document.body.scrollTop;
							blind.style.display="block";
							},
			"hide":function (){
							okno.style.display="none";
							blind.style.display="none";
							}
							
			}
};