<?php 

class AbThemeManager extends AbBaseManager 
{

	public $childClass = 'AbThemeTask';
	public $childName  = 'theme';
	public $readmeFile = 'README.txt';

	public function init() 
	{
		parent::init();

		$this->_baseDir = $this->_baseDir . '/themes/';
		$this->_baseUrl = $this->_baseUrl . '/themes/'; //var_dump(Yii::app()->basePath);
	}

	public function getThemeList() 
	{
		return $this->getList();
	}

	public function fetchTheme($name) 
	{
		return $this->fetchChild( $name );
	}

	public function iterateTheme() 
	{
		return $this->iterateList();
	}
}