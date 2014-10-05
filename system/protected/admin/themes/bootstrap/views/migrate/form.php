<style>
	/* Base class */
	.bs-docs-example {
	  position: relative;
	  margin: 15px 0;
	  padding: 39px 19px 14px;
	  *padding-top: 19px;
	  background-color: #fff;
	  border: 1px solid #ddd;
	  -webkit-border-radius: 4px;
	     -moz-border-radius: 4px;
	          border-radius: 4px;
	}

	/* Echo out a label for the example */
	.bs-docs-example:after {
	  content: "Result";
	  position: absolute;
	  top: -1px;
	  left: -1px;
	  padding: 3px 7px;
	  font-size: 12px;
	  font-weight: bold;
	  background-color: #f5f5f5;
	  border: 1px solid #ddd;
	  color: #9da0a4;
	  -webkit-border-radius: 4px 0 4px 0;
	     -moz-border-radius: 4px 0 4px 0;
	          border-radius: 4px 0 4px 0;
	}

	/* Remove spacing between an example and it's code */
	.bs-docs-example + .prettyprint {
	  margin-top: -20px;
	  padding-top: 15px;
	}
</style>

<div class="form">
	<?php $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'seo-form',
		'type'=>'horizontal',
		'htmlOptions'=>array(
			'enctype'=>'multipart/form-data'
		)
	)); ?>

	<fieldset>
	    <legend><i class="icon-fixed-width icon-cogs"></i> Migration <small>(From Old BrainHippo Media)</small></legend>
	</fieldset>

	<div class="control-group">
		<label for="filedb" class="control-label">SQL Dump</label>
		<div class="controls">
			<?php echo CHtml::fileField('filedb', $setting['filedb'], array(
				'class'=>'span5', 'accept'=>'text/x-sql,text/plain,application/sql'
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<button name="save" class="btn btn-large btn-primary" type="submit">
				<i class="icon-upload"></i> Migrate
			</button>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div>

<?php if (count($rows)>0): ?>
<div class="bs-docs-example">
	<p>Migration Result: <small>(<?php echo round($time, 3) ?> seconds)</small></p>
  <ul>
  	<?php foreach ($rows as $table => $jml): ?>
  	<li>Tabel <?php echo $table ?> ... (<?php echo $jml ?> rows)</li>
  	<?php endforeach ?>
  </ul>
</div>
<?php endif ?>