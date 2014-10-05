<!DOCTYPE html>
<!--[if IE 7]> 	<html class="ie ie7" dir="ltr" lang="en-US" prefix="og: http://ogp.me/ns#"><![endif]-->
<!--[if IE 8]> 	<html class="ie ie8" dir="ltr" lang="en-US" prefix="og: http://ogp.me/ns#"><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html dir="ltr" lang="en-US" prefix="og: http://ogp.me/ns#">
<!--<![endif]-->
	<head>
		<?php $this->doEvent('doSetupHead'); ?>
	</head>
	<body class="home blog paged custom-background custom-font-enabled single-author">
		<div id="page" class="hfeed site">
			<header id="masthead" class="site-header" role="banner">
				<?php $this->doEvent('doLoadHeader'); ?>
			</header><!-- #masthead -->

			<div id="main" class="wrapper">
				<?php echo $content; ?>
			</div><!-- #main .wrapper -->

			<footer id="colophon" role="contentinfo">
				<?php $this->doEvent('doLoadFooter') ?>
			</footer><!-- #colophon -->

			<div class="site-wordpress">
				<!-- <a href="http://www.nama-situs.com/">Nama Situs</a> Theme |  -->
				Powered by <a href="http://brainhippo.com">Brainhippo</a>
			</div><!-- .site-info -->

			<div class="clear"></div>
		</div><!-- #page -->
		
		<script type='text/javascript' src='<?php echo Yii::app()->theme->baseUrl ?>/assets/js/selectnav.js?ver=1.0'></script>
		<?php $this->doEvent('doSetupBottom') ?>
	</body>
</html>