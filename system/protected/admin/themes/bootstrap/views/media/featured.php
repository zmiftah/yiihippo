<style>
	.button-left {
		text-align: left;
		margin: 10px auto;
	}

	#wrapper {
		width: 90%;
		max-width: 520px;
		min-width: 300px;
		margin: auto auto;
	}

	#columns {
		-webkit-column-count: 3;
		-webkit-column-gap: 10px;
		-webkit-column-fill: auto;
		-moz-column-count: 3;
		-moz-column-gap: 10px;
		-moz-column-fill: auto;
		column-count: 3;
		column-gap: 15px;
		column-fill: auto;
	}

	.pin {
		display: inline-block;
		background: #FEFEFE;
		border: 2px solid #FAFAFA;
		box-shadow: 0 1px 2px rgba(34, 25, 25, 0.4);
		margin: 0 2px 15px;
		-webkit-column-break-inside: avoid;
		-moz-column-break-inside: avoid;
		column-break-inside: avoid;
		padding: 10px;
		padding-bottom: 5px;
		background: -webkit-linear-gradient(45deg, #FFF, #F9F9F9);
		opacity: 1;
		
		-webkit-transition: all .2s ease;
		-moz-transition: all .2s ease;
		-o-transition: all .2s ease;
		transition: all .2s ease;
	}

	.pin img {
		/*width: 100%;*/
		border-bottom: 1px solid #ccc;
		padding-bottom: 15px;
		margin-bottom: 5px;
	}

	.pin p {
		text-align: justify;
		font: 12px/18px Arial, sans-serif;
		color: #333;
		margin: 0;
	}

	#columns:hover .pin:not(:hover) {

		opacity: 0.4;
	}
</style>

<div id="wrapper">
	<!-- <div class="button-left"><a href="#" class="btn">Select</a></div> -->

	<div id="columns">
		<?php foreach ($images as $image): ?>
		<?php $url = Yii::app()->baseUrl . $image->url ?>
		<?php $size = filesize(dirname(dirname(Yii::app()->basePath)).$image->url) ?>
		<div class="pin">
			<a href="javascript:void(0)" onclick="selectImage(<?php echo $image->link_id ?>)">
				<img src="<?php echo $url ?>" width="100" class="img-polaroid">
			</a>
			<p>
				<strong>File name</strong>: <span id="fileName"><?php echo $image->name ?></span> <br>
				<strong>File type</strong>: <span id="fileType"><?php echo $image->content_type ?></span> <br>
				<strong>File size</strong>: <span id="fileSize"><?php echo SizeHelper::calculate($size) ?></span> <br>
			</p>
		</div>
		<?php endforeach ?>
	</div>
</div>