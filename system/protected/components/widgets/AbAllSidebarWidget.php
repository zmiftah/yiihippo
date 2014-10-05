<?php 

class AbAllSidebarWidget extends CWidget
{
	public $widgets = null;
	private $_options = null;

	public function init()
	{
		$this->_options = Yii::app()->options;
		$this->widgetData();
	}

	public function run()
	{
		$location = 'application.components.widgets.';

		$html = '<aside class="wsb widget-mas">';
		$html .= '<div class="div-content">';
		foreach ($this->widgets as $widget) {
			if ($widget['show']) {
				$id         = $widget['id'];
				$widgetName = $location.$this->widgetByID($id);
				$config     = $this->widgetConfigByID($id);
				$html       .= $this->controller->widget($widgetName, $config, true);
			}
		}
		$html .= '</div>';
		$html .= '</aside>';
		echo $html;
	}

	public function widgetData()
	{
		$widgets = Yii::app()->options->get('app_widgets', array());
		$this->widgets = $widgets;
	}

	public function widgetByID($id)
	{
		$widgets = array(
			1  => 'AbPopularPostWidget',
			2  => 'AbRecentPostWidget',
			3  => 'AbRecentCommentWidget',
			5  => 'AbCategoriesWidget',
			7  => 'AbLinksWidget',
			8  => 'AbCalenderWidget',
			12 => 'AbTextWidget',
		);

		return $widgets[$id];
	}

	public function widgetConfigByID($id)
	{
		switch ($id) {
			case 8: //Calender
				$config = $this->_options->get('widget_8', false);
				if ($config == false) {
					$config = array(
						'year'=>$_GET['year'],
						'month'=>$_GET['month']
					);
				}
				break;
			default:
				$name = "widget_$id";
				$config = $this->_options->get($name, array());
				break;
		}
		return $config;
	}
}