<?php
//-*-coding: utf-8 -*-
class Reys {

	private $point1;//пункт отправления
	private $point2;//пункт прибытия
	private $route;//список пунктов ? делать класс
	private $date;//дата отправления в формате YYYY-mm-dd
	private $avtobus;//автобус - объект класса Avtobus (file://[mainDir]/vkluch/avtobus.php)
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
	public function __call($method,$args)
	{
		$prefix=substr($method,0,3);
		$prop=substr($method,2);
		$vars=get_object_vars($this);
		switch ($prefix)
		{
			case "get":
				if(array_key_exists($this->$prop,$vars))
				{
					return $this->$prop;
				}
				else
				{
					throw new CallException("class ".__CLASS__." hasn\'t prop $prop");
				};
			break;
			case "set":
				if(array_key_exists($this->$prop,$vars))
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
}