<?php 

class AbBaseTask extends CComponent 
{
	private $_name;
	private $_path;
	private $_url;
	private static $_prefixOption = 'active-';
	private static $_pluginNote   = 'No Description';

	public function __construct($path, $url, $name) 
	{
		$this->_name = $name;
		$this->_path = $path;
		$this->_url  = $url;
	}

	public function activate() 
	{
		$optName = self::$_prefixOption . $this->_name;
		Yii::app()->options->add( $optName, 1 );
	}

	public function deactivate() 
	{
		$optName = self::$_prefixOption . $this->_name;
	}

	public function update() {}

	public function uninstall() {}

	public function getBasename() 
	{
		return $this->_path;
	}

	public function getPrefix() 
	{
		return self::$_prefixOption;
	}

	public static function readInfo($readmeFile) 
	{
		if ( file_exists($readmeFile) ) {
			return @file_get_contents( $readmeFile );
		} else {
			return self::$_pluginNote;
		}
	}

	public static function isActivated($pluginName) 
	{
		$opt   = self::$_prefixOption . $pluginName;
		$value = Yii::app()->options->get( $opt );
		return !empty($value);
	}

	protected function isValid() 
	{
		// TODO 2: AbPluginTask isValid function
	}
}