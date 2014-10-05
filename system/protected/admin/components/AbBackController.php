<?php

class AbBackController extends CController 
{
	public $layout='//layouts/column2';

	private $_assetBase;

	public function init()
	{
		$_GET['page'] = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
		$this->attachBehavior('gridData', new AbGridViewDataBehavior);
		$this->attachBehavior('firstRun', new AbFirstRunBehavior);

		if ( isset($_GET['fix']) ) {
			Yii::app()->options->add('first_run', 1);
			$this->publishAssets();
		}

		$this->executeFirstRun();
	}

	public function getAssetsBase()
	{
		if ($this->_assetBase === null) {
			$this->_assetBase = $this->publishAssets();
		}
		return $this->_assetBase;
	}

	public function redirectUrl($url) 
	{
		if ($url == 'site/login') $url = "/site";
		if (is_array($url)) {
			$redirect = $this->createUrl( $url[0], $url[1] );
		} else {
			$redirect = $this->createUrl( $url );	
		}
		
		$this->redirect( $redirect );
	}

	protected function hasLogin()
	{
		$hasLogin = !Yii::app()->user->isGuest;
		return  $hasLogin;
	}

	protected function createMenu() 
	{
		$arrMenus = array(
			array('Main Setting', 'home', null, null, array(
				array('Settings', 'dashboard', '/setting' ),
				array('Category', 'list-ol', '/taxonomy/category' ),
				array('Tags', 'list-ul', '/taxonomy/tags' ),
			)),
			array('Tampilan', 'picture', null, null, array(
				array('Theme', 'book', '/theme' ),
				array('Links', 'align-justify', '/link' ),
				array('Widget', 'bar-chart', '/widget'/*, 'Not Yet'*/ ),
			)),
			array('Keyword', 'key', '/keyword' ),
			array('Article', 'list-alt', '/article' ),
			array('Page', 'file', '/page' ),
			array('Media', 'camera', '/media' ),
			array('Comment', 'comments', '/comment' ),
			array('Banner', 'flag-alt', '/banner' ),
			array('Migration', 'cogs', '/migrate', 'Beta' ),
		);

		Yii::app()->menuwidget->addMenus($arrMenus);
	}

	/**
	 * Handle Auth and Login Page
	 * 
	 * @param  CInlineAction $action
	 * @return boolean
	 */
	protected function beforeAction($action) 
	{
		$login_action = in_array($action->id, array('login','captcha'));
		$login_controller = $action->controller->id == 'site';

		if ( $login_controller && $login_action ) {
			if ( !Yii::app()->user->isGuest ) {
				if ( yii::app()->user->getState('sessionTimeout') < time() ) {
          Yii::app()->user->logout();
          $this->redirectUrl('site/login');
      	} else {
      		$this->redirectUrl( 'setting/index' );
      	}
			} else {
				Yii::app()->session['hasLogin']  = false;
			}
		} else {
			if ( Yii::app()->user->isGuest ) {
				$this->redirectUrl('site/login');
			} else if ( yii::app()->user->getState('sessionTimeout') < time() ) {
        Yii::app()->user->logout();
        $this->redirectUrl('site/login');
    	}
		}

		return parent::beforeAction($action);
	}
	
	protected function beforeRender($view) 
	{
		$this->createMenu();
		return parent::beforeRender( $view );
	}
}
