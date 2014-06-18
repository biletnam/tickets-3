<?php
//-*-coding: utf-8 -*-
class SelfCallerException extends Exception
{
}
abstract class SelfCaller{
	private $prefix;
	public function __construct($prefix)
	{
		$this->prefix=$prefix;
	}
	
	public function __call($method,$args)
	{
		$methodName=$this->prefix.$method;
		if(method_exists($this,$methodName))
		{
			call_user_func(array($this,"mDefault"));
			print_r($args);
			call_user_func_array(array($this,$methodName),array($args[0][1]));
		}
		else
		{
			throw new SelfCallerException("method $methodName not exists in class ".__CLASS__);
		}
	}
	abstract public function mDefault();
}