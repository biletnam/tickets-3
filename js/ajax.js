function sendZapros(url,data,func)
{
	try{request=new XMLHttpRequest();}catch(trymicrosoft){try{request=new ActiveObject("Msxm12.XMLHTTP");}catch(othermicrosoft){try {request=new ActiveObject("Microsoft.XMLHTTP");}catch(failed){request=null;}}};
	request.open("POST",url,true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	var proc=func;
	request.onreadystatechange=function (){if(request.readyState==4){	proc(request.responseText);}};
	request.send(data);
};