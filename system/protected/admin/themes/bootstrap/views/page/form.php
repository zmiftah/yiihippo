<script src="<?php echo $this->assetsBase.'/js/ckeditor/ckeditor.js'; ?>"></script>
<script>
	submitPage = function(option) {
		$('#page-form').submit();
	}

	String.prototype.ucwords = function() {
    return (this + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
	}
	String.prototype.trim = function() {
		
	    return this.replace(/^\s+|\s+$/g, "");
	};
	String.prototype.toPermalink = function() {
		var s = this.replace(/.htm+$/gi, '').toLowerCase().split(' ').join('-');
		s = s.length>0 ? s + '.htm' : '';
		return s;
	};

	<?php $permalink = strtolower( str_replace(' ', '-', $keyword) ); ?>
	showKeyword = function(kw, url, title) {
		$('#PostModel_keyword').val(kw)
		$('#PostModel_url').val(url.replace('.htm', ''))
		<?php if($action!='Edit'): ?>
		$('#PostModel_title').val(title)
		<?php elseif($model->image): ?>
		selectImage(<?php echo $model->image ?>)
		<?php endif ?>
		$('#link_url').html(url+'.htm')
	}

	keywordChange = function(e){
		var id = $(this).val(),
				kw = $(':selected', this).text(),
				url = kw.toLowerCase().replace(/\s/g, '-'),
				title = kw.ucwords()
		showKeyword(id, url, title)
	}

	permalinkChange = function(e){
		var link = $('#link_url'),
				url = $('#PostModel_url').val();

		url = url.toPermalink();
		link.html(url);
	}

	checkPermalink = function(e) {
		$.ajax({
			type: 'POST',
      url: '<?php echo Yii::app()->baseUrl."/admin/article/validlink.php" ?>',
      data: {url: $(this).html()},
      cache: false,
      dataType: 'json'
    }).done(function(json){
      if(json.result == 1){
      	$(this).css({color: 'red'})
      	$('#link_icon').attr('class', 'icon-ok')
      } else {
      	$(this).css({color: '#0088cc'})
      	$('#link_icon').attr('class', 'icon-remove')
      }
    })
	}

	$(document).ready(function(){
		//showKeyword('<?php echo $keyword_id ?>', '<?php echo $permalink ?>', '<?php echo ucwords($keyword) ?>');
		$('#PostModel_keyword').change(keywordChange);
		$('#PostModel_url').keyup(permalinkChange);
		$('#link_url').click(checkPermalink);
	});
</script>

<div class="form">
	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'page-form',
		'focus'=>array($model, 'title'),
	)); ?>
		<fieldset>
		    <legend><i class="icon-fixed-width icon-file"></i> <?php echo $action ?> Halaman</legend>
		</fieldset>
		
		<?php echo $form->textFieldRow($model, 'title', array('class'=>'span8')); ?>

		<div class="row">
			<div class="span4">
				<label for="meta_title" class="required">
					<strong>Meta Title</strong>
				</label>
				<?php echo CHtml::textField('meta_title', $metadata['title'], array(
					'class'=>'span4'
				)) ?>
			</div>
			<div class="span4">
				<label for="meta_keyword" class="required">
					<strong>Meta Keyword</strong>
				</label>
				<?php echo CHtml::textField('meta_keyword', $metadata['keyword'], array(
					'class'=>'span4',
				)); ?>
			</div>
		</div>

		<?php echo $form->textAreaRow($model, 'desc', array('class'=>'span8', 'rows'=>4)); ?>

		<div class="row">
			<div class="span4">
				<?php $options = $action == 'Edit' ? array('disabled'=>'disabled') : array() ?>
				<?php echo $form->dropDownListRow($model, 'keyword', $keywords, array_merge(
					array('class'=>'span4'), $options
				)) ?>
			</div>
			<div class="span4">
				<?php echo $form->textFieldRow($model, 'url', array( 
					'hint'     => '<span id="linkloader"></span> <i id="link_icon"></i> <a id="link_url" href="javascript:void(0)"></a>', 
					'class'    => 'span4',
					'required' => 'required' 
				)); ?>
			</div>
		</div>

		<?php echo $form->textAreaRow($model, 'content', array('class'=>'span8')); ?>


	<?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
	CKEDITOR.replace( 'PostModel_content', {
		'fullpage':true,'width':'695','resize_maxWidth':'695','resize_minWidth':'280'
	});
</script>

<?php Yii::app()->navwidget->beginNav('actions', 'Actions'); ?>
	<div style="text-align:center;">
	  <?php $this->widget('bootstrap.widgets.TbButton', array(
			'icon'=>'mail-reply',
			'label'=>'Back',
			'htmlOptions' => array(
				'onclick'=>'location.href="index.php"',
				'style'=>'margin-right:20px'
			)
	  )); ?>

	  <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'icon'=>'mail-forward',
			'type'=>'primary',
			'label'=>'Save',
			'htmlOptions' => array(
				'onclick'=>'submitPage()',
			)
	  )); ?>
  </div>
<?php Yii::app()->navwidget->endNav('actions'); ?>