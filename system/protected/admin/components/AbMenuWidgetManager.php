<?php

class AbMenuWidgetManager extends CApplicationComponent 
{

	private $items = array();
	private $deleteKey;

	public function addMenus($arrMenus)
	{
		foreach ($arrMenus as $menu) {
			$this->items[$menu[0]] = $this->createMenu($menu[0], $menu[1], $menu[2], $menu[3], $menu[4]);
		}
	}

	/**
	 * Add Menu to Admin Menubar
	 *
	 * @param string  $label
	 * @param string  $icon
	 * @param string  $url
	 * @param string  $notif
	 */
	public function createMenu($label, $icon, $url='#', $notif=null, $items=array()) 
	{
		$notif = $notif ? '<span class="label label-success">' . $notif . '</span>' : '';
		return array(
			'id'    => StringHelper::camelize( $label ),
			'label' => '&nbsp;' . "$label $notif",
			'icon'  => 'icon-fixed-width icon-' . $icon,
			'url'   => $this->createUrl($url),
			'items' => $items,
			'class' => count($items) ? 'class="dropdown"' : '',
		);
	}

	protected function createUrl($value)
	{
		if ( $value == '#' ) {
			$url = '#';
		} elseif ( strpos($value, 'javascript'	) ) {
			$url = $value;
		} else {
			$url = Yii::app()->createUrl($value);
		}
		return $url;
	}

	/**
	 * Update Menu to Admin Menubar
	 * 
	 */
	public function editMenu($label, $icon, $url='#', $notif=null) 
	{
		$this->addMenu( $label, $icon, $url, $notif );
	}

	/**
	 * Remove Menu
	 *
	 * @param string  $label
	 */
	public function removeMenu($label) 
	{
		$this->deleteKey = $label;
		$this->items = array_filter( $this->items, array( $this, 'filter' ) );

		return $this;
	}

	/**
	 * Not Yet Implemented
	 *
	 * @param string  $label
	 * @param string  $icon
	 * @param array   $submenus
	 */
	public function addSubmenu($label, $icon, $submenus) 
	{
		// code...
		//
		// return $this;
	}

	/**
	 * Return array
	 *
	 * @return array
	 */
	public function getArrayMenu() 
	{
		return $this->items;
	}

	private function filter($key, $value) 
	{
		return $key != $this->deleteKey;
	}
}
