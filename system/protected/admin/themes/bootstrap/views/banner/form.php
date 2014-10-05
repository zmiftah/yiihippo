<script>
	var oFReader = new FileReader(),
			oFile = null

	oFReader.onload = loadPreview

	function onUploaderChange() {
		var val = $(this).val(),
				fname = val.split(/[\\/]/),
				fileName = ''

		oFile = document.getElementById('LinkModel_url').files[0]
		fileName = fname[fname.length-1]
		$('#filename').val(fileName)
		oFReader.readAsDataURL(oFile)
	}

	function loadPreview(e) {
		var src

		$('#imgPreview').attr('src', e.target.result)
		// src = $('#imgPreview')[0]

		// $('#imgWidth').val(src.width)
		// $('#imgHeight').val(src.height)
	}

	$(document).ready(function(){
		$('#LinkModel_url').change(onUploaderChange)
	})
</script>

<style>
	.right{ text-align:center; }
</style>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'          => 'banner-form',
		'type'        => 'horizontal',
		'htmlOptions' => array('enctype'=>'multipart/form-data',),
	)); ?>

	<fieldset>
	    <legend><i class="icon-fixed-width icon-flag-alt"></i> <?=$title?> Banner</legend>
	</fieldset>

	<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'     => true,
		'fade'      => true,
		'closeText' => 'x',
		'alerts'    => array(
			'success'   => array('block'=>true, 'fade'=>true, 'closeText'=>'x'),
			'error'     => array('block'=>true, 'fade'=>true, 'closeText'=>'x'),
		),
  )); ?>

	<?php $default = '/content/assets/img/460x120.gif';
	$source  = $title=='Edit'? $model->url: $default; ?>
	<div class="control-group">
		<label class="control-label">Preview</label>
		<div class="controls">
			<div class="span6" style="margin-left:0">
				<img src="<?php echo Yii::app()->baseUrl.$source ?>" id="imgPreview" class="img-polaroid">
			</div>
		</div>
	</div>

	<input type="hidden" id="imgWidth" name="imgWidth">
	<input type="hidden" id="imgHeight" name="imgHeight">

	<div class="control-group">
		<label for="LinkModel_url" class="control-label">File Banner</label>
		<div class="controls">
			<?php echo CHtml::activeFileField($model, 'url', array(
				// 'required'=>'required',
				'accept'=>'image/*'
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="filename" class="control-label">Nama File</label>
		<div class="controls">
			<?php echo CHtml::textField('filename', $model->name, array(
				'required'=>'required',
				'class'=>'span4',
			)); ?>
			<span class="help-block">Nama file yang dikehendaki</span>
		</div>
	</div>

	<div class="control-group">
		<label for="position" class="control-label">Posisi</label>
		<div class="controls">
			<?php echo CHtml::dropDownList('position', $position, $positionList, array(
				'required'=>'required'
			)); ?>
		</div>
	</div>

	<!-- <div class="control-group">
		<label for="width" class="control-label">Dimension</label>
		<div class="controls">
			W<?php //echo CHtml::textField('width', '200', array('class'=>'span1 right')); ?> X
			H<?php //echo CHtml::textField('height', '200', array('class'=>'span1 right')); ?>
		</div>
	</div> -->

	<div class="control-group">
		<label for="LinkModel_image_url" class="control-label">Link Banner</label>
		<div class="controls">
			<?php echo CHtml::activeTextField($model, 'image_url', array(
				'required'=>'required'
			)); ?>
			<span class="help-block">ex. http://www.asianbrain.com</span>
		</div>
	</div>

	<div class="control-group">
		<label for="text" class="control-label">Teks Banner</label>
		<div class="controls">
			<?php echo CHtml::textField('text', $text, array(
				'required'=>'required'
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>'save',
        'label'=>$title,
	    )); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div>