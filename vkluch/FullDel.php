<style>
pre{font-size:80%}
</style>
<?php
//-*-coding: utf-8 -*-
/*$query="SELECT * FROM booking WHERE time<'2013-06-25 0:00:00' AND status=0";
$res=mysql_query($query);
$aDataBooks=mysql_fetch_assoc($res);
while (is_array($aDataBooks)&&(count($aDataBooks)>0))
{
	$query="SELECT * FROM reyses WHERE id=".$aDataBooks["idreys"];
	$res2=mysql_query($query);
	$aDataReys=mysql_fetch_assoc($res2);
	
	
	$aDataBooks=mysql_fetch_assoc($res);
};*/
print("ERROR");
exit();
//require("config.php");
mysql_connect(Config::$host,Config::$user,Config::$parol);
mysql_query("SET NAMES 'utf8'");
mysql_query("USE ".Config::$db);
mysql_query("LOCK TABLES reyses WRITE, booking WRITE;");
$query="SELECT * FROM reyses WHERE date>'2013-06-25'";
$res=mysql_query($query);
$aDataReys=mysql_fetch_assoc($res);
while(is_array($aDataReys))
{
	$query="SELECT * FROM booking WHERE idreys=".$aDataReys["id"];
	$res2=mysql_query($query);
	$aDataBook=mysql_fetch_assoc($res2);
	$aFreePlaces=explode(",",$aDataReys["free_places"]);
	$aBookedPlaces=explode(",",$aDataReys["booked_places"]);
	$aReservedPlaces=explode(",",$aDataReys["reserved_places"]);
	//print("OLDFREEP: ".implode(",",$aFreePlaces)."<br>");
	//print("OLDBOOKP: ".implode(",",$aBookedPlaces)."<br>");
	
	print("<pre>");
	print_r($aDataReys);
	print("</pre>");
	//print("<div style='margin-left:25px'>");
	$aFreekingPlaces=array();
	$aNoFreekingPlaces=array();
	if($aDataReys["typeavtobus"]==3)
	{
		$aNoFreekingPlaces[]=18;
	};
	while(is_array($aDataBook))
	{
		//print("<pre>");
		//print_r($aDataBook);
		//print("</pre>");
			
		if(($aDataBook["time"]<'2013-06-25 00:00:00')&&(($aDataBook["status"]==0)||($aDataBook["status"]==2)))
		{
			$aPlaces=explode(",",$aDataBook["places"]);
			
			$aFreekingPlaces=array_merge($aFreekingPlaces,$aPlaces);
			//print_r($aFreekingPlaces);
			$query="UPDATE booking SET status=2 WHERE id=".$aDataBook["id"];
			mysql_query($query);
	
			//$res3=mysql_query($query);
			//print($query."<br>");
		}
		else
		{
			$aPlaces=explode(",",$aDataBook["places"]);
			$aNoFreekingPlaces=array_merge($aNoFreekingPlaces,$aPlaces);
		};
	//	print("---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>");
		$aDataBook=mysql_fetch_assoc($res2);
	};

	$aFreekingPlaces=array_unique($aFreekingPlaces);
	//print("FREE0: ".implode(",",$aFreekingPlaces)."<br>");
	
	
	$aNoFreekingPlaces=array_unique($aNoFreekingPlaces);
	
	//print("FREE1: ".implode(",",$aFreekingPlaces)."<br>");
	$aTemp=array_diff($aFreekingPlaces,$aNoFreekingPlaces);
	$aFreekingPlaces=$aTemp;
	//print("<br>FREE2: ".implode(",",$aFreekingPlaces)."<br>");
	$aFreekingPlaces=array_unique($aFreekingPlaces);
	sort($aFreekingPlaces);
	sort($aNoFreekingPlaces);
	$aFreePlaces=array_merge($aFreePlaces,$aFreekingPlaces);
	$aFreePlaces=array_unique($aFreePlaces);
	sort($aFreePlaces);
	$aBookedPlaces=array_diff($aBookedPlaces,$aFreekingPlaces);
	$aBookedPlaces=array_unique($aBookedPlaces);
	sort($aBookedPlaces);
	$strFree=implode(",",$aFreePlaces);
	$strFree=preg_replace("/(^,|,,|,$)/","",$strFree);
	$strBook=implode(",",$aBookedPlaces);
	$strBook=preg_replace("/(^,|,,|,$)/","",$strBook);
	//print("FREEP: ".$strFree."<br>");
	//print("BOOKP: ".$strBook."<br>");
	//print("FREE: ".implode(",",$aFreekingPlaces)."<br>");
	//print("NOFREE: ".implode(",",$aNoFreekingPlaces)."<br>");
	$query="UPDATE reyses SET free_places='".$strFree."',booked_places='".$strBook."' WHERE id=".$aDataReys["id"];
	mysql_query($query);
	print($query."<br>".mysql_error()."<hr>");
	
	$aDataReys=mysql_fetch_assoc($res);
};
mysql_query("UNLOCK TABLES;");
?>