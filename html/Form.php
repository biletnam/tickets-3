<?php
//-*-coding: utf-8 -*-
interface Worker
{
	public function work($obj);
}
class Form
{
	const NEWF=0;
	const EDITF=1;
	const COMPLITF=2;
	const ENCTYPE="application/x-www-form-urlencoded";
	const ECTYPE_FILE="multipart/form-data";
	private $fields=array();
	private $messages=array();
	private $htmlFile;
	private $action;
	private $method;
	private $enctype;
	private $workers=array();
	protected $htmlRequired;
	public function getHtmlField($name,$type)
	{
		$htmlF=$this->fields[$name]->getHtml($type);
		if($this->fields[$name]->isRequired())
		{
			$htmlF.=$this->htmlRequired;
		};
		return $htmlF;
	}
	public function getScriptField($name,$type)
	{
		$htmlF=$this->fields[$name]->getScript($type);
		return $htmlF;
	}
	public function setHtmlRequired($html)
	{
		$this->htmlRequired=$html;
	}
	public function getHtmlRequired()
	{
		return $this->htmlRequired;
	}
	public function addWorker($worker)
	{
		$this->workers[]=$worker;
	}
	
	public function __construct($action,$method="POST",$enctype=self::ENCTYPE,$htmlFile="view/form1.php")
	{
		$this->action=$action;
		$this->method=$method;
		$this->enctype=$enctype;
		$this->htmlFile=$htmlFile;
	}
	public function addFields()
	{
		$num=func_num_args();
		for($i=0;$i<$num;$i++)
		{
			$field=func_get_arg($i);
			$name=$field->getName();
			$this->fields[$name]=$field;
			
		};
		
	}
	public function addMessage($text)
	{
		$this->messages[]=$text;
	}
	private function clearMessages()
	{
		$this->messages=array();
	}
	public function check()
	{
		$this->clearMessages();
		foreach($this->fields as $num=>$field)
		{
			$field->check($this);
		}
	}
	public function getData()
	{
		require_once("cIData.php");
		$data=iData::getRealize();
		print_r($data->data);
		$this->clearMessages();
		foreach($this->fields as $name=>$field)
		{
			print($data->getData($name));
			$field->setValue($data->getData($name));
			$field->check($this);
			
			foreach($this->workers as $num=>$worker)
			{
				$worker->work($field);
			}
		};
		if(count($this->messages))
		{
			return 1;
		}
		else
		{
			$query="";
			return 0;
		};
		
	}
	public function getProps()
	{
		$aTemp=array();
		$numA=func_num_args();
		for($i=0;$i<$numA;$i++)
		{
			$argName=func_get_arg($i);
			$aTemp[$argName]=$this->$argName;
		};
		return $aTemp;
		
	}
	public function compile($type)//type - тип отображения NEWF, EDITF, COMPLITF
	{
		ob_start();
		require ($this->htmlFile);
		//ob_flush();
		$str1=ob_get_contents();
		ob_end_clean();
		if(count($this->messages))
		{
			$strMessage="<div class=\"error-msg\">";
			foreach($this->messages() as $num=>$message)
			{
				$strMessage.=$message."<br>";
			};
			$strMessage.="</div>";
			$str1=$strMessage.$str1;
		};
		return $str1;
	}
}