<?php
//-*-coding: utf-8 -*-
class MethodNotFoundException extends Exception
{
};
class RoutedatCommand extends Command
{
	private $routeMan;
	public function execute(CommandContext $context)
	{
		require_once("RouteMan.php");
		$this->routeMan=new RouteManDB();
		$inputs=iData::getRealize();
		$link=mysql_connect(Config::$host,Config::$user,Config::$parol);
		mysql_query("USE ".Config::$db);
		mysql_query("SET NAMES 'utf8'");
		$inputs=iData::getRealize();
		$aDD=$inputs->getAllData();
		if (is_callable(array($this,$context->getParam("act"))))
		{
			print( call_user_func_array(array($this,$context->getParam("act")),array("aData",$aDD)));
		}else
		{
			throw new MethodNotFoundException("method ".$context->getParam("act")." not found in object ".$this);
		};
		//$saver1->saveCache($this->reys);
		
	}
	public function __call($method,$args)
	{
		
		return call_user_func_array(array($this->routeMan,$method),array($args));
	}
}