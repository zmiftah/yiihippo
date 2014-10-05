<style>
	.widget{ float:left; }
	.form-horizontal .controls{ margin-left:140px; }
	.form-horizontal .control-label{ width:130px; }
</style>

<div class="form-login">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'          => 'login-form',
		'type'        => 'horizontal',
		'htmlOptions' => array( 'class' => 'well' ),
	)); ?>

	<fieldset>
	    <legend style="text-align: center;">
	    	<i class="icon-lock"></i>
	    	Selamat Datang di Brain Hippo Media!
	    </legend>
	</fieldset>

  <?php echo $form->textFieldRow($model, 'username'); ?>
  <?php echo $form->passwordFieldRow($model, 'password'); ?>
	<?php echo $form->captchaRow($model,'verifyCode', array(
		'class'=>'span2',
		'style'=>'margin-left:5px; vertical-align:top; width:80px',
		'captchaOptions'=>array(
			'captchaAction'=>'captcha',
    	'buttonLabel'=>'',
    	'clickableImage'=>true,
    	'showRefreshButton'=>false,
    	'imageOptions'=>array(
    		'width'=>'100',
    		'height'=>'60',
    		'alt'=>'Klik untuk Captcha baru',
    		'title'=>'Klik untuk Captcha baru',
    		'style'=>'cursor: pointer;',
    	),
    )
	)); ?>

	<!-- <div class="control-group">
  	<label class="control-label required" for="LoginForm_password">
  		Verifikasi <span class="required">*</span>
  	</label>
  	<div class="controls">
  		<img src="<?php //echo $this->createUrl('site/captcha') ?>" alt="Captcha" width="100" height="30">
  		<input class="span2" name="LoginForm[verifyCode]" id="LoginForm_verifyCode" type="verifyCode">
  	</div>
  </div> -->

  <div class="control-group">
  	<div class="controls">
  		<?php $this->widget('bootstrap.widgets.TbButton', array(
	      'buttonType'=>'submit',
	      'type'=>'primary',
	      'icon'=>'icon-user icon-white',
	      'label'=>'Login',
	    )); ?>
  	</div>
	</div>

	<?php $this->endWidget(); ?>
	<a href="<?php echo WEBSITE ?>">
		<i class="icon-arrow-left"></i> Go To Website
	</a>
</div>	