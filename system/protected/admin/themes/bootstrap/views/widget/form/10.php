<script>
	
</script>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" />

	<label for="sortby">Taxonomy:</label>
	<select name="sortby" id="sortby">
		<option value="title">Tag</option>
		<option value="order">Category</option>
	</select>
	
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
