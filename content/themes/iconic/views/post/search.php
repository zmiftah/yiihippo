<header class="archive-header">
	<h1 class="archive-title">Search Results for: <span><?php echo $_GET['s'] ?></span></h1>
</header><!-- .archive-header -->

<?php $siteUrl = Yii::app()->baseUrl ?>
<?php foreach( $posts as $article ): ?>
	<?php 
		$id 		  = $article->post_id;
		$url      = $siteUrl.'/'.$this->createPermalink($article->url, $article->created);
		$title    = $article->title;
		$excerpt  = $article->excerpt;
		$datetime = date('c', strtotime($article->created));
		$date     = date('F d, Y', strtotime($article->created));
		$time     = date('g:i a', strtotime($article->created));
		$featured = ( $article->featured ) 
			? Yii::app()->baseUrl . $article->featured->url 
			: Yii::app()->theme->baseUrl . '/assets/img/default.png';
	?>
	<article id="post-<?php echo $id ?>" class="post-<?php echo $id ?> post type-post status-publish format-standard hentry">
		<header class="entry-header">
			<h1 class="entry-title">
				<a href="<?php echo $url ?>" title="Permalink to <?php echo $title ?>" rel="bookmark"><?php echo $title ?></a>
			</h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<p><?php echo $excerpt ?></p>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<span>Category: <?php $this->widget('application.components.widgets.AbGetCategoriesWidget', array(
	      'categories'=>$article->categories[0]
	    )) ?></span>
	    <span>Tag: <?php $this->widget('application.components.widgets.AbGetTagsWidget', array(
	      'tags'=>$article->tags[0]
	    )) ?></span>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
<?php endforeach; ?>

<!-- <nav id="nav-below" class="navigation" role="navigation">
	<div class="assistive-text">Post navigation</div>
	<div class="nav-previous alignleft"><a href="http://localhost/wordpress/2013/06/17/page/2/"><span class="meta-nav">←</span> Older posts</a></div>
	<div class="nav-next alignright"></div>
</nav> --><!-- #nav-below .navigation -->