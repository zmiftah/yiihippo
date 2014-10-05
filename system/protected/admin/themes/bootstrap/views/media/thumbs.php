<style>
	.dim { 
		width: 30px;
		text-align: center;
	}
	.detail {
		margin-bottom: 20px;
	}
	.detail .file {
		margin-left: 25px;
	}
</style>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'media-form'
	)); ?>

	<fieldset>
	  <legend><i class="icon-fixed-width icon-camera"></i> Create Thumbnail</legend>
	</fieldset>

	<div class="row detail">
		<div class="span4">
			<img src="<?php echo Yii::app()->baseUrl . $row->url ?>" width="450" class="img-polaroid">
		</div>
		<div class="span4 file">
			<strong>File name</strong>: <span id="fileName"><?php echo $row->name ?></span> <br>
			<strong>File type</strong>: <span id="fileType"><?php echo $row->content_type ?></span> <br>
			<strong>File size</strong>: <span id="fileSize"><?php echo SizeHelper::calculate($row->size) ?></span> <br>
			<!-- <strong>Dimensions</strong>: <span id="fileDimension">-</span> -->
		</div>
	</div>

	<div class="control-group dimension">
		<label for="dw">Dimensions</label>
		<div class="controls">
			<input id="dw" type="text" name="dwidth" class="dim" value="80"> x 
			<input id="dh" type="text" name="dheight" class="dim" value="80"> pixels
		</div>
	</div>

	<div class="control-group">
		<a href="<?php echo $this->createUrl('media/index') ?>" class="btn">
			<i class="icon-arrow-left"></i> Back
		</a>
			
		<button name="submit" class="btn btn-primary" type="submit">
			<i class="icon-upload"></i> Create
		</button>
	</div>

	<?php $this->endWidget(); ?>
</div>