<?php 

class SizeHelper
{
	public static function calculate($size)
	{
		$output    = $size;
		$bytes     = array("KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB");
		$nApprox   = $size / 1024;

	  for ($n = 0; $nApprox > 1; $n++) {
	    $output = round($nApprox, 3) . " " . $bytes[$n];
	    $nApprox /= 1024;
	  }

		return $output;
	}
}