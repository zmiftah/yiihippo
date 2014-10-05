<style>
	.row .span5{ width:340px; }
	.button{ margin-bottom:10px; }
</style>

<script>
//<![CDATA[
	function load_widget(id, container) {
		$.ajax({
			url: '<?php echo Yii::app()->baseUrl."/admin/widget/form.php" ?>',
			data: { id:id }
		}).done(function(val){
			if(id==2) console.log(val)
			$(container).html(val)
		});
	}
//]]>
</script>

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

  <div class="button">
	  <a href="<?php echo $this->createUrl('widget/index') ?>" class="btn" id="showWidget">
	    <i class="icon-arrow-left"></i> Back
	  </a>
	</div>

  <div class="row">
  	<div class="span5">
  		<div class="accordion" id="leftwidget">
  			
			  <?php foreach ($widgets as $key => $widget) {
			  	$id = $widget['id'];
			  	if ($id % 2 == 1) {
			  		$label = str_replace(' ', '_', strtolower($widget['name']));
			  		echo BootstrapHelper::createAccordion('leftwidget', $label, $widget['name'], '<div id="widget'.$id.'"></div>', $widget['show']);
			  	}
			  } ?>
			  
			</div>
  	</div>

  	<div class="span5">
  		<div class="accordion" id="rightwidget">
			<?php foreach ($widgets as $key => $widget) {
		  	$id = $widget['id'];
		  	if ($id % 2 == 0) {
		  		$label = str_replace(' ', '_', strtolower($widget['name']));
		  		echo BootstrapHelper::createAccordion('rightwidget', $label, $widget['name'], '<div id="widget'.$id.'"></div>', $widget['show']);
		  	}
		  } ?>
		  </div>
  	</div>
  </div>

</div>

<script>
//<![CDATA[
	$(document).ready(function(){
		<?php foreach ($widgets as $key => $widget): ?>
			<?php $id = $widget['id'] ?>
		load_widget(<?php echo $id ?>, '#widget<?php echo $id ?>')
		<?php endforeach ?>
	});
//]]>
</script>