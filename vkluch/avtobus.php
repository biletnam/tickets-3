<?php
//-*-coding: utf-8 -*-
class AvtobusException extends Exception
{
}
class ATZ
{
	//типы автобусов
	const MAN=0;
	const MERSEDES=1;
	const VOLVO=2;
	const GAZEL=3;
	public function createAvtobus($type)
	{
		$avtobus=new Avtobus($type);
		switch ($type)
		{
			case self::MAN:
			$pl=$avtobus->createPlaces(55,0);//первичные настройки
			break;
			case self::MERSEDES:
			$pl=$avtobus->createPlaces(55,0);
			break;
			case self::VOLVO:
			$pl=$avtobus->createPlaces(45,0);
			break;
			case self::GAZEL:
			$pl=$avtobus->createPlaces(18,0);
			break;
		};
		$avtobus->setType($type);
		$avtobus->setPlaces($pl);
		return $avtobus;
	}
}
class Avtobus
{
	const FREE=0;
	const RESERVED=1;
	const BOOKED=2;
	private $places=array();//вид: [numPlace]=typePlace
	private $template;
	private $type;
	function __construct($type)
	{
		$this->type=$type;
	}
	function createPlaces($num0,$numReserved)
	{
	//вспомогательная функция $num0 - общее количество мест, $numReserved-первые забронированные
		$temp=array();
		for($i=0;$i<$numReserved;$i++)
		{
			$temp[$i+1]=self::RESERVED;
		};
		for($i=$numReserved;$i<$num0;$i++)
		{
			$temp[$i+1]=self::FREE;
		};
		return $temp;
	}
	public function getPlaces()
	{
		$this->checkPlaces();
		return $this->places;
	}
	public function getStrPlaces($type)
	{
		$aTypes=array("free"=>self::FREE,"booked"=>self::BOOKED,"reserved"=>self::RESERVED);
		$str="";
		foreach($this->places as $num=>$placeType)
		{
			if($aTypes[$type]==$placeType)
			{
				$str.=$num.",";
			};
		};
		$str=substr($str,0,-1);
		return $str;
	}
	public function setPlaces($places)
	{
		$this->places=$places;
	}
	private function checkPlaces()
	{
		if(count($this->places)==0)
		{
			throw new AvtobusException("places not init");
		}
	}
	public function testPlaces()
	{
		$num=count($this->places);
		$errorPlaces=array();
		for($i=1;$i<=$num;$i++)
		{
			if(!isset($this->places[$i]))
			{
				$errorPlaces[]=$i;
			};
		};
		if(count($errorPlaces))
		{
			return $errorPlaces;
		}
		else
		{
			return 0;
		};
		
	}
	private function settingsPlaces($aData)
	{
	//основная функция для резервирования, бронирования и освобождения мест
		$typePlace=$aData["type"];
		$num=count($aData["places"]);
		$tPlaces=$this->places;
		try
		{
			for($i=0;$i<=$num;$i++)
			{
				$numPlace=$aData["places"][$i];
				//$nn=count($this->places);
				
					if(is_numeric($numPlace)){$tPlaces[$numPlace]=$typePlace;};
				
			}
		}
		catch(Exception $e)
		{
			print($e->getMessage());
			return false;
		}
		$this->places=$tPlaces;
		
	}
	public function booking()
	{
	//бронирование мест в автобусе
		$this->checkPlaces();
		$user=User::getRealize();
		$user->checkAccess(User::USER);
		$aArgs=func_get_args();
		if(is_array($aArgs[0]))
		{
			$temp=$aArgs[0];
			$aArgs=$temp;
			
		};
		$this->settingsPlaces(array("type"=>self::BOOKED,"places"=>$aArgs));
	}
	public function freeking()
	{
	//освобождение занятых мест в автобусе
		$this->checkPlaces();
		$user=User::getRealize();
		$user->checkAccess(User::USER);
		$aArgs=func_get_args();
		if(is_array($aArgs[0]))
		{
			$temp=$aArgs[0];
			$aArgs=$temp;
		};
		$this->settingsPlaces(array("type"=>self::FREE,"places"=>$aArgs));
	}
	public function reserving()
	{
	//резервирование мест в автобусе(только админ)
		$this->checkPlaces();
		$user=User::getRealize();
		$user->checkAccess(User::USER);
		$aArgs=func_get_args();
		if(is_array($aArgs[0]))
		{
			$temp=$aArgs[0];
			$aArgs=$temp;
		};
		$this->settingsPlaces(array("type"=>self::RESERVED,"places"=>$aArgs));
	}
	function getProp($prop)
	{
		return $this->$prop;
	}
	public function setType($type)
	{
		$this->type=$type;
	}
	
}