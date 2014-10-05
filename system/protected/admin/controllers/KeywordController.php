<?php

class KeywordController extends AbBackController 
{
	const KEYWORD_LIMIT = 10;

	public function actionIndex() 
	{
		$this->pageTitle = Yii::app()->name . ' - Daftar Kata Kunci';

		$criteria = new CDbCriteria(array(
			'select'=>'*',
			'condition'=>'status='.KeywordModel::STATUS_ADDED,
		));

		$page = 'KeywordModel_page';
    $view = $this->generateData('KeywordModel', $_GET[$page], self::KEYWORD_LIMIT, $criteria);
    $this->render('list', $view);
	}

	public function actionAdd() 
	{

		$this->pageTitle=Yii::app()->name . ' - Tambah Kata Kunci';

		if ( isset( $_POST['KeywordModel'] ) ) {
			$keywords = preg_split( '/\r\n|\n|\r/', $_POST['KeywordModel']['keyword'] );

			foreach ($keywords as $keyword) {
				$keyword = StringHelper::escape($keyword);
				$data[] = trim( $keyword ); 
			}
			$keywords = array_unique( $data );
			
			$sql    = "INSERT IGNORE INTO keywords (name, status) VALUES";
			foreach ($keywords as $keyword) {
				$values[] = "('$keyword', 0)";
			}

			$sql .= implode(',', $values);

			$inserted = Yii::app()->db->createCommand($sql)->execute();
			if( $inserted > 0 ) {
				Yii::app()->user->setFlash( 'success', "Berhasil menambahkan $inserted keyword." );
				$this->redirect('index.php');
			}
		}

		$this->render( 'form' );
	}

	public function actionSubmit()
	{
		$id = $_GET['id'];
		Yii::app()->session['keyword_id'] = $id;
		$this->redirectUrl( 'article/add' );
	}

	public function actionDelete() 
	{
		$id = $_GET['id'];
		$model = KeywordModel::model()->findByPk( $id );
		if ( !( $model instanceof KeywordModel ) ) {
			Yii::app()->user->setFlash( 'error', "<strong>Error</strong> Tidak ada keyword dengan id $id." );
		} else {
			if( $model->delete() ) {
				Yii::app()->user->setFlash( 'success', "Keyword <b>'$model->name'</b> berhasil didelete." );
			}
		}

		$this->redirect( 'index.php' );
	}
}
