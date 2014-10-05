<?php

class AbWebApplication extends CWebApplication
{
  public function __construct($config=null)
  {
    parent::__construct($config);
    register_shutdown_function(array($this, 'shutdown'));
    //set_error_handler(array($this, 'handleErrors'));
  }

  public function shutdown()
  {
    if (YII_ENABLE_ERROR_HANDLER && ($error = error_get_last())) {
      $this->handleError($error['type'], $error['message'], $error['file'], $error['line']);
      die();
    }
  }

  public function handleErrors($errno, $errstr, $errfile, $errline, $errcontext)
  {
    // error was suppressed with the @-operator
    if (in_array(error_reporting(), array(0, ~E_NOTICE))) {
      return false;
    }

    throw new CException($errstr, $errno);
  }
}