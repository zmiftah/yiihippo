<?php $this->beginContent('//layouts/main'); ?>




<div id="left">
	<div id="content"  role="main">
		<?php echo $content; ?>
	</div>

	<div id="sidebar-container">
		<?php $this->doEvent('doLoadSidebar'); ?>
	</div>
	
	<div class="clear"></div>
</div>

<?php $this->endContent(); ?>