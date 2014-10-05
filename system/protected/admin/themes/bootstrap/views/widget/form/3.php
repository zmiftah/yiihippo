<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" value="<?php echo $title ?>" />

	<label for="commentCount">Number of Comment to Show:</label>
	<input type="text" class="span1" name="commentCount" id="commentCount" value="<?php echo $commentCount ?>" />

	<div></div>

  <button class="btn btn-info" name="save" id="showWidget">
		Save
	</button>

	<?php $this->endWidget(); ?>
</div>