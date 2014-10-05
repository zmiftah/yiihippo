<?php

class CryptoHelper
{
	private $_key;
	private $_algorithm;
	private $_salt;

	public function __construct($key, $algorithm=MCRYPT_BLOWFISH)
	{
		$this->_key       = substr($key, 0, mcrypt_get_key_size($algorithm, MCRYPT_MODE_ECB));
		$this->_algorithm = $algorithm;
	}

	public function encrypt($data)
	{
		$iv_size = mcrypt_get_iv_size($this->_algorithm, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypt = mcrypt_encrypt($this->_algorithm, $this->_key, $data, MCRYPT_MODE_ECB, $iv);

		return trim(base64_encode($crypt));
	}

	public function decrypt($data)
	{
		$crypt = base64_decode($data);
		$iv_size = mcrypt_get_iv_size($this->_algorithm, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypt = mcrypt_decrypt($this->_algorithm, $this->_key, $crypt, MCRYPT_MODE_ECB, $iv);

		return trim($decrypt);
	}
}