<?php

class CaptchaHelper extends CComponent
{
	// public $sess_captcha = 'captcha';
	protected $chars = 'ABCDEFGHKLMNPQRSTUVWYZ13456789';
	protected $randomStr = '';

	protected $image = null;
	protected $string = '';

	public $location = '';

	public function output( $width=100, $height=30, $length=3 )
	{
		$location  = $this->location;
		$resultStr = $this->randomStr;
		$chars     = $this->chars;

		// Generating the captcha string
		for ( $i = 0; $i < $length; $i++ ) 
		{
			$pos = mt_rand( 0, strlen( $chars )-1 );
			$resultStr .= substr( $chars, $pos, 1 );
		}

		$newImage = imagecreatefromjpeg( "$location/img.jpg" );
		$textColor = imagecolorallocate( $newImage, 0, 0, 0 );

		//$line_clr = imagecolorallocate($newImage, 0, 255, 11);
		//Top left to Bottom Left
		//imageline($newImage, 0, $height-22, $width, $height-1, $line_clr);

		// Bottom Left to Bottom Right
		//imageline($newImage, $width-1, 0, $width-100, $height, $line_clr);
		//imageline($newImage, $height-1, 0, $width-100, $width, $line_clr);
		//imageline($newImage, $width-1, 0, $height-1, $width, $line_clr);

		// Print the string
		$result = imagestring( $newImage, 5, 20, 6, $resultStr, $textColor );

		$this->image = $newImage;
		$this->string = $resultStr;

		return $result;
	}

	public function getCaptchaImage()
	{
		return $this->image;
	}

	public function getCaptchaString()
	{
		return $this->string;
	}
}