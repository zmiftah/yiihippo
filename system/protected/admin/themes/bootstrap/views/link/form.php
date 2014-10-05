<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'   => 'link-form',
		'type' => 'horizontal',
	)); ?>

	<fieldset>
	    <legend><i class="icon-fixed-width icon-align-justify"></i> <?=$title?> Link</legend>
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

	<?php echo $form->textFieldRow($model, 'name', array( 
		'class'=>'span4', 
		'required'=>'required' 
	)); ?>

	<?php echo $form->textFieldRow($model, 'url', array( 
		'hint'=>'ex. http://www.asianbrain.com', 
		'class'=>'span4', 
		'required'=>'required' 
	)); ?>

	<?php echo $form->dropDownListRow($model, 'target', $targetList, array( 
		'class'=>'span4', 
		'required'=>'required' 
	)); ?>

	<div class="control-group">
		<div class="controls">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>'plus',
        'label'=>'Insert',
	    )); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div>