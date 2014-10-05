<div class="form">
	<?php $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'socmed-form',
		'type'=>'horizontal',
		'action'=>$this->createUrl('setting/socmed')
	)); ?>

	<fieldset>
	    <legend><i class="icon-fixed-width icon-html5"></i> Social Media Setting</legend>
	</fieldset>

	<?php CHtml::hiddenField('tab', 'socmed') ?>

	<div class="control-group">
		<label for="socmed_facebook" class="control-label">
			Facebook Url <i class="icon-facebook-sign"></i></label>
		<div class="controls">
			<?php echo CHtml::textField('socmed_facebook', $setting['socmed_facebook'], array(
				'class'=>'span5',
				'placeholder'=>'Your Facebook Url',
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="socmed_twitter" class="control-label">
			Twitter Url <i class="icon-twitter-sign"></i></label>
		<div class="controls">
			<?php echo CHtml::textField('socmed_twitter', $setting['socmed_twitter'], array(
				'class'=>'span5',
				'placeholder'=>'Your Twitter Url',
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="socmed_googleplus" class="control-label">
			Google+ Url <i class="icon-google-plus-sign"></i></label>
		<div class="controls">
			<?php echo CHtml::textField('socmed_googleplus', $setting['socmed_googleplus'], array(
				'class'=>'span5',
				'placeholder'=>'Your Google+ Url',
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<button name="save" class="btn btn-large btn-primary" type="submit">
				<i class="icon-save"></i> Save
			</button>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div>