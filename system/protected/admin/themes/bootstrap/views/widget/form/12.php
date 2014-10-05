<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" value="<?php echo $title ?>" />

	<label for="content">Content (HTML/Javascript):</label>
	<textarea name="content" id="content" class="span4" rows="5"><?php echo $content ?></textarea>
	
  <button class="btn btn-info" name="save" id="showWidget">
		Save
	</button>

	<?php $this->endWidget(); ?>
</div>