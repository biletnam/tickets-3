<style>
*[id|=place]{background-image:url("/pics/placesa2.png");width:32px;height:25px;overflow:hidden;border:0px solid blue;padding:4px 0px 0px 12px;background-repeat:no-repeat;cursor:pointer}
.booked{background-position:0px 1px;}
.reserved{background-position:0px -30px;}
.free{background-position:0px -62px;}
.free:hover{background-position:0px -96px;}
.taxibox{border:4px solid #AAF;height:150px;width:340px;border-radius:25px;background-color:#FFF}
.busbox{border:4px solid #AAF;height:200px;width:700px;border-radius:25px;background-color:#FFF}
.lestniza{width:35px;height:50px;background-image:url("/pics/lestniza.png")}
</style>
<div class="taxibox">
<?php
//-*-coding: utf-8 -*-
$w1=56;
$h1=44;
$dx0=30;
$dy0=20;
$dx=45;
$dy=35;
$dyjs=12;
$dxjs=15;
$str1="places={";
for($i=0;$i<6;$i++)
{
	$x0=$i*$dx+$dx0;
	$x1=$x0-$dxjs;
	$y00=$dy0;
	$y01=$y00-$dyjs;
	$y10=$y00+$dy;
	$y11=$y10-$dyjs;
	$y20=$y10+2*$dy;
	$y21=$y20-$dyjs;
	
	$num1=3*(5-$i)+1;
	$num2=$num1+1;
	$num3=$num1+2;
	
	$str1.="\"".$num1."\":{\"x\":\"".$x1."\",\"y\":\"".$y01."\",\"type\":\"free\"},\"".$num2."\":{\"x\":\"".$x1."\",\"y\":\"".$y11."\",\"type\":\"free\"},\"".$num3."\":{\"x\":\"".$x1."\",\"y\":\"".$y21."\",\"type\":\"free\"},";
	?>
	<div id="place-<?php print($num1);?>" class="reserved" style="position:absolute;top:<?php print($y00);?>px;left:<?php print($x0);?>px"><?php print($num1);?></div>
	<div id="place-<?php print($num2);?>" class="free" style="position:absolute;top:<?php print($y10);?>px;left:<?php print($x0);?>px"><?php print($num2);?></div>
	<div id="place-<?php print($num3);?>" class="booked" style="position:absolute;top:<?php print($y20);?>px;left:<?php print($x0);?>px"><?php print($num3);?></div>
	<?php
};
$y1=$dy0+0.5*$dy-$dyjs;
$str1=substr($str1,0,-1).",\"0\":{\"x\":\"285\",\"y\":\"".$y1."\",\"type\":\"reserved\"}}";
file_put_contents("/var/www/sites/tickets/site/js/places.js",$str1);
?>
<div id="place-no" class="reserved" style="position:absolute;top:<?php print($dy0+0.5*$dy);?>px;left:300px"></div>
</div>



<div class="busbox">
<?php
//-*-coding: utf-8 -*-
$w1=56;
$h1=44;
$dx0=30;
$dy0=20;
$dx=45;
$dy=35;
$dyjs=12;
$dxjs=15;
$str1="places={";
for($i=1;$i<7;$i++)
{
	$x0=$i*$dx+$dx0;
	$x1=$x0-$dxjs;
	$y00=$dy0;
	$y01=$y00-$dyjs;
	$y10=$y00+$dy;
	$y11=$y10-$dyjs;
	$y20=$y10+2*$dy;
	$y21=$y20-$dyjs;
	$y30=$y10+3*$dy;
	$y31=$y30-$dyjs;
	
	$num1=4*(13-$i)-1;
	$num2=$num1+1;
	$num3=$num1+2;
	$num4=$num1+3;
	
	$str1.="\"".$num1."\":{\"x\":\"".$x1."\",\"y\":\"".$y01."\",\"type\":\"free\"},\"".$num2."\":{\"x\":\"".$x1."\",\"y\":\"".$y11."\",\"type\":\"free\"},\"".$num4."\":{\"x\":\"".$x1."\",\"y\":\"".$y21."\",\"type\":\"free\"},\"".$num3."\":{\"x\":\"".$x1."\",\"y\":\"".$y31."\",\"type\":\"free\"},";
	?>
	<div id="place-<?php print($num1);?>" class="reserved" style="position:absolute;top:<?php print($y00);?>px;left:<?php print($x0);?>px"><?php print($num1);?></div>
	<div id="place-<?php print($num2);?>" class="free" style="position:absolute;top:<?php print($y10);?>px;left:<?php print($x0);?>px"><?php print($num2);?></div>
	<div id="place-<?php print($num4);?>" class="booked" style="position:absolute;top:<?php print($y20);?>px;left:<?php print($x0);?>px"><?php print($num4."a");?></div>
	<div id="place-<?php print($num3);?>" class="booked" style="position:absolute;top:<?php print($y30);?>px;left:<?php print($x0);?>px"><?php print($num3);?></div>
	<?php
};

$x0=7*$dx+$dx0;
$x1=$x0-$dxjs;
$y00=$dy0;
$y01=$y00-$dyjs;
$y10=$y00+$dy;
$y11=$y10-$dyjs;
$y20=$y10+2*$dy+12;
$xl=$x0+3;

	
$num1=4*(13-7)+1;
$num2=$num1+1;

	
$str1.="\"".$num1."\":{\"x\":\"".$x1."\",\"y\":\"".$y01."\",\"type\":\"free\"},\"".$num2."\":{\"x\":\"".$x1."\",\"y\":\"".$y11."\",\"type\":\"free\"},";
	?>
<div id="place-<?php print($num1);?>" class="reserved" style="position:absolute;top:<?php print($y00);?>px;left:<?php print($x0);?>px"><?php print($num1);?></div>
<div id="place-<?php print($num2);?>" class="free" style="position:absolute;top:<?php print($y10);?>px;left:<?php print($x0);?>px"><?php print($num2);?></div>
<div class="lestniza" style="position:absolute;top:<?php print($y20);?>px;left:<?php print($xl);?>px"></div>

<?php

for($i=8;$i<14;$i++)
{
	$x0=$i*$dx+$dx0;
	$x1=$x0-$dxjs;
	$y00=$dy0;
	$y01=$y00-$dyjs;
	$y10=$y00+$dy;
	$y11=$y10-$dyjs;
	$y20=$y10+2*$dy;
	$y21=$y20-$dyjs;
	$y30=$y10+3*$dy;
	$y31=$y30-$dyjs;
	
	$num1=4*(13-$i)+1;
	$num2=$num1+1;
	$num3=$num1+2;
	$num4=$num1+3;
	
	$str1.="\"".$num1."\":{\"x\":\"".$x1."\",\"y\":\"".$y01."\",\"type\":\"free\"},\"".$num2."\":{\"x\":\"".$x1."\",\"y\":\"".$y11."\",\"type\":\"free\"},\"".$num4."\":{\"x\":\"".$x1."\",\"y\":\"".$y21."\",\"type\":\"free\"},\"".$num3."\":{\"x\":\"".$x1."\",\"y\":\"".$y31."\",\"type\":\"free\"},";
	?>
	<div id="place-<?php print($num1);?>" class="reserved" style="position:absolute;top:<?php print($y00);?>px;left:<?php print($x0);?>px"><?php print($num1);?></div>
	<div id="place-<?php print($num2);?>" class="free" style="position:absolute;top:<?php print($y10);?>px;left:<?php print($x0);?>px"><?php print($num2);?></div>
	<div id="place-<?php print($num4);?>" class="booked" style="position:absolute;top:<?php print($y20);?>px;left:<?php print($x0);?>px"><?php print($num4);?></div>
	<div id="place-<?php print($num3);?>" class="booked" style="position:absolute;top:<?php print($y30);?>px;left:<?php print($x0);?>px"><?php print($num3);?></div>
	<?php
};

$x0=$dx0;
$x1=$x0-$dxjs;
$y00=$dy0;
$y01=$y00-$dyjs;
$y10=$y00+$dy;
$y11=$y10-$dyjs;
$y20=$y10+$dy;
$y21=$y20-$dyjs;
$y30=$y20+$dy;
$y31=$y30-$dyjs;
$y40=$y30+$dy;
$y41=$y40-$dyjs;
	
$num1=4*13-1;
$num2=$num1+1;
$num3=$num1+2;
$num4=$num1+3;
$num5=$num1+4;
	
$str1.="\"".$num5."\":{\"x\":\"".$x1."\",\"y\":\"".$y01."\",\"type\":\"free\"},\"".$num4."\":{\"x\":\"".$x1."\",\"y\":\"".$y11."\",\"type\":\"free\"},\"".$num3."\":{\"x\":\"".$x1."\",\"y\":\"".$y21."\",\"type\":\"free\"},\"".$num2."\":{\"x\":\"".$x1."\",\"y\":\"".$y31."\",\"type\":\"free\"},\"".$num1."\":{\"x\":\"".$x1."\",\"y\":\"".$y41."\",\"type\":\"free\"},";
	?>
<div id="place-<?php print($num5);?>" class="reserved" style="position:absolute;top:<?php print($y00);?>px;left:<?php print($x0);?>px"><?php print($num5);?></div>
<div id="place-<?php print($num4);?>" class="free" style="position:absolute;top:<?php print($y10);?>px;left:<?php print($x0);?>px"><?php print($num4);?></div>
<div id="place-<?php print($num3);?>" class="booked" style="position:absolute;top:<?php print($y20);?>px;left:<?php print($x0);?>px"><?php print($num3);?></div>
<div id="place-<?php print($num2);?>" class="booked" style="position:absolute;top:<?php print($y30);?>px;left:<?php print($x0);?>px"><?php print($num2);?></div>
<div id="place-<?php print($num1);?>" class="booked" style="position:absolute;top:<?php print($y40);?>px;left:<?php print($x0);?>px"><?php print($num1);?></div>

<?php

$y1=$dy0+0.5*$dy-$dyjs;
$str1=substr($str1,0,-1).",\"0\":{\"x\":\"285\",\"y\":\"".$y1."\",\"type\":\"reserved\"}}";
file_put_contents("/var/www/sites/tickets/site/js/places2.js",$str1);
?>
<div id="place-no" class="reserved" style="position:absolute;top:<?php print($dy0+0.5*$dy);?>px;left:670px"></div>
<div class="lestniza" style="position:absolute;top:<?php print($dy0+3*$dy+15);?>px;left:660px"></div>

</div>