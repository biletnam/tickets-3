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
function sendTicketOk(text)
{
	alert(text);
};
function showTicket(text)
{
	window.open("http://tickets.777tur.com/temp/"+text,"ticket");
};