<?php 

/**
 * Inspiration: http://codex.wordpress.org/Plugin_API 
 * in Activation/Deactivation/Uninstall Functions
 */
class AbPluginTask extends AbBaseTask 
{

	public function __construct($path, $url, $name) 
	{
		parent::__construct( $path, $url, $name );
	}
}