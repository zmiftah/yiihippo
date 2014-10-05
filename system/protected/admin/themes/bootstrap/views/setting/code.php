<div class="form">
	<?php $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'code-form',
		'type'=>'horizontal',
		'action'=>$this->createUrl('setting/code')
	)); ?>

	<fieldset>
	    <legend><i class="icon-fixed-width icon-code"></i> Code/Adsense Setting</legend>
	</fieldset>

	<?php CHtml::hiddenField('tab', 'code') ?>

	<?php for($i=1; $i<=5; $i++): ?>
	<?php $option = 'adsense_'.$i; ?>
	<div class="control-group">
		<label for="<?php echo $option ?>" class="control-label">
			Code/Adsense <?php echo $i ?></label>
		<div class="controls">
			<?php echo CHtml::textArea($option, $setting[$option], array(
				'class'=>'span5',
				'rows'=>5,
				'placeholder'=>'Your Code/Adsense',
			)); ?>
		</div>
	</div>
	<?php endfor ?>

	<div class="control-group">
		<div class="controls">
			<button name="save" class="btn btn-large btn-primary" type="submit">
				<i class="icon-save"></i> Save
			</button>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div>