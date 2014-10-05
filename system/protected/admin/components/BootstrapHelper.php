<?php 

class BootstrapHelper
{
	public static function createAccordion($parent, $label, $heading, $content, $enable=false, $expand=false)
	{
		$in = $expand ? 'in' : '';
		$accordion  = '<div class="accordion-group">';
		$accordion .= '	<!-- Title -->';
		$accordion .= '	<div class="accordion-heading">';
		$accordion .= '		<a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$parent.'" href="#c_'.$label.'">';
		$accordion .= '			<strong>'.$heading.($enable?' <span class="label label-success">Visible</span>':'').'</strong>';
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