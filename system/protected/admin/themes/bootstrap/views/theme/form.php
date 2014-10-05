<script>
	clearFileInput = function(selector){
	    var oldFile = document.getElementById(selector),
	    		newFile = document.createElement("input")
	     
	    newFile.type = "file"
	    newFile.id = oldFile.id
	    newFile.name = oldFile.name
	    newFile.className = oldFile.className
	    newFile.style.cssText = oldFile.style.cssText
	    newFile.accept = oldFile.accept
	     
	    oldFile.parentNode.replaceChild(newFile, oldFile)
	}

	createXHRObject = function () {
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

	getThemeFile = function(){
		return document.getElementById('theme').files[0]
	}

	uploadFile = function(theme, progId) {
		var fd = new FormData(),
				progress = $(progId),
				xhr = createXHRObject()

		fd.append("theme", theme)
		fd.append("upload", 1)

		xhr.upload.addEventListener("progress", function(e) {
			if ( e.lengthComputable ) {
				var percentage = Math.round((e.loaded * 100) / e.total)
				if ( percentage == 100 ) {
					progress.html('Sedang mengekstrak theme file. Silakan tunggu ...')
				} else {
					progress.html('Progress upload ... '+percentage+'%')
				}
			}
		}, false)

		xhr.addEventListener("error", function(e) {
			var json = $.parseJSON(e.target.response)
			progress.attr('class', 'text-error')
			progress.html(json.text)
		}, false)

		xhr.addEventListener("load", function(e) {
			var json = $.parseJSON(e.target.response)
			progress.attr('class', 'text-success')
			progress.html(json.text)
			location.href = 'index.php'
		}, false)

		xhr.open("POST", "<?php echo $this->createUrl('theme/upload') ?>");
		xhr.send(fd);
	}

	onChangeFile = function(e){
		if (getThemeFile().name.split('.').pop() !== 'zip') {
			alert('Ekstensi file harus zip')
			clearFileInput('theme')

			return false
		} else {
			return true
		}
	}

	onSubmitForm = function(e){
		//if ( onChangeFile() ) {
			var theme = getThemeFile()
			uploadFile(theme, '#uploadinfo')
		//}
	}

	$(document).ready(function(){
		$('#theme').on('change', onChangeFile)
		$('#uploadbtn').on('click', onSubmitForm)
	})
</script>

<div class="form">
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<fieldset>
		    <legend><i class="icon-fixed-width icon-list-alt"></i> Upload Theme</legend>
		</fieldset>

		<div class="control-group">
			<label class="control-label" for="theme">Select Theme File</label>
			<div class="controls">
				<?php echo CHtml::fileField('theme','',array(
					'accept'=>'application/zip|application/octet-stream'
				)) ?>
				<div class="help-block">
					<p class="text-error">* Pastikan file ber ekstensi zip archive</p>
					<p id="uploadinfo"></p>
				</div>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<button name="upload" class="btn btn-primary" type="button" id="uploadbtn">
					<i class="icon-upload"></i> Upload 
				</button>
			</div>
		</div>
	</form>
</div>