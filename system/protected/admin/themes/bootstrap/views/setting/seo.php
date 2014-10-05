<div class="form">
	<?php $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'seo-form',
		'type'=>'horizontal',
		'action'=>$this->createUrl('setting/seo'),
		'htmlOptions'=>array(
			'enctype'=>'multipart/form-data'
		)
	)); ?>

	<fieldset>
	    <legend><i class="icon-fixed-width icon-bar-chart"></i> SEO Setting</legend>
	</fieldset>

	<?php CHtml::hiddenField('tab', 'seo') ?>

	<div class="control-group">
		<label for="meta_keyword" class="control-label">Meta Keyword</label>
		<div class="controls">
			<?php echo CHtml::textField('meta_keyword', $setting['meta_keyword'], array(
				'class'=>'span5',
				'placeholder'=>'Meta Keyword',
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="favicon" class="control-label">Favicon</label>
		<div class="controls">
			<?php if (isset($setting['favicon'])): ?>
			<img src="<?php echo $setting['favicon'] ?>" alt="Favicon" width="32" height="32"> <br>
			<?php endif ?>
			<?php echo CHtml::fileField('favicon', $setting['favicon'], array(
				'class'=>'span5', 
			)); ?>
			<span class="help-block">
				<a href="http://www.favicongenerator.com/" target="_blank">Apa itu favicon?</a>
			</span>
		</div>
	</div>

	<div class="control-group">
		<label for="site_feed" class="control-label">Website Feed Url</label>
		<div class="controls">
			<?php echo CHtml::textField('site_feed', $setting['site_feed'], array(
				'class'=>'span5',
				'placeholder'=>'Website Feed Url',
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="analytic" class="control-label">Google Analytic Script</label>
		<div class="controls">
			<?php echo CHtml::textArea($option, $setting['analytic'], array(
				'class'=>'span5',
				'rows'=>5,
				'placeholder'=>'Your Google Analytic Script',
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="webmaster" class="control-label">Google Webmaster Script</label>
		<div class="controls">
			<?php echo CHtml::textField($option, $setting['webmaster'], array(
				'class'=>'span5',
				'placeholder'=>'Your google-site-verification Content',
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