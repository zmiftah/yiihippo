<script>
	
</script>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">RSS Feed Url:</label>
	<input type="text" class="span4" name="title" id="title" />

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" />

	<label for="title">Items to show:</label>
	<input type="text" class="span1" name="title" id="title" />

	<label class="checkbox">
    <input type="checkbox"> Display with content
  </label>

  <label class="checkbox">
    <input type="checkbox"> Display with author
  </label>

  <label class="checkbox">
    <input type="checkbox"> Display with date
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
