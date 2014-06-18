<?php
//-*-coding: utf-8 -*-
class User
{
	const ADMIN=0;
	const MANAGER=1;
	const USER=3;
	private static $realize;
	private $login;
	private $groupe=self::USER;
	private $name;
	private function __construct()
	{
		
	}
	public static function getRealize()
	{
		if(empty(self::$realize))
		{
			self::$realize=new User();
		}
		return self::$realize;
	}
	public function login($login,$parol)
	{
		$this->login=$login;
		if(($login=="admin")&&("123456"==$parol))
		{
			$this->groupe=self::ADMIN;
		}
	}
	public function checkAccess($groupe)
	{
		//print($this->groupe."--".$groupe);
		if($this->groupe>$groupe)
		{
			print("access denied");
			exit();
		}
	}
}