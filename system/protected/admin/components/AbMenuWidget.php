<?php 

class AbMenuWidget extends CWidget 
{
	private $id = 'mnu';
	private $items;

	public function init() 
	{
		$menuwidget = Yii::app()->menuwidget;
    $this->items = $menuwidget->getArrayMenu();
	}

	public function run() 
	{
		$widget = '';
		if ( count($this->items)>0 ) {
			$index  = 1;
			$widget = '<ul id="'.$this->id.'" class="nav nav-tabs nav-stacked">';
			foreach ($this->items as $label => $item) {
				$widget .= $this->createMenu( $item );
				$index++;
			}
			$widget .= '</ul>';
		}
		echo $widget;

   	//$cssUrl = Yii::app()->baseUrl.'/content/assets/admin/bootstrap';
		//Yii::app()->clientScript->registerCssFile($cssUrl.'/css/submenu.css');
	}

	protected function createMenu( $item )
	{
	  $menu .= '<li id="'.$item['id'].'" '.$item['class'].'>';
	  if ( count($item['items']) ) {
	  	$menu .= '<a class="dropdown-toggle" data-toggle="dropdown" href="'.$item['url'].'">';
	  	$menu .= '	<i class="'.$item['icon'].'"></i> '.$item['label'].'';
	  	$menu .= '  <span class="pull-right"><i class="icon-caret-right"></i></a>';
	  	$menu .= '</a>';

			$menu .= '<ul class="dropdown-menu">';
			foreach ($item['items'] as $subItem) {
				$notif = $subItem[3] ? '<span class="label label-success">' . $subItem[3] . '</span>' : '';
				$menu .= '	<li><a href="'.Yii::app()->createUrl($subItem[2]).'"><i class="icon-fixed-width icon-'.$subItem[1].'"></i> '.$subItem[0].' '.$notif.'</a></li>';
			}
			$menu .= '</ul>';
	  } else {
	  	$menu .= '<a href="'.$item['url'].'"><i class="'.$item['icon'].'"></i> '.$item['label'].' </a>';
	  }
		$menu .= '</li>';

		return $menu;
	}
}