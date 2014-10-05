<?php 

class StringHelper
{
	public static function camelize($string)
	{
		$string = strtolower($string);
		return str_replace(' ', '-', $string);
	}

	public static function urlize($string)
	{
		$file = pathinfo($string);
		return self::camelize($file['filename']).'.htm';
	}

	public static function uncamelize($string, $upper=false)
	{
		$string = str_replace('-', ' ', $string);
		return $upper ? $string : ucwords($string);
	}

	public static function deurlize($string)
	{
		$string = str_replace('.htm', '', $string);
		return substrself::uncamelize($string);
	}

	public static function parseTag($tag)
  {
  	if(empty($tag) || $tag=='[]') return '';
    $tags = str_replace(array('[',']','"'), '', $tag);
    $tags = explode(',', $tags);
    return $tags;
  }

  public static function escape($value)
  {
  	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
  	$value = mysql_real_escape_string( $value );
  	mysql_close($link);
  	return $value;
  }
}