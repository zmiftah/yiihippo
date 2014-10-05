<script>
	$(document).ready(function(e){

		$('#showHelp').popover({
			html:true,
			placement:'top'
		})

		$('.optLink').change(function(e){
			$('#customPermalink').val(this.getAttribute('tag'))
		})
	})
</script>

<?php $showHelp = '<ul>
	<li>%year%</li>
	<li>%monthnum%</li>
	<li>%day%</li>
	<!--li>%post_id%</li-->
	<li>%postname%</li>
</ul>'; ?>

<div class="form">
	<?php $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'permalink-form',
		'type'=>'horizontal',
		'action'=>$this->createUrl('setting/permalink')
	)); ?>

	<fieldset>
	    <legend><i class="icon-fixed-width icon-code-fork"></i> Permalink Setting</legend>
	</fieldset>

	<?php CHtml::hiddenField('tab', 'permalink') ?>

	<div class="control-group">
		<label for="meta_keyword" class="control-label">Article Permalink</label>
		<div class="controls">

			<label class="radio">
				<?php $checked = $opt_permalink==1? 'checked': '' ?>
			  <input type="radio" <?php echo $checked ?> class="optLink" name="opt_permalink" value="1" id="optLink1" tag="%postname%">
			  Post name <em>(Default)</em>
			  <span class="help-block">
			  	<code><small>(http://localhost/hiipopress/article.htm)</small></code>
			  </span>
			</label>

			<label class="radio">
				<?php $checked = $opt_permalink==2? 'checked': '' ?>
			  <input type="radio" <?php echo $checked ?> class="optLink" name="opt_permalink" value="2" id="optLink2" tag="%year%/%postname%">
			  Year and name
			  <span class="help-block">
			  	<code><small>(http://localhost/hiipopress/<?php echo date('Y') ?>/article.htm)</small></code>
			  </span>
			</label>

			<label class="radio">
				<?php $checked = $opt_permalink==3? 'checked': '' ?>
			  <input type="radio" <?php echo $checked ?> class="optLink" name="opt_permalink" value="3" id="optLink3" tag="%year%/%monthnum%/%postname%">
			  Month and name
			  <span class="help-block">
			  	<code><small>(http://localhost/hiipopress/<?php echo date('Y/m') ?>/article.htm)</small></code>
			  </span>
			</label>

			<label class="radio" style="display:none">
				<?php $checked = $opt_permalink==4? 'checked': '' ?>
			  <input type="radio" <?php echo $checked ?> class="optLink" name="opt_permalink" value="4" id="optLink4" tag="%year%/%monthnum%/%day%/%postname%">
			  Day and name
			  <span class="help-block">
			  	<code><small>(http://localhost/hiipopress/<?php echo date('Y/m/d') ?>/article.htm)</small></code>
			  </span>
			</label>

			<label class="radio" style="display:none">
				<?php $checked = $opt_permalink==5? 'checked': '' ?>
			  <input type="radio" <?php echo $checked ?> class="optLink" name="opt_permalink" value="5" id="optLink5" tag="<?php echo $permalink ?>">
			  Custom
			  <span class="help-block">
			  	<input type="text" class="span4" name="permalink" value="<?php echo $permalink ?>" id="customPermalink" required> <br>
			  	<a id="showHelp" href="javascript:void(0)" data-toggle="popover" title="Possible Settings" data-original-title="A Title" 
			  	data-content="<?php echo $showHelp ?>" >Show Help</a>
			  </span>
			</label>

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