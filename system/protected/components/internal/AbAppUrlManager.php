<?php 

class AbAppUrlManager extends CUrlManager
{
	public function init()
	{
		$this->urlSuffix        = '.htm';
		$this->useStrictParsing = true;
		$this->showScriptName   = false;
		$this->appendParams     = false;
		$this->urlFormat        = 'path';
		$this->cacheID          = false;

		$this->secureLockHosting();
		parent::init();
	}

	public function secureLockHosting()
	{
		$request   = Yii::app()->request;
		$whitelist = in_array( gethostbyname($_SERVER['HTTP_HOST']), $this->getWhiteListIP() );

		if ( $whitelist ) {
			$this->rules = $this->standardRules();
		} else {
			$this->rules = $this->blacklistRules();
		}
	}

	public function standardRules()
	{
		$standard = array(
			'/' => array('post/index',   'urlSuffix'=>'', 'defaultParams'=>array('page'=>1)), //with pagination
			// '/home' => array('post/index',   'defaultParams'=>array('page'=>1)), //possible duplicate content

			// Specific Rule
			'/search/'                       => array('post/search', 'urlSuffix'=>''),
			'/category/<taxo:[a-zA-Z0-9-]+>' => array('post/taxonomy'),
			'/tag/<taxo:[a-zA-Z0-9-]+>'      => array('post/taxonomy'),

			// Archives
			'/archive/<year:[0-9]{4}>' => array('post/archives', 'urlSuffix'=>''),
			'/archive/<year:[0-9]{4}>/<month:[0-9]{2}>' => array('post/archives', 'urlSuffix'=>''),
			'/archive/<year:[0-9]{4}>/<month:[0-9]{2}>/<day:[0-9]{2}>' => array('post/archives', 'urlSuffix'=>''),

			// Sitemap
			'/sitemap' => array('text/sitemap', 'urlSuffix'=>'.txt'),

			// Error 404
			// '/404' => array('blog/error', 'urlSuffix'=>''),
		);	

		// Reserved for Additional rules
		// End
		
		$newRules = $this->parsePermalink(); // For Article & Page
		return array_merge($standard, $newRules);
	}

	public function parsePermalink()
	{
		$option    = Yii::app()->options->get('opt_permalink');
		$permalink = Yii::app()->options->get('permalink');

		$format = array('%year%','%monthnum%','%postname%');
		$rules  = array('[0-9]{4}','[0-9]{2}','<post:[a-zA-Z0-9-]+>');

		$newPermalink = str_replace($format, $rules, $permalink);

		if ($option==1) {
			return array( "/$newPermalink" => array('post/post') );
		} else {
			return array(
				"/$newPermalink"        => array('post/article'),
				'/<post:[a-zA-Z0-9-]+>' => array('post/page'), //article and post
			);
		}
	}

	public function blacklistRules()
	{
		return array(
			'/'                   => array( 'blog/blacklist', 'urlSuffix'=>'' ),
			'/<ct:[a-zA-Z0-9-]+>' => array( 'blog/blacklist', 'urlSuffix'=>'' ),
			'/<gx:[a-zA-Z0-9-]+>' => array( 'blog/blacklist' ),
		);
	}

	public function getWhiteListIP()
	{
		$list = include dirname( __FILE__ ) . '/../../config/whitelist.php';
		return $list;
	}
}