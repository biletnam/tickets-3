 <?php
//-*-coding: utf-8 -*-

class Mainform
{
	private $form1;
	private function getTowns($sector,$status=1)
	{
		$res=mysql_query("SELECT DISTINCT point FROM routes WHERE sector=".$sector." AND status=".$status);
		$aData=mysql_fetch_assoc($res);
		$towns=array();
		while (is_array($aData))
		{
			$towns[]=$aData["point"];
			$aData=mysql_fetch_assoc($res);
			
		};
		sort($towns);
		return $towns;
	}
	public function __construct()
	{
		require_once("config.php");
		require_once(Config::$dir0."/html/Form.php");
		require_once(Config::$dir0."/html/Field.php");
		require_once("QueryBD.php");
		require_once("Mail.php");
		require_once("Reys.php");
		require_once("avtobus.php");
		require_once("Invoice.php");
		mysql_connect(Config::$host,Config::$user,Config::$parol);
		mysql_query("SET NAMES 'utf8'");
		mysql_query("USE ".Config::$db);
		
		$this->form1=new Form("","POST",FORM::ENCTYPE,"view/form2.php");
		$this->form1->setHtmlRequired("");
		$fKod=new FText("kodagency",'id_kod','/[0-9a-zA-Z]{4}/','Поле "код" должно содержать только цифры и буквы латинского алфавита','код');
		$field1=new FPoints("point1","inp1","/.*?/",'поле "Откуда" не может содержать цифры',"Откуда:",true);
		$field1->setValue("--Выберите пункт отправления--");
		$towns0=$this->getTowns(0);
		$field1->addPoints("t_points1","НА МОРЕ",$towns0);
		$towns1=$this->getTowns(1);
		$field1->addPoints("t_points2","ОБРАТНО",$towns1);
		$field1->initPoints();
		
		$field2=new FPoints("point2","inp2","/.*?/",'поле "Куда" не может содержать цифры',"Куда:",true);
		$field2->setValue("--Выберите пункт прибытия--");
		$field2->addPoints("t_points3","",$towns0);
		$field2->addPoints("t_points4","",$towns1);
		$field2->initPoints();
		
		$field3=new FPoints("point3","inp8","/.*?/",'поле "Откуда" не может содержать цифры',"Откуда:",true);
		$field3->setValue("--Выберите пункт отправления--");
		$field3->addPoints("t_points5","",$towns0);
		$field3->addPoints("t_points6","",$towns1);
		$field3->initPoints();
		
		$field4=new FPoints("point4","inp9","/.*?/",'поле "Куда" не может содержать цифры',"Куда:",true);
		$field4->setValue("--Выберите пункт прибытия--");
		$field4->addPoints("t_point7","",$towns0);
		$field4->addPoints("t_points8","",$towns1);
		$field4->initPoints();
		
		$fieldCalendar= new FCalendar("date1","inp3","/.*/",'поле "Число" должно содержать дату',"Число: ",true);
		$fieldCalendar2= new FCalendar2("date2","inp10","/.*/",'поле "Число" должно содержать дату',"Число: ",true);
		$fPlaces1=new FSelect("places1","inpplaces1","/.*/",'Поле "Количество мест" неправильно заполнено',"Количество мест: ",true);
		$fPlaces1->addOptions(1,2,3,4,5,6,7);
		$fPlaces1->compile();
		//$fPlaces1->setReadonly();
		$fPlaces2=new FSelect("places2","inpplaces2","/[0-9,]*/",'Поле "Количество мест" неправильно заполнено',"Количество мест: ",true);
		$fPlaces2->addOptions(1,2,3,4,5,6,7);
		
		$fPlaces2->compile();
		//$fPlaces1->setReadonly();
		$fieldFIO=new FText("fio","inp5","/.*/","","ФИО:",true);
		$fieldEmail=new FText("email","inp6","/.*/","","email:",true);
		$fieldPhone=new FText("phone","inp7","/.*/","","Телефон:",true);
		$rTicket=new FCheckbox("rticket","check2","/.*/","","Без обратного билета");
		$this->form1->addFields($field1,$field2,$fieldCalendar,$field3,$field4,$fieldCalendar2,$fPlaces1,$fPlaces2,$rTicket,$fKod);
		$this->form1->addFields($fieldFIO,$fieldEmail,$fieldPhone);
		
	}
	public function show()
	{
		$strHtml=$this->form1->compile("Form::NEWF");
		print($strHtml);
		
	}
	public function getdata()
	{
		require_once("RouteMan.php");
		
		$rsql=mysql_connect(Config::$host,Config::$user,Config::$parol);
		mysql_query("USE ".Config::$db);
		mysql_query("SET NAMES 'utf8'");
		$rmDB=new RouteManDB();
		
		$idReys=(int)$_POST["reys1"];
		if($idReys==-1)
		{
			$query="SELECT * FROM routes as t1,routes as t2 WHERE (t1.point ='".$_POST["point1"]."') AND(t2.point ='".$_POST["point2"]."') AND (t1.idroute=t2.idroute) AND(t1.idpoint<t2.idpoint)";
			$res=mysql_query($query);
			$aData=mysql_fetch_assoc($res);
			$reys=new Reys();
			$query="SELECT * FROM routesetting WHERE idroute=".$_POST["route1"];
			$res=mysql_query($query);
			$aData=mysql_fetch_assoc($res);
			$reys->initAvtobus($aData["typeavtobus"]);
			$avtobus=$reys->getAvtobus();
			$reys->setDate($_POST["date1"]);
			$reys->setRoute($_POST["route1"]);
			$aR=explode(",",$aData["free_places"]);
			$avtobus->freeking($aR);
			$aR=explode(",",$aData["reserved_places"]);
			$avtobus->reserving($aR);
			$dateReys=$reys->getDate("db");
			$query="INSERT INTO `reyses` (`idroute`,`free_places`,`booked_places`,`reserved_places`,`date`,`typeavtobus`) VALUES (".$reys->getRoute().",'".$avtobus->getStrPlaces("free")."','".$avtobus->getStrPlaces("booked")."','".$avtobus->getStrPlaces("reserved")."','".$dateReys."',".$avtobus->getProp("type").")";
			$res=mysql_query($query);
			$res=mysql_query("SELECT LAST_INSERT_ID();");
			$aData=mysql_fetch_assoc($res);
			$idReys=$aData["LAST_INSERT_ID()"];
			
			//$res=mysql_query($query);
		};
			$price0=$rmDB->getPrice($_POST["route1"],$_POST["point1"],$_POST["point2"]);
			
			$numPlaces=(int)$_POST["places1"];
			$price1=$price0*$numPlaces;
			$query="INSERT INTO `booking` (`fio`,`phone`,`email`,`num_places`,`time`,`status`,`idreys`,`price`,`num_ligoty`,`point1`,`point2`) VALUES ('".$_POST["fio"]."','".trim($_POST["email"])."','".$_POST["phone"]."','".$numPlaces."','".date("Y-m-d H:i:s")."',0,".$idReys.",".$price1.",0,'".$_POST["point1"]."','".$_POST["point2"]."')";
			mysql_query($query);
			$res=mysql_query("SELECT LAST_INSERT_ID();");
			$aData=mysql_fetch_assoc($res);
			$idTicket=$aData["LAST_INSERT_ID()"];
			$strMail="Вы заказали билеты. <br> Откуда: ".$_POST["point1"].", куда: ".$_POST["point2"]." ".$_POST["date1"]." количество мест: ".$numPlaces." <br>";
			$textMailAdmin="Произведен заказ билетов. <br> ФИО:".$_POST["fio"]."<br> Телефон:".$_POST["phone"]."<br> email:".trim($_POST["email"])."<br> Откуда: ".$_POST["point1"].", куда: ".$_POST["point2"]." ".$_POST["date1"]." количество мест: ".$numPlaces."<br>";
		//-------------------------------------------------------------------------------------  обратный билет ---------------------------------------------------------------------
		if(!$_POST["rticket"])
		{
			$idReys=(int)$_POST["reys2"];
			if($idReys==-1)
			{
				$query="SELECT * FROM routes as t1,routes as t2 WHERE (t1.point ='".$_POST["point3"]."') AND(t2.point ='".$_POST["point4"]."') AND (t1.idroute=t2.idroute) AND(t1.idpoint<t2.idpoint)";
				$res=mysql_query($query);
				$aData=mysql_fetch_assoc($res);
				$reys=new Reys();
				$query="SELECT * FROM routesetting WHERE idroute=".(int)$_POST["route2"];
				$res=mysql_query($query);
				$aData=mysql_fetch_assoc($res);
				$reys->initAvtobus($aData["typeavtobus"]);
				$avtobus=$reys->getAvtobus();
				$reys->setDate($_POST["date2"]);
				$reys->setRoute((int)$_POST["route2"]);
				$aR=explode(",",$aData["free_places"]);
				$avtobus->freeking($aR);
				$aR=explode(",",$aData["reserved_places"]);
				$avtobus->reserving($aR);
				$dateReys=$reys->getDate("db");
				$query="INSERT INTO `reyses` (`idroute`,`free_places`,`booked_places`,`reserved_places`,`date`,`typeavtobus`) VALUES (".$reys->getRoute().",'".$avtobus->getStrPlaces("free")."','".$avtobus->getStrPlaces("booked")."','".$avtobus->getStrPlaces("reserved")."','".$dateReys."',".$avtobus->getProp("type").")";
				
				
				$res=mysql_query($query);
				$res=mysql_query("SELECT LAST_INSERT_ID();");
				$aData=mysql_fetch_assoc($res);
				$idReys=$aData["LAST_INSERT_ID()"];
				
			};
			$price0=$rmDB->getPrice((int)$_POST["route2"],$_POST["point3"],$_POST["point4"]);
			$numPlaces=(int)$_POST["places2"];
			$price2=$price0*$numPlaces;
			$query="INSERT INTO `booking` (`fio`,`phone`,`email`,`num_places`,`time`,`status`,`idreys`,`price`,`num_ligoty`,`point1`,`point2`) VALUES ('".$_POST["fio"]."','".trim($_POST["email"])."','".$_POST["phone"]."','".$numPlaces."','".date("Y-m-d H:i:s")."',0,".$idReys.",".$price2.",0,'".$_POST["point3"]."','".$_POST["point4"]."')";
			mysql_query($query);
			$strMail.=" Откуда: ".$_POST["point3"].", куда: ".$_POST["point4"]." ".$_POST["date2"]." количество мест: ".$numPlaces."<br>&nbsp;<br>";
			$textMailAdmin.=" Откуда: ".$_POST["point3"].", куда: ".$_POST["point4"]." ".$_POST["date2"]." количество мест: ".$numPlaces."<br>";
		}
		else
		{
			$price2=0;
		};
		$numInvoice=10100+$idTicket;
		$totalPrice=floor($price1+$price2);
		$strMail.="Счет действителен в течение 48 часов после заказа. После оплаты счета свяжитесь с менеджером по одному из телефонов: +380 (66) 577-58-58,+380 (97) 291-44-70, +380 (95) 688-68-78<br>Письмо сгенерировано автоматически. Не отвечайте на него.";
		$invoice=new Invoice(Config::$dir0."/pics/invoice.png");
		$fPdf=$invoice->create($_POST["fio"],$numInvoice,$totalPrice);
		$mail1=new Mail(trim($_POST["email"]),"no-reply@tickets.777tur.com","Счет за билеты",$fPdf);
		$mail1->send($strMail."<br>Счет во вложении. <br>С уважением топ менеджер транспортного центра «Новый Симферополь», Татьяна.");
		$query="SELECT * FROM users WHERE login='administrator' AND status='admin'";
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$mail2=new Mail($aData["email"],"no-reply@tickets.777tur.com","Заказ билетов".$numInvoice,$fPdf);
		if($_POST["kodagency"])
		{
			$query="SELECT `email` FROM `agencys` WHERE `kod`=".$_POST["kodagency"];
			$res=mysql_query($query);
			$aData=mysql_fetch_assoc($res);
			$tEmail=$aData['email'];
			$mail4=new Mail($tEmail,"no-reply@tickets.777tur.com","Заказ билетов №".$numInvoice,$fPdf);
			$mail4->send($textMailAdmin);
			$textMailAdmin.="Заказ от турагенства. Код : ".$_POST["kodagency"];
		};
		$mail2->send($textMailAdmin);
		$mail3=new Mail("al3guboff@yandex.ru","no-reply@tickets.777tur.com","Заказ билетов".$numInvoice,$fPdf);
		$mail3->send($textMailAdmin);
		$mail3->clearFiles();
		print("На вашу электронную почту(".trim($_POST["email"]).") отправлено письмо с вложенным счетом. После оплаты свяжитесь с нашим менеджером Стоимость билетов: ".$totalPrice." грн.");
	}
}