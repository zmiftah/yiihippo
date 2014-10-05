<?php

class ArticleController extends AbBackController 
{
	const ARTICLE_LIMIT = 10;

	public function init()
	{
		$this->attachBehavior('handler', new AbArticleHandlerBehavior);
		parent::init();
	}

	public function actionIndex() 
	{
		$this->pageTitle = Yii::app()->name . ' - Daftar Artikel';

		$criteria = new CDbCriteria(array(
			'select'=>'*',
			'condition'=>'posttype_id='.PostTypeModel::TYPE_ARTICLE,
			'order'=>'post_id DESC'
		));

		$page = 'PostModel_page';
    $view = $this->generateData('PostModel', $_GET[$page], self::ARTICLE_LIMIT, $criteria);
    $this->render('list', $view);
	}

	public function actionAdd() 
	{
		$this->pageTitle = Yii::app()->name . ' - Tambah Artikel';

		$keyword    = new KeywordModel;
		$keyword_id = Yii::app()->session['keyword_id'];

		// Submitted Keyword
		$keyword  = KeywordModel::model()->findByPk($keyword_id, 'status='.KeywordModel::STATUS_ADDED);
		if ( !$keyword instanceof KeywordModel ) {
			Yii::app()->user->setFlash( 'error', "Tidak ada keyword yang disubmit" );
			$this->redirect( $this->createUrl('keyword/index') );
		}

		$model = new PostModel;
		if ( isset( $_POST['PostModel'] ) ) {
			$model->attributes  = $_POST['PostModel'];
			$model->posttype_id = PostTypeModel::TYPE_ARTICLE;
			$model->created     = new CDbExpression('NOW()');
			$model->author      = Yii::app()->user->adminId;
			$model->excerpt     = substr(strip_tags($_POST['PostModel']['content']), 0, 100) . '..';
			$model->url         = StringHelper::urlize( $_POST['PostModel']['url'] );
			$model->status      = $_POST['PostModel']['status'];
			$model->image       = $_POST['PostModel']['image'];
			$model->keyword 		= $_POST['PostModel']['keyword'];

			$trx = Yii::app()->db->beginTransaction();
			try {
				if ( $model->save() ) {
					// Update keyword status
					$this->handleKeyword('ADD', $_POST['PostModel']['keyword'], $model->post_id);

					// Insert category, if any
					$this->handleCategory($_POST['category'], $model->post_id);
					
					// Insert tags, if any
					$this->handleTags($_POST['tags'], $model->post_id);

					// Insert metas
					$this->handlePostMeta($_POST['meta_title'], $_POST['meta_keyword'], $model->post_id);

					// Commit Trx
					$trx->commit();

					// Redirect to index
					Yii::app()->user->setFlash( 'success', "Artikel '$model->title' berhasil disimpan" );
					Yii::app()->session['keyword_id'] = '';

					$this->redirect( 'index.php' );
				} else {
					$trx->rollback();
				}
			} catch (Exception $e) {
				// var_dump($e->getMessage());
				$trx->rollback();
			}
		}

		$keywords   = KeywordModel::getMap();
		$categories = TermModel::getCategory();
		

		$this->render( 'form', array( 
			'action'		 => 'Tambah',
			'model'      => $model,
			'keyword_id' => $keyword_id,
			'keyword'    => $keyword->name,
			'keywords'	 => $keywords,
			'categories' => $categories,
		) );
	}

	public function actionEdit() 
	{
		$id = $_GET['id'];
		$this->pageTitle = Yii::app()->name . ' - Edit Artikel';

		$model = PostModel::model()->findByPk($id);
		if ( !($model instanceof PostModel) ) {
			Yii::app()->user->setFlash( 'error', "Artikel yang Anda ingin ubah tidak ditemukan" );
			$this->redirect( 'index.php' );
		}

		if ( isset( $_POST['PostModel'] ) ) {
			$model->attributes  = $_POST['PostModel'];
			$model->modified    = new CDbExpression('NOW()');
			$model->excerpt     = substr(strip_tags($_POST['PostModel']['content']), 0, 100) . '..';
			$model->url         = StringHelper::urlize( $_POST['PostModel']['url'] );
			$model->status      = $_POST['PostModel']['status'];
			$model->image       = $_POST['PostModel']['image'];

			$trx = Yii::app()->db->beginTransaction();
			try {
				if ( $model->save() ) {
					// Insert category, if any
					$this->handleCategory($_POST['category'], $model->post_id);
					
					// Insert tags, if any
					$this->handleTags($_POST['tags'], $model->post_id);

					// Insert metas
					$this->handlePostMeta($_POST['meta_title'], $_POST['meta_keyword'], $model->post_id);

					// Commit Trx
					$trx->commit();

					// Redirect to index
					Yii::app()->user->setFlash( 'success', "Artikel '$model->title' berhasil disimpan" );
					$this->redirect( 'index.php' );
				} else {
					$trx->rollback();
				}
			} catch (Exception $e) {
				$trx->rollback();
				var_dump($e->getMessage());
			}
		}

		$keywords   = KeywordModel::getMap($model->keyword);
		$categories = TermModel::getCategory();
		
		$category = PostTermModel::getPostTerms($id, TaxonomyModel::CATEGORY);
		$tags     = PostTermModel::getPostTerms($id, TaxonomyModel::TAG);
		$metadata = $this->parsePostMeta($model);

		$this->render( 'form', array( 
			'action'		 => 'Edit',
			'model'      => $model,
			'keyword_id' => $model->keyword,
			'keyword'    => $model->postKeyword->name,
			'keywords'	 => $keywords,
			'categories' => $categories,
			'category'	 => $category,
			'tags'			 => $tags,
			'metadata'	 => $metadata
		) );
	}

	public function actionDelete() 
	{
		$id   = $_GET['id'];
		$post = PostModel::model()->findByPk($id);

		if ( !$post instanceof PostModel ) {
			Yii::app()->user->setFlash('error', "Artikel tidak ditemukan");
			$this->redirectUrl('article/index');
		}

		$status = 'error';
		$text = 'gagal';

		$transaction = Yii::app()->db->beginTransaction();
		try {
			// Delete / change status
			$command = Yii::app()->db->createCommand();
			$command->delete('comments', 'post_id=:id', array(':id'=>$post->post_id));
			$command->reset();
			$command->delete('postterm', 'post_id=:id', array(':id'=>$post->post_id));
			// $post->posttype_id = PostTypeModel::TYPE_TRASH;
			
			if( $post->delete() ){
				// Update Keyword status
				$this->handleKeyword('DELETE', $post->keyword, null);

				$status = 'success';
				$text   = 'berhasil';
			}

			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollback();
		}

		Yii::app()->user->setFlash( $status, "Artikel '{$post->title}' $text dihapus." );
		$this->redirectUrl('article/index');
	}

	public function actionPublish()
	{
		$id    = $_GET['id'];
		$model = PostModel::model()->findByPk($id);
		$model->status = PostStatusModel::STATUS_PUBLISH;
		$model->save();

		$this->redirectUrl('page/index');
	}

	public function actionValidLink()
	{
		$url = $_POST['url'];

		$match = PostModel::model()->find(array(
			'condition'=>'url=:url',
			'params'=>array(':url'=>$url)
		));
		$valid = !($match instanceof PostModel);

		header('Content-Type: application/javascript');
		echo CJSON::encode(array('result'=>(int)$valid));
	}

	public function actionUpload()
	{
		echo 'OK';
	}
}
