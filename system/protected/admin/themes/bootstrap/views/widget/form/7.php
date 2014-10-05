<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" value="<?php echo $title ?>" />

	<label for="linkCount">Number of Links to Show:</label>
	<input type="text" class="span1" name="linkCount" id="linkCount" value="<?php echo $linkCount ?>" />

	<div></div>

  <button class="btn btn-info" name="save" id="showWidget">
		Save
	</button>

	<?php $this->endWidget(); ?>
</div>