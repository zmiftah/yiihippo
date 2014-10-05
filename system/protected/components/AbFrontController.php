<?php
/**
 * AB Front/Blog Controller
 * Base Controller for Blog
 */
class AbFrontController extends CController 
{
	public $layout        = '//layouts/column2';
	public $cacheDuration = 3600;

	public $useSlider   = false;
	public $useSidebar  = false;
	public $siteTitle   = '';
	public $siteAddress = '';
	public $siteName    = '';
	public $metaTitle   = '';
	public $metaDesc    = '';
	public $metaKeyword = '';
	public $favicon;
	public $webmasterId = '';
	public $googleAnalytic = '';


	public $commentWidgetLocation = '';
	public $bannerWidgetLocation = '';

	protected $events = array();

	public function init()
	{
		$this->attachBehavior('events', new AbMainEventBehavior);
		$this->attachBehavior('firstRun', new AbFirstRunBehavior);

		$this->executeFirstRun();
		$this->setTheme();
		$this->setGlobalVar();

		if ( strtolower($this->id) == 'abfront' ) {
			$this->registerEvent('onSetupHead', array($this, 'doSetupHead'));
			$this->registerEvent('onLoadHeader', array($this, 'doLoadHeader'));
			$this->registerEvent('onBeforeContent', array($this, 'doBeforeContent'));
			$this->registerEvent('onLoadSidebar', array($this, 'doLoadSidebar'));
			$this->registerEvent('onLoadFooter', array($this, 'doLoadFooter'));
			$this->registerEvent('onSetupBottom', array($this, 'doSetupBottom'));
		}
	}

	public function setTheme()
	{
		//application theme {'theme' => 'iconic'}, // iconic, swift
		$theme = Yii::app()->options->get('site_theme', 'iconic');
		Yii::app()->theme = $theme;

		$this->commentWidgetLocation = "webroot.content.themes.{$theme}.widget.AbListCommentWidget";
		$this->bannerWidgetLocation = "webroot.content.themes.{$theme}.widget.AbBannerWidget";
	}

	public function setGlobalVar()
	{
		$options = Yii::app()->options;

		$this->siteTitle      = $options->get('site_title');
		$this->siteAddress    = $options->get('site_address');
		$this->siteName       = $options->get('site_name');
		$this->metaTitle      = $this->siteTitle; //Default
		$this->metaDesc       = $options->get('meta_desc'); //Default
		$this->metaKeyword    = $options->get('meta_keyword'); //Default
		$this->favicon        = $options->get('favicon');
		$this->webmasterId    = $options->get('webmaster');
		$this->googleAnalytic = $options->get('analytic');
	}

	public function registerEvent($eventName, $event)
	{
		if ( in_array( $eventName, $this->validEvents ) ) {
			$this->events[$eventName] = $event;
			$this->$eventName = $event;
		} else {
			throw new CException("Invalid Event for Controller");
		}
	}

	public function doEvent($eventName)
	{
		$event = new CEvent( $this );
		$this->$eventName( $event );
	}

	public function behaviors()
	{
		return array(
			'events'=>array(
			  'class'=>'application.components.AbMainEventBehavior',
			)
		);
	}

	protected function getValidEvents()
	{
		return array(
			'onSetupTheme',
			'onSetupPlugin',
			'onSetupHead',
			'onLoadHeader',
			'onBeforeContent',
			'onLoadContent',
			'onAfterContent',
			'onLoadSidebar',
			'onLoadFooter',
			'onSetupBottom'
		);
	}

	protected function getValidFilters()
	{
		return array(
			'onTitle',
			'onContent',
			'onListPost',
		);
	}
}