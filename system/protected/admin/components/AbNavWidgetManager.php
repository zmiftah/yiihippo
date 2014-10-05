<?php

class AbNavWidgetManager extends CApplicationComponent 
{
	private $items = array();
	private $heading;

	public function beginNav($label, $heading) 
	{
		ob_start();
		$this->heading = $heading;
	}

	public function endNav($label) 
	{
		$content = ob_get_contents();

		$this->items[$label] = array(
			'heading' => $this->heading, 
			'content' => $content
		);

		ob_end_clean();
	}

	public function getArrayNavs() 
	{
		return $this->items;
	}
}
