<?php
//-*-coding: utf-8 -*-
class funcDates
{
	protected $aDays=array("понедельник","вторник","среда","четверг","пятница","суббота","воскресенье");
	protected $aShortDays=array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
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
	public function getDates($nameDay,$month,$year)
	{
		$aDates=array();
		$firstDay=date("w",mktime(0,0,0,$month,1,$year));
		$numLastDay=date("d",mktime(0,0,0,$month+1,-1,$year))+1;
		$numWDay=array_search($nameDay,$this->aDays);
		
		
	//	print($this->transDay($firstDay)."<br>");
	//	print($numLastDay."<br>");
		
		$firstNeedDay=((7+$numWDay-$this->transDay($firstDay)) % 7)+1;
		while ($firstNeedDay<=$numLastDay)
		{
			$aDates[]=$firstNeedDay;
			$firstNeedDay+=7;
		};
		return $aDates;
	}
	public function setRange($first,$last,$aDates)
	{
		$aTemp=array();
		foreach($aDates as $num=>$day)
		{
			if(($day>=$first)&&($day<=$last))
			{
				$aTemp[]=$day;
			};
		};
		return $aTemp;
	}
	public function getWName($num)
	{
		return $this->aDays[$num];
	}
	public function createMonth($month,$year,$id,$days=array("dates"=>array(),"weekdays"=>array()))
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
	public function createHTMLMonth($oMonth,$id,$year='2013')
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
		$timeFirstDay=mktime(0,0,0,$oMonth->getNum(),1,$year);
		$timeLastDay=mktime(0,0,0,$oMonth->getNum()+1,-1,$year);
		
		$firstWeekDay=$this->transDay(date("w",$timeFirstDay));
		$lastDay=date("d",$timeLastDay)+1;
		$strKalendar="<table class='kalendar' id='".$id."'><caption>".$this->aMonths[$oMonth->getNum()-1]."</caption><tbody><tr>";
		foreach($this->aShortDays as $num=>$strWDay)
		{
			$strKalendar.="<th>".$strWDay."</th>";
		};
		$strKalendar.="</tr><tr>";
		while($numWeekDay<$firstWeekDay)
		{
			//$strKalendar.="<td class='no-num'>&nbsp;</td>";
			$strKalendar.=$oMonth->getHtmlDay("","no");
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
			/*$nmClass="day-cell";
			if(in_array($numDay ,$days["dates"])||(in_array($numWeekDay,$days["weekdays"]))&&(!key_exists("range",$days)||(($numDay>=$days["range"][0])&&($numDay<=$days["range"][1]))))
			{$nmClass="day-act";};
			$strKalendar.="<td class='".$nmClass."'>$numDay</td>";*/
			$strKalendar.=$oMonth->getHtmlDay($numDay,$numWeekDay);
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
				//$strKalendar.="<td class='no-num'>&nbsp;</td>";
				$strKalendar.=$oMonth->getHtmlDay("","no");
				$numWeekDay++;
			};
		};	
		$strKalendar.="</tr></tbody></table>";
		return $strKalendar;
	}
	public function getMonthNum($name)
	{
		$num=array_search($name,$this->aMonths);
		$num++;
		return $num;
	}
	public function getNumWDay($name)
	{
		return array_search($name,$this->aDays);
	}
}