<?php

class PostController extends AbFrontController 
{
	public $layout = '//layouts/column2';

	public function init()
	{
		$this->attachBehavior('parseUrl', new AbParseUrlBehavior);
		$this->attachBehavior('handler', new AbArticleHandlerBehavior);

		parent::init();
	}

	public function actionIndex()
	{
		$page = $_GET['page'];
		$this->pageTitle = Yii::app()->options->get('site_title', 'Daftar Artikel');

		// $this->useSlider = true;
		$limit = Yii::app()->options->get('post_limit');
		$posts = $this->dbGetPosts($page, $limit);
		$pages = $this->postPagination($page, $limit);

		if (count($posts)>0) {
			$this->render('list', array(
				'posts'=>$posts,
				'pages'=>$pages
			));
		} else {
			$this->render('zero');
		}
	}

	public function actionPost()
	{
		$link = $_GET['post'];
		$post = $this->dbParsePost($link);

		if( !($post instanceof PostModel) ){
			throw new CHttpException(404, 'Halaman tidak ditemukan');
		}

		$metadata = $this->parsePostMeta($post);
		$this->metaTitle = $metadata['title'];
		$this->metaKeyword = $metadata['keyword'];
		$this->metaDesc = $post->desc;

		if ($post->posttype_id == PostTypeModel::TYPE_ARTICLE) {
			$this->processComment();

			$viewFile = 'view_article';
		} else {
			$this->layout = '//layouts/column1';
			$viewFile = 'view_page';
		}
		
		$this->render($viewFile, array(
			'post' => $post
		));
	}

	public function actionArticle() 
	{
		$link = $_GET['post'];
		$post = $this->dbParseArticle($link);

		if( !($post instanceof PostModel) ){
			throw new CHttpException(404, 'Halaman tidak ditemukan');
		}

		$metadata = $this->parsePostMeta($post);
		$this->metaTitle = $metadata['title'];
		$this->metaKeyword = $metadata['keyword'];
		$this->metaDesc = $post->desc;

		$this->processComment();

		$this->render('view_article', array(
			'post' => $post
		));
	}

	public function actionPage()
	{
		$link = $_GET['post'];
		$post = $this->dbParsePage($link);

		if( !($post instanceof PostModel) ){
			throw new CHttpException(404, 'Halaman tidak ditemukan');
		}

		$metadata = $this->parsePostMeta($post);
		$this->metaTitle = $metadata['title'];
		$this->metaKeyword = $metadata['keyword'];
		$this->metaDesc = $post->desc;

		$this->layout = '//layouts/column1';
		$this->render('view_page', array(
			'post' => $post
		));
	}

	public function actionTaxonomy()
	{
		$link = Yii::app()->request->getUrl();
		$type = preg_match('/\/category\//', $link) ? 'category':'tag';
		$id   = preg_match('/\/category\//', $link) ? TaxonomyModel::CATEGORY:TaxonomyModel::TAG;
		$posts = $this->dbParseTaxonomy($_GET['taxo'], $type, $id);

		if (count($posts)>0) {
			$viewFile = 'taxonomy';
		} else {
			$viewFile = 'blank';
		}

		$this->render($viewFile, array(
			'type'=>$type,
			'posts'=>$posts,
			'taxo'=>$_GET['taxo']
		));
	}

	public function actionSearch()
	{
		$posts = $this->dbParseSearch($_GET['s']);

		if (count($posts)>0) {
			$viewFile = 'search';
		} else {
			$viewFile = 'blank';
		}

		$this->render($viewFile, array(
			'posts' => $posts
		));
	}

	public function actionArchives()
	{
		$posts = $this->dbParseArchive($_GET['year'], $_GET['month'], $_GET['day']);

		if (count($posts)>0) {
			$viewFile = 'archive';
		} else {
			$viewFile = 'blank';
		}

		$this->render($viewFile, array(
			'posts' => $posts
		));
	}

	public function processComment()
	{
		// Post Comment
		if ( $_POST['submit'] ) {
			$comment = new CommentModel;
      $comment->post_id     = $_POST['comment_post_ID'];
      $comment->author      = $_POST['author'];
      $comment->email       = $_POST['email'];
      $comment->website     = $_POST['website'];
      $comment->content     = $_POST['comment'];
      $comment->ip_address  = $_SERVER['REMOTE_ADDR'];
      $comment->date_insert = new CDbExpression('NOW()');
      $comment->status      = CommentModel::STATUS_PENDING;
      $comment->reply_to    = $replyTo;

      if( $comment->save() ){
      	Yii::app()->user->setFlash('message', "Komentar Anda menunggu untuk dimoderasi. Terima kasih");
      	$url = basename($_POST['post_url']).'#comments';
      	$this->redirect( $url );
      } else {
      	Yii::app()->user->setFlash('error', "Komentar Anda tidak lengkap silakan periksa kembali");
      }
		}
	}

	public function beforeRender( $view ) 
	{
		return parent::beforeRender( $view );
	}
}
