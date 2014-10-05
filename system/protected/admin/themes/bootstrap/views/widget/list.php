<div class="form">
	<fieldset>
	    <legend><i class="icon-fixed-width icon-bar-chart"></i> Daftar Widget <small>Total: <?=$total?></small></legend>
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
				'labelExpression'   => '"<i class=\"icon-cog\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('widget/configure') . '?id=".$data["id"]',
				'headerHtmlOptions' => array('colspan'=>'3', 'style'=>'text-align: center;'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Configure',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Configure'
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '($data["show"])?"":"<i class=\"icon-eye-open\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('widget/show') . '?id=".$data["id"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Show Widget',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Show Widget'
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '($data["show"])?"<i class=\"icon-eye-close\"></i>":""', 
				'urlExpression'     => '"' . $this->createUrl('widget/hide') . '?id=".$data["id"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Hide Widget',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Hide Widget'
      	)
      ),
    ),
	))); ?>
</div>