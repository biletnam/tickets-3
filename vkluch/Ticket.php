<?php
//-*-coding: utf-8 -*-
class Ticket
{
	private $aKoords=array(
					"date"=>array(534,117),
					"fio"=>array(520,234),
					"places"=>array(573,161),
					"num"=>array(870,325),
					"time"=>array(703,186),
					"phone"=>array(520,260),
					"date_sale"=>array(735,280),
					"price"=>array(590,325),
					"route"=>array(573,137)
					);
	private $filePic;
	private $numTicket;
	public function __construct($numTicket)
	{
		$this->filePic=Config::$dir0."/data/ticket.png";
		//print($this->filePic);
		$this->numTicket=$numTicket;
	}
	public function create()
	{
		$id=$this->numTicket-10100;
		$query="SELECT * FROM booking WHERE id=".$id;
		$res=mysql_query($query);
		$aData=mysql_fetch_assoc($res);
		$query="SELECT * FROM reyses WHERE id=".$aData["idreys"];
		$res=mysql_query($query);
		$aData2=mysql_fetch_assoc($res);
		$query="SELECT ptime FROM routes WHERE idroute=".$aData2["idroute"]." AND point='".$aData["point1"]."'";
		$res=mysql_query($query);
		$aDataPTime=mysql_fetch_assoc($res);
		if($aDataPTime["ptime"]=="*")
		{
			$ptime='';
		}
		else
		{
			$ptime=$aDataPTime["ptime"];
		};
		require_once("ImgDoc.php");
		require_once("funcs.php");
		$iDoc=new ImgDoc($this->filePic);
		$iDoc->addText(535,115,transDate($aData2["date"]));
		$iDoc->addText(520,235,$aData["fio"]);
		$iDoc->addText(575,160,$aData["places"]);
		$iDoc->addText(870,325,10100+$aData["id"]);
		$iDoc->addText(705,185,$ptime);
		$iDoc->addText(520,260,$aData["email"]);
		$iDoc->addText(735,280,transDate(substr($aData["time"],0,10)));
		$iDoc->addText(590,325,$aData["price"]."  грн.");
		$iDoc->addText(575,135,$aData["point1"]." - ".$aData["point2"]);
		$fileName=$iDoc->create();
		$fileName=$iDoc->createPdf("ticket");
		return $fileName;
	}
	
	
}