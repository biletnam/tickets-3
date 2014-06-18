<?php
//-*-coding: utf-8 -*-
class cIData{
	private static $realize;
	public $data=array();
	private function __construct()
	{
		$aInputs=array($_GET,$_POST);
		foreach($aInputs as $name=>$aIn)
		{
			if(is_array($aIn))
			{
				$this->data=array_merge($this->data,$aIn);
				break;
			};
		};
	}
	public static function getRealize()
	{
		if(empty(self::$realize))
		{
			self::$realize=new cIData();
		}
		return self::$realize;
	}
	public function getData($key)
	{
		return $this->data[$key];
	}
	public function getAllData()
	{
		return $this->data;
	}
	public function addData($key,$value)
	{
		$this->data[$key]=$value;
	}
}