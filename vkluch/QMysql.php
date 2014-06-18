<?php
//-*-coding: utf-8 -*-
class QMysql
{
	private $query;
	public function __construct($query)
	{
		$this->query=$query;
		
	}
	public function exec($proc)
	{
		$res=mysql_query($this->query);
		do
		{
			$aData=mysql_fetch_assoc($res);
			if(is_array($aData))
			{
				$proc->run($aData);
			}
		}while(is_array($aData));
	}
}
?>