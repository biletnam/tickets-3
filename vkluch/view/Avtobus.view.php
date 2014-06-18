<?php
//-*-coding: utf-8 -*-
//ob_start();
?>
<style>
*[id|=place]{background-image:url("/pics/placesa2.png");width:32px;height:25px;overflow:hidden;border:0px solid blue;padding:4px 0px 0px 12px;background-repeat:no-repeat;cursor:pointer}
.booked{background-position:0px 1px;}
.reserved{background-position:0px -30px;}
.free{background-position:0px -62px;}
.free:hover{background-position:0px -96px;}
.taxibox{border:4px solid #AAF;height:150px;width:340px;border-radius:35px;background-color:#FFF}
</style>
<div class="taxibox">
<?php
$aClasses=array("free","reserved","booked");
$str1=file_get_contents("/var/www/sites/tickets/site/vkluch/view/taxidat.php");
$places=unserialize($str1);
foreach($places as $num=>$pos)
{
	
	$pls=$aData->getPlaces();
	?>
	<div id="place-<?php print($num);?>" class="<?php print($aClasses[$pls[$num]]);?>" style="position:absolute;top:<?php print($pos["y"]);?>px;left:<?php print($pos["x"]);?>px"><?php print($num);?></div>
	<?php
};
?>
<div id="place-no" class="reserved" style="position:absolute;top:25px;left:300px"></div>
</div>