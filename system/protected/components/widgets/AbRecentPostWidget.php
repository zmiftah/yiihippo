<?php 

class AbRecentPostWidget extends CWidget 
{

	public $postId = 0;
	public $title = 'Recent Articles';
	public $postCount = 5;
	public $showThumb = true;
	public $showDate = true;

	private $_queries = null;

	public function run() 
	{
		$id   = 'widgetRecentPostWidget';
		$prop = array('duration'=>$this->controller->cacheDuration);

		//if( $this->beginCache($id, $prop) ) {
			$this->getLastPosts();
			$this->recentPost();

			//$this->endCache(); 
		//}
	}

	public function recentPost() 
	{
		$html = '<aside id="swift-popular-posts-'.$this->postId.'" class="widget widget_recent_entries">';
		$html .= '<p class="widget-title">'.$this->title.'</p>  ';
		$html .= '<ul>';

		foreach ( $this->_queries as $post ) {
			$html .= '<li class="clearfix">';

			$url      = $this->controller->createPermalink($post->url, $post->created);
			$datetime = date('c', strtotime($post->created));
			$date     = date('F d, Y', strtotime($post->created));
			$time     = date('g:i a', strtotime($post->created));
			$featured = ( $post->featured ) 
				? MediaHelper::getFileThumbnail(array(
					'name'=>$post->featured->name,
					'url'=>$post->featured->url
					), 36, 36)
				: Yii::app()->theme->baseUrl.'/assets/img/default.png';

			if ( $this->showThumb ) {
				$html .= '	<a href="'.$url.'" title="'.$post->title.'">';
				$html .= '		<img width="36" height="36" src="'.$featured.'" class="alignleft thumb wp-post-image" alt="'.$post->title.'" title="'.$post->title.'">';
				$html .= '	</a>';
			}

			$html .= '	<a href="'.$url.'" title="'.$post->title.'">';
			$html .= 		$post->title;
			$html .= '	</a>';
			$html .= '	<br>';

			if ( $this->showDate ) {
				$html .= '	<span class="meta">';
				$html .= '		<a href="'.$url.'" title="'.$time.'" rel="bookmark">';
				$html .= '			<time class="entry-date" datetime="'.$datetime.'">'.$date.'</time>';
				$html .= '		</a>';
				$html .= '	</span>';
			}

			$html .= '	<div class="clear"></div>';
			$html .= '</li>';
		}
		
		$html .= '</ul>';
		$html .= '</aside>';

		echo $html;
	}

	public function getLastPosts() 
	{
		$this->_queries = PostModel::model()->articles()->findAll(array(
			'order'=>'created DESC',
			'limit'=>$this->postCount
		));
	}
}