<?php

class TaxonomyController extends AbBackController
{
	const TAXONOMY_LIMIT = 10;

	public $defaultAction = 'category';

  public function actionCategory()
  {
    $this->pageTitle = Yii::app()->name . ' - Daftar Kategori';

    // Updating Data
    // 
    $model = new TermModel;
    if ( $_POST['TermModel'] ) {
      if( $_POST['action'] == 'Edit' ) {
        $model = TermModel::model()->findByPk($_POST['id']);
      }

      $model->taxo_id = TaxonomyModel::CATEGORY;
      $model->name = $_POST['TermModel']['name'];
      $model->slug = strtolower($_POST['TermModel']['slug']);
      $model->term_group = $_POST['TermModel']['term_group'];
      $model->desc = $_POST['TermModel']['desc'];

      if ( $model->save() ) {
        Yii::app()->user->setFlash( 'success', "Kategori '$model->name' berhasil diupdate" );
      } else {
        Yii::app()->user->setFlash( 'error', "Gagal mengupdate kategori" );
      }
    }

		$criteria = new CDbCriteria(array(
			'select'=>'*',
			'condition'=>'taxo_id='.TaxonomyModel::CATEGORY,
      'order'=>'term_id DESC'
		));

		$page = 'TermModel_page';
    $view = $this->generateData('TermModel', $_GET[$page], self::TAXONOMY_LIMIT, $criteria);
    $this->render('category', $view);
  }

  public function actionFormCategory()
  {
  	$this->layout = '//layouts/blank';

  	// Selecting Data
  	// 
  	if ( isset($_POST['id']) ) {
			$action = 'Edit';
			$model  = TermModel::model()->findByPk($_POST['id']);
			$data   = array(
	  		'condition'=>'term_group IS NULL AND taxo_id=:taxo AND term_id != :id',
	  		'params'=>array(':taxo'=>TaxonomyModel::CATEGORY, ':id'=>$_POST['id'])
	  	);
  	} else {
			$action = 'Add';
			$model  = new TermModel;
			$data   = array(
	  		'condition'=>'term_group IS NULL AND taxo_id=:taxo',
	  		'params'=>array(':taxo'=>TaxonomyModel::CATEGORY)
	  	);
  	}

  	$parents = TermModel::model()->findAll(array(
  		'select'=>'term_id,name',
  		'condition'=>$data['condition'],
  		'params'=>$data['params']
  	));
  	
  	$this->render('form', array(
  		'model'=>$model,
  		'parents'=>$parents,
  		'action'=>$action,
      'term_id'=>$_POST['id'],
  	));
  }

  public function actionTags()
  {
    $this->pageTitle = Yii::app()->name . ' - Daftar Tag';

    // Updating Data
    // 
    $model = new TermModel;
    if ( $_POST['TermModel'] ) {
      if( $_POST['action'] == 'Edit' ) {
        $model = TermModel::model()->findByPk($_POST['id']);
      }

      $model->taxo_id = TaxonomyModel::TAG;
      $model->name = $_POST['TermModel']['name'];
      $model->slug = strtolower($_POST['TermModel']['slug']);
      $model->term_group = $_POST['TermModel']['term_group'];
      $model->desc = $_POST['TermModel']['desc'];

      if ( $model->save() ) {
        Yii::app()->user->setFlash( 'success', "Tag '$model->name' berhasil diupdate" );
      } else {
        Yii::app()->user->setFlash( 'error', "Gagal mengupdate tag" );
      }
    }

    $criteria = new CDbCriteria(array(
      'select'=>'*',
      'condition'=>'taxo_id='.TaxonomyModel::TAG,
      'order'=>'term_id DESC'
    ));

    $page = 'TermModel_page';
    $view = $this->generateData('TermModel', $_GET[$page], self::TAXONOMY_LIMIT, $criteria);
    $this->render('tags', $view);
  }

  public function actionFormTags()
  {
    $this->layout = '//layouts/blank';

    // Selecting Data
    // 
    if ( isset($_POST['id']) ) {
      $action = 'Edit';
      $model  = TermModel::model()->findByPk($_POST['id']);
      $data   = array(
        'condition'=>'term_group IS NULL AND taxo_id=:taxo AND term_id != :id',
        'params'=>array(':taxo'=>TaxonomyModel::TAG, ':id'=>$_POST['id'])
      );
    } else {
      $action = 'Add';
      $model  = new TermModel;
      $data   = array(
        'condition'=>'term_group IS NULL AND taxo_id=:taxo',
        'params'=>array(':taxo'=>TaxonomyModel::TAG)
      );
    }

    $parents = TermModel::model()->findAll(array(
      'select'=>'term_id,name',
      'condition'=>$data['condition'],
      'params'=>$data['params']
    ));
    
    $this->render('form', array(
      'model'=>$model,
      'parents'=>$parents,
      'action'=>$action,
      'term_id'=>$_POST['id'],
    ));
  }

  public function actionDelete()
  {
    $id = $_POST['id'];
    $result = TermModel::model()->deleteByPk($id);

    header('Content-Type: application/json');
    echo (int)$result;
  }
}
