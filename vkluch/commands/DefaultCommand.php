<?php
//-*-coding: utf-8 -*-
namespace commands;
class DefaultCommand extends Command
{
	public function execute(CommandContext $context)
	{
		print("this default command");
	}
}