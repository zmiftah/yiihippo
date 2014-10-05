<?php

class FileHelper
{
	public static function getContentType($filename)
	{
		$info = pathinfo($filename);
		switch (strtolower($info['extension'])) {
			case 'gif':
				$contentType = 'image/gif';
				break;
			case 'png':
				$contentType = 'image/png';
				break;
			case 'bmp':
				$contentType = 'image/bmp';
				break;
			default:
				$contentType = 'image/jpeg';
				break;
		}
		return $contentType;
	}
}