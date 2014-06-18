<?php
//-*-coding: utf-8 -*-

class reysMan{
	public function getRoute($punkt1,$punkt2)
	{
	//находит маршрут по пункту отправления и пункту прибытия
	//в идеале должен возвращать список маршрутов
		return $route; //type:oRoute
	}
	
	public function getReys($route,$date)
	{
		return $reys;
	}
	public function getVoyage($reys,$date,$punkt1,$punkt2)
	{
		return $voyage//нужен ли?
	}
	public function getDates($route)
	{
		return array();
	}
};
class oReys {
	const BRONJ=0;
	const FREE=1;
	const ZAKAZ=2;
	private $listCity =array();
	private $places=array();
	private $date;
	private $avtobus;
	public function getPlaces()
	{
	
		return $places;//array(self::BRONJ,self::BRONJ,self::FREE,self::ZAKAZ)
	}
	public function getAvtobus()
	{
		return true;
	}
	
	
};