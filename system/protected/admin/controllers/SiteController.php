<?php

class SiteController extends AbBackController
{
	public $layout        = '//layouts/column1';
	public $defaultAction = 'login';

	public function actionLogin() 
	{
		$this->pageTitle = Yii::app()->name . ' - Login';
		$model = new LoginForm( 'formLogin' );

		// Submit Login
		if ( isset( $_POST['LoginForm'] ) ) {
			$model->attributes = $_POST['LoginForm'];

			if ( $model->validate() && $model->login() ) {
				// Redirect 
				$this->redirectUrl('setting/index');
			}
		}

		$this->render('login', array( 
			'model'=>$model 
		));
	}

	public function actionLogout() 
	{
		Yii::app()->user->logout(true); //destroy Session
		$this->redirectUrl('site/login');
	}

	public function actionAccount()
	{
		$this->pageTitle = Yii::app()->name . ' - My Account';
		$this->layout    = '//layouts/column2';

		$this->render('account', array(
		));
	}

	public function actions()
	{
		return array(
			'captcha'=>array(
        'class'=>'CCaptchaAction',
        'backColor'=>0xFFFFFF,
        // 'testLimit'=>3,
      ),
		);
	}

	public function accessRules() {
    return array(
      array('allow',
        'actions'=>array('index','login','captcha'),
        'users'=>array('*'),
      ),
      array('allow',
        'actions'=>array('index','logout','captcha'),
        'users'=>array('@'),
      ),
      array('deny',
        'users'=>array('*'),
      )
    );
  }
}