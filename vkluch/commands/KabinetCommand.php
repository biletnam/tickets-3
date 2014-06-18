<?php
//-*-coding: utf-8 -*-
require_once(Config::$dir0."/vkluch/Exceptions.php");
class KabinetCommand extends Command
{
	private $user;
	private $kabinet;
	public function execute(CommandContext $context)
	{
		if($_SESSION["status"]=="admin")
		{
			mysql_connect(Config::$host,Config::$user,Config::$parol);
			mysql_query("USE ".Config::$db);
			mysql_query("SET NAMES 'utf8'");
			if($_POST["act"]=="out")
			{
				$_SESSION["login"]="";
				$_SESSION["status"]="";
				print('<meta http-equiv="refresh" content="0;URL='.$_SERVER["REQUEST_URI"].'">');
				return true;
			}
			require_once(Config::$dir0."/vkluch/Kabinet.php");
			$this->kabinet=new Kabinet();
			$strHtml=file_get_contents(Config::$dir0."/html/fish/kabinet.tpl");
				
			$inputs=iData::getRealize();
			$aDD=$inputs->getAllData();
			if(!$context->getParam("act"))
			{
				$strHtml=str_replace("{TITLE}","Кабинет администратора",$strHtml);
				$strHtml=str_replace("{CONTENTS}","<br><form encode='application/x-www-form-urlencoded' method='post' action=''><input type='hidden' name='act' value='out'><input type='submit' value='Выйти'></form>",$strHtml);
				print($strHtml);
				return true;
			}elseif(substr($context->getParam("act"),0,3)=="put")
			{
				$str1=call_user_func_array(array($this,substr($context->getParam("act"),3)),array("aData",$aDD));
				print($str1);
				//return true;
			}elseif (is_callable(array($this,$context->getParam("act"))))
			{
				$aHtml=call_user_func_array(array($this,$context->getParam("act")),array("aData",$aDD));
				$strHtml=str_replace("{TITLE}",$aHtml[0],$strHtml);
				$strHtml=str_replace("{CONTENTS}",$aHtml[1]."<br><form encode='application/x-www-form-urlencoded' method='post' action=''><input type='hidden' name='act' value='out'><input type='submit' value='Выйти'></form>",$strHtml);
				print($strHtml);
				return  true;
				
			}else
			{
				throw new MethodNotFoundException("method ".$context->getParam("act")." not found in object ".$this);
			};
			
		}elseif($_POST["login"])
		{
			mysql_connect(Config::$host,Config::$user,Config::$parol);
			mysql_query("USE ".Config::$db);
			mysql_query("SET NAMES 'utf8'");
			$query="SELECT * FROM users WHERE login='".$_POST["login"]."' AND password='".hash("sha256",$_POST["parol"])."'" ;
			$res=mysql_query($query);
			$aData=mysql_fetch_assoc($res);
			if($aData["login"])
			{
				$_SESSION["login"]=$aData["login"];
				$_SESSION["status"]=$aData["status"];
			};
			print('<meta http-equiv="refresh" content="0;URL='.$_SERVER["REQUEST_URI"].'">');
		}
		
		else
		{
			$strFormLogin=file_get_contents(Config::$dir0."/html/formalogin.html");
			print($strFormLogin);
		};
		//$saver1->saveCache($this->reys);
		
	}
	public function __call($method,$args)
	{
		
		return call_user_func_array(array($this->kabinet,$method),array($args));
	}
}