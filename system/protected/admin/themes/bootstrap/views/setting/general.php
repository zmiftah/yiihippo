<div class="form">
	<?php $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'setting-form',
		'type'=>'horizontal',
		'action'=>$this->createUrl('setting/general')
	)); ?>

	<fieldset>
	    <legend><i class="icon-fixed-width icon-cog"></i> General Setting</legend>
	</fieldset>

	<?php CHtml::hiddenField('tab', 'general') ?>

	<div class="control-group">
		<label for="site_address" class="control-label">Website Address</label>
		<div class="controls">
			<?php echo CHtml::textField('site_address', $setting['site_address'], array(
				'class'=>'span5', 
				'placeholder'=>'http://example.com/',
				'required'=>'required' 
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="site_name" class="control-label">Site Name</label>
		<div class="controls">
			<?php echo CHtml::textField('site_name', $setting['site_name'], array(
				'class'=>'span5', 
				'placeholder'=>'Site Name',
				'required'=>'required' 
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="site_title" class="control-label">Site Title</label>
		<div class="controls">
			<?php echo CHtml::textField('site_title', $setting['site_title'], array(
				'class'=>'span5', 
				'placeholder'=>'Site Title',
				'required'=>'required' 
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="meta_desc" class="control-label">Site Description</label>
		<div class="controls">
			<?php echo CHtml::textArea('meta_desc', $setting['meta_desc'], array(
				'class'=>'span5', 
				'placeholder'=>'Site Description',
				'rows'=>5,
				'required'=>'required' 
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="email" class="control-label">Email</label>
		<div class="controls">
			<div class="input-prepend">
			  <span class="add-on">@</span>
			  <?php echo CHtml::textField('email', $setting['email'], array(
					'class'=>'span4', 
					'placeholder'=>'Email',
					'style'=>'width:339px'
				)); ?>
			</div>
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