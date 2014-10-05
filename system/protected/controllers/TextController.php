<?php

class TextController extends AbFrontController 
{
	public function init()
	{
		parent::init();

		$parseObj = new AbParseUrlBehavior;
		$this->attachBehavior('parseUrl', $parseObj);
	}

	public function actionSitemap() 
	{
		header('Content-type: text/plain');
		
		$sitemaps = $this->dbGenerateSitemap();
		echo $sitemaps;
	}
}
