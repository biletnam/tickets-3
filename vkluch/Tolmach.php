<?php
//-*-coding: utf-8 -*-
class Tolmach{
	private $uri;
	private $aUri;
	public function __construct()
	{
		$this->uri=$_SERVER["REQUEST_URI"];
		$this->aUri=explode("/",$this->uri);
	}
	public function getTask()
	{
		return $this->aUri[1];
	}
	public function getAct()
	{
		return $this->aUri[2];
	}
	public function getView()
	{
		if(($this->aUri[1]=="_poligon")||(substr($this->aUri[3],0,1)=="?"))
		{
			return("default");
		}else
		{
			return($this->aUri[3]);
		}
		
	}
}