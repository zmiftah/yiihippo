<!DOCTYPE html>
<!--[if IE 6]>			<html id="ie6" dir="ltr" lang="en-US"><![endif]-->
<!--[if IE 7]>			<html id="ie7" dir="ltr" lang="en-US"><![endif]-->
<!--[if IE 8]>			<html id="ie8" dir="ltr" lang="en-US"><![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html dir="ltr" lang="en-US">
<!--<![endif]-->
	<head>
		<?php $this->doEvent('doSetupHead'); ?>
	</head>
	<body class="home blog" id="top">
		<div id="wrapper" class="clearfix">
			<div id="header-container">
				<?php $this->doEvent('doLoadHeader'); ?>
			</div>

			<div id="main" class="hybrid">
				<?php if ($this->useSlider): ?>
				<div id="full-width-slider" class="flex-container div-content">
					<?php $this->doEvent('doBeforeContent') ?>
				</div>
				<?php endif ?>

				<?php echo $content; ?>

			</div><!-- /#main -->
			<div class="clear"></div>

			<footer>
				<?php $this->doEvent('doLoadFooter') ?>
			</footer>
		</div><!-- /#wrapper -->

		<?php $this->doEvent('doSetupBottom') ?>
	</body>
</html>