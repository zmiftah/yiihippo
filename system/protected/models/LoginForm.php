<?php

class LoginForm extends CFormModel 
{
	public $username;
	public $password;
	public $verifyCode;

	private $_identity;

	public function attributeLabels() {
		return array(
			'verifyCode'=>'Verifikasi'
		);
	}

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() 
	{
		return array(
			array( 'username, password, verifyCode', 'required', 'on' => 'formLogin' ),
			array( 'password', 'authenticate', 'on' => 'formLogin' ),
			array( 'verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()/*, 'on' => 'formLogin'*/),
		);
	}

	public function authenticate($attribute, $params) 
	{
		if ( !$this->hasErrors() ) {
			$this->_identity = new AbUserIdentity( $this->username, $this->password );
			if ( !$this->_identity->authenticate() ) {
				$this->addError( 'username', 'Username atau Password salah.' );
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 *
	 * @return boolean whether login is successful
	 */
	public function login() 
	{
		if ( $this->_identity->errorCode === ABUserIdentity::ERROR_NONE ) {
			$duration = Yii::app()->params['sessionTimeout']; // 3 hours
			Yii::app()->user->login( $this->_identity, $duration );

			return true;
		} else {
			return false;
		}
	}
}
