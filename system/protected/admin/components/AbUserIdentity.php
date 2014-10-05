<?php 

class AbUserIdentity extends CUserIdentity 
{
	public $id;
	public $username;
	public $password;

	public function __construct($username, $password) 
	{
		parent::__construct( $username, $password );
		$this->attachBehavior('ab', new AbUserAPIBehavior());

		$this->username = $username;
		$this->password = $password;
	}

	// public function getId()
 //  {
 //    return $this->id;
 //  }

	public function authenticate() 
	{
		$this->setState('hasLogin', false);
		$proxy = $this->credentialLogin($this->username, $this->password);

		if ( $proxy->info == 'login success' ) {
			$this->storeInfo($proxy->urow);

			// Verify User
			$exist = Yii::app()->user->verifyAdminExist($this->username, $this->password);
			if ( !$exist ) {
				Yii::app()->user->createAdmin($proxy->urow);
			}

			// Valid User
			$validMember = Yii::app()->user->validAdmin($this->username, $this->password);
			if ($validMember) {
				$this->id = $proxy->urow->uid;
				$this->errorCode = self::ERROR_NONE;
			} else {
				$this->errorCode = self::ERROR_USERNAME_INVALID;
			}
		} elseif ( $proxy->info == 'login failed' ) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else {
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
		}

		return !$this->errorCode;
	}

	private function storeInfo($user) 
	{
		$timeout = Yii::app()->params['sessionTimeout'];
		
		$this->setState('hasLogin', 	true);
		$this->setState('username', 	$user->uid);
		$this->setState('nickname', 	$user->unick);
		$this->setState('email', 			$user->umail);
		$this->setState('status', 		$user->ustat);
		$this->setState('lastLogin', 	date( 'Y-m-d H:i:s' ));
		$this->setState('sessionTimeout', time() + $timeout);
	}
}