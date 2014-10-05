<?php 

class AbLinksWidget extends CWidget 
{
	public $title = 'Links';
	public $linkCount = 10;

	private $_queries = null;

	public function run() 
	{
		$id   = 'widgetLinksWidget';
		$prop = array('duration'=>$this->controller->cacheDuration);
		
		if( $this->beginCache($id, $prop) ) {
			$this->getLinks();
			$this->linksWidget();

			$this->endCache();
		}
	}

	public function linksWidget() 
	{
		$html = '<aside id="linkcat-2" class="widget widget_links">';
		$html .= '<p class="widget-title">'.$this->title.'</p>';
		$html .= '<ul class="xoxo blogroll">';

		foreach ( $this->_queries as $link ) {
			$url = str_replace('http://', '', $link->url);
			$html .= '<li><a href="http://'.$url.'" target="'.$link->target.'">'.$link->name.'</a></li>';
		}
		
		$html .= '</ul>';
		$html .= '</aside>';

		echo $html;
	}

	public function getLinks() 
	{
		$this->_queries = LinkModel::model()->websites()->findAll(array(
			'order'=>'created',
			'limit'=>$this->linkCount
		));
	}
}?>