<div class="form">
	<fieldset>
	    <legend><i class="icon-fixed-width icon-comments"></i> Daftar Komentar <small>Total: <?=$total?></small></legend>
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

	<div>
		<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
			'size'=>'mini',
			'buttons'=>array(
				array(
					'label'=>'All',
					'url'=>$this->createUrl('comment/index'),
					'active'=>!isset($_GET['sort'])
				),
				array(
					'label'=>'Pending',
					'url'=>$this->createUrl('comment/index', array('sort'=>'pending')),
					'active'=>$_GET['sort']=='pending'
				),
				array(
					'label'=>'Approved',
					'url'=>$this->createUrl('comment/index', array('sort'=>'approve')),
					'active'=>$_GET['sort']=='approve'
				),
				array(
					'label'=>'Spam',
					'url'=>$this->createUrl('comment/index', array('sort'=>'spam')),
					'active'=>$_GET['sort']=='spam'
				),
				array(
					'label'=>'Trash',
					'url'=>$this->createUrl('comment/index', array('sort'=>'trash')),
					'active'=>$_GET['sort']=='trash'
				),
			),
		)); ?>
	</div>

  <?php $this->widget('bootstrap.widgets.TbGridView', array_merge( $config, array(
		'columns' => array(
    	array(
				'header'      => 'No',
				'value'       => '$row+"' . $offset . '"+1',
				'htmlOptions' => array('style'=>'width: 10px; text-align: right;'),
    	),      array(
      	'header'=>'From',
      	'class'=>'CLinkColumn',
      	'labelExpression'=>'$data["author"]', 
      	'linkHtmlOptions'=>array('target'=>'_blank'),
      	'urlExpression'=>'"mailto:" . $data["email"]',
      ),
      array(
      	'header'=>'Comment',
      	// 'type'=>'value',
      	'value'=> 'substr($data["content"],0,50)."..."'
      ),
      array(
      	'header'=>'Response To',
      	'class'=>'CLinkColumn',
      	'labelExpression'=>'substr($data->post["title"],0,17)."..."',
      	'linkHtmlOptions'=>array('target'=>'_blank'),
      	'urlExpression'=>'Yii::app()->controller->createPermalink($data->post->url, $data->post->created)."#comment-".$data->comment_id',
      ),
      array(
      	'header'=>'Date',
      	'value'=>'date("Y-m-d",strtotime($data["date_insert"]))',
      	'htmlOptions'=>array('style'=>'text-align:center;width:65px;')
      ),
      array(
				'header'            => 'Action',
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-edit\"></i>"', 
				'urlExpression'     => 'Yii::app()->controller->createUrl("comment/edit", array(
					"id"=>$data["comment_id"],"sort"=>"'.$_GET['sort'].'"
				))',
				'headerHtmlOptions' => array('colspan'=>'5', 'style'=>'text-align: center;'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Edit',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Edit'
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-reply\"></i>"', 
				'urlExpression'     => 'Yii::app()->controller->createUrl("comment/reply", array(
					"id"=>$data["comment_id"],"sort"=>"'.$_GET['sort'].'"
				))',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Reply',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Reply'
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-thumbs-up\"></i>"', 
				'urlExpression'     => 'Yii::app()->controller->createUrl("comment/approve", array(
					"id"=>$data["comment_id"],"sort"=>"'.$_GET['sort'].'"
				))',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Approve',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Approve'
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-inbox\"></i>"', 
				'urlExpression'     => 'Yii::app()->controller->createUrl("comment/spam", array(
					"id"=>$data["comment_id"],"sort"=>"'.$_GET['sort'].'"
				))',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Mark As Spam',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Mark As Spam'
      	)
      ),
      array(
				'class'             => 'CLinkColumn',
				'labelExpression'   => '"<i class=\"icon-'.($_GET['sort']=='trash'?'remove':'trash').'\"></i>"', 
				'urlExpression'     => 'Yii::app()->controller->createUrl("comment/trash", array(
					"id"=>$data["comment_id"],"sort"=>"'.$_GET['sort'].'"
				))',
				'headerHtmlOptions' => array('style'=>'display:none'),
				'htmlOptions'       => array('style'=>'width: 20px; text-align: center;'),
				'linkHtmlOptions'   => array(
      		'alt'=>'Delete',
      		'rel'=>'tooltip',
      		'data-original-title'=>'Delete',
      		'onclick'=>"return confirm('Anda yakin ingin menghapus komentar ini?')",
      	)
      )
	  )
	))); ?>
</div>