<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    window.jQuery || document.write('<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/vendor/jquery-1.9.1.min.js"><\/script>')
</script>

<!-- script src="<?php //echo Yii::app()->theme->baseUrl ?>/assets/js/main.js"></script -->
<script src='<?php echo Yii::app()->theme->baseUrl ?>/assets/js/swift-js.min.js'></script>

<?php if (!empty($this->googleAnalytic)){
	echo $this->googleAnalytic;
} ?>