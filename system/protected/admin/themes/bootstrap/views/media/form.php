<style>
	.inputfile {
		margin-top: 30px;
	}
	.detail .file {
		margin-left: 25px;
	}
	.dim { 
		width: 30px;
		text-align: center;
	}
	.hiden {
		display: none;
	}
	#filename { 
		margin-bottom: 0;
	}
	#checkThumb {
		margin-top: 0;
	}
</style>

<script>
	$(document).ready(function(){
		$('.barfile').css('margin-bottom', '0px');
	});

	$(function() {
		var oFReader = new FileReader(),
				oFile = null;
				oFReader.onload = loadPreview;

		function onFileButton(e) {
			$('#fileupload').trigger('click');
		}

		function checkFile() {
			$('#message').html('<p class="text-success">Pesan Error</p>');
		}

		function getHTTPObject() {
	    if (typeof XMLHttpRequest != 'undefined') {
	       return new XMLHttpRequest();
	    }
	    try {
	       return new ActiveXObject("Msxml2.XMLHTTP");
	    } catch (e) {
        try {
          return new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {}
	    }
	    return false;
		}

		function onUploaderChange() {
			var val = $(this).val(),
				fname = val.split(/[\\/]/),
				fileName = fileExt = '';

			oFile = document.getElementById('fileupload').files[0];
			fileName = fname[fname.length-1];
			fileExt = fileName.substr(fileName.length-4, 4);
			$('#filename').val(fileName);
			$('#fileext').val(fileExt);
			oFReader.readAsDataURL(oFile);
		}

		function loadPreview(e) {
			var w = h = '';

			$('#imgPreview').attr('src', e.target.result);

			$('#fileName').html(oFile.name);
			$('#fileType').html(oFile.type);
			$('#fileSize').html(getSize(oFile.size));
			// w = $('#imgPreview').css('width').replace('px', '');
			// h = $('#imgPreview').css('height').replace('px', '');
			// $('#fileDimension').html(w + 'x' + h);
		}

		function getSize(size) {
			var sOutput = size, 
					aMultiples = ["KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"],
					nMultiple = 0, 
					nApprox = size / 1024;

		  for (nMultiple; nApprox > 1; nApprox /= 1024, nMultiple++) {
		    sOutput = nApprox.toFixed(3) + " " + aMultiples[nMultiple]; // + " (" + size + " bytes)";
		  }

		  return sOutput;
		}

		function showDimension() {
			$('.dimension').toggleClass('hiden');
		}

		$('#fileselectbutton').click( onFileButton );
		$('#fileupload').change( onUploaderChange );
		$('#checkThumb').on( 'click', showDimension );
	});
</script>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'          => 'media-form',
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>

		<fieldset>
		    <legend><i class="icon-fixed-width icon-camera"></i> Upload New Media</legend>
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

		<div class="row detail">
			<div class="span4">
				<img src="http://localhost/hiipopress/content/assets/img/450x450.gif" id="imgPreview" class="img-polaroid">
			</div>
			<div class="span4 file">
				<h4></h4>
				<strong>File name</strong>: <span id="fileName">-</span> <br>
				<strong>File type</strong>: <span id="fileType">-</span> <br>
				<strong>File size</strong>: <span id="fileSize">-</span> <br>
				<!-- <strong>Dimensions</strong>: <span id="fileDimension">-</span> -->
			</div>
		</div>
		
		<div class="control-group inputfile">
			<label for="upload">Upload a file <small>(Change filename)</small></label>
			<div class="controls">
				<input id="fileupload" type="file" name="fileupload" style="display: none;">
				<input id="fileext" type="text" name="fileext" style="display: none;">
				<input id="filename" type="text" name="filename" class="input span4 barfile" >
				<a id="fileselectbutton" class="btn">Find...</a>
			</div>
		</div>

		<div class="control-group">
			<label for="checkThumb">
				<input id="checkThumb" type="checkbox" name="checkThumb"> Create Thumbnail
			</label>
		</div>

		<div class="control-group dimension hiden">
			<label for="dw">Dimensions</label>
			<div class="controls">
				<input id="dw" type="text" name="dwidth" class="dim" value="80"> x 
				<input id="dh" type="text" name="dheight" class="dim" value="80"> pixels
			</div>
		</div>

		<div class="control-group">
			<a href="<?php echo $this->createUrl('media/index') ?>" class="btn">
				<i class="icon-arrow-left"></i> Back
			</a>
			
			<button name="submit" class="btn btn-primary" type="submit">
				<i class="icon-upload"></i> Upload
			</button>
		</div>

	<?php $this->endWidget(); ?>
</div>