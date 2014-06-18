<?php
//-*-coding: utf-8 -*-
class Viewer
{
	private $obj;
	private $view;
	public function __construct()
	{
		$num=func_num_args();
		$this->obj=func_get_arg(0);
		if($num=2)
		{
			$this->view=func_get_arg(1);
		}
	}
	public function display()
	{
		$class=get_class($this->obj);
		if(isset($this->view)
		{
			$dir=$this->view;
			$class=basename($dir,".php")."Viewer";
			
		}
		else
		{
			$dir="view/".$class.".php";
			$class=$class."Viewer";
			
			
		}
		require_once($dir);
		$viewer=new $class($this->obj);
		$viewer->display();
	}
	
}