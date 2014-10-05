<?php 

class AbPluginManager extends AbBaseManager 
{

	public $childClass = 'AbPluginTask';
	public $childName  = 'plugin';
	public $readmeFile = 'README.txt';

	public function init() 
	{
		parent::init();

		$this->_baseDir = $this->_baseDir . '/plugins/';
		$this->_baseUrl = $this->_baseUrl . '/plugins/';
	}

	public function getPluginList() 
	{
		return $this->getList();
	}

	public function fetchPlugin( $name ) 
	{

		return $this->fetchChild( $name );
	}

	public function iteratePlugin() 
	{

		return $this->iterateList();
	}
}