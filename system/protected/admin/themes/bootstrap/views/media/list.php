<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'media-form',
	)); ?>
		<fieldset>
		    <legend><i class="icon-fixed-width icon-camera"></i> Pustaka Media <small>Total: <?=$total?></small></legend>
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

	  <a href="<?php echo $this->createUrl('media/upload') ?>" class="btn btn-success">
	    <i class="icon-plus"></i> Add New
	  </a>

	  <?php $this->widget('bootstrap.widgets.TbGridView', array_merge( $config, array(
	    'columns' => array(
	    	array(
					'header'      => 'No',
					'value'       => '$row+"' . $offset . '"+1',
					'htmlOptions' => array('style'=>'width: 10px; text-align: right;'),
	    	),
	    	array(
        	'header'=>'File',
        	'type'=>'html',
        	'value'=>'MediaHelper::getThumbnail($data,32,32)',
        ),
        array(
        	'header'=>'Type',
        	'name'=>'content_type', 
        ),
        array(
        	'header'=>'File Url',
        	'class'=>'CLinkColumn',
        	'labelExpression'=>'"Link"',
        	'urlExpression'=>'$data["url"]',
        	'linkHtmlOptions'=>array('target'=>'_blank'),
        ),
        array(
        	'header'=>'Date',
        	'value'=>'date("Y-m-d", strtotime($data["created"]))',
        	'htmlOptions' => array('style'=>'width:75px;'),
        ),
	      array(
					'header'            => 'Action',
					'class'             => 'CLinkColumn',
					'labelExpression'   => '$data->isImage?"<i class=\"icon-thumbs-up\"></i>":""', 
					'urlExpression'     => '"'.$this->createUrl('media/thumbs').'?id=".$data["link_id"]',
					'headerHtmlOptions' => array('colspan'=>'3', 'style'=>'text-align: center;'),
					'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
					'linkHtmlOptions'   => array(
						'alt'                 => 'Create Thumbnail',
						'rel'                 => 'tooltip',
						'data-original-title' => 'Create Thumbnail'
        	)
	      ),
	      array(
					'class'             => 'CLinkColumn',
					'labelExpression'   => '"<i class=\"icon-zoom-in\"></i>"', 
					'urlExpression'     => '"'.$this->createUrl('media/detail').'?id=".$data["link_id"]',
					'headerHtmlOptions' => array('style'=>'display:none'),
					'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
					'linkHtmlOptions' => array(
						'alt'                 => 'View Detail',
						'rel'                 => 'tooltip',
						'data-original-title' => 'View Detail'
        	)
	      ),
	      array(
					'class'             => 'CLinkColumn',
					'labelExpression'   => '"<i class=\"icon-remove\"></i>"', 
					'urlExpression'     => '"'.$this->createUrl('media/delete').'?id=".$data["link_id"]',
					'headerHtmlOptions' => array('style'=>'display:none'),
					'htmlOptions'       => array(
						'style'   => 'width: 20px; text-align: center;',
						'onClick' => "return confirm('Anda Yakin akan menghapus media ini?')"
					),
					'linkHtmlOptions' => array(
						'alt'                 => 'Delete',
						'rel'                 => 'tooltip',
						'data-original-title' => 'Delete'
        	)
	      ),
	    ),
		))); ?>

	<?php $this->endWidget(); ?>
</div>