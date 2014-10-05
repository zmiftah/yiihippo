<?php

class AbFrontWidgetManager extends CComponent
{
	private $orders = null;

	public function init()
	{
		$orders = Yii::app()->options->get('app_widgets');
		if ( $orders === false ) {
			$orders = $this->defaultWidgets();
			Yii::app()->options->add('app_widgets', serialize($orders));
		}
	}

	public function getWidgets()
	{
		$widgets = Yii::app()->options->get('app_widgets');
		if ( $widgets === false ) {
			$widgets = $this->defaultWidgets();
		}
		return $widgets;
	}

	public function getItemCount()
	{
		return 12;
	}

	public function defaultWidgets()
	{
		return array(
			1    => array('id'=>1, 	'name'=>'Popular Article', 	'show'=>false, 'order'=>1),
			2    => array('id'=>2, 	'name'=>'Recent Article', 	'show'=>true,  'order'=>2),
			3    => array('id'=>3, 	'name'=>'Recent Comment', 	'show'=>false, 'order'=>3),
			//4  => array('id'=>4, 	'name'=>'Search', 					'show'=>false, 'order'=>4),
			5    => array('id'=>5, 	'name'=>'Category', 				'show'=>false, 'order'=>5),
			//6  => array('id'=>6, 	'name'=>'Archive', 					'show'=>false, 'order'=>6),
			7    => array('id'=>7,  'name'=>'Links', 						'show'=>false, 'order'=>7),
			8    => array('id'=>8, 	'name'=>'Calender', 				'show'=>false, 'order'=>8),
			//9  => array('id'=>9, 	'name'=>'Pages', 						'show'=>false, 'order'=>9),
			//10 => array('id'=>10, 'name'=>'Tag Cloud', 				'show'=>false, 'order'=>10),
			//11 => array('id'=>11, 'name'=>'RSS', 							'show'=>false, 'order'=>11),
			12   => array('id'=>12, 'name'=>'Text/Javascript', 	'show'=>false, 'order'=>12),
		);
	}
}