<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'keyword-form',
	)); ?>
		<fieldset>
		    <legend><i class="icon-fixed-width icon-key"></i> Tambah Kata Kunci</legend>
		</fieldset>

	    <div class="control-group ">
	    	<label class="control-label required" for="KeywordModel_keyword">
	    		Masukkan Kata Kunci
	    	</label>
	    	<div class="controls">
	    		<textarea class="span6" rows="8" name="KeywordModel[keyword]" id="KeywordModel_keyword"></textarea>
	    	</div>
	    	<em>Kata kunci dipisahkan per baris</em>
	    </div>

	    <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Tambahkan',
        )); ?>

	<?php $this->endWidget(); ?>
</div>