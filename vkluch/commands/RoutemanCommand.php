<?php
//-*-coding: utf-8 -*-
class MethodNotFoundException extends Exception
{
};
class RoutemanCommand extends Command
{
	private $routeMan;
	public function execute(CommandContext $context)
	{
		mysql_connect(Config::$host,Config::$user,Config::$parol);
		mysql_query("USE ".Config::$db);
		$this->routeMan=new RouteMan();
		$inputs=cIData::getRealize();
		$aDD=$inputs->getAllData();
		if (is_callable(array($this,$context->getParam("act"))))
		{
			return call_user_func_array(array($this,$context->getParam("act")),array("aData",$aDD));
		}else
		{
			throw new MethodNotFoundException("method ".$context->getParam("act")." not found in object ".$this);
		};
	}
	public function __call($method,$args)
	{
		
		return call_user_func_array(array($this->routeMan,$method),array($args));
	}
}