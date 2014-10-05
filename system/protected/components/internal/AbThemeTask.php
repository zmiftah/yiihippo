<?php 

/**
 * Inspiration: http://codex.wordpress.org/Plugin_API 
 * in Activation/Deactivation/Uninstall Functions
 */
class AbThemeTask extends AbBaseTask 
{
	public function __construct($path, $url, $name) 
	{
		parent::__construct( $path, $url, $name );
	}

	public function getScreenshot()
	{
		# code...
	}	
}