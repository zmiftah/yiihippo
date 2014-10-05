<?php 

class AbNavMenuTopWidget extends CWidget
{
	public $orderBy = 'title';
	public $ulID    = '';
	public $ulClass = '';
	public $liClass = '';
	private $pages = null;

	public function init()
	{
		parent::init();
		$this->pages = $this->getPosts();
	}

	public function run()
	{
		if ( !(is_array($this->pages) && $this->pages[0] instanceof PostModel) )
			return;

		$baseUrl = Yii::app()->baseUrl;

		$menuHtml = '<ul id="'.$this->ulID.'" class="'.$this->ulClass.'">';
		$menuHtml .= '<li class="'.$this->liClass.'"><a href="'.$baseUrl.'/">Home</a></li>';
		foreach ($this->pages as $page) {
			$menuHtml .= $this->createLink($baseUrl, $page);
		}
		$menuHtml .= '</ul>';

		echo $menuHtml;
	}

	public function createLink($baseUrl, $page)
	{
		$class = "{$this->liClass} menu-item-{$page->post_id}";
		$title = $page->title;
		$url = $baseUrl.'/'.$page->url;

		return '<li id="menu-item-'.$page->post_id.'" class="'.$class.'"><a href="'.$url.'">'.$title.'</a></li>';
	}

	public function getPosts()
	{
		$pages = PostModel::model()->pages()->findAll(array(
			'order'=>$this->orderBy
		));

		return $pages;
	}
}
