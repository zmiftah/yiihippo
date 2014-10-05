<?php

/* App Config */

// remove the following lines when in production mode
defined( 'YII_DEBUG' ) or define( 'YII_DEBUG', true );

// specify how many levels of call stack should be shown in each log message
defined( 'YII_TRACE_LEVEL' ) or define( 'YII_TRACE_LEVEL', 3 );

// website url
defined( 'BASEPATH' ) or define( 'BASEPATH', dirname(__FILE__) );
defined( 'WEBSITE' ) or define( 'WEBSITE', 'http://www.asianbrainvideo.com' );


/* Database Config */

// MySQL hostname
define('DB_HOST', 'localhost');

// MySQL database name
define('DB_NAME', 'as72nvid_brainhippodb');

// MySQL database username
define('DB_USER', 'as72nvid_admin');

// MySQL database password
define('DB_PASSWORD', '123456ef78');