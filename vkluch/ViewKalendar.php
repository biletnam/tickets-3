<?php
//-*-coding: utf-8 -*-
class ViewKalendar
{
	
}
class ViewMonth
{
	protected $strHtml;
	protected $aDates=array();
	protected $aDays=array();
	protected $range=array(0,32);
	protected $name;
	protected $num;
	protected $strNo;
	public function __construct($name)
	{
		require_once('funcDates.php');
		$oDates=new funcDates();
		$this->name=$name;
		$this->num=$oDates->getMonthNum($name);
		$this->strNo="<td class='no-day'>&nbsp;</td>";
		//$this->strNoAct="<td class='no-day'>&nbsp;</td>";
	}
	public function addDate($date,$str)
	{
		$this->aDates[$date]=$str;
	}
	public function addDay($day,$str)
	{
		require_once('funcDates.php');
		$oDates=new funcDates();
		$numDay=$oDates->getNumWDay($day);
		$this->aDays[$numDay]=$str;
	}
	public function clearHtml()
	{
		$this->strHtml="";
	}
	public function getHtmlDay($num,$day)
	{
		if($num<10)
		{
			$num="0".$num;
		};
		if(!$num)
		{
			return $this->strNo;//"<td class='no-day'>&nbsp;</td>";
		}
		elseif(($num<$this->range[0])||($num>$this->range[1]))
		{
			return "<td class='day-cell'><span>".$num."</span></td>";
		}
		elseif(array_key_exists($num,$this->aDates))
		{
			return str_replace("{NUM}",$num,$this->aDates[$num]);
		}
		elseif(array_key_exists($day,$this->aDays))
		{
			return str_replace("{NUM}",$num,$this->aDays[$day]);
		}
		else
		{
			return "<td class='day-cell'><span>".$num."</span></td>";
		}
	}
	public function getNum()
	{
		return $this->num;
	}
	public function dShowDates()
	{
		print_r($this->aDates);
	}
	public function clearDates()
	{
		$this->aDates=array();
		$this->aDays=array();
		$this->range[0]=0;
		$this->range[1]=32;
	}
	public function setRange($date1,$date2=32)
	{
		$this->range[0]=$date1;
		$this->range[1]=$date2;
	}
}