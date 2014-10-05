<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" value="<?php echo $title ?>" />

	<label for="postCount">Number of Post to Show:</label>
	<input type="text" class="span1" name="postCount" id="postCount" value="<?php echo $postCount ?>" />

	<?php $checked = $showThumb? 'checked': '' ?>
	<label class="checkbox">
    <input type="checkbox" name="showThumb" <?php echo $checked ?>> Show Thumbnail
  </label>

  <?php $checked = $showDate? 'checked': '' ?>
	<label class="checkbox">
    <input type="checkbox" name="showDate" <?php echo $checked ?>> Show Date
  </label>

	<button class="btn btn-info" name="save" id="showWidget">
		Save
	</button>

	<?php $this->endWidget(); ?>
</div>