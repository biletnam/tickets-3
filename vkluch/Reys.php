<?php
//-*-coding: utf-8 -*-
class CallException extends Exception{
}
class Reys {

	private $point1;//пункт отправления
	private $point2;//пункт прибытия
	private $route;//номер маршрута
	private $date;//дата отправления в формате YYYY-mm-dd
	private $avtobus;//автобус - объект класса Avtobus (file://[mainDir]/vkluch/avtobus.php)
	private $idReys=-1;
	public function initavtobus($typeAvtobus)
	{
		$this->avtobus=ATZ::createAvtobus($typeAvtobus);
	}
	
	public function setpoints()
	{
		$aData=func_get_args();
		$this->point1=func_get_arg(1);
		$this->point2=func_get_arg(2);
	}
	public function getpoints()
	{
		return array($this->point1,$this->point2);
	}
	public function getIdReys()
	{
		return $this->idReys;
	}
	public function setIdReys($id)
	{
		$this->idReys=$id;
	}
	public function booking()
	{
		$aArgs=func_get_args();
		$this->avtobus->booking($aArgs);
	}
	public function reserving()
	{
		$aArgs=func_get_args();
		$this->avtobus->reserving($aArgs);
	}
	public function freeking()
	{
		$aArgs=func_get_args();
		$this->avtobus->freeking($aArgs);
	}
	public function getDate($type="form")
	{
		if($type=="form")
		{
			$aTemp=explode("-",$this->date);
			return $aTemp[2].".".$aTemp[1].".".$aTemp[0];
		}else
		{
			return $this->date;
		}
	}
	public function setDate($date)
	{
		$aTemp=explode(".",$date);
		$this->date=$aTemp[2]."-".$aTemp[1]."-".$aTemp[0];
		
	}
	public function __call($method,$args)
	{
		$prefix=substr($method,0,3);
		$prop=strtolower(substr($method,3));
		$vars=get_object_vars($this);
		switch ($prefix)
		{
			case "get":
				if(array_key_exists($prop,$vars))
				{
					return $this->$prop;
				}
				else
				{
					throw new CallException("class ".__CLASS__." hasn\'t prop $prop");
				};
			break;
			case "set":
				if(array_key_exists($prop,$vars))
				{
					$this->$prop=$args[0];
				}
				else
				{
					throw new CallException("class ".__CLASS__." hasn\'t prop $prop");
				};
			break;
			default:
				throw new CallException("class ".__CLASS__." hasn\'t method $method");
		};
	}
	public function check($obj)
	{
	//заглушка
		return true;
	}
	public function fullCheck($obj)
	{
	//заглушка
		return true;
	}
}