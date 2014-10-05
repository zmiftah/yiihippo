<div class="form">
  <fieldset>
	 <legend>Daftar Banner</legend>
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

  <a href="<?php echo $this->createUrl('banner/add') ?>" class="btn btn-success">
    <i class="icon-plus"></i> Add New
  </a>

  <?php $basePath = dirname(dirname(Yii::app()->basePath)) ?>
  <?php $baseUrl  = Yii::app()->baseUrl ?>
  <?php $noImage  = 'http://placehold.it/69x52' ?>

	<?php $this->widget('bootstrap.widgets.TbGridView', array_merge( $config, array(
    'columns'=>array(
    	array(
  			'header'      => 'No',
  			'value'       => '$row+"' . $offset . '"+1',
  			'htmlOptions' => array('style'=>'width: 10px; text-align: right;'),
    	),
      array(
        'header'=>'Banner',
        'headerHtmlOptions' => array('colspan'=>'2', 'style'=>'text-align: center;'),
        'type'=>'image',
        'value'=>'file_exists("'.$basePath.'".$data["url"])?"'.$baseUrl.'".$data["url"]:"'.$noImage.'"',
        'htmlOptions'=>array('style'=>'width: 70px;'),
      ),
      array(
        'headerHtmlOptions'=>array('style'=>'display:none'),
        'name'=>'name',
        'htmlOptions'=>array('style'=>'width: 100px;'),
      ),

    	array(
    		'header'=>'Link Banner',
        'class'=>'CLinkColumn',
        'labelExpression'=>'$data["image_url"]', 
        'urlExpression'=>'$data["image_url"]',
    	),
    	array(
    		'header'=>'Teks Banner',
    		'value'=>'Yii::app()->controller->getText($data["desc"])',
    	),
    	array(
    		'header'=>'Posisi',
    		'value'=>'Yii::app()->controller->getPosition($data["target"])',
    	),
    	array(
  			'header'            => 'Action',
  			'class'             => 'CLinkColumn',
  			'labelExpression'   => '"<i class=\"icon-".($data->status==0?"ok":"ban")."-circle\"></i>"', 
  			'urlExpression'     => '"'.$this->createUrl('banner/activate').'?id=".$data["link_id"]',
  			'headerHtmlOptions' => array('colspan'=>'3', 'style'=>'text-align: center;'),
  			'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
  			'linkHtmlOptions'   => array(
      		'alt'=>'Toggle Activate',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Toggle Activate'
      	)
      ),
      array(
  			'class'             => 'CLinkColumn',
  			'labelExpression'   => '"<i class=\"icon-edit\"></i>"', 
  			'urlExpression'     => '"' . $this->createUrl('banner/edit') . '?id=".$data["link_id"]',
  			'headerHtmlOptions' => array('style'=>'display:none'),
  			'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
  			'linkHtmlOptions'   => array(
      		'alt'=>'Edit',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Edit'
      	)
      ),
      array(
    		'class'             => 'CLinkColumn',
    		'labelExpression'   => '"<i class=\"icon-remove\"></i>"', 
    		'urlExpression'     => '"' . $this->createUrl('banner/delete') . '?id=".$data["link_id"]',
    		'headerHtmlOptions' => array('style'=>'display:none'),
    		'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
    		'linkHtmlOptions'   => array(
      		'alt'=>'Delete',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Delete',
      		'onclick'=>"return confirm('Anda yakin ingin menghapus banner ini?')"
      	)
      ),
    ),
	))); ?>
</div>