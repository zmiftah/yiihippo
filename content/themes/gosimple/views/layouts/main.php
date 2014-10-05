<!DOCTYPE html>
<html lang="en-US">
<!-- BEGIN head -->
	<head>
		<?php $this->doEvent('doSetupHead'); ?>
	</head>
	<body class="home blog" style="">
		<div id="wrap" class="clearfix">
			<?php $this->doEvent('doLoadHeader'); ?>

			<?php echo $content; ?>

			<?php $this->doEvent('doLoadFooter') ?>
		</div>
		
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.form.min.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/scripts.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/devicepx-jetpack.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/hoverIntent.min.js"></script>
	</body>
</html>