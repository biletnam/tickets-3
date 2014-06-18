<?php
//-*-coding: utf-8 -*-
function transDate($date)
{
	$aTemp=explode("-",$date);
	return $aTemp[2].".".$aTemp[1].".".$aTemp[0];
};