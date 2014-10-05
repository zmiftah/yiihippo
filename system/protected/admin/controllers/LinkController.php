<?php

class LinkController extends AbBackController 
{
	const LINK_LIMIT = 10;

  public function actionIndex() 
	{
		$this->pageTitle = Yii::app()->name.' - Daftar Link';

		$criteria = new CDbCriteria(array(
			'scopes'=>'websites'
		));

		$page = 'LinkModel_page';
    $view = $this->generateData('LinkModel', $_GET[$page], self::LINK_LIMIT, $criteria);
    $this->render('list', $view);
	}

	public function actionAdd()
	{
		$this->pageTitle = Yii::app()->name . ' - Tambah Link';
		$model = new LinkModel;

		if ( isset( $_POST['LinkModel'] ) ) {
			$model->strictUrl = true; //Url Validation

			$model->name = $_POST['LinkModel']['name'];
			$model->url = $_POST['LinkModel']['url'];
			$model->target = $_POST['LinkModel']['target'];
			$model->type = LinkModel::LINK_TYPE_WEBSITE;
			$model->created = new CDbExpression('NOW()');

			if ( $model->save() ) {
				Yii::app()->user->setFlash( 'success', "Link '$model->name' berhasil ditambahkan" );
				$this->redirect('index.php');
			}
		}

		$this->render('form', array(
			'model' => $model,
			'title' => 'Tambah',
			'targetList' => $this->targetList
		));
	}

	public function actionEdit()
	{
		$id = $_GET['id'];
		$model = LinkModel::model()->findByPk($id);

		if ( !$model instanceof LinkModel ) {
			Yii::app()->user->setFlash('error', "Link yang Anda cari tidak ditemukan");
      $this->redirectUrl('link/index');
		}

		if ( isset($_POST['LinkModel']) ) {
			$model->strictUrl = true; //Url Validation
			
			$old_name = $model->name;
			$model->name = $_POST['LinkModel']['name'];
			$model->url = $_POST['LinkModel']['url'];
			$model->target = $_POST['LinkModel']['target'];

			if( $model->save() ){
				Yii::app()->user->setFlash('success', "Link '$old_name' berhasil diedit");
				$this->redirectUrl('link/index');
			}
		}

		$this->render('form', array(
			'model' => $model,
			'title' => 'Edit',
			'targetList' => $this->targetList
		));
	}

	public function actionDelete()
	{
		$id = $_GET['id'];
		$model = LinkModel::model()->findByPk($id);

		if ( !$model instanceof LinkModel ) {
			Yii::app()->user->setFlash('error', "Link yang Anda cari tidak ditemukan");
      $this->redirectUrl('link/index');
		}

		if( $model->delete() ) {
			Yii::app()->user->setFlash( 'success', "Link '$model->name' berhasil didelete." );
		} else {
			Yii::app()->user->setFlash( 'error', "Link '$model->name' gagal didelete." );
		}

		$this->redirect('index');
	}

	public function getTargetList()
	{
		return array(
			'_blank' => 'Blank',
			'_self'  => 'Self',
			// '_top'   => 'Top (Not Recommended)'
		);
	}
}