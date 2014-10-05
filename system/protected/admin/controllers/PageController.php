<?php

class PageController extends AbBackController
{
	const PAGE_LIMIT = 10;

	public function init()
	{
		parent::init();
		$this->attachBehavior('handler', new AbArticleHandlerBehavior);
	}

	public function actionIndex() 
	{
		$this->pageTitle = Yii::app()->name.' - Daftar Halaman';
		$siteTitle       = Yii::app()->options->get('site_title');

		$criteria = new CDbCriteria(array(
			'select'=>'*',
			'condition'=>'posttype_id='.PostTypeModel::TYPE_PAGE
		));

		$page = 'PostModel_page';
    $view = $this->generateData('PostModel', $_GET[$page], self::PAGE_LIMIT, $criteria);
    $this->render( 'list', array_merge($view, array(
			'title' => $siteTitle,
		)));
	}

	public function actionAdd() 
	{
		$model = new PostModel;

		if ( $_POST['PostModel'] ) {
			$kwd = KeywordModel::model()->findByPk($_POST['PostModel']['keyword']); //$kwd->id

			$model->attributes  = $_POST['PostModel'];
			$model->keyword 		= $kwd->id;
			$model->posttype_id = PostTypeModel::TYPE_PAGE;
			$model->created     = new CDbExpression('NOW()');
			$model->author      = Yii::app()->user->adminId;
			$model->excerpt     = substr(strip_tags($_POST['PostModel']['content']), 0, 100) . '..';
			$model->url         = StringHelper::urlize( $_POST['PostModel']['url'] );
			$model->status 			= PostStatusModel::STATUS_PUBLISH; //issue #1

			if ( $model->save() ) {
				// Update Keyword
				$this->handleKeyword('ADD', $kwd->id, $model->post_id);
				// Update Meta
				$this->handlePostMeta($_POST['meta_title'], $_POST['meta_keyword'], $model->post_id);

				Yii::app()->user->setFlash( 'success', "Berhasil menyimpan page '$model->title'." );
				$this->redirectUrl('page/index');
			}
		}
		
		$keywords = KeywordModel::getMap('');
		$this->render('form', array(
			'action'     => 'Tambah',
			'model'      => $model,
			'keywords'   => $keywords,
		));
	}

	public function actionEdit() 
	{
		$id    = $_GET['id'];
		$model = PostModel::model()->findByPk($id);

		if ( !$model instanceof PostModel ) {
			Yii::app()->user->setFlash( 'error', "Artikel yang ingin Anda edit tidak ada." );
			$this->redirectUrl('page/index');
		}
		$title   = $model->title;
		$keyword = $model->keyword;

		if ( $_POST['PostModel'] ) {
			$model->attributes  = $_POST['PostModel'];
			$model->url         = StringHelper::urlize( $_POST['PostModel']['url'] );
			$model->modified    = new CDbExpression('NOW()');
			$model->excerpt     = substr(strip_tags($_POST['PostModel']['content']), 0, 100) . '..';

			if ( $model->save() ) {
				// Update Meta
				$this->handlePostMeta($_POST['meta_title'], $_POST['meta_keyword'], $model->post_id);

				Yii::app()->user->setFlash( 'success', "Artikel '$title' berhasil diedit." );
				$this->redirectUrl('page/index');
			}
		}

		$keywords = KeywordModel::getMap($keyword);
		$metadata = $this->parsePostMeta($model);
		$this->render('form', array(
			'action'     => 'Edit',
			'model'      => $model,
			'keywords'   => $keywords,
			'metadata'   => $metadata,
			'keyword_id' => $keyword,
			'keyword'    => $model->postKeyword['name'],
		));
	}

	public function actionDelete() 
	{
		$id   = $_GET['id'];
		$post = PostModel::model()->pages()->findByPk($id);

		if ( !$post instanceof PostModel ) {
			Yii::app()->user->setFlash('error', "Artikel tidak ditemukan");
			$this->redirectUrl('page/index');
		}

		try {
			$post->delete();

			// Update Keyword status
			$this->handleKeyword('DELETE', $post->keyword, null);

			$status = 'success';
			$text   = 'berhasil';
		} catch (CDbException $e) {
			$error = "Error Code:".$e->getCode();
			$status = 'error';
			$text = 'gagal';
		}

		Yii::app()->user->setFlash( $status, "Page '$post->title' $text dihapus. $error" );
		$this->redirectUrl('page/index');
	}
}