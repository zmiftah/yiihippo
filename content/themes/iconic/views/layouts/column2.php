<?php $this->beginContent('//layouts/main'); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php echo $content; ?>
		</div><!-- #content -->
	</div><!-- #primary -->

	<div id="secondary" class="widget-area" role="complementary">
		<?php $this->doEvent('doLoadSidebar'); ?>
	</div><!-- #secondary -->
<?php $this->endContent(); ?>