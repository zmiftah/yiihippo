<div class="form">
	<fieldset>
	    <legend>Themes <small>(Active: <?php echo $activeTheme ?>)</small></legend>
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

  <!-- <a href="<?php echo $this->createUrl('theme/upload') ?>" class="btn btn-success">
  	<i class="icon-upload icon-white"></i> Upload Theme
  </a> -->

	<?php $basePath = dirname(dirname(Yii::app()->basePath)) ?>
	<?php $noImage  = 'http://placehold.it/69x52' ?>

	<?php $this->widget('bootstrap.widgets.TbGridView', array_merge( $config, array(
		'rowCssClassExpression'=>'$data["theme"]=="'.$activeTheme.'"?"info":""',
	  'columns'=>array(
	  	array(
				'header'      => 'No',
				'value'       => '$row+'.$offset.'+1',
				'htmlOptions' => array('style'=>'width: 10px; text-align: right;'),
	  	),
	  	array(
      	'header'=>'Theme',
      	'headerHtmlOptions' => array('colspan'=>'2', 'style'=>'text-align: center;'),
      	'type'=>'image',
      	'value'=>'file_exists("'.$basePath.'".$data["url"])?$data["url"]:"'.$noImage.'"',
      	'htmlOptions'=>array('style'=>'width: 70px;'),
      ),
      array(
      	'headerHtmlOptions'=>array('style'=>'display:none'),
      	'name'=>'theme',
      	'htmlOptions'=>array('style'=>'width: 100px;'),
      ),
	  	array(
	  		'header'=>'Description',
	  		'name'=>'desc',
	  		// 'headerHtmlOptions'=>array('style'=>'width:450px'),
	  	),
	  	array(
				'header'            => 'Action',
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-ok-circle\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('theme/activate') . '?id=".$data["name"]',
				'headerHtmlOptions' => array('colspan'=>'1', 'style'=>'text-align: center;'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Activate',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Activate',
      		'onclick'=>"return confirm('Anda yakin ingin mengaktifkan theme ini?')"
      	)
	    ),
			/*array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-remove\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('theme/delete') . '?id=".$data["name"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
					'alt'=>'Delete',
					'rel'=>'tooltip',
					'data-original-title'=>'Delete',
					'onclick'=>"return confirm('Anda yakin ingin menghapus theme ini?')"
				)
			),*/
		)
	))); ?>
</div>