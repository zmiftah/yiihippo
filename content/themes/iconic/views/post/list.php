<?php foreach( $posts as $article ): ?>
<?php 
	$id 		  = $article->post_id;
	$url      = $this->createPermalink($article->url, $article->created);
	$title    = $article->title;
	$excerpt  = substr(strip_tags($article->content),0,350);
	$datetime = date('c', strtotime($article->created));
	$date     = date('F d, Y', strtotime($article->created));
	$time     = date('g:i a', strtotime($article->created));
	$comments = $article->commentCount;
	$featured = ( $article->featured ) 
		? MediaHelper::getFileThumbnail(array(
			'name'=>$article->featured->name,
			'url'=>$article->featured->url
			), 175, 140)
		: false;
?>
<article id="post-<?php echo $id ?>" class="post-<?php echo $id ?> post type-post status-publish format-standard hentry clearfix blog-style">
	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php echo $url ?>" title="<?php echo $title ?>" rel="bookmark"><?php echo $title ?></a>
		</h2>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<div class="excerpt-thumb">
			<?php if ($featured): ?>
				 <a href="<?php echo $url ?>" title="Permalink to <?php echo $title ?>" rel="bookmark">
	        <img src="<?php echo $featured ?>" class="alignleft wp-post-image" title="<?php echo $title ?>" />
	      </a>
			<?php endif ?>
  	</div>
		<p><?php echo $excerpt.' [..]' ?></p>
	</div><!-- .entry-summary -->

	<footer class="entry-meta">
		<span>Category: <?php $this->widget('application.components.widgets.AbGetCategoriesWidget', array(
      'categories'=>$article->categories[0]
    )) ?></span>
    <span>Tag: <?php $this->widget('application.components.widgets.AbGetTagsWidget', array(
      'tags'=>$article->tags[0]
    )) ?></span>
    <!-- <span>Tags: </span> -->
  </footer><!-- .entry-meta -->
</article><!-- #post-<?php echo $id ?> -->
<?php endforeach; ?>

<nav id="nav-below" class="navigation" role="navigation">
	<div class="assistive-text">Post navigation</div>
	<div class="nav-previous alignleft"><a href="http://localhost/wordpress/page/3/" ><span class="meta-nav">&larr;</span> Older posts</a></div>
	<div class="nav-next alignright"><a href="http://localhost/wordpress/" >Newer posts <span class="meta-nav">&rarr;</span></a></div>
</nav><!-- #nav-below .navigation -->