<?php 

class AbListCommentWidget extends CWidget
{
	public $postId = 0;
	private $model = null;
	private $valid = false;

	public function init() 
	{
		parent::init();

		$this->model = PostModel::model()->findByPk($this->postId);
		$this->valid = ($this->model instanceof PostModel);
	}

	public function run() 
	{
		if ( $this->valid == false )
			return;

		$postTitle = $this->model->title;
		$comments  = $this->model->comment;

		if ( count($comments)<=0 )
			return;

		$prop = array('duration'=>$this->controller->cacheDuration);
		if( $this->beginCache('showComment_'.$this->postId, $prop) ) {
			$commentHtml = '<div id="comments">';
			$commentHtml .= '	<h4 id="comments-title">';
			$commentHtml .= $this->model->commentCount.' thoughts on “<span>'.$postTitle.'</span>”';
			$commentHtml .= '	</h4>';
			$commentHtml .= '	<ol class="commentlist">';

			foreach ($comments as $comment) {
				$postUrl = $url = Yii::app()->baseUrl.'/'.$this->controller->createPermalink($this->model->url, $this->model->created);
				$commentHtml .= $this->createCommentLi($comment, $postUrl);
			}
			$commentHtml .= '</div>';
			echo $commentHtml;

		 	$this->endCache(); 
		}
	}

	public function createCommentLi($comment, $postUrl, $reply=false)
	{
		$id = $comment->comment_id;
		$date = date('F d, Y', strtotime($comment->date_insert));
		$time = date('H:i a', strtotime($comment->date_insert));
		$author = $comment->author;
		$avatar = $reply ? 'admin.png' : 'user.png';
		$content = $comment->content;
 
		$commentHtml  = '<li class="comment byuser bypostauthor even depth-2 parent" id="comment-'.$id.'">';
		$commentHtml .= '	<div id="div-comment-'.$id.'" class="comment-body">';
		$commentHtml .=	'	<div class="comment-author vcard postauthor-avatar">';
		$commentHtml .=	'		<img src="'.Yii::app()->baseUrl.'/content/assets/img/'.$avatar.'" class="avatar avatar-'.$id.' photo" height="64" width="64">';
		$commentHtml .=	'		<div class="comment-meta commentmetadata">';
		$commentHtml .=	'			<a href="'.$postUrl.'/#comment-'.$id.'">'.$date.' at '.$time.'</a>&nbsp;&nbsp;';
		$commentHtml .=	'		</div>';
		$commentHtml .=	'		<cite class="fn">'.$author.' </cite> <span class="says">says:</span>';
		$commentHtml .=	'	</div>';
		$commentHtml .=	'	<div class="comment-content"><p>'.$content.'</p></div>';
		$commentHtml .=	'	<div class="clear"></div>';
		$commentHtml .=	'</div>';

		if( count($comment->reply)>0 && $comment->reply[0] instanceof CommentModel ){
			$commentHtml .=	'<ul class="children">';
			foreach ($comment->reply as $child) {
				$commentHtml .= $this->createCommentLi($child, $postUrl, true);
			}
			$commentHtml .= '</ul>';
		}

		return $commentHtml;
	}
}
