<div class="form">
	<fieldset>
	    <legend><i class="icon-fixed-width icon-bar-chart"></i> Configure Widget: <?php echo $widget['name'] ?></legend>
	</fieldset>

	<div class="row">
	  <div class="span5">
	  	<div class="accordion" id="widget">
				<?php echo BootstrapHelper::createAccordion('widget', $label, $widget['name'], $content, $widget['show'], true) ?>
			</div>
	  </div>
	</div>

	<div class="button">
	  <a href="<?php echo $this->createUrl('widget/index') ?>" class="btn" id="showWidget">
	    <i class="icon-arrow-left"></i> Back
	  </a>
	</div>
</div>