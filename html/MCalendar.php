<?php
//-*-coding: utf-8 -*-

class MCalendar
{
	protected $aDays=array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
	protected $aMonths=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
	protected function transDay($numDay,$ih_nash="ih")
	{
		if($ih_nash=="ih")
		{
			return ($numDay+6)%7;
		}
		else
		{
			return ($numDay+1)%7;
		};
	}
	protected function testWeekDay(& $numWeekDay,& $numWeek)
	{
		if($numWeekDay==7)
		{
			$numWeekDay=0;
			$numWeek++;
		};
	}
	protected function createMonth($month,$year,$id,$days=array("dates"=>array(),"weekdays"=>array()))
	{
	/*
		days - задает даты
		days=array(	"dates"=>array(date1,date2...),
					"weekdays"=>array(0,3...),
					"ranges"=>array("date1:date2",...) - реализую потом
	*/
		$numWeek=0;
		$numDay=0;
		$numWeekDay=0;
		$timeFirstDay=mktime(0,0,0,$month,1,$year);
		$timeLastDay=mktime(0,0,0,$month+1,-1,$year);
		
		$firstWeekDay=$this->transDay(date("w",$timeFirstDay));
		$lastDay=date("d",$timeLastDay)+1;
		$strKalendar="<table class='kalendar' id='".$id."'><caption>".$this->aMonths[$month-1]."</caption><tbody><tr>";
		foreach($this->aDays as $num=>$strWDay)
		{
			$strKalendar.="<th>$strWDay</th>";
		};
		$strKalendar.="</tr><tr>";	
		while($numWeekDay<$firstWeekDay)
		{
			$strKalendar.="<td class='no-num'>&nbsp;</td>";
			$numWeekDay++;
			if($numWeekDay==7)
			{
				$numWeekDay=0;
				$numWeek++;
				$strKalendar.="</tr><tr>";
			};
			
		};
		$numDay++;
		while($numDay<=$lastDay)
		{
			$nmClass="day-cell";
			if(in_array($numDay ,$days["dates"])||(in_array($numWeekDay,$days["weekdays"]))&&(!key_exists("range",$days)||(($numDay>=$days["range"][0])&&($numDay<=$days["range"][1]))))
			{$nmClass="day-act";};
			$strKalendar.="<td class='".$nmClass."'>$numDay</td>";
			$numDay++;
			$numWeekDay++;
			if($numWeekDay==7)
			{
				$numWeekDay=0;
				$numWeek++;
				$strKalendar.="</tr><tr>";
			};
		};
		if($numWeekDay>0)
		{
			while($numWeekDay<7)
			{
				$strKalendar.="<td class='no-num'>&nbsp;</td>";
				$numWeekDay++;
			};
		};	
		$strKalendar.="</tr></tbody></table>";
		return $strKalendar;
	}
	public function __construct($point1,$point2,$id)
	{
		$query="SELECT * FROM routes as t1,routes as t2 WHERE (t1.point ='".$_POST["point1"]."') AND(t2.point ='".$_POST["point2"]."') AND (t1.idroute=t2.idroute) AND(t1.idpoint<t2.idpoint)";
			
		$this->html="<table id='tkalendar_".$id."' style='display:none'><tr><td style='vertical-align:top'>".$this->createMonth(6,2013,"june_06_".$id,array("dates"=>array(),"weekdays"=>array(1,4,5),"range"=>array(15,31)))."</td><td style='vertical-align:top'>".$this->createMonth(7,2013,"july_07_".$id,array("dates"=>array(),"weekdays"=>array(1,4,5)))."</td><td style='vertical-align:top'>".$this->createMonth(8,2013,"august_08_".$id,array("dates"=>array(),"weekdays"=>array(1,4,5)))."</td></tr></table>";
	
	}
	public function gethtml()
	{
		print($this->html);
		
	}
}
