<?php

error_reporting( ~E_NOTICE );
date_default_timezone_set( 'Asia/Jakarta' );

define('YII_BEGIN_TIME', microtime(true));
define('YII_DEBUG', true);

// change the following paths if necessary
$yii     = dirname( __FILE__ ).'/system/vendor/yii.php';
$app     = dirname( __FILE__ ).'/system/protected/components/internal/AbWebApplication.php';
$version = dirname( __FILE__ ).'/system/vendor/version.php';
$main    = dirname( __FILE__ ).'/system/protected/config/back.php';
$client  = dirname( __FILE__ ).'/config.php'; 

include $client;
include $yii;
include $version;
include $app;

// Yii::beginProfile('app');
Yii::createApplication( 'AbWebApplication', $main )->run();
// Yii::endProfile('app');