<?php 

class AbGetTagsWidget extends CWidget
{
	public $tags = null;
	private $terms = null;

	public function run()
	{
		if( !($this->tags instanceof PostTermModel) )
			return;

		$Ids = $this->tags->terms;

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
			$html .= ', <a href="'.Yii::app()->baseUrl.'/tag/'.$term->slug.'.htm"';
			$html .= ' title="View all posts in '.$term->name.'" rel="tag">'.$term->name.'</a>';
		}
		return substr($html, 1);
	}
}