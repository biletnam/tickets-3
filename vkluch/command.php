<?php
//-*-coding: utf-8 -*-
abstract class Command
{
	abstract public function execute(CommandContext $context);
}
class CommandContext
{
	private $params=array();
	private $errors="";
	public function __construct()
	{
		$inputs=cIData::getRealize();
		$params=$inputs->getAllData();
	}
	public function addParam($key,$value)
	{
		$this->params[$key]=$value;
	}
	public function getParam($key)
	{
		return $this->params[$key];
	}
}
class CommandNotFoundException extends Exception
{
}
class CommandFactory
{
	private static $dir="/vkluch/commands";
	public static function getCommand($act="Default")
	{
		if(preg_match("/\W/",$act))
		{
			throw new Exception("notAvailable Chars");
		};
		$inputs=cIData::getRealize();
			
		if($act=="poligon")
		{
			$filename=Config::$dir0.str_replace("poligon","_poligon",$_SERVER["REQUEST_URI"]);
			include($filename);
		}else
		{
			$class=UCFirst(strtolower($act))."Command";
			$file=Config::$dir0.self::$dir."/".$class.".php";
			$class=$class;
			if(!file_exists($file))
			{
				throw new CommandNotFoundException("file ".$file." not found");
			};
			require_once($file);
			if(!class_exists($class))
			{
				print($class);
				throw new CommandNotFoundException("class ".$class." not found");
			};
		
		
			$cmd=new $class();
			return $cmd;
		};
	}
}