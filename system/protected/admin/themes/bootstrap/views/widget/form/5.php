<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" value="<?php echo $title ?>" />

	<?php $checked = $showCount? 'checked': '' ?>
	<label class="checkbox">
    <input type="checkbox" name="showCount" <?php echo $checked ?>> Show Post Count
  </label>

  <button class="btn btn-info" name="save" id="showWidget">
		Save
	</button>

	<?php $this->endWidget(); ?>
</div>