<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'plugins-form',
	    'type'=>'horizontal',
	)); ?>

	<fieldset>
	    <legend><i class="icon-cogs"></i> Plugins</legend>
	</fieldset>

	<?php $this->widget('bootstrap.widgets.TbGridView', array(
	    'type'=>'striped bordered condensed hover',
	    'dataProvider'=> $data,
	    'template'=>"{items}",
	    'columns'=>array(
	    	array(
				'header'      => 'No',
				'value'       => '($row+1)."."',
				'htmlOptions' => array('style'=>'width: 10px; text-align: right;'),
	    	),
	    	array(
	    		'header'=>'Plugin',
	    		'class'             => 'CLinkColumn',
				'labelExpression'   => '$data["plugin"]',
				'linkHtmlOptions'   => array(
	        		'alt'=>'Detail',
	        		'rel'=>'tooltip',
	        		'data-original-title'=>'Detail'
	        	)
	    	),
	    	array(
	    		'header'=>'Description',
	    		'name'=>'desc',
	    		'headerHtmlOptions'=>array('style'=>'width:450px'),
	    	),
	    	array(
				'header'            => 'Action',
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-ok-circle\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('plugin/activate') . '?id=".$data["name"]',
				'headerHtmlOptions' => array('colspan'=>'3', 'style'=>'text-align: center;'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
	        		'alt'=>'Activate',
	        		'rel'=>'tooltip',
	        		'data-original-title'=>'Activate'
	        	)
	        ),
	        array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-retweet\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('plugin/update') . '?id=".$data["name"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
	        		'alt'=>'Update',
	        		'rel'=>'tooltip',
	        		'data-original-title'=>'Update'
	        	)
	        ),
	        array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-remove\"></i>"', 
				'urlExpression'     => '"' . $this->createUrl('plugin/delete') . '?id=".$data["name"]',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
	        		'alt'=>'Uninstall',
	        		'rel'=>'tooltip',
	        		'data-original-title'=>'Uninstall',
	        		'onclick'=>"return confirm('Anda yakin ingin menghapus plugin ini?')"
	        	)
	        ),
	    ),
	)); ?>

	<?php $this->endWidget(); ?>
</div><!-- form -->