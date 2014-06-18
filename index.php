<?php
//-*-coding: utf-8 -*-
require("vkluch/Config.php");
require("controller/controller.php");
function __autoload($classname)
{
	require_once($classname.".php");
	
};
Controller::run();