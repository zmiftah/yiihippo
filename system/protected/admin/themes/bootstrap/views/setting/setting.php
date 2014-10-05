<script>
	var image = '<div style="text-align:center; padding:0;">'
	image += '<img src="<?php echo $this->assetsBase ?>/img/loading.gif">'
	image += '</div>'

	generalTab = function(e){
		$('#generalTab').html(image)
		$.ajax({
			url:'<?php echo $this->createUrl('setting/general') ?>'
		}).done(function(html){
			$('#generalTab').html(html)
		})
	}

	seoTab = function(e){
		$('#seoTab').html(image)
		$.ajax({
			url:'<?php echo $this->createUrl('setting/seo') ?>'
		}).done(function(html){
			$('#seoTab').html(html)
		})
	}

	permaTab = function(e){
		$('#permaTab').html(image)
		$.ajax({
			url:'<?php echo $this->createUrl('setting/permalink') ?>'
		}).done(function(html){
			$('#permaTab').html(html)
		})
	}

	socmedTab = function(e){
		$('#socmedTab').html(image)
		$.ajax({
			url:'<?php echo $this->createUrl('setting/socmed') ?>'
		}).done(function(html){
			$('#socmedTab').html(html)
		})
	}

	codeTab = function(e){
		$('#codeTab').html(image)
		$.ajax({
			url:'<?php echo $this->createUrl('setting/code') ?>'
		}).done(function(html){
			$('#codeTab').html(html)
		})
	}

	$(document).ready(function(){
		// $('.tabbable').children('ul').children('li').removeClass('active');
		<?php switch (Yii::app()->user->getFlash('tab')) {
			case "code":
				$tab5Active = ' class="active"';
				$tab5 = ' active';
				echo "codeTab();";
				break;
			case "socmed":
				$tab4Active = ' class="active"';
				$tab5 = ' active';
				echo "socmedTab();";
				break;
			case "permalink":
				$tab3Active = ' class="active"';
				$tab5 = ' active';
				echo "permaTab();";
				break;
			case "seo":
				$tab2Active = ' class="active"';
				$tab5 = ' active';
				echo "seoTab();";
				break;
			default:
				$tab1Active = ' class="active"';
				$tab5 = ' active';
				echo "generalTab();";
				break;
		} ?>


		$('#tab1').click(generalTab);
		$('#tab2').click(seoTab);
		$('#tab3').click(permaTab);
		$('#tab4').click(socmedTab);
		$('#tab5').click(codeTab);
	})
</script>

<div class="setting">
	<div class="tabbable">
	  <ul class="nav nav-tabs">
	    <li<?php echo $tab1Active ?>><a id="tab1" href="#generalTab" data-toggle="tab">General</a></li>
	    <li<?php echo $tab2Active ?>><a id="tab2" href="#seoTab" data-toggle="tab">SEO</a></li>
	    <li<?php echo $tab3Active ?>><a id="tab3" href="#permaTab" data-toggle="tab">Permalink</a></li>
	    <li<?php echo $tab4Active ?>><a id="tab4" href="#socmedTab" data-toggle="tab">Social Media</a></li>
	    <li<?php echo $tab5Active ?>><a id="tab5" href="#codeTab" data-toggle="tab">Code / Adsense</a></li>
	  </ul>
	  <div class="tab-content">
	    <div class="tab-pane<?php echo $tab5 ?>" id="generalTab"></div>
	    <div class="tab-pane<?php echo $tab5 ?>" id="seoTab"></div>
	    <div class="tab-pane<?php echo $tab5 ?>" id="permaTab"></div>
	    <div class="tab-pane<?php echo $tab5 ?>" id="socmedTab"></div>
	    <div class="tab-pane<?php echo $tab5 ?>" id="codeTab"></div>
	  </div>
	</div>
</div>