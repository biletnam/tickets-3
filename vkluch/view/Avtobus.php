<?php
//-*-coding: utf-8 -*-
class AvtobusViewer
{
	private $aData;
	public function __construct($data)
	{
		$this->aData=$data;
	}
	public function display()
	{
		$aData=$this->aData;
		require("Avtobus.view.php");
	}
}
?>