<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'comment-form',
	)); ?>
		<fieldset>
		    <legend><i class="icon-fixed-width icon-comments"></i> Edit / Moderate Komentar</legend>
		</fieldset>

			<div class="control-group ">
	    	<label class="control-label required" for="KeywordModel_keyword">
	    		Comment by 
	    		<a href="mailto:<?php echo $row->email ?>" target="_blank"><?php echo $row->author ?></a> 
	    		in reply to 
	    		<a href="<?php echo $row->post['url'] ?>" target="_blank"><?php echo $row->post['title'] ?></a>
	    	</label>

	    	<div class="controls">
	    		<textarea class="span6" rows="8" name="comment" id="comment"><?php echo $row->content ?></textarea>
	    	</div>
	    	<small>Post at <?php echo date('Y-m-d H:i:s', strtotime($row->date_insert)) ?></small>
	    </div>

			<div class="control-group">
				<a href="<?php echo $this->createUrl('comment/index') ?>" class="btn">
					<i class="icon-arrow-left"></i> Back
				</a>
				 <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'buttonType'=>'submit',
	        'icon'=>'edit',
	        'label'=>'Edit / Moderate',
	      )); ?>
			</div>

	<?php $this->endWidget(); ?>
</div>