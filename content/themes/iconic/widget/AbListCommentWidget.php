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
			$commentHtml = '<div id="comments" class="comments-area">';
			$commentHtml .= '	<h2 class="comments-title">';
			$commentHtml .= $this->model->commentCount.' thoughts on “<span>'.$postTitle.'</span>”';
			$commentHtml .= '	</h2>';
			$commentHtml .= '	<ol class="commentlist">';

			// $ctrl = Yii::app()->controller;
			foreach ($comments as $comment) {
				$postUrl = $url = Yii::app()->baseUrl.'/'.$this->controller->createPermalink($this->model->url, $this->model->created);
				$commentHtml .= $this->createCommentLi($comment, $postUrl);
			}
			$commentHtml .= '	</ol>';
			$commentHtml .= '</div>';
			echo $commentHtml;

			$this->endCache(); 
		}
	}

	public function createCommentLi($comment, $postUrl, $reply=false)
	{
		$id = $comment->comment_id;
		$date = date('F d, Y', strtotime($comment->date_insert));
		$time = date('c', strtotime($comment->date_insert));
		$author = $comment->author;
		$avatar = $reply? 'admin.png': 'user.png';
		$status = $reply? 'Reply Admin': 'Post Author';
		$content = $comment->content;
 
		$commentHtml  = '<li class="comment byuser bypostauthor even thread-even depth-1" id="comment-'.$id.'">';
		$commentHtml .= '	<article id="comment-'.$id.'" class="comment">';
		$commentHtml .= '		<header class="comment-meta comment-author vcard">';
		$commentHtml .= '			<img src="'.Yii::app()->baseUrl.'/content/assets/img/'.$avatar.'" class="avatar avatar-'.$id.' photo" height="30" width="30">';
		$commentHtml .= '			<cite class="fn">'.$author.' <span> '.$status.'</span></cite>';
		$commentHtml .= '			<a href="'.$postUrl.'#comment-'.$id.'">';
		$commentHtml .= '				<time datetime="'.$time.'">'.$date.'</time>';
		$commentHtml .= '			</a>';
		$commentHtml .= '		</header><!-- .comment-meta -->';
		$commentHtml .= '		<section class="comment-content comment">';
		$commentHtml .= '			<p>'.$content.'</p>';
		$commentHtml .= '		</section><!-- .comment-content -->';
		$commentHtml .= '	</article><!-- #comment-## -->';
		$commentHtml .=	'</li>';

		if( count($comment->reply)>0 && $comment->reply[0] instanceof CommentModel ){
			$commentHtml .=	'<ol class="children">';
			foreach ($comment->reply as $child) {
				$commentHtml .= $this->createCommentLi($child, $postUrl, true);
			}
			$commentHtml .= '</ol>';
		}

		return $commentHtml;
	}
}