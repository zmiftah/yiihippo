<?php

// change the following paths if necessary
$yiit   = dirname(__FILE__) . '/../../vendor/yiit.php';
$config = dirname(__FILE__) . '/../config/test.php';

require $yiit;
require dirname(__FILE__).'/WebTestCase.php';

Yii::createWebApplication( $config );