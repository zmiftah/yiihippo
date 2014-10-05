<?php 

class AbNavWidget extends CWidget 
{
	public $id = 'accord';
	public $items;

	public function init() 
	{
		//if ( count($this->items)<=0 ) {
			$navwidget = Yii::app()->navwidget;
    	$this->items = $navwidget->getArrayNavs();
		//}
	}

	public function run() 
	{
		$widget = '';
		if ( count($this->items)>0 ) {
			$index  = 1;
			$widget = '<div class="accordion" id="'.$this->id.'">';
			foreach ($this->items as $label => $array) {
				$widget .= $this->createAccordion( $label, ($index==1) );
				$index++;
			}
			$widget .= '</div>';
		}
		echo $widget;
	}

	private function createAccordion($label, $expand)
	{
		$heading = $this->items[$label]['heading'];
		$content = $this->items[$label]['content'];

		$in = $expand ? 'in' : '';
		$accordion = '<div class="accordion-group">';
		$accordion .= '	<!-- Title -->';
		$accordion .= '	<div class="accordion-heading">';
		$accordion .= '		<a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$this->id.'" href="#c_'.$label.'">';
		$accordion .= '			<strong>'.$heading.'</strong>';
		$accordion .= '		</a>';
		$accordion .= '	</div>';
		$accordion .= '	<!-- Content -->';
		$accordion .= '	<div id="c_'.$label.'" class="accordion-body collapse '.$in.'">';
		$accordion .= '	  <div class="accordion-inner">';
		$accordion .= 			$content;
		$accordion .= '	  </div>';
		$accordion .= '	</div>';
		$accordion .= '</div>';

		return $accordion;
	}
}