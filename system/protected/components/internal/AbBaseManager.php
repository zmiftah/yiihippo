<?php 

class AbBaseManager extends CApplicationComponent 
{
	public $childClass     = 'AbBaseTask';
	public $childName      = 'plugin';
	public $readmeFile     = 'README.txt';
	public $screenshotFile = 'screenshot.png';

	protected $_baseDir   = '';
	protected $_baseUrl   = '';
	protected $_list      = null;
	protected $_directory = 'content';

	public function init() 
	{
		parent::init();

		$basePath = Yii::app()->basePath; //protected folder included
		$baseUrl  = Yii::app()->baseUrl; 
		$this->_baseDir = dirname(dirname($basePath)) . '/' . $this->_directory . '';
		$this->_baseUrl = $baseUrl . '/' . $this->_directory . '';
		$this->_baseUrl = str_replace("\\", '/', $this->_baseUrl);
	}

	protected function getBaseDir() 
	{

		return $this->_baseDir;
	}

	protected function getBaseUrl() 
	{

		return $this->_baseUrl;
	}

	protected function getList() 
	{
		if ( !$this->_list instanceof CMap ) {
			$this->_list = $this->iterateList();
		}
		return $this->_list;
	}

	protected function fetchChild( $name ) 
	{
		if ( $this->_list->contains($name) ) {
			$child = $this->_list->itemAt($name);

			return new $this->childClass ( $this->_baseDir, $this->_baseUrl, $child['name'] );
		} else {
			throw new CException("Error initialize a {$this->childName}");
		}
	}

	protected function iterateList() 
	{
		$dir = new DirectoryIterator($this->_baseDir);
		$childClass = $this->childClass;
		$childName  = $this->childName;

		foreach ($dir as $fileInfo) {
			if ( !$fileInfo->isDot() && $fileInfo->isDir() ) {
				$id++;

				$name     = $fileInfo->getFilename();
				$filename = ucwords( str_replace('-', ' ', $name) );
				$location = $this->_baseDir . $name;
				$readme   = $location . '/' . $this->readmeFile;

				$plugins[$name] = array(
					'id'        => $id,
					'name'      => $name,
					$childName  => $filename,
					'desc'      => /*$childClass*/AbBaseTask::readInfo($readme),
					'url'       => $this->_baseUrl."$name/assets/img/".$this->screenshotFile,
					'activated' => /*$childClass*/AbBaseTask::isActivated($name),
				);
			}
		}

		return new CMap($plugins);
	}
}