<?php
//-*-coding: utf-8 -*-
class GetpointsCommand extends Command
{
	public function execute(CommandContext $context)
	{
		$saver1=new saver();
		$reys1=$saver1->getCache("reys");
		if(!$reys1)
		{
			$reys1=new oReys();
		};
		//print_r($reys1);
		$dd=$reys1->getPoints();
		print_r($dd);
		$saver1->saveCache($reys1);
	}
}