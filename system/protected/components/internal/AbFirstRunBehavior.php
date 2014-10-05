<?php

class AbFirstRunBehavior extends CBehavior
{
  public $firstRun;

  public function init()
  {
    parent::init();
  }

  public function executeFirstRun()
  {
    $this->firstRun = Yii::app()->options->get('first_run', 1);

    if (in_array($this->firstRun, array(1, null))) {
      $this->publishAssets();
      $this->registerOptions();
      $this->registerWidgets();

      Yii::app()->options->add('first_run', 0, 'setting');
    }
  }

	public function publishAssets()
	{
		$path = Yii::getPathOfAlias('application.assets');
    $publish = Yii::app()->assetManager->getPublishedUrl($path); 

		if (in_array($this->firstRun, array(1, null))) {
			$debug = defined('YII_DEBUG') && YII_DEBUG;
			$publish = Yii::app()->assetManager->publish($path, false, -1, $debug);
		}

    return $publish;
	}

	public function registerOptions()
	{
    // Default Options
    $options = Yii::app()->options;
    $options->add('site_title', 'Website Title')
    ->add('meta_desc', 'Description, 170 chars')
    ->add('meta_keyword', 'keyword')
    ->add('favicon', '')
    ->add('site_address', 'http://www.website.com')
    ->add('site_name', 'Nama Situs')
    ->add('email', 'admin@website.com')
    ->add('default_category', 'uncategorized')
    ->add('post_limit', '10')
    ->add('feed_limit', '10')
    ->add('feed_show', 'summary') //summary || full
    ->add('encoding', 'utf-8')
    ->add('permalink', '%postname%')
    ->add('opt_permalink', 1)
    ->add('spam_link_count', 2) //comment
    ->add('spam_blacklist', '') //comment
    ->add('site_theme', 'swift')
    ->add('first_run', 1);
	}

  public function registerWidgets()
  {
    $widgets = array(
      1    => array('id'=>1,  'name'=>'Popular Article',  'show'=>false, 'order'=>1),
      2    => array('id'=>2,  'name'=>'Recent Article',   'show'=>true,  'order'=>2),
      3    => array('id'=>3,  'name'=>'Recent Comment',   'show'=>false, 'order'=>3),
      //4  => array('id'=>4,  'name'=>'Search',           'show'=>false, 'order'=>4),
      5    => array('id'=>5,  'name'=>'Category',         'show'=>false, 'order'=>5),
      //6  => array('id'=>6,  'name'=>'Archive',          'show'=>false, 'order'=>6),
      7    => array('id'=>7,  'name'=>'Links',            'show'=>false, 'order'=>7),
      8    => array('id'=>8,  'name'=>'Calender',         'show'=>false, 'order'=>8),
      //9  => array('id'=>9,  'name'=>'Pages',            'show'=>false, 'order'=>9),
      //10 => array('id'=>10, 'name'=>'Tag Cloud',        'show'=>false, 'order'=>10),
      //11 => array('id'=>11, 'name'=>'RSS',              'show'=>false, 'order'=>11),
      12   => array('id'=>12, 'name'=>'Text/Javascript',  'show'=>false, 'order'=>12),
    );
    Yii::app()->options->add('app_widgets', serialize($widgets));
  }
}