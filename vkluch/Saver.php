<?php
//-*-coding: utf-8 -*-
class Saver{
	public function saveCache($obj)
	{
		$_SESSION[get_class($obj)]=serialize($obj);
	}
	public function getCache($className)
	{
		if (isset($_SESSION[$className]))
		{
			return unserialize($_SESSION[$className]);
		}else
		{
			return new $className;
		}
	}
	public function reset($className)
	{
		unset($_SESSION[$className]);
	}
}