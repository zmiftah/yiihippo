<script>
	
</script>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

	<label for="title">Title:</label>
	<input type="text" class="span4" name="title" id="title" />

	<label for="sortby">Sort By:</label>
	<select name="sortby" id="sortby">
		<option value="id">ID</option>
		<option value="title">Title</option>
		<option value="order">Order</option>
	</select>

	<label for="title">Exclude:</label>
	<input type="text" class="span4" name="title" id="title" />
	<span class="help-block"><small>Page ID, separated by comma</small></span>
	
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
