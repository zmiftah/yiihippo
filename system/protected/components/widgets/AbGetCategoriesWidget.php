<?php 

class AbGetCategoriesWidget extends CWidget
{
	public $categories = null;
	private $terms = null;

	public function run()
	{
		if( !($this->categories instanceof PostTermModel) )
			return;

		$Ids = $this->categories->terms;

		if (empty($Ids))
			return;

		$this->terms = TermModel::model()->findAll(array(
			'condition'=>"term_id IN ($Ids)",
		));

		echo $this->generateList();
	}

	public function generateList()
	{
		$html = '';
		foreach ($this->terms as $term) {
			$html .= ', <a href="'.Yii::app()->baseUrl.'/category/'.$term->slug.'.htm"';
			$html .= ' title="View all posts in '.$term->name.'" rel="category tag">'.$term->name.'</a>';
		}
		return substr($html, 1);
	}
}