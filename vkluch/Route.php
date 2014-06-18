<?php
//-*-coding: utf-8 -*-
class RouteException extends Exception
{
}
class Route
{
	private $num;
	private $points=array();
	private $dates=array();
	private $typeAvtobus;
	public function addPoint($point)
	{
		$user=User::getRealize();
		$user->checkAccess(User::ADMIN);
		$this->points[]=$point;
	}
	public function insertBeforePoint($pointNew,$numPoint)
	{
		$user=User::getRealize();
		$user->checkAccess(User::ADMIN);
		$num=count($this->points);
		if($num>$pointNew)
		{
			for($i=$num;$i>=$numPoint;$i--)
			{
				$this->points[$i]=$this->points[$i-1];
			};
			$this->points[$numPoint]=$pointNew;
		}else
		{
			throw new RouteException("not be inserted numPoint: $numPoint bigger num: $num");
		}

	}
	public function init($aData)
	{
		$this->points=$aData["points"];
		$this->dates=$aData["dates"];
		$this->typeAvtobus=$aData["typeAvtobus"];
	}
	
	public function getPoints()
	{
		return $this->points;
	}
	public function getDates()
	{
		return $this->dates;
	}
	public function addDate($date)
	{
		$user=User::getRealize();
		$user->checkAccess(User::ADMIN);
		$this->dates[]=$date;
		sort($this->dates);
	}
	public function insertSQL()
	{
		$query="INSERT INTO `route` (`points`,`dates`,`typeAvtobus`) VALUES('".$this->points."','".$this->dates."','".$this->typeAvtobus."')";
		return $query;
	}
	public function updateSQL()
	{
		$query="UPDATE `route` SET `points`='".$this->points."',`dates`='".$this->dates."',`typeAvtobus`='".$this->typeAvtobus."' WHERE `id`=".$this->num;
		return $query;
	}
	public function selectSQL()
	{
		$query="SELECT `points`,`dates`,`typeAvtobus` FROM `route` WHERE `id`=".$this->num;
		return $query;
	}
	
}