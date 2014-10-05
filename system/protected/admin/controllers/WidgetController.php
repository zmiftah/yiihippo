<?php

class WidgetController extends AbBackController
{
	public $frontWidget = null;

	public function init()
	{
		parent::init();
		$this->frontWidget = new AbFrontWidgetManager;
    $this->frontWidget->init();
	}

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . ' - Widget';
    $widgets = $this->frontWidget->widgets;
    $count   = $this->frontWidget->itemCount;

    $view = $this->generateData($widgets, $_GET['page'], 10, null, false);
    $this->render('list', array_merge($view, array(
      'itemCount'=>$count
    )));
  }

  public function actionConfigure() 
  {
    $id = $_GET['id'];

    if (isset($_POST['save'])) {
      $this->handleSave($id, $_POST);
    }

  	$this->pageTitle = Yii::app()->name . ' - Configure Widget';
  	$widgets = $this->frontWidget->widgets;
    $widget  = $widgets[$id];

    $label   = str_replace(' ', '_', strtolower($widget['name']));
    $config  = Yii::app()->options->get("widget_$id", array());
    $content = $this->getContentForm($id,  $config);

    $this->render('configure', array(
      'id'=>$id,
      'widget'=>$widget,
      'content'=>$content,
      'label'=>$label
    ));
  }

  public function actionShow()
  {
    $id = $_GET['id'];

    if ( !in_array($id, $this->availableWidgets) ) {
      Yii::app()->user->setFlash('error', 'Widget yang Anda cari tidak ada.');
    } else {
      $widgets = Yii::app()->options->get('app_widgets');
      $widgets[$id]['show'] = true;
      Yii::app()->options->add('app_widgets', serialize($widgets));
      Yii::app()->user->setFlash('success', "Widget '{$widgets[$id][name]}' berhasil ditampilkan");
    }

    $this->redirect('index');
  }

  public function actionHide()
  {
    $id = $_GET['id'];

    if ( !in_array($id, $this->availableWidgets) ) {
      Yii::app()->user->setFlash('error', 'Widget yang Anda cari tidak ada.');
    } else {
      $widgets = Yii::app()->options->get('app_widgets');
      $widgets[$id]['show'] = false;
      Yii::app()->options->add('app_widgets', serialize($widgets));
      Yii::app()->user->setFlash('success', "Widget '{$widgets[$id][name]}' berhasil disembunyikan");
    }

    $this->redirect('index');
  }

  public function handleSave($id, $form)
  {
    // List: 1,2,3,5,7,8,12
    $widget = 'widget_'.$id;

    unset($form['save']);
    Yii::app()->options->add($widget, $form, null, true);
    Yii::app()->user->setFlash('success', 'Setting Widget berhasil disimpan');
    $this->redirect('index.php');
  }

  public function getContentForm($id, $config)
  {
    $theme = Yii::app()->theme->name;
    $filePath = dirname( Yii::app()->theme->basePath );
    $filePath .= "/{$theme}/views/{$this->id}/form/{$id}.php";

    return $this->renderFile($filePath, array_merge($config, array(
      'id'=>$id
    )), true);
  }

  public function getAvailableWidgets()
  {
    return array(
      1, 2, 3, 5, 7, 8, 12
    );
  }
}