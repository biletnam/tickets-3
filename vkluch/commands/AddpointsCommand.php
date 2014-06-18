<?php
//-*-coding: utf-8 -*-
class AddpointsCommand extends Command
{
	public function execute(CommandContext $context)
	{
		$saver1=new saver();
		$reys1=$saver1->getCache("reys");
		if(!$reys1)
		{
			$reys1=new oReys();
		}
		$reys1->setPoints($_GET["point1"],$_GET["point2"]);
		$saver1->saveCache($reys1);
	}
}