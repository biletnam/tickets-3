<?php
//-*-coding: utf-8 -*-
class Controller
{
	private static $realize;
	private function __construct()
	{
	}
	public static function run()
	{
		$realize=new Controller();
		$realize->init();
		$realize->work();
	}
	private function init()
	{
		session_start();
		$dPath=explode("/",__FILE__);
		$num=count($dPath)-1;
		unset($dPath[$num]);
		$num--;
		unset($dPath[$num]);
		$dir1=implode("/",$dPath);
		set_include_path(get_include_path().":".$dir1."/vkluch");
		
		return true;
	}
	private function work()
	{
		$tolmach=new Tolmach();
		$task=$tolmach->getTask();
		require_once("command.php");
		$context=new CommandContext();
		$context->addParam("act",$tolmach->getAct());
		$context->addParam("view",$tolmach->getView());
		try{
			$cmd=CommandFactory::getCommand($task);
			
		}
		catch(Exception $e)
		{
			header("HTTP/1.1 404: Not Found\r\n");
			print("ERROR 404 PAGE NOT FOUND");
			exit();
		};
		$str=$cmd->execute($context);
		print($str);
		//$kmd=new Komandor();
		//$kmd->addParam();
	}
}