<?php
//-*-coding: utf-8 -*-
require_once(Config::$dir0."/vkluch/Exceptions.php");
class MainformCommand extends Command
{
	private $form;
	public function execute(CommandContext $context)
	{
		require_once(Config::$dir0."/html/MCalendar.php");
		
		$inputs=iData::getRealize();
		mysql_connect(Config::$host,Config::$user,Config::$parol);
		mysql_query("USE ".Config::$db);
		mysql_query("SET NAMES 'utf8'");
		$query="SELECT * FROM routes as t1,routes as t2 WHERE (t1.point ='".$_POST["point1"]."') AND(t2.point ='".$_POST["point2"]."') AND (t1.idroute=t2.idroute) AND(t1.idpoint<t2.idpoint)";
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$query="SELECT * FROM routes WHERE idroute=".$aData["idroute"]." AND NOT days='*'";
		$inputs=iData::getRealize();
		$aDD=$inputs->getAllData();
		$this->form=new MCalendar();
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