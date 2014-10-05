<?php

$uploadpath = BASEPATH.'/content/upload/';
Yii::setPathOfAlias( 'uploadpath', $uploadpath );

// This is the main Web application configuration.
return array(
	'basePath'          => dirname( dirname(__FILE__) ),
	'name'              => 'Brain Hippo CMS',
	'sourceLanguage'    => 'id',

	// preloading 'log' component
	'preload' => array('log'),

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.internal.*',
	),

	// application components
	'components' => array(

    'phpThumb' => array(
      'class' => 'ext.EPhpThumb.EPhpThumb'
    ),

		/* Plugin & Themes Config */
    'plugins' => array(
      'class' => 'AbPluginManager'
    ),
    'themes' => array(
      'class' => 'AbThemeManager'
    ),
    'options' => array(
      'class' => 'AbOptionAPI'
    ),
    'actions' => array(
      'class' => 'AbActionAPI'
    ),
    'taxonomy' => array(
      'class' => 'AbTaxonomyAPI'
    ),
    /* End Config */

    /* CLient Script */
    // 'clientScript'=>array(
    //   'coreScriptPosition'=>CClientScript::POS_END
    // ),
    
    'session' => array(
      'timeout' => 3600*3,
    ),

    // Db components
    'db' => array(
      'connectionString' => 'mysql:host='.DB_HOST.';dbname='.DB_NAME,
      'emulatePrepare'   => true,
      'username'         => DB_USER,
      'password'         => DB_PASSWORD,
      'charset'          => 'utf8',
      'class'            => 'CDbConnection'
    ),

    // Log components
    'log' => array(
      'class' => 'CLogRouter',
      'routes' => array(
        array(
          'class'      => 'CFileLogRoute',
          'levels'     => 'error, warning',
          'categories' => 'system.*',
        ),
      ),
    ),

    'cache'=>array(
      'class'=>'system.caching.CDummyCache',
    )
	),

  // Compress Gzip
  //'onBeginRequest' => create_function('$event', 'return ob_start("ob_gzhandler");'),
  //'onEndRequest' => create_function('$event', 'return ob_end_flush();'),
);