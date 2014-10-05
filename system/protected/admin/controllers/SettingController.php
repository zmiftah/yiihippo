<?php

class SettingController extends AbBackController
{
  public function actionIndex()
  {
  	$this->render('setting'); 
  }

  public function actionGeneral()
  {
    if ( isset($_POST['save']) ) {
      if ( !empty($_POST['site_address']) ) {
        Yii::app()->options->add('site_address', $_POST['site_address'], 'setting');
      }
      if ( !empty($_POST['site_name']) ) {
        Yii::app()->options->add('site_name', $_POST['site_name'], 'setting');
      }
      if ( !empty($_POST['site_title']) ) {
        Yii::app()->options->add('site_title', $_POST['site_title'], 'setting');
      }
      if ( !empty($_POST['meta_desc']) ) {
        Yii::app()->options->add('meta_desc', $_POST['meta_desc'], 'setting');
      }
      if ( !empty($_POST['email']) ) {
        Yii::app()->options->add('email', $_POST['email'], 'setting');
      }

      Yii::app()->user->setFlash('tab', 'general');
      $this->redirect('index.php');
    }

    $setting['site_address'] = Yii::app()->options->get('site_address');
    $setting['site_name']    = Yii::app()->options->get('site_name');
    $setting['site_title']   = Yii::app()->options->get('site_title');
    $setting['meta_desc']    = Yii::app()->options->get('meta_desc');
    $setting['email']        = Yii::app()->options->get('email');

    $this->renderPartial('general', array(
      'setting'=>$setting
    ));
  }

  public function actionSEO()
  {
    if ( isset($_POST['save']) ) {
      if ( !empty($_POST['meta_keyword']) ) {
        Yii::app()->options->add('meta_keyword', $_POST['meta_keyword'], 'setting');
      }
      
      $destination = dirname(dirname(Yii::app()->basePath))."/content/upload/favicon.ico";
      $favicon     = CUploadedFile::getInstanceByName('favicon');
      if(isset($favicon) && $favicon->saveAs( $destination )){
        Yii::app()->options->add('favicon', '/content/upload/favicon.ico', 'setting');
      }

      if ( !empty($_POST['site_feed']) ) {
        Yii::app()->options->add('site_feed', $_POST['site_feed'], 'setting');
      }

      if ( !empty($_POST['analytic']) ) {
        Yii::app()->options->add('analytic', $_POST['analytic'], 'setting');
      }

      if ( !empty($_POST['webmaster']) ) {
        Yii::app()->options->add('webmaster', $_POST['webmaster'], 'setting');
      }

      Yii::app()->user->setFlash('tab', 'seo');
      $this->redirect('index.php');
    }

    $setting['meta_keyword'] = Yii::app()->options->get('meta_keyword');
    $setting['favicon'] = Yii::app()->options->get('favicon'); 
    $setting['site_feed'] = Yii::app()->options->get('site_feed');
    $setting['analytic'] = Yii::app()->options->get('analytic'); 
    $setting['webmaster'] = Yii::app()->options->get('webmaster'); 

    $this->renderPartial('seo', array(
      'setting'=>$setting
    ));
  }

  public function actionPermalink()
  {
    if ( isset($_POST['save']) ) {
      if ( !empty($_POST['permalink']) ) {
        Yii::app()->options->add('permalink', $_POST['permalink'], 'setting');
      }
      if ( !empty($_POST['opt_permalink']) ) {
        Yii::app()->options->add('opt_permalink', $_POST['opt_permalink'], 'setting');
      }

      Yii::app()->user->setFlash('tab', 'permalink');
      $this->redirect('index.php');
    }

    $setting['permalink']     = Yii::app()->options->get('permalink');
    $setting['opt_permalink'] = Yii::app()->options->get('opt_permalink');

    $this->renderPartial('permalink', $setting);
  }

  public function actionSocmed()
  {
    if ( isset($_POST['save']) ) {
      if ( !empty($_POST['socmed_facebook']) ) {
        Yii::app()->options->add('socmed_facebook', $_POST['socmed_facebook'], 'setting');
      }
      if ( !empty($_POST['socmed_twitter']) ) {
        Yii::app()->options->add('socmed_twitter', $_POST['socmed_twitter'], 'setting');
      }
      if ( !empty($_POST['socmed_googleplus']) ) {
        Yii::app()->options->add('socmed_googleplus', $_POST['socmed_googleplus'], 'setting');
      }

      Yii::app()->user->setFlash('tab', 'socmed');
      $this->redirect('index.php');
    }

    $setting['socmed_facebook']   = Yii::app()->options->get('socmed_facebook');
    $setting['socmed_twitter']    = Yii::app()->options->get('socmed_twitter');
    $setting['socmed_googleplus'] = Yii::app()->options->get('socmed_googleplus');

    $this->renderPartial('socmed', array(
      'setting'=>$setting
    ));
  }

  public function actionCode()
  {
    if ( isset($_POST['save']) ) {
      for ($i=0; $i<5; $i++) {
        $option = 'adsense_'.$i;
        if ( !empty($_POST[$option]) ) {
          Yii::app()->options->add($option, $_POST[$option], 'setting');
        }
      }

      Yii::app()->user->setFlash('tab', 'code');
      $this->redirect('index.php');
    }

    for ($i=1; $i<=5; $i++) { 
      $option = 'adsense_'.$i;
      $setting[$option]   = Yii::app()->options->get($option);
    }

    $this->renderPartial('code', array(
      'setting'=>$setting
    ));
  }
}
