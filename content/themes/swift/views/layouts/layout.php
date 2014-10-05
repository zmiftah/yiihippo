<!DOCTYPE html>
<!--[if IE 6]>			<html id="ie6" dir="ltr" lang="en-US"><![endif]-->
<!--[if IE 7]>			<html id="ie7" dir="ltr" lang="en-US"><![endif]-->
<!--[if IE 8]>			<html id="ie8" dir="ltr" lang="en-US"><![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html dir="ltr" lang="en-US">
<!--<![endif]-->
	<head>
		<?php $this->doEvent('onSetupHead'); ?>
	</head>
	<body class="home blog" id="top">
		<div id="wrapper" class="clearfix">
			<div id="header-container">
				<?php $this->doEvent('doLoadHeader'); ?>
			</div>

			<div id="main" class="hybrid">
				<div id="left">
					<div id="content"  role="main">
						<div class="div-content">
							<div id="content-width-slider" class="flex-container">
								<?php $this->doEvent('onBeforeContent') ?>
							</div>
						</div>	
						<div class="clear"></div>
									
						<div id="blog-wrapper" class="div-content clearfix">
							<?php echo $content; ?>
							<div class="clear"></div>
						</div><!-- /.div-content -->
									
						<div class="div-content"></div>
					</div><!-- #content -->

					<div class="clear"></div>
				</div><!-- /#left -->				
			</div><!-- /#main -->
			<div class="clear"></div>

			<footer>
				<?php $this->doEvent('onLoadFooter') ?>
			</footer>
		</div><!-- /#wrapper -->

		<?php $this->doEvent('doSetupBottom') ?>
	</body>
</html>