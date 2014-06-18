<?php
//-*-coding: utf-8 -*-
class RouteMan
{
	const SEL=",";//разделитель пунктов в списке
	public function getroute()
	{
	//получение маршрута из БД по пункту отправления и  прибытия
		$aInputs=func_get_arg(0);
		if(array_key_exists("id",$aInputs[1]))
		{
			$query="SELECT * FROM routes WHERE idroute=".$aInputs[1]["id"];
		}
		elseif(array_key_exists("point1",$aInputs[1]))
		{
			$query="SELECT * FROM routes as t1,routes as t2 WHERE (t1.point ='".$aInputs[1]["point1"]."') AND(t2.point ='".$aInputs[1]["point2"]."') AND (t1.idroute=t2.idroute) AND(t1.idpoint<t2.idpoint)";
			
		}else
		{
			throw( new  BadDataException());
			exit();
		};
		$res=mysql_query($query);
		$aData= mysql_fetch_assoc($res);
		return $aData["idroute"];
	}
	public function getrouteid()
	{
		$aInputs=func_get_arg(0);
		$args=$aInputs[1];
		$query="SELECT t1.idroute FROM routes as t1,routes as t2 WHERE (t1.point ='".$aInputs[1]["point1"]."') AND(t2.point ='".$aInputs[1]["point2"]."') AND (t1.idroute=t2.idroute) AND(t1.idpoint<t2.idpoint)";
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		return $aData["idroute"];
	}
	
	
	
}