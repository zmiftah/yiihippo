<div class="form">
	<fieldset>
	    <legend><i class="icon-fixed-width icon-align-justify"></i> Daftar Link Website <small>Total: <?=$total?></small></legend>
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

  <a href="<?php echo $this->createUrl('link/add') ?>" class="btn btn-success">
    <i class="icon-plus"></i> Add New
  </a>

  <?php $this->widget('bootstrap.widgets.TbGridView', array_merge( $config, array(
    'columns' => array(
    	array(
				'header'      => 'No',
				'value'       => '$row+"'.$offset.'"+1',
				'htmlOptions' => array('style'=>'width: 10px; text-align: right;'),
    	),
    	array(
      	'header'=>'Nama Website',
      	'name'=>'name', 
      ),
      array(
      	'header'=>'Website Url',
      	'class'=>'CLinkColumn',
      	'labelExpression'=>'$data["url"]',
      	'linkHtmlOptions'=>array('target'=>'_blank'),
      	'urlExpression'=>'$data["url"]',
      ),
      array(
      	'header'=>'Target',
      	'name'=>'target',
      ),
      array(
				'header'            => 'Action',
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-edit\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('link/edit') . '?id=".$data["link_id"]',
				'headerHtmlOptions' => array('colspan'=>'2', 'style'=>'text-align: center;'),
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
				'urlExpression'     => '"' . $this->createUrl('link/delete') . '?id=".$data["link_id"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Delete',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Delete',
      		'onclick'=>"return confirm('Anda yakin ingin menghapus link ini?')",
      	)
      ),
    ),
	))); ?>
</div>