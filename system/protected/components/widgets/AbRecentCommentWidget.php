<?php 

class AbRecentCommentWidget extends CWidget 
{
	public $title = 'Recent Comments';
	public $commentCount = 5;

	private $_queries = null;

	public function run() 
	{
		$id   = 'widgetRecentCommentWidget';
		$prop = array('duration'=>$this->controller->cacheDuration);

		//if( $this->beginCache($id, $prop) ) {
			$this->getLastComments();
			$this->recentComments();

			//$this->endCache();
		//}
	}

	public function recentComments() 
	{
		$html = '<aside id="recent-comments" class="widget widget_recent_comments">';
		$html .= '<p class="widget-title">'.$this->title.'</p>  ';
		$html .= '<ul id="recentcomments">';
		
		foreach ( $this->_queries as $comment ) {
			$post = $comment->post;
			$url = $this->controller->createPermalink($post->url, $post->created);

			$html .= '<li class="recentcomments">';
			$html .= 		$comment->author.' on ';
			$html .= 		'<a href="'.$url.'#comment-'.$comment->comment_id.'" title="'.$post->title.'">';
			$html .= 			$post->title;
			$html .= 		'</a>';
			$html .= '</li>';
		}
		
		$html .= '</ul>';
		$html .= '</aside>';

		echo $html;
	}

	public function getLastComments() 
	{
		$this->_queries = CommentModel::model()->comments()->findAll(array(
			'order'=>'date_insert DESC',
			'limit'=>$this->commentCount
		));
	}
}