<div class="form">
	<fieldset>
	  <legend><i class="icon-fixed-width icon-file"></i> Daftar Halaman <small>Total: <?=$total?></small></legend>
	</fieldset>

	<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'     => true,
		'fade'      => true,
		'closeText' => 'x',
		'alerts'    => array(
			'success'   => array('block'=>true, 'fade'=>true, 'closeText'=>'x'),
			'error'     => array('block'=>true, 'fade'=>true, 'closeText'=>'x'),
		),
  ) ); ?>

  <a href="<?php echo $this->createUrl('page/add') ?>" class="btn btn-success">
    <i class="icon-plus"></i> Add New
  </a>

  <?php $this->widget('bootstrap.widgets.TbGridView', array_merge( $config, array(
    'columns'=>array(
      array(
      	'header'=>'Title',
      	'class'=>'CLinkColumn',
      	'labelExpression'=>'$data["title"]', 
      	'linkHtmlOptions'=>array('target'=>'_blank'),
      	'urlExpression'=>'WEBSITE . "/" . $data["url"]',
      ),
      array(
      	'header'=>'SEO Title',
      	'value'=>'"'.$title.' - ".$data["title"]',
      ),
      array(
      	'header'=>'Keyword',
      	'value'=> '$data["postKeyword"]->name'
      ),
      array(
      	'header'=>'Comments',
      	'class'=>'CLinkColumn',
      	'labelExpression'=>'"<span class=\"badge\">".$data->commentCount."</span>"',
      	'linkHtmlOptions'=>array('target'=>'_blank'),
      	'urlExpression'=>'$data["url"]."#comments"',
      	'htmlOptions'=>array('style'=>'text-align:center')
      ),
      array(
      	'header'=>'Date',
      	'value'=> 'date("d F Y", strtotime($data["created"]))',
      	'htmlOptions'=>array('nowrap'=>'nowrap')
      ),
      array(
				'header'            => 'Action',
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-edit\"></i>"', 
				'urlExpression'     => '"'.$this->createUrl('page/edit').'?id=".$data["post_id"]',
				'headerHtmlOptions' => array('colspan'=>'3', 'style'=>'text-align: center;'),
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
				'urlExpression'     => '"'.$this->createUrl('page/delete').'?id=".$data["post_id"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
					'onclick'=>'return confirm("Anda yakin ingin menghapus Page ini?")',
      		'alt'=>'Delete',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Delete'
      	)
      ),
    ),
	))); ?>
</div>