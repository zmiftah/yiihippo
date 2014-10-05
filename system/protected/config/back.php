<?php

$admin     = BASEPATH.'/system/protected/admin';
$bootstrap = $admin.'/extensions/bootstrap';

Yii::setPathOfAlias( 'admin', $admin );
Yii::setPathOfAlias( 'bootstrap', $bootstrap );

return CMap::mergeArray(
  require( dirname( __FILE__ ) . '/main.php' ), array(
    'defaultController' => 'site/login',

    'controllerPath' => $admin.'/controllers',
    'runtimePath'    => $admin.'/runtime',

    // autoloading model and component classes
    'import' => array(
      'admin.components.*',
      'application.components.internal.PseudoCrypt',
      'application.extensions.SQLParser.SqlParser'
    ),
    
    // bootstrap
    'theme' => 'bootstrap', // copy the theme to themes directory

    // Preloading
    'preload' => array('log'),

    // application components
    'components' => array(
      'migration' => array(
        'class' => 'AbMigrationComponent'
      ),
      'menuwidget' => array(
        'class' => 'AbMenuWidgetManager'
      ),
      'navwidget' => array(
        'class' => 'AbNavWidgetManager'
      ),
      'user' => array(
        'class' => 'AbWebUser',
        'allowAutoLogin' => true,
        'authTimeout' => 3600*3,
        'loginUrl' => array('/site/login'),
      ),
      'bootstrap' => array(
        'class' => 'bootstrap.components.Bootstrap',
      ),
      'themeManager' => array(
        'basePath' => 'system/protected/admin/themes',
        'baseUrl'  => WEBSITE.'/content/assets/admin',
      ),
      'assetManager' => array(
        'basePath' => BASEPATH.'/content/assets',
        'baseUrl'  => WEBSITE.'/content/assets',
        'linkAssets' => false,
      ),
      'urlManager' => array(
        'urlFormat'      => 'path',
        'appendParams'   => true,
        'showScriptName' => false,
        'rules' => array(
          'admin'                                        => array('site/login' ),
          'admin/captcha/*'                              => array('site/captcha', 'urlSuffix'=>'.png'),
          'admin/<controller:\w+>'                       => array('<controller>/', 'urlSuffix' => '.php'),
          // 'admin/<controller:\w+>/<id:\d+>'              => array('<controller>/view', 'urlSuffix' => '.php'),
          'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => array('<controller>/<action>', 'urlSuffix' => '.php' ),
          'admin/<controller:\w+>/<action:\w+>'          => array('<controller>/<action>', 'urlSuffix' => '.php' ),
        ),
      ),
      'log'=>array(
          'class'=>'CLogRouter',
          'routes'=>array(
              array(
                  'class'=>'CFileLogRoute',
                  'levels'=>'warning, error',
                  'categories'=>'system.*',
              ),
              array(
                  'class'=>'CProfileLogRoute',
                  'report'=>'summary',
              ),
          ),
      ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
      // Email
      'email' => 'admin@brainhippo.com',

      // DB prefix
      'tablePrefix' => '',

      // Timeout
      'sessionTimeout' => 3600*3,
      
      // Auth to AsianBrain.com
      'abproxy' => array(
        'host'      => 'http://www.asianbrain.com',
        'proxy'     => '/bhm-auth.php',
        'add_param' => 'bhm_service=1',
        // {username:u, password:p, bhm_service:1}
      ),
    ),
  )
);