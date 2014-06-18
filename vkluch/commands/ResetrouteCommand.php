<?php
//-*-coding: utf-8 -*-
class ResetrouteCommand extends Command
{
	public function execute(CommandContext $context)
	{
		$saver1=new saver();
		$saver1->reset("reys");
	}
}