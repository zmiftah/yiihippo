<?php 

class AbTextWidget extends CWidget 
{
	public $title = '';
	public $content = '';

	public function run() 
	{
		if( empty($this->content) )
			$this->content = Yii::app()->options->get('widget_12', '');

		$this->textWidget();
	}

	public function textWidget() 
	{
		$html = '<aside id="text-3" class="widget widget_text">';
		$html .= '<p class="widget-title">'.$this->title.'</p>  ';
		$html .= '<div class="textwidget" style="text-align:center">';
		$html .= $this->content;
		$html .= '</div>';
		$html .= '</aside>';

		echo $html;
	}
}