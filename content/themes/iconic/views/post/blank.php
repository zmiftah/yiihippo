<article id="post-0" class="post error404 no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title">Page not found!</h1>
	</header>

	<div class="entry-content">
		<p>Kindly search your topic below.</p>
		<form role="search" method="get" id="searchform" action="<?php echo Yii::app()->baseUrl ?>/search/">
			<div>
				<label class="screen-reader-text" for="s">Search for:</label>
				<input type="text" value="<?php echo $_GET['s'] ?>" name="s" id="s">
				<input type="submit" id="searchsubmit" value="Search">
			</div>
		</form>
	</div><!-- .entry-content -->
</article>