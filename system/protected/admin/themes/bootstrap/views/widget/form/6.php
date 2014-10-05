<script>
	
</script>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" />

	<label class="checkbox">
    <input type="checkbox"> Show Post Count
  </label>

  <div class="btn-group">
	  <a href="javascript:void(0)" class="btn btn-small btn-info" id="showWidget">
	    Show
	  </a>
	  <a href="javascript:void(0)" class="btn btn-small" id="closeWidget">
	    Close
	  </a>
	</div>

	<?php $this->endWidget(); ?>
</div>