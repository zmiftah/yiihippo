<?php 

class AbUserAPIBehavior extends CBehavior 
{
	private $_host;
	private $_proxy;
	private $_param;

	public function credentialLogin($username, $password) 
	{
		$this->getABCredential();

		$url  = $this->_host . '/' . $this->_proxy;
		$data = 'username=' . $username;
		$data .= '&password=' . $password;
		$data .= '&' . $this->_param;

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$json = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $json );
	}

	private function getABCredential() 
	{
		$abproxy     = Yii::app()->params['abproxy'];
		$this->_host  = $abproxy['host'];
		$this->_proxy = $abproxy['proxy'];
		$this->_param = $abproxy['add_param'];
	}
}