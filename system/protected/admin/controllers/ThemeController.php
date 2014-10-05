<?php

class ThemeController extends AbBackController 
{
	const THEME_LIMIT = 10;
  const THEME_DIR   = 'content/themes';

	public function init()
  {
    $this->attachBehavior('media', new AbMediaBehavior());
    parent::init();
  }

  public function actionIndex() 
  {
  	$this->pageTitle = Yii::app()->name . ' - Daftar Theme';

		$themes = Yii::app()->themes->themeList;
		$list   = array_values($themes->toArray());
    $active = Yii::app()->options->get('site_theme');

		$page = 'page';
    $view = $this->generateData($list, $_GET[$page], self::THEME_LIMIT, new CDbCriteria, false);
    $this->render('list', array_merge($view, array(
      'activeTheme' => ucwords($active)
    )));
	}

  public function actionUpload()
  {
    if ( isset($_POST['upload']) ) {
      $filename = CUploadedFile::getInstanceByName('theme');
      $finfo = pathinfo($filename->name);

      if ($finfo['extension'] == 'zip') {
        // Save Theme
        $uploadPath = $this->uploadPath;
        $destination = $uploadPath . $finfo['basename'];
        $uploaded = $filename->saveAs($destination);
        $extracted = false;

        if( $uploaded ){ // Extract
          $extracted = ZipHelper::decompress($destination, $uploadPath);
          @unlink($destination);
        }

        if ( $extracted) {
          $result = array('result'=>1,'text'=>'Upload berhasil');
        } else {
          $result = array('result'=>0,'text'=>'Upload gagal. Silakan diulangi lagi');
        }
      } else {
        $result = array('result'=>0,'text'=>'File bukan ber ekstensi zip');
      }

      header('Content-Type: application/json');
      echo CJSON::encode($result);
    } else {
      $this->render('form');
    }
  }

  public function actionActivate()
  {
    $id = $_GET['id'];

    $result = Yii::app()->options->add('site_theme', $id, 'setting');
    if ( $result ) {
      Yii::app()->user->setFlash( 'success', "Theme '".ucwords($id)."' berhasil di aktifkan" );
    }
    $this->redirect('index.php');
  }

  public function actionDelete()
  {
    $id = $_GET['id'];

    var_dump($this->uploadPath);
    // Delete Folder
    // Update Info
  }

  public function getUploadPath()
  {
    $dir = dirname(dirname(Yii::app()->basePath)).'/'.self::THEME_DIR.'/';
    return $dir;
  }
}