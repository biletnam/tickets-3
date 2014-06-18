<?php
//-*-coding: utf-8 -*-
class MainformCommand extends Command
{
	private $form;
	public function execute(CommandContext $context)
	{
		require_once(Config::$dir0."/vkluch/Mainform2.php");
		$this->form=new Mainform();
		$inputs=iData::getRealize();
		mysql_connect(Config::$host,Config::$user,Config::$parol);
		mysql_query("USE ".Config::$db);
		mysql_query("SET NAMES 'utf8'");
		$inputs=iData::getRealize();
		$aDD=$inputs->getAllData();
		if (is_callable(array($this,$context->getParam("act"))))
		{
			return call_user_func_array(array($this,$context->getParam("act")),array("aData",$aDD));
		}else
		{
			throw new MethodNotFoundException("method ".$context->getParam("act")." not found in object ".$this);
		};
		//$saver1->saveCache($this->reys);
		
	}
	public function __call($method,$args)
	{
		
		return call_user_func_array(array($this->form,$method),array($args));
	}
}