<?php
//-*-coding: utf-8 -*-
class Kabinet
{
	private function realCount($array)
	{
		if((count($array)>1)||($array[0]))
		{
			return count($array);
		}else
		{return 0;};
		
	}
	public function getreysdata()
	{
		$query="SELECT * FROM reyses WHERE idroute=".(int)$_GET["idroute"]." AND date='".$_GET["date"]."'";
		$res=mysql_query($query);
		$aDataReys=mysql_fetch_assoc($res);
		$query="SELECT * FROM routes WHERE idroute=".$aDataReys["idroute"]." AND idpoint='1'";
		$res=mysql_query($query);
		$aData2=mysql_fetch_assoc($res);
		$point1=$aData2["point"];
		$query="SELECT * FROM routes WHERE idroute=".$aDataReys["idroute"]." ORDER BY idpoint DESC LIMIT 1";
		$res=mysql_query($query);
		$aData2=mysql_fetch_assoc($res);
		$point2=$aData2["point"];
		$aFreePlaces=explode(",",$aDataReys["free_places"]);
		$aBookedPlaces=explode(",",$aDataReys["booked_places"]);
		$aReservedPlaces=explode(",",$aDataReys["reserved_places"]);
		//print($aDates[2].".".$aDates[1]."</br>");
		$str1=$this->realCount($aFreePlaces)."/".$this->realCount($aBookedPlaces)."/".$this->realCount($aReservedPlaces);
		$query="SELECT * FROM booking WHERE idreys=".$aDataReys["id"]." AND NOT status=2";
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		
		$strTable='<table class="bookstable"><tr><th>№</th><th>ФИО</th><th>состояние</th><th>места</th><th>льготы</th><th>стоимость</th><th>email</th><th>телефон</th><th>время заказа</th></tr>';
		$numBook=0;
		$numPaid=0;
		while (is_array($aData)&&count($aData))
		{
		
			$strButt="";
			if($aData['status']==0)
			{
				$numBook++;
				$strButt="<input type=\"button\" value=\"оплачено\"  id='butt".$aData["id"]."' onclick=\"sendZapros('/kabinet/putsetpaid','id=".$aData["id"]."',paidOk)\">";
			}
			else
			{
				$numPaid++;
			};
			$strTable.='<tr><td>'.(10100+$aData['id']).'</td><td>'.$aData['fio'].'</td><td><span id="sp'.$aData['id'].'">'.$aData['status']."</span> ".$strButt." "."<input type='button' onclick=\"sendZapros('/kabinet/putsendticket','id=".$aData["id"]."&do=send',sendTicketOk)\" value='Отправить билет'>"." "."<input type='button' onclick=\"sendZapros('/kabinet/putsendticket','id=".$aData["id"]."&do=show',showTicket)\" value='Показать билет'></td><td>".$aData['places'].'</td><td>'.$aData['num_ligoty'].'</td><td>'.$aData['price'].'</td><td>'.$aData['phone'].'</td><td>'.$aData['email'].'</td><td>'.$aData['time'].'</td></tr>';
			$aData=mysql_fetch_assoc($res);
		};
		if($aDataReys["typeavtobus"]==0)
		{
			$totalP=55;
		}elseif($aDataReys["typeavtobus"]==3)
		{
			$totalP=18;
		};
		$strTable.="</table>";
		$str2="<h3>Общие данные:</h3>\nМаршрут: ".$point1." - ".$point2." <br><span style='font-weight:900;text-decoration:underline'>Оплачено: ".$numPaid."</span> Всего мест: ".$totalP." Заявок: ".$numBook." Неоплаченных мест: ".($totalP-$numPaid)."<br> Свободных мест: ".$this->realCount($aFreePlaces)." Забронировано мест: ".$this->realCount($aBookedPlaces)." Зарезервировано мест:".$this->realCount($aReservedPlaces);
		return array("Рейс № ".$aDataReys["id"],$str2.$strTable);
		
		
	}
	public function getreyses() 
	{
	//reyses.id,reyses.date,routes.idpoint,routes.point
		$query='SELECT reyses.id as idreys, routes.idroute as idroute,point,date,reyses.typeavtobus  as avto FROM reyses,routes where reyses.idroute=routes.idroute ORDER BY reyses.id,routes.idpoint';
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$oldData=$aData;
		$oldPoint=$aData['point'];
		$oldId=$aData['idreys'];
		$str1='<table><tr><td>'.$oldId.'</td><td>'.$oldPoint.' - ';
		while (is_array($aData)&&count($aData))
		{
			//print_r($aData);
			if($oldId!=$aData['idreys'])
			{
				$str1.=$oldData["point"]."</td><td>".$oldData["idroute"]."</td><td>".$oldData['date'].'</td><td>'.$oldData['avto']."</td></tr>\n<tr><td>".$aData['idreys'].'</td><td>'.$aData["point"].' - ';
	
			};
			$oldData=$aData;
			$oldId=$aData['idreys'];
			$aData=mysql_fetch_assoc($res);
		};
		$str1.=$oldData["point"]."</td><td>".$oldData["idroute"]."</td><td>".$oldData['date'].'</td><td>'.$oldData['avto']."</td></tr>";
		return array("Рейсы",$str1."</table>");
		//return "Kabinet";
	}
	public function getbooks() 
	{
	
	
	//----------------------------------------------------------------  Таблица заказов-------------------------------------------------------------------------------------------
	//reyses.id,reyses.date,routes.idpoint,routes.point
		//$query="SELECT * from booking  where status=0 or status=1 ORDER BY idreys";
		$query="SELECT * from booking WHERE NOT status=2 ORDER BY idreys";
		//$query="SELECT * from booking  where status=2 ORDER BY idreys";
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$query="SELECT * FROM reyses WHERE id=".$aData["idreys"];
		$res2=mysql_query($query);
		$aDataReys=mysql_fetch_assoc($res2);
		$query="SELECT point FROM routes WHERE idroute=".$aDataReys["idroute"]." ORDER BY idpoint LIMIT 1";
		$res3=mysql_query($query);
		$aDataRoute=mysql_fetch_assoc($res3);
		$point1=$aDataRoute["point"];
		$query="SELECT point FROM routes WHERE idroute=".$aDataReys["idroute"]." ORDER BY idpoint DESC LIMIT 1";
		$res3=mysql_query($query);
		$aDataRoute=mysql_fetch_assoc($res3);
		$point2=$aDataRoute["point"];
		$aTables=array();
		$strRoute=$point1." - ".$point2;
			$strDate=$aDataReys["date"];
		$str1='<table class="bookstable"><tr><th>№</th><th>ФИО</th><th>состояние</th><th>места</th><th>льготы</th><th>стоимость</th><th>email</th><th>телефон</th><th>время заказа</th></tr>';
		//$str1.="<tr><td colspan=10 style='font-size:120%;background-color:white;color:#35A;text-align:center'>".$point1." - ".$point2." ".$aDataReys["date"]."</td></tr>";
		$oldIdReys=$aData["idreys"];
		while (is_array($aData)&&count($aData))
		{
		
		if($oldIdReys!=$aData["idreys"])
		{
			$query="SELECT * FROM reyses WHERE id=".$aData["idreys"];
			$res2=mysql_query($query);
			$aDataReys=mysql_fetch_assoc($res2);
			$query="SELECT point FROM routes WHERE idroute=".$aDataReys["idroute"]." ORDER BY idpoint LIMIT 1";
			$res3=mysql_query($query);
			$aDataRoute=mysql_fetch_assoc($res3);
			$point1=$aDataRoute["point"];
			$query="SELECT point FROM routes WHERE idroute=".$aDataReys["idroute"]." ORDER BY idpoint DESC LIMIT 1";
			$res3=mysql_query($query);
			$aDataRoute=mysql_fetch_assoc($res3);
			$point2=$aDataRoute["point"];
			//$str1.="<tr><td colspan=10 style='font-size:120%;background-color:white;color:#35A;text-align:center'>".$point1." - ".$point2." ".$aDataReys["date"]."</td></tr>";
			$strRoute=$point1." - ".$point2;
			$strDate=$aDataReys["date"];
			$oldIdReys=$aData["idreys"];
		};
		//	print_r($aData);
		$strButt="";
		if($aData['status']==0){$strButt="<input type=\"button\" value=\"оплачено\"  id='butt".$aData["id"]."' onclick=\"sendZapros('/kabinet/putsetpaid','id=".$aData["id"]."',paidOk)\">";};
			//$str1.='<tr><td>'.$aData['id'].'</td><td>'.$aData['fio'].'</td><td>'.$aData['email'].'</td><td>'.$aData['phone'].'</td><td>'.$aData['time'].'</td><td><span id="sp'.$aData['id'].'">'.$aData['status']."</span> ".$strButt."</td><td>".$aData['places'].'</td><td>'.$aData['idreys'].'</td><td>'.$aData['num_ligoty'].'</td><td>'.$aData['price'].'</td></tr>';
			$aTables[$strRoute][$strDate].='<tr><td>'.(10100+$aData['id']).'</td><td>'.$aData['fio'].'</td><td><span id="sp'.$aData['id'].'">'.$aData['status']."</span> ".$strButt." "."<input type='button' onclick=\"sendZapros('/kabinet/putsendticket','id=".$aData["id"]."&do=send',sendTicketOk)\" value='Отправить билет'>"." "."<input type='button' onclick=\"sendZapros('/kabinet/putsendticket','id=".$aData["id"]."&do=show',showTicket)\" value='Показать билет'></td><td>".$aData['places'].'</td><td>'.$aData['num_ligoty'].'</td><td>'.$aData['price'].'</td><td>'.$aData['phone'].'</td><td>'.$aData['email'].'</td><td>'.$aData['time'].'</td></tr>';
			$aData=mysql_fetch_assoc($res);
		};
		foreach($aTables as $strRoute=>$aData)
		{
			ksort($aData);
			foreach($aData as $strDate=>$aTR)
			{
				$str1.="<tr><td colspan=10 style='font-size:120%;background-color:white;color:#35A;text-align:left'>".$strRoute."<br>".$strDate."</td></tr>".$aTR;
				/*foreach($aTRs as $num=>$strTR)
				{
					
				};*/
			};
		};
		return array("Заявки",$str1.'</table>');
		//----------------------------------------------------------------  Таблица заказов-------------------------------------------------------------------------------------------
	
	
	
	
		//return "Kabinet";
	}
	public function getroutedata()
	{
		
		require_once('funcDates.php');
		require_once('ViewKalendar.php');
		$oDates=new funcDates();
		$oMJune=new ViewMonth('Июнь');
		$oMJuly=new ViewMonth('Июль');
		$oMAugust=new ViewMonth('Август');
		
		$query="select * from routes order by idroute,idpoint";
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$oldData=$aData;
		$id=1;
		$strTable="<table class='maintable'><caption style='position:fixed;width:100%;text-align:center;margin:0px'>Маршруты</caption>\n<thead><tr><th class='numroute'>№ м-та</th><th  class='thpoints'>Города</th><th class='thkalendar'>Календарь рейсов</th></tr></thead><tbody>\n<tr style='height:70px'><td colspan=3>&nbsp;</td></tr><tr><td class='tdnumroute'>".$aData['idroute']."</td><td class='tdpoints'>".$aData['point'];
		while (is_array($aData)&&(0!=count($aData)))
		{
			//нужно определить дни рейсов по дням недели;
			
			if($aData["idroute"]!=$oldData["idroute"])
			{
				$query="select * from reyses where idroute=".$oldData['idroute'];
				$res2=mysql_query($query);
				$aDataReys=mysql_fetch_assoc($res2);
				$oMJune->setRange(17);
				while (is_array($aDataReys)&&(count($aDataReys)!=0))
				{
					$aDates=explode("-",$aDataReys["date"]);
					$aFreePlaces=explode(",",$aDataReys["free_places"]);
					$aBookedPlaces=explode(",",$aDataReys["booked_places"]);
					$aReservedPlaces=explode(",",$aDataReys["reserved_places"]);
					//print($aDates[2].".".$aDates[1]."</br>");
					$str1="<td class='day-act'><sup>".$this->realCount($aFreePlaces)."/".$this->realCount($aBookedPlaces)."/".$this->realCount($aReservedPlaces).""."</sup><br><span>{NUM}</span></td>";
					switch($aDates[1])
					{
						case "06":
							$oMJune->addDate($aDates[2],$str1);
						break;
						case "07":
							$oMJuly->addDate($aDates[2],$str1);
						break;
						case "08":
							$oMAugust->addDate($aDates[2],$str1);
						break;
					};
					
					//в классе funcDates изменить метод createMonth так, чтобы можно было добавить шаблон.
					$aDataReys=mysql_fetch_assoc($res2);
				};
				$id=$oldData["idroute"];
				//$oMJune->dShowDates();
				$strTable.="<br>".$oldData['point']."</td><td class='tdkalendar'>\n<!--kalendar-->\n\n<table id='tkalendar".$id."' ><tr><td style='vertical-align:top'>".$oDates->createHTMLMonth($oMJune,"june_06_".$id)."</td><td style='vertical-align:top'>".$oDates->createHTMLMonth($oMJuly,"july_07_".$id)."</td><td style='vertical-align:top'>".$oDates->createHTMLMonth($oMAugust,"august_08_".$id)."</td></tr></table>\n<!--kalendar-->\n\n</td></tr><tr><td class='tdnumroute'>".$aData['idroute']."</td><td class='tdpoints'>".$aData['point'];
				$oMJune->clearDates();
				$oMJuly->clearDates();
				$oMAugust->clearDates();
			}
			
			else
			{
				//$strTable.="<br>".$aData['point'];
			};
			if($aData["days"]&&($aData["days"]!="*"))
			{	$aDays=explode(",",$aData["days"]);
				$str1="<td class='day-act'><span>{NUM}</span></td>";
				foreach($aDays as $num=>$day)
				{
					$oMJune->addDay($day,$str1);
					$oMJuly->addDay($day,$str1);
					$oMAugust->addDay($day,$str1);
				};
			};
			$oldData=$aData;
			$aData=mysql_fetch_assoc($res);
		};
		$query="select * from reyses where idroute=".$oldData['idroute'];
		$res2=mysql_query($query);
		$aDataReys=mysql_fetch_assoc($res2);
		$oMJune->setRange(17);
		while (is_array($aDataReys)&&(count($aDataReys)!=0))
		{
			$aDates=explode("-",$aDataReys["date"]);
			$aFreePlaces=explode(",",$aDataReys["free_places"]);
			$aBookedPlaces=explode(",",$aDataReys["booked_places"]);
			$aReservedPlaces=explode(",",$aDataReys["reserved_places"]);
			//print($aDates[2].".".$aDates[1]."</br>");
			$str1="<td class='day-act'><sup>".$this->realCount($aFreePlaces)."/".$this->realCount($aBookedPlaces)."/".$this->realCount($aReservedPlaces).""."</sup><br><span>{NUM}</span></td>";
			switch($aDates[1])
			{
				case "06":
					$oMJune->addDate($aDates[2],$str1);
				break;
				case "07":
					$oMJuly->addDate($aDates[2],$str1);
				break;
				case "08":
					$oMAugust->addDate($aDates[2],$str1);
				break;
			};
			
			//в классе funcDates изменить метод createMonth так, чтобы можно было добавить шаблон.
			$aDataReys=mysql_fetch_assoc($res2);
		};
		$id=$oldData["idroute"];
		//$oMJune->dShowDates();
		$strTable.="<br>".$oldData['point']."</td><td class='tdkalendar'>\n<!--kalendar-->\n\n<table id='tkalendar".$id."' ><tr><td style='vertical-align:top'>".$oDates->createHTMLMonth($oMJune,"june_06_".$id)."</td><td style='vertical-align:top'>".$oDates->createHTMLMonth($oMJuly,"july_07_".$id)."</td><td style='vertical-align:top'>".$oDates->createHTMLMonth($oMAugust,"august_08_".$id)."</td></tr></table>\n<!--kalendar-->\n\n</td></tr><tr><td>".$aData['idroute']."</td></tr></tbody></table>";
		
		return array("Управление рейсами",$strTable);
	}
	public function setpaid()
	{
		$query="UPDATE booking SET status=1 WHERE id=".$_POST["id"];
		$res=mysql_query($query);
		if(mysql_errno())
		{
			return "ERROR";
		}else
		{
			return "OK_".$_POST["id"];
		};
	}
	public function getReys()
	{
		$query="SELECT * FROM reyses WHERE id=".$_GET["id"];
		
	}
	public function freeplaces()
	{
		$query="SELECT * FROM reyses WHERE date='".$_POST["date"]."' and idroute=".$_POST["idroute"];
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$aFreeP=explode(",",$aData["free_places"]);
		$aBookP=explode(",",$aData["booked_places"]);
		$aReservP=explode(",",$aData["reserved_places"]);
		$aNewFreeP=explode(",",$_POST["places"]);
		
		$aFreeP=array_merge($aFreeP,$aNewFreeP);
		$aBookP=array_diff($aBookP,$aNewFreeP);
		$aReservP=array_diff($aReservP,$aNewFreeP);
		
		foreach($aFreeP as $num=>$value)
		{
			if(!$value)
			{unset($aFreeP[$num]);};
		};
		sort($aFreeP);
		sort($aBookP);
		sort($aReservP);
		$aFreeP=array_unique($aFreeP);
		$aBookP=array_unique($aBookP);
		$aReservP=array_unique($aReservP);
		$strFree=implode(",",$aFreeP);
		$strBook=implode(",",$aBookP);
		$strReserv=implode(",",$aReservP);
		//$str=implode(",",$aFreeP)."\n".implode(",",$aBookP)."\n".implode(",",$aReservP)."\n";
		mysql_query("UPDATE reyses set free_places='".$strFree."',booked_places='".$strBook."',reserved_places='".$strReserv."' WHERE date='".$_POST["date"]."' and idroute=".$_POST["idroute"]);
		$query="SELECT * FROM reyses WHERE date='".$_POST["date"]."' and idroute=".$_POST["idroute"];
		//print($query);
		$res=mysql_query($query);
		$aDataReys=mysql_fetch_assoc($res);
		$aFreePlaces=explode(",",$aDataReys["free_places"]);
		$aBookedPlaces=explode(",",$aDataReys["booked_places"]);
		$aReservedPlaces=explode(",",$aDataReys["reserved_places"]);
		//print($aDates[2].".".$aDates[1]."</br>");
		$str1=$this->realCount($aFreePlaces)."/".$this->realCount($aBookedPlaces)."/".$this->realCount($aReservedPlaces);
		return $str1;
		
	}
	public function changeavtobus()
	{
		
		$query="SELECT * FROM reyses WHERE date='".$_POST["date"]."' and idroute=".$_POST["idroute"];
		//print($query);
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$aFreeP=explode(",",$aData["free_places"]);
		$aBookP=explode(",",$aData["booked_places"]);
		$aReservP=explode(",",$aData["reserved_places"]);
		$typeAvtobus=$aData["typeavtobus"];
		if($typeAvtobus==0)
		{
			for ($j=1;$j<19;$j++)
			{
				$aNewFreeP[]=$j;
			};
			foreach($aFreeP as $num=>$value)
			{
				if((!$value)||($value>18))
				{
					unset($aFreeP[$num]);
					
				};
			};
			foreach($aBookP as $num=>$value)
			{
				if((!$value)||($value>18))
				{
					unset($aBookP[$num]);
					
				};
			};
			foreach($aReservP as $num=>$value)
			{
				if((!$value)||($value>18))
				{
					unset($aReservP[$num]);
					
				};
			};
			$typeAvtobus=3;
		}elseif($typeAvtobus==3)
		{
			for ($j=1;$j<56;$j++)
			{
				$aNewFreeP[]=$j;
			};
		
			foreach($aFreeP as $num=>$value)
			{
				if(!$value)
				{
					unset($aFreeP[$num]);
					
				};
			};
			foreach($aBookP as $num=>$value)
			{
				if(!$value)
				{
					unset($aBookP[$num]);
					
				};
			};
			foreach($aReservP as $num=>$value)
			{
				if(!$value)
				{
					unset($aReservP[$num]);
					
				};
			};
			$typeAvtobus=0;
		};
		$aNewFreeP=array_diff($aNewFreeP,$aBookP);
		$aNewFreeP=array_diff($aNewFreeP,$aReservP);
		$aFreeP=array_merge($aFreeP,$aNewFreeP);
	
		$aFreeP=array_unique($aFreeP);
		$aBookP=array_unique($aBookP);
		$aReservP=array_unique($aReservP);
		sort($aFreeP);
		sort($aBookP);
		sort($aReservP);
		$strFree=implode(",",$aFreeP);
		$strBook=implode(",",$aBookP);
		$strReserv=implode(",",$aReservP);
		//$str=$aData["free_places"]."\n".$aData["booked_places"]."\n".$aData["reserved_places"]."\n".$strFree."\n".$strBook."\n".$strReserv."\n";
		$query="UPDATE reyses set free_places='".$strFree."',booked_places='".$strBook."',reserved_places='".$strReserv."',typeavtobus='".$typeAvtobus."' WHERE date='".$_POST["date"]."' and idroute=".$_POST["idroute"];
		//print("\n".$query."\n");
		mysql_query($query);
		$query="SELECT * FROM reyses WHERE date='".$_POST["date"]."' and idroute=".$_POST["idroute"];
		//print($query);
		$res=mysql_query($query);
		$aDataReys=mysql_fetch_assoc($res);
		$aFreePlaces=explode(",",$aDataReys["free_places"]);
		$aBookedPlaces=explode(",",$aDataReys["booked_places"]);
		$aReservedPlaces=explode(",",$aDataReys["reserved_places"]);
		//print($aDates[2].".".$aDates[1]."</br>");
		$str1=$this->realCount($aFreePlaces)."/".$this->realCount($aBookedPlaces)."/".$this->realCount($aReservedPlaces);
		
		return $str1;
		
	}
	public function addreys()
	{
		//print ($_POST["idroute"]." ".$_POST["date"]." ".$_POST["typeavto"]);
		$query="SELECT * FROM reyses WHERE idroute=".$_POST["idroute"]." and date='".$_POST["date"]."'";
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		if(is_array($aData) && (count($aData)>0))
		{
			print("var oAnswer={'kod':'1','message':'Рейс существует под номером ".$aData["id"]."'}");
		}
		else
		{
			if($_POST["typeavtobus"]==3)
			{
			
			$query="insert into reyses (idroute,free_places,booked_places,reserved_places,date,typeavtobus) values(".$_POST["idroute"].",'4,5,6,7,8,9,10,11,12,13,14,15,16,17,18','','1,2,3','".$_POST["date"]."',3)";
			$strOut="15/0/3";
			}elseif($_POST["typeavtobus"]==0)
			{
				$query="insert into reyses (idroute,free_places,booked_places,reserved_places,date,typeavtobus) values(".$_POST["idroute"]."5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55','','1,2,3,4','".$_POST["date"]."',0)";
				$strOut="50/0/5";
			};
			mysql_query($query);
			print("var oAnswer={'kod':'0','message':\"".$strOut."\"}");
		};
	}
	public function sendticket()
	{
		require_once("Ticket.php");
		require_once("Mail.php");
		$id=(int)$_POST["id"];
		$query="SELECT * FROM booking WHERE id=".$id;
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$tt=new Ticket(10100+$id);
		$fName=$tt->create();
		//print($aData["phone"]);
		if($_POST["do"]=="send")
		{
			$mail1=new Mail($aData["phone"],"no-reply@tickets.777tur.com","Заказ билета",$fName,"билет.pdf");
			$mail1->send("<br>Вы приобрели  билет в турагентстве \"777тур\". Билет во вложении. Распечатайте его или запомните номер.<br>С уважением топ-менеджер транспортного центра «Новый Симферополь», Татьяна.");
		}else
		{
			print(basename($fName));
		};
	}
	
}