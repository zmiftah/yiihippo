<?php

class BlogController extends AbFrontController 
{
	public function actionError() 
	{
		$this->layout = '//layouts/404';
		$this->pageTitle = 'Page Not Found';

		$this->render('404', array());
	}

	public function actionBlacklist() 
	{
		$this->layout = '//layouts/404';
		$this->pageTitle = 'IP Blacklist';

		$ip = Yii::app()->cache->get('userHostAddress');
		if ($ip == false) {
			$ip = Yii::app()->request->userHostAddress;
			Yii::app()->cache->set('userHostAddress', $ip, $this->cacheDuration);
		}
		
		$this->render( 'blacklist', array(
			'ip' => $ip
		));
	}
}