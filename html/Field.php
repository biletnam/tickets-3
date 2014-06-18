<?php
//-*-coding: utf-8 -*-
abstract class Field
{
	
	const ERROR_CSS_CLASS="error-field";
	const OK_CSS_CLASS="field";
	protected $name;
	protected $html;
	protected $id;
	protected $script;
	protected $value;
	protected $message;
	protected $label;
	protected $cssClass=self::OK_CSS_CLASS;
	protected $quote="'";
	protected $requiredV;
	protected $patt;
	
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		$this->id=$id;
		$this->name=$name;
		$this->patt=$patt;
		$this->message=$message;
		$this->label=$label;
		$this->required=$required;
		
	}
	public function setReadonly()
	{
		$this->html=str_replace(">"," readonly>",$this->html);
	}
	public function isRequired()
	{
		return $this->required;
	}
	public function getScript()
	{
		return $this->script;
	}
	protected function setHtmlAttr($name,$value,$str)
	{
		return str_replace($name."=\"\"",$name."=\"".$value."\"",$str);
	}
	public function getName()
	{
		return $this->name;
	}
	public function setValue($value)
	{
		$this->value=$value;
	}
	public function getValue()
	{
		return $this->value;
	}
	public function getQuote()
	{
		return $this->quote;
	}
	public function getHtmlLabel()
	{
		return "<label for=\"".$this->id."\">".$this->label."</label>";
	}
	public function getHtml($type)
	{
		$strHtml=$this->setHtmlAttr("name",$this->name,$this->html);
		$strHtml=$this->setHtmlAttr("id",$this->id,$strHtml);
		switch ($type)
		{
			case Form::NEWF:
				//$strHtml=str_replace("value=\"\"","",$strHtml);
				$strHtml=$this->setHtmlAttr("value",$this->value,$strHtml);
				$strHtml=$this->setHtmlAttr("class",self::OK_CSS_CLASS,$strHtml);
				
			break;
			case Form::EDITF:
				$strHtml=$this->setHtmlAttr("value",$this->value,$strHtml);
				$strHtml=$this->setHtmlAttr("class",self::OK_CSS_CLASS,$strHtml);
			break;
			case Form::COMPLIT:
				$cssClass=$this->check();
				$strHtml=$this->setHtmlAttr("value",$this->value,$strHtml);
				$strHtml=$this->setHtmlAttr("class",$this->cssClass,$strHtml);
		}
		return $strHtml;
	}
	abstract public function check($obj);
	
}
class FText extends Field
{
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		$this->html="<input value=\"\" class=\"\" id=\"\" name=\"\" type=\"text\">";
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function check($obj)
	{
		$flag=false;
		$this->cssClass=parent::ERROR_CSS_CLASS;
		if(preg_match($this->patt,$this->value))
		{
			$this->cssClass=parent::ERROR_CSS_CLASS;
			$obj->addMessage($this->message);
			$flag=true;
		};
		if(($this->required)&&(!$this->value))
		{
			$obj->addMessage("Поле ".$this->label." должно быть заполнено");
			$flag=true;
		}
		return false;
		
	}
}
class FTextarea extends Field
{
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		$this->html="<TEXTAREA value=\"\" class=\"\" id=\"\" name=\"\"></TEXTAREA>";
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function check($obj)
	{
		$this->cssClass=parent::ERROR_CSS_CLASS;
		if(preg_match($this->patt,$this->value))
		{
			$this->cssClass=parent::ERROR_CSS_CLASS;
			$obj->addMessage($this->message);
			return true;
		};
		return false;
		
	}
}
class FPoints extends Field
{
	private $aPoints=array();
	
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		mysql_connect(Config::$host,Config::$user,Config::$parol);
		mysql_query("SET NAMES 'utf8'");
		mysql_query("USE ".Config::$db);
		$res=mysql_query("SELECT DISTINCT point FROM routes WHERE sector=0 AND status=1");
		$aData=mysql_fetch_assoc($res);
		$towns=array();
		while (is_array($aData))
		{
			$towns[]=$aData["point"];
			$aData=mysql_fetch_assoc($res);
		};
		sort($towns);
		$strScript="";
		$strDiv="";
		foreach($towns as $num=>$town)
		{
			$strScript.="'$town',";
			$strDiv.=$town."</br>";
		};
		
		$strScript0="<script>var oTT={'1':new Array(".substr($strScript,0,-1)."),";
		$res=mysql_query("SELECT DISTINCT point FROM routes WHERE sector=1 AND status=1");
		$aData=mysql_fetch_assoc($res);
		$towns=array();
		while (is_array($aData))
		{
			$towns[]=$aData["point"];
			$aData=mysql_fetch_assoc($res);
		};
		sort($towns);
		$strScript2="";
		$strDiv="";
		foreach($towns as $num=>$town)
		{
			$strScript2.="'$town',";
			$strDiv.=$town."</br>";
		};
		$strScript0.="'2':new Array(".substr($strScript2,0,-1)."),'0':new Array(".$strScript.substr($strScript2,0,-1).")};</script>";
		$this->html="<input value=\"\" class=\"\" id=\"\" name=\"\" type=\"text\">";
		$this->script=$strScript0;
		$this->html="<input name=\"".$name."\" id=\"".$id."\" readonly  value=\"\">";
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function addPoints($idT,$caption,$aPs)
	{
		$this->aPoints[$idT]["caption"]=$caption;
		$this->aPoints[$idT]["points"]=$aPs;
	}
	public function initPoints()
	{
		$num=count($this->aPoints);
		$width=ceil(330/$num-1);
		$strHtml="<div class='dpoints' id='d".$this->id."'>";
		foreach($this->aPoints as $idT=>$aDatas)
		{
			$strHtml.='<div class="colpoints" style="width:'.$width.'px" id="'.$idT.'">';
			$strHtml.=$aDatas['caption'].'<br>';
			foreach($aDatas['points'] as $numP=>$point)
			{
				$strHtml.='<p>'.$point.'</p>';
			}
			$strHtml.='</div>';
		};
		$this->html.=$strHtml.'</div>';
	}
	public function check($obj)
	{return true;
	}
}
class FCalendar extends Field
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
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		$this->html="<input value=\"\" class=\"\" id=\"\" name=\"\" rel=\"calendar\" type=\"text\" readonly><table id='tkalendar_".$id."' style='display:none'><tr><td style='vertical-align:top'>".$this->createMonth(7,2013,"july_07_".$id,array("dates"=>array(),"weekdays"=>array(1,4,5)))."</td><td style='vertical-align:top'>".$this->createMonth(8,2013,"august_08_".$id,array("dates"=>array(),"weekdays"=>array(1,4,5)))."</td></tr></table>";
		
		$this->script="/js/calendar.js";
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function check($obj)
	{
		$this->cssClass=parent::ERROR_CSS_CLASS;
		if(preg_match($this->patt,$this->value))
		{
			$this->cssClass=parent::ERROR_CSS_CLASS;
			$obj->addMessage($this->message);
			return true;
		};
		return false;
		
	}
}

class FCalendar2 extends Field
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
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		$this->html="<input value=\"\" class=\"\" id=\"\" name=\"\" rel=\"calendar\" type=\"text\" readonly><table id='tkalendar_".$id."' style='display:none'><tr><td style='vertical-align:top'>".$this->createMonth(7,2013,"july_07_".$id,array("dates"=>array(),"weekdays"=>array(2,5,6),"range"=>array(date("d"),32)))."</td><td style='vertical-align:top'>".$this->createMonth(8,2013,"august_08_".$id,array("dates"=>array(),"weekdays"=>array(2,5,6)))."</td></tr></table>";
		
		$this->script="/js/calendar.js";
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function check($obj)
	{
		$this->cssClass=parent::ERROR_CSS_CLASS;
		if(preg_match($this->patt,$this->value))
		{
			$this->cssClass=parent::ERROR_CSS_CLASS;
			$obj->addMessage($this->message);
			return true;
		};
		return false;
		
	}
}
class FCheckbox extends Field
{
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		$this->html="<input value=\"\" class=\"check\" id=\"\" name=\"\"  type=\"checkbox\">";
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function check($obj)
	{
		$this->cssClass=parent::OK_CSS_CLASS;
		if(preg_match($this->patt,$this->value))
		{
			$obj->addMessage($this->message);
			return true;
		};
		return false;
		
	}
	public function setChecked()
	{
		$this->html=str_replace("type=\"checkbox\"","type=\"checkbox\" checked",$this->html);
	}
}
class FButton extends Field
{
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		$this->html="<input value=\"\" class=\"\" id=\"\" name=\"\" type=\"button\">";
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function check($obj)
	{
		$this->cssClass=parent::OK_CSS_CLASS;
		if(preg_match($this->patt,$this->value))
		{
			$obj->addMessage($this->message);
			return true;
		};
		return false;
		
	}
}
class FAutoDop extends Field
{
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		mysql_connect(Config::$host,Config::$user,Config::$parol);
		mysql_query("SET NAMES 'utf8'");
		mysql_query("USE ".Config::$db);
		$res=mysql_query("SELECT DISTINCT point FROM routes WHERE sector=0");
		$aData=mysql_fetch_assoc($res);
		$towns=array();
		while (is_array($aData))
		{
			$towns[]=$aData["point"];
			$aData=mysql_fetch_assoc($res);
		};
		sort($towns);
		$strScript="";
		$strDiv="";
		foreach($towns as $num=>$town)
		{
			$strScript.="'$town',";
			$strDiv.=$town."</br>";
		};
		
		$strScript0="<script>var oTT={'1':new Array(".substr($strScript,0,-1)."),";
		$res=mysql_query("SELECT DISTINCT point FROM routes WHERE sector=1");
		$aData=mysql_fetch_assoc($res);
		$towns=array();
		while (is_array($aData))
		{
			$towns[]=$aData["point"];
			$aData=mysql_fetch_assoc($res);
		};
		sort($towns);
		$strScript2="";
		$strDiv="";
		foreach($towns as $num=>$town)
		{
			$strScript2.="'$town',";
			$strDiv.=$town."</br>";
		};
		$strScript0.="'2':new Array(".substr($strScript2,0,-1)."),'0':new Array(".$strScript.substr($strScript2,0,-1).")};</script>";
		$this->html="<input value=\"\" class=\"\" id=\"\" name=\"\" type=\"text\">";
		$this->script=$strScript0;
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function check($obj)
	{
		$this->cssClass=parent::OK_CSS_CLASS;
		if(preg_match($this->patt,$this->value))
		{
			$obj->addMessage($this->message);
			return true;
		};
		return false;
		
	}
}
class FSelect extends Field
{
	private $aOptions=array();
	public function __construct($name,$id,$patt,$message,$label="",$required=false)
	{
		$this->html="<SELECT value=\"\" class=\"\" id=\"\" name=\"\">\n";
		parent::__construct($name,$id,$patt,$message,$label,$required);
	}
	public function check($obj)
	{
		$this->cssClass=parent::OK_CSS_CLASS;
		if(preg_match($this->patt,$this->value))
		{
			$obj->addMessage($this->message);
			return true;
		};
		return false;
	}
	public function addOptions()
	{
		$args=func_get_args();
		foreach($args as $num=>$arg)
		{
			$aArg=explode(":",$arg);
			if(count($aArg)==2)
			{
				$aTemp["option"]=$aArg[0];
				$aTemp["value"]=$aArg[1];
				
			}else
			{
				$aTemp["option"]=$aArg[0];
				$aTemp["value"]="";
			};
			$this->aOptions[]=$aTemp;
		}
	}
	public function compile()
	{
		foreach($this->aOptions as $num=>$option)
		{
			if($option["value"])
			{
				$this->html.="<OPTION value=\"".$option["value"]."\">".$option["option"]."</OPTION>\n";
			}else
			{
				$this->html.="<OPTION>".$option["option"]."</OPTION>\n";
			};
		};
		
	}

}
