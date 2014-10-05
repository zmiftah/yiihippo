<?php $this->beginContent('//layouts/main'); ?>
	<div id="index" class="post clearfix">
		<?php echo $content; ?>
	</div>
	<div id="sidebar" class="clearfix">
		<?php $this->doEvent('doLoadSidebar'); ?>
	</div>
<?php $this->endContent(); ?>