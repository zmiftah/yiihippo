<div class="form">
	<fieldset>
	    <legend><i class="icon-fixed-width icon-key"></i> Daftar Kata Kunci <small>Total: <?=$total?></small></legend>
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

  <a href="<?php echo $this->createUrl('keyword/add') ?>" class="btn btn-success">
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
      	'header'=>'Keyword',
      	'name'=>'name', 
      ),
      array(
				'header'            => 'Action',
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-arrow-right\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('keyword/submit') . '?id=".$data["id"]',
				'headerHtmlOptions' => array('colspan'=>'2', 'style'=>'text-align: center;'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Submit Artikel',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Submit Artikel'
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-remove\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('keyword/delete') . '?id=".$data["id"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array(
					'style'=>'width: 20px; text-align: center;',
					'onClick'=>"return confirm('Anda Yakin akan menghapus keyword ini?')"
				),
				'linkHtmlOptions'   => array(
      		'alt'=>'Delete',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Delete'
      	)
      ),
    ),
	))); ?>
</div>