<link rel="stylesheet" href="<?php echo $this->assetsBase.'/css/textext.core.css'; ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->assetsBase.'/css/textext.plugin.tags.css'; ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->assetsBase.'/css/bootstrap-select.min.css'; ?>" type="text/css" />
<style>
	.dl-info{ margin:0 auto; }
	.img-select{ border-bottom:1px solid #ccc; padding-bottom:15px; margin-bottom:5px; }
	.btnplus{ float:right; }
	#tags{ font-size:14px; line-height:normal; }
	/*.text-button{ margin-top: 2px; margin-left: 2px; }*/
	.tag-span{ width:301px; }
</style>
<!-- Fix bug with YoutubeVid -->
<link rel="stylesheet" href="<?php echo $this->assetsBase.'/js/ckeditor/skins/moono-light/dialog.css?t=C7LG'; ?>">

<script src="<?php echo $this->assetsBase.'/js/jquery.limiter.js'; ?>"></script>
<script src="<?php echo $this->assetsBase.'/js/textext.core.js'; ?>"></script>
<script src="<?php echo $this->assetsBase.'/js/textext.plugin.tags.js'; ?>"></script>
<script src="<?php echo $this->assetsBase.'/js/bootstrap-select.min.js'; ?>"></script>
<script src="<?php echo $this->assetsBase.'/js/ckeditor/ckeditor.js'; ?>"></script>
<!-- Fix bug with YoutubeVid -->
<script src="<?php echo $this->assetsBase.'/js/ckeditor/plugins/image/dialogs/image.js?t=C7LG'; ?>"></script>
<script>
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

	savePage = function(option){
		var val = (option == 'publish') ? 2 : 1;
		$('#PostModel_status').val(val);

		// validasi

		$('#artikel-form').submit();
	}

	selectMediaModal = function(e){
		var image = '<img src="<?php echo Yii::app()->baseUrl ?>/content/assets/admin/bootstrap/img/loading.gif">'

		$('#showMedia').modal();
		$('#showMediaList').css({margin:'20px', textAlign:'center', padding:'0px'});
		$('#showMediaList').html(image);
		$.ajax({ 
			url:'<?php echo Yii::app()->baseUrl ?>/admin/media/imagelist.php' 
		}).done(function(html){
			$('#showMediaList').html(html)
		});
	}

	selectImage = function(media_id) {
		var image = '<img src="<?php echo Yii::app()->baseUrl ?>/content/assets/admin/bootstrap/img/loading.gif">'

		$('#showMedia').modal('hide')
		$('#selectedImage').css({textAlign:'center', marginTop:'10px'})
		$('#selectedImage').html(image)
		$.ajax({ 
			type: 'POST',
			data: { id:media_id },
			url:'<?php echo Yii::app()->baseUrl ?>/admin/media/getimage.php' 
		}).done(function(img){
			$('#PostModel_image').val(media_id)
			
			var html = '<div>',
					url  = '<?php echo Yii::app()->baseUrl ?>'+img.url;
			html += '<img src="'+url+'" width="190" class="img-polaroid img-select">'
			html += '</div>';
			$('#selectedImage').html(html)
		})
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

	showLoading = function(selector){
    var loading = '<div style="text-align:center">'
    loading += '<img src="<?php echo Yii::app()->baseUrl ?>/content/assets/admin/bootstrap/img/loading.gif">'
    loading += '</div>'
    $(selector).html(loading)
  }

	createCategory = function(e) {
		showLoading('#showCategoryContent')

    $.ajax({
      url: '<?php echo Yii::app()->baseUrl."/admin/taxonomy/formcategory.php" ?>',
      cache: false
    }).done(function(html){
      $('#showCategoryContent').html(html)
    })

    $('#showCategory').modal('show')
	}

	insertKeyword = function(e) {
		CKEDITOR.instances.PostModel_content.insertText('[kwd][/kwd]');
	}

	insertAdsense = function(e) {
		CKEDITOR.instances.PostModel_content.insertText('[ads:]');	
	}

	$(document).ready(function(){
		//showKeyword('<?php echo $keyword_id ?>', '<?php echo $permalink ?>', '<?php echo ucwords($keyword) ?>');
		$('#PostModel_keyword').change(keywordChange);
		$('#selectMedia').click(selectMediaModal);
		$('#PostModel_url').keyup(permalinkChange);
		$('#link_url').click(checkPermalink);
		$('#newcategory').click(createCategory);

		// $('#insertKeyword').click(insertKeyword);
		$('#insertAdsense').click(insertAdsense);
	});
</script>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'artikel-form',
	)); ?>

		<fieldset>
		    <legend><i class="icon-fixed-width icon-list-alt"></i> <?php echo $action ?> Artikel</legend>
		</fieldset>

		<?php echo CHtml::activeHiddenField($model, 'status'); ?>
		<?php echo CHtml::activeHiddenField($model, 'image'); ?>

		<div class="row">
			<div class="span3">
				<?php $options = $action == 'Edit' ? array('disabled'=>'disabled') : array() ?>
				<?php echo $form->dropDownListRow($model, 'keyword', $keywords, array_merge(
					array('class'=>'span3'), $options
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

		<div class="row">
			<div class="span3">
				<label for="category" class="required">
					<strong>Category</strong>
				</label>
				<?php echo CHtml::dropDownList('category', $blank, $categories, array(
					'class'=>'span3','multiple'=>1
				)) ?>
				<!-- <div class="btnplus">
					<span id="catloader"></span>&nbsp;
					<a id="newcategory" href="#" class="btn btn-small btn-success">
						<i class="icon-plus"></i> Add
					</a>
				</div> -->
			</div>
			<div class="span4">
				<label for="tags" class="required">
					<strong>Tags</strong>
				</label>
				<?php echo CHtml::textField('tags', $blank, array('class'=>'tag-span')) ?>
				<span class="help-block">Tekan <code>Enter</code> untuk menambahkan tag</span>
			</div>
		</div>

		<div class="row">
			<hr class="span7">
		</div>

		<?php echo $form->textFieldRow($model, 'title', array( 
			'hint'=>'<span id="limit">(70 characters left)</span>', 
			'class'=>'span7', 
			'required'=>'required' 
		)); ?>
	
		<div class="row">
			<div class="span4">
				<label for="meta_title" class="required">
					<strong>Meta Title</strong> <span class="required">*</span>
				</label>
				<?php echo CHtml::textField('meta_title', $metadata['title'], array(
					'class'=>'span4'
				)) ?>
			</div>
			<div class="span3">
				<label for="meta_keyword" class="required">
					<strong>Meta Keyword</strong> <span class="required">*</span>
				</label>
				<?php echo CHtml::textField('meta_keyword', $metadata['keyword'], array(
					'class'=>'span3',
				)); ?>
			</div>
		</div>

		<?php echo $form->textAreaRow($model, 'desc', array( 'class'=>'span7', 'rows'=>5, 'required'=>'required' )); ?>
		<?php echo $form->textAreaRow($model, 'content', array( 'class'=>'span7', 'rows'=>10, 'required'=>'required' )); ?>

		<div class="btn-group" style="margin-top:5px">
		  <!-- <a id="insertKeyword" href="javascript:void(0)" class="btn btn-mini">Keyword</a> -->
		  <a id="insertAdsense" href="javascript:void(0)" class="btn btn-mini">Adsense</a>
		</div>
		
	<?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		CKEDITOR.replace( 'PostModel_content', {
			'fullpage':true,
			'width':'690',
			'resize_maxWidth':'690',
			'resize_minWidth':'300',
			'filebrowserBrowseUrl': '<?php echo WEBSITE ?>/admin/media/browse.php',
   		'filebrowserUploadUrl': '<?php echo WEBSITE ?>/admin/media/fileupload.php',
   		'filebrowserWindowWidth': '640',
    	'filebrowserWindowHeight': '480'
		})
		$('#tags').textext({ plugins: 'tags', tags: { items:[<?php echo $tags ?>] } })
		$('#category').selectpicker({ 
			// size:7,
			header:'Pilih Kategori',
			title:'--- Pilih Kategori ---',
		})

		$('#category').selectpicker('val', [<?php echo $category ?>]);

		$("#PostModel_title").limiter(70, $('#limit'), ' characters left');
	});
</script>

<div id="showMedia" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h5><i class="icon-fixed-width icon-camera"></i> Set Featured Image</h5>
  </div>
  <div id="showMediaList" class="modal-body"></div>
</div>

<div id="showCategory" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h5><i class="icon-fixed-width icon-cog"></i> Create Category</h5>
  </div>
  <div id="showCategoryContent" class="modal-body"></div>
</div>

<?php Yii::app()->navwidget->beginNav('actions', 'Actions'); ?>
	<?php if (PostStatusModel::STATUS_PUBLISH != $model->status): ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'icon'=>'tags',
		'label'=>'Draft',
		'htmlOptions' => array(
			'onclick'=>"savePage('draft')",
			'style'=>'width:90px'
		)
	)); ?>
	<?php endif ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'icon'=>'mail-forward',
		'type'=>'primary',
		'label'=>'Publish',
		'htmlOptions' => array(
			'onclick'=>"savePage('publish')"
		)
	)); ?>
<?php Yii::app()->navwidget->endNav('actions'); ?>

<?php if ($action=='Edit'): ?>
<?php Yii::app()->navwidget->beginNav('info', 'Article Info'); ?>
	<dl class="dl-info">
	  <dt>Status</dt>
	  <dd><?php echo $model->postStatus->name ?></dd>

	  <dt>Publish on</dt>
	  <dd><?php echo $model->created ?></dd>
	</dl>
<?php Yii::app()->navwidget->endNav('info'); ?>
<?php endif ?>

<?php Yii::app()->navwidget->beginNav('image', 'Featured Image'); ?>
	<i class="icon-fixed-width icon-picture"></i>
	<a href="javascript:void(0)" id="selectMedia">Pilih Gambar</a>
	<p id="selectedImage"></p>
<?php Yii::app()->navwidget->endNav('image'); ?>
