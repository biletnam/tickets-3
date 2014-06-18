<?php
//-*-coding: utf-8 -*-
class FactoryQueriesBD
{
	public function createQuery($type,$table)
	{
		$className="QueryBD".ucfirst(strtolower($type));
		return new $className($table);
	}
}
abstract class QueryBD implements Worker
{
	protected $names="";
	protected $values="";
	protected $table;
	public function __construct($table)
	{
		$this->table=$table;
	}
	public function work($field)
	{
		$this->addField($field);
	}
	abstract public function addField($field);
	abstract public function compile();
}
class QueryBDInsert extends QueryBD
{
	public function addField($field)
	{
		$nn=$this->names;
		$this->names=$nn."`".$field->getName()."`,";
		$this->values.=$field->getQuote().$field->getValue().$field->getQuote().",";
	}
	public function compile()
	{
		$str2=$this->names;
		$names=substr($str2,0,-1);
		$values=substr($this->values,0,-1);
		$query="INSERT INTO ".$this->table." (".$names.") VALUES ($values)";
		return $query;
	}
}
class QueryBDUpdate extends QueryBD
{
	public function addField($field)
	{
		$this->values.="`".$field->getName()."`=".$field->getQuote().$field->getValue().$field->getQuote().",";
	}
	public function compile()
	{
		$query="UPDATE $this->table SET ".substr($this-values,0,-1);
		return $query;
	}
	
}