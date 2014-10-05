<?php

error_reporting( ~E_NOTICE );
date_default_timezone_set( 'Asia/Jakarta' );

// change the following paths if necessary
$yii    = dirname( __FILE__ ).'/system/vendor/yii.php';
$app 		= dirname( __FILE__ ).'/system/protected/components/internal/AbWebApplication.php';
$main   = dirname( __FILE__ ).'/system/protected/config/front.php';
$client = dirname( __FILE__ ).'/config.php';

include $client;
include $yii;
include $app;

// var_dump($_SERVER);exit;

Yii::createApplication( 'AbWebApplication', $main )->run();
