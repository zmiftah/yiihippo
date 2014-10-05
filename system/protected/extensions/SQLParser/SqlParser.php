<?php

require 'php-sql-parser.php';

class SqlParser extends CApplicationComponent
{
	private $parser = null;

	public function init()
	{
		$this->parser = new PHPSQLParser;
		parent::init();
	}

	public function parse($sql)
	{
		return $this->parser->parse($sql);
	}
}