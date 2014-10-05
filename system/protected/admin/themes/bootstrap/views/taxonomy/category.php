<script>
  showLoading = function(){
    var loading = '<div style="text-align:center">'
    loading += '<img src="<?php echo $this->assetsBase ?>/img/loading.gif">'
    loading += '</div>'
    $('#showCategoryContent').html(loading)
  }

  createCategory = function(e){
    showLoading()

    $.ajax({
      url: '<?php echo Yii::app()->baseUrl."/admin/taxonomy/formcategory.php" ?>',
      cache: false
    }).done(function(html){
      $('#showCategoryContent').html(html)
    })

    $('#showCategory').modal('show')
  }

  editCategory = function(e){
    e.preventDefault()
    showLoading()

    var idCat = this.href
    idCat = idCat.substr(idCat.indexOf('edit/')+5)

    $.ajax({
      type: 'POST',
      url: '<?php echo Yii::app()->baseUrl."/admin/taxonomy/formcategory.php" ?>',
      data: {id: idCat}
    }).done(function(html){
      $('#showCategoryContent').html(html)
    })

    $('#showCategory').modal('show')
  }

  deleteCategory = function(e){
    e.preventDefault()

    var idCat = this.href
    idCat = idCat.substr(idCat.indexOf('delete/')+7)

    $.ajax({
      type: 'POST',
      url: '<?php echo Yii::app()->baseUrl."/admin/taxonomy/delete.php" ?>',
      data: {id: idCat},
      dataType: 'json'
    }).done(function(json){
      if (json == 1) {
        alert('Kategori berhasil dihapus')
        location.href = 'category.php'
      } else {
        alert('Gagal menghapus kategori')
      }
    })    
  }

  $(document).ready(function(){
    $('#addNew').click(createCategory)
    $('.editCat').click(editCategory)
    $('.deleteCat').click(deleteCategory)
  })
</script>

<div class="form">
	<fieldset>
	    <legend><i class="icon-fixed-width icon-list-alt"></i> Daftar Kategori <small id="total"></small></legend>
	</fieldset>

  <?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block'     => true,
    'fade'      => true,
    'closeText' => 'x',
    'alerts'    => array(
      'success' => array('block'=>true, 'fade'=>true, 'closeText'=>'x'),
      'error'   => array('block'=>true, 'fade'=>true, 'closeText'=>'x'),
    ),
  )); ?>

  <a href="javascript:void(0)" class="btn btn-success" id="addNew">
    <i class="icon-plus"></i> Add New
  </a>

  <?php $this->widget('bootstrap.widgets.TbGridView', array_merge( $config, array(
    'columns'=>array(
    	array(
				'header'      => 'No',
				'value'       => '$row+"' . $offset . '"+1',
				'htmlOptions' => array('style'=>'width: 10px; text-align: right;'),
    	),
    	array(
      	'header'=>'Name',
      	'name'=> 'name'
      ),
      array(
      	'header'=>'Slug / Url',
      	'name'=> 'slug',
      ),
      array(
				'header'            => 'Action',
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-edit\"></i>"', 
				'urlExpression'     => '"edit/".$data["term_id"]',
				'headerHtmlOptions' => array('colspan'=>'3', 'style'=>'text-align: center;'),
				'htmlOptions'       => array('style'=>'width:20px; text-align:center;'),
				'linkHtmlOptions'   => array(
          'class'=>'editCat',
      		'alt'=>'Edit',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Edit'
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-remove\"></i>"', 
				'urlExpression'     => '"delete/".$data["term_id"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width:20px; text-align:center;'),
				'linkHtmlOptions'   => array(
          'class'=>'deleteCat',
      		'alt'=>'Delete',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Delete',
      		'onclick'=>"return confirm('Anda yakin ingin menghapus kategori ini?')",
      	)
      ),
    ),
	))); ?>
</div>

<div id="showCategory" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h5><i class="icon-fixed-width icon-cog"></i> Form Category</h5>
  </div>
  <div id="showCategoryContent" class="modal-body"></div>
</div>