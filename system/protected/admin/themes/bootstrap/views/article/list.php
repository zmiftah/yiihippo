<div class="form">
	<fieldset>
	    <legend><i class="icon-fixed-width icon-list-alt"></i> Daftar Artikel <small>Total: <?=$total?></small></legend>
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

  <!-- <a href="<?php //echo $this->createUrl('article/add') ?>" class="btn btn-success">
    <i class="icon-plus"></i> Add New
  </a> -->

  <?php $this->widget('bootstrap.widgets.TbGridView', array_merge( $config, array(
    'columns'=>array(
    	array(
				'header'      => 'No',
				'value'       => '$row+"'.$offset.'"+1',
				'htmlOptions' => array('style'=>'width: 10px; text-align: right;'),
    	),
      array(
      	'header'=>'Artikel Title',
      	'class'=>'CLinkColumn',
      	'labelExpression'=>'$data["title"]', 
      	'linkHtmlOptions'=>array('target'=>'_blank'),
      	'urlExpression'=>'WEBSITE . "/" . $data["url"]',
      ),
    	array(
      	'header'=>'Keyword',
      	'value'=> '$data["postKeyword"]->name'
      ),
      array(
      	'header'=>'Status',
      	'value'=> '$data["status"] == 2 ? "Publish" : "Draft"',
      ),
      array(
      	'header'=>'Comments',
      	'class'=>'CLinkColumn',
      	'labelExpression'=>'"<span class=\"badge\">".$data->commentCount."</span>"',
      	'linkHtmlOptions'=>array('target'=>'_blank'),
      	'urlExpression'=>'$data["url"]."#comments"',
      	'htmlOptions'=>array('style'=>'text-align:center;width:65px;')
      ),
      array(
      	'header'=>'Date',
      	'value'=> 'date("Y-m-d", strtotime($data["created"]))',
      	'htmlOptions' => array('style'=>'width:65px;'),
      ),
      array(
				'header'            => 'Action',
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-edit\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('article/edit') . '?id=".$data["post_id"]',
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
				'urlExpression'     => '"' . $this->createUrl('article/delete') . '?id=".$data["post_id"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Delete',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Delete',
      		'onclick'=>"return confirm('Anda yakin ingin menghapus article ini?')",
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '$data["status"]!=2?"<i class=\"icon-mail-forward\"></i>":""', 
				'urlExpression'     => '"'.$this->createUrl('page/publish').'?id=".$data["post_id"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Publish',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Publish'
      	)
      ),
    ),
	))); ?>
</div>