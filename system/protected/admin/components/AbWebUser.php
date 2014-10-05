<?php 

class AbWebUser extends CWebUser
{
	private $_id;
	private $_username;
	private $_password;
	private $_salt = '$1$abSalt13$'; //12 chars

	// public function setId($value)
	// {
	// 	$this->_id = $value;
	// }

	// public function getId()
	// {
	// 	$this->selectUser();
	// 	return $this->_id;
	// }

	public function getAdminId()
	{
		$this->selectUser();
		return $this->_id;
	}

	public function validAdmin($username, $password)
	{
		$hash = crypt($password, $this->_salt);
		$user = UserModel::model()->find(array(
			'condition'=>'username=:user AND password=:pass',
			'params'=>array(':user'=>$username, ':pass'=>$hash)
		));
		$validUser = $user instanceof UserModel;
		return $validUser;
	}

	public function verifyAdminExist($username, $password)
	{
		$userCount = UserModel::model()->count();
		if ( !$userCount ) {
			$this->_username = $username;
			$this->_password = $password;
			return false;
		} else {
			return true;
		}
	}

	public function createAdmin($user)
	{
		$admin = new UserModel;
		$admin->username    = $this->_username;
		$admin->password    = crypt($this->_password, $this->_salt); //save hash data
		$admin->nickname    = $user->unick;
		$admin->email       = $user->umail;
		$admin->ab_status   = $user->ustat;
		$admin->first_login = date('Y-m-d');
		$admin->save();
	}

	protected function selectUser()
	{
		if ( empty($this->_id) ) {
			$username = Yii::app()->session['username'];
			$user = UserModel::model()->find(array(
				'select'=>'user_id',
				'condition'=>'username=:user',
				'params'=>array(':user'=>$username)
			));
			$this->_id = $user['user_id'];
		}
	}

	// public function afterLogin($fromCookie)
	// {
	// 	var_dump($fromCookie); exit;
	// }
}