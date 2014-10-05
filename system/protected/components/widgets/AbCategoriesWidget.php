<?php 

class AbCategoriesWidget extends CWidget 
{
	public $title = 'Categories';
	public $showCount = false;
	public $categoryCount = 25;
	
	private $_queries = null;

	public function run() 
	{
		$id   = 'widgetCategoriesWidget';
		$prop = array('duration'=>$this->controller->cacheDuration);

		if( $this->beginCache($id, $prop) ) {
			$this->getCategories();
			$this->categoryWidget();

			$this->endCache();
		}
	}

	public function categoryWidget() 
	{
		$html = '<aside id="categories" class="widget widget_categories">';
		$html .= '<p class="widget-title">'.$this->title.'</p>  ';
		$html .= '<ul>';

		$baseUrl = Yii::app()->baseUrl.'/category/';

		foreach ( $this->_queries as $category ) {
			$html .= '<li class="cat-item cat-item-'.$category->term_id.'">';
			$html .= 		'<a href="'.$baseUrl.$category->slug.'.htm" title="View all posts filed under '.$category->name.'">';
			$html .= 			$category->name;
			$html .= 		'</a>';
			if ($this->showCount) $html .= " ($category->postCount)";
			$html .= '</li>';
		}
		
		$html .= '</ul>';
		$html .= '</aside>';

		echo $html;
	}

	public function getCategories() 
	{
		$this->_queries = TermModel::model()->category()->findAll(array(
			'order'=>'slug',
			'limit'=>$this->categoryCount
		));
	}
}