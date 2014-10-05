<?php

class CommentController extends AbBackController 
{
	const COMMENT_LIMIT = 10;

	public function init()
	{
		parent::init();
		$this->attachBehavior('parseUrl', new AbParseUrlBehavior);
	}

	public function actionIndex() 
	{
		$this->pageTitle = Yii::app()->name.' - Daftar Comment';

		$scope = 'comments';
		switch ($_GET['sort']) {
			case 'pending': $scope = 'pending'; break;
			case 'approve': $scope = 'approve'; break;
			case 'spam': 		$scope = 'spam'; break;
			case 'trash': 	$scope = 'trash'; break;
		}

		$criteria = new CDbCriteria(array(
			'select'=>'*',
			'scopes'=>$scope,
			'order'=>'comment_id DESC'
		));

		$page = 'CommentModel_page';
    $view = $this->generateData('CommentModel', $_GET[$page], self::COMMENT_LIMIT, $criteria);
    $this->render('list', $view);
	}

	public function actionEdit() 
	{
		$id = $_GET['id'];
		$row = CommentModel::model()->findByPk($id);

		if ( !$row instanceof CommentModel ) {
			Yii::app()->user->setFlash('error', "Komentar yang Anda cari tidak ditemukan");
      $this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
		}

		if ( isset($_POST['yt0']) ) {
			$row->content = $_POST['comment'];

			if( $row->save() ){
				Yii::app()->user->setFlash('success', "Komentar berhasil diedit");
				$this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
			}
		}

		$this->render('edit', array(
			'row'=>$row
		));
	}

	public function actionReply() 
	{
		$id = $_GET['id'];
		$row = CommentModel::model()->findByPk($id);

		if ( !$row instanceof CommentModel ) {
			Yii::app()->user->setFlash('error', "Komentar yang Anda cari tidak ditemukan");
      $this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
		}

		if ( $row->replyCount>0 ) {
			$child = $row->reply[0];
			$reply = CommentModel::model()->findByPk($child->comment_id);
		} else {
			$reply = new CommentModel;
		}

		if ( isset($_POST['yt0']) ) {
			if ( $row->replyCount==0 ) {
				$email = Yii::app()->options->get('email');

				$reply->author      = 'Admin';
				$reply->email 			= $email;
				$reply->post_id     = $_POST['CommentModel']['post_id'];
				$reply->reply_to    = $_POST['CommentModel']['comment_id'];
				$reply->date_insert = new CDbExpression('NOW()');
				$reply->status  = CommentModel::STATUS_REPLY;
			}
			$reply->content = $_POST['reply'];

			if( $reply->save() ){
				Yii::app()->user->setFlash('success', "Komentar berhasil direply");
				$this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
			}
		}

		$this->render('reply', array(
			'row'=>$row,
			'reply'=>$reply
		));
	}

	public function actionApprove() 
	{
		$id = $_GET['id'];
		$row = CommentModel::model()->findByPk($id);

		if ( !$row instanceof CommentModel ) {
			Yii::app()->user->setFlash('error', "Komentar yang Anda cari tidak ditemukan");
      $this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
		}

		$row->status = CommentModel::STATUS_APPROVE;
		if ( $row->save() ) {
			Yii::app()->user->setFlash('success', "Komentar berhasil diapprove");
		} else {
			Yii::app()->user->setFlash('error', "Komentar gagal diapprove");
		}
		$this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
	}

	public function actionSpam() 
	{
		$id = $_GET['id'];
		$row = CommentModel::model()->findByPk($id);

		if ( !$row instanceof CommentModel ) {
			Yii::app()->user->setFlash('error', "Komentar yang Anda cari tidak ditemukan");
      $this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
		}

		$row->status = CommentModel::STATUS_SPAM;
		if ( $row->save() ) {
			Yii::app()->user->setFlash('success', "Komentar berhasil ditandai sebagai spam");
		} else {
			Yii::app()->user->setFlash('error', "Komentar gagal ditandai sebagai spam");
		}
		$this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
	}

	public function actionTrash() 
	{
		$id = $_GET['id'];
		$row = CommentModel::model()->findByPk($id);

		if ( !$row instanceof CommentModel ) {
			Yii::app()->user->setFlash('error', "Komentar yang Anda cari tidak ditemukan");
      $this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
		}

		if ($row->status == CommentModel::STATUS_TRASH) {
			$trashed = $row->delete();
		} else {
			$row->status = CommentModel::STATUS_TRASH;
			$trashed = $row->save();
		}

		if ($trashed) {
			Yii::app()->user->setFlash('success', "Komentar berhasil dihapus");
		} else {
			Yii::app()->user->setFlash('error', "Komentar gagal dihapus");
		}
			
		$this->redirectUrl(array('comment/index',array('sort'=>$_GET['sort'])));
	}
}
