<?php

$base_url = WEBSITE; //($_SERVER['SERVER_NAME'] == 'localhost') ? dirname($_SERVER['SCRIPT_NAME']) : '';

return CMap::mergeArray(
  require( dirname( __FILE__ ).'/main.php' ),
  array(
    'defaultController' => 'post',
    
    // application modules
    'modules' => array(
      'gii' => array(
        'class'     => 'system.gii.GiiModule',
        'password'  => 'miftah',
        'ipFilters' => array( '127.0.0.1', '::1' ),
      ),
    ),

    // autoloading model and component classes
    'import' => array(
      'application.components.*',
      'application.components.widgets.*',
    ),

    // application components
    'components' => array(
      'themeManager' => array(
        'basePath' => BASEPATH.'/content/themes',
        'baseUrl'  => WEBSITE.'/content/themes',
      ),
      'assetManager' => array(
        'basePath' => BASEPATH.'/content/assets',
        'baseUrl'  => WEBSITE.'/content/assets',
      ),
      'urlManager' => array(
        'class'    => 'application.components.internal.AbAppUrlManager',
      ),
      'cache'=>array(
        'class'=>'system.caching.CDummyCache',
      ),
      // Error Handler
      'errorHandler' => array(
        'errorAction' => 'blog/error',
      ),
    ),
  )
);
