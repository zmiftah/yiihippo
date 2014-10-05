<div id="blog-wrapper" class="div-content clearfix" style="margin-top:20px;">
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
			: Yii::app()->theme->baseUrl . '/assets/img/default.png';
	?>
	<article id="post-<?php echo $id ?>" class="post-<?php echo $id ?> post type-post status-publish format-standard hentry category-uncategorized clearfix blog-style">
		<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?php echo $url ?>" title="<?php echo $title ?>" rel="bookmark"><?php echo $title ?></a>
			</h2>
		</header><!-- .entry-header -->

		<div class="entry-summary clearfix">
			<a href="<?php echo $url ?>" title="<?php echo $title ?>">
				<img width="175" src="<?php echo $featured ?>" class="alignleft blog-thumb blog wp-post-image" alt="" title="<?php echo $title ?>" />
			</a>
			<?php echo $excerpt.' [..]' ?> 
			<a href="<?php echo $url ?>" class="swift-sc-button small continue-reading alignright">
				<span>Read More &rarr;</span>
			</a>
		</div><!-- .entry-summary -->
		
		<footer class="home entry-meta">
			<div class="entry-meta alignleft">
				posted on <span class="date">
					<a href="<?php echo $url ?>" title="<?php echo $time ?>" rel="bookmark">
						<time class="entry-date" datetime="<?php echo $datetime ?>" pubdate="pubdate">
							<?php echo $date ?>
						</time>
					</a>
				</span>
			</div>
			<div class="comments-link">
				<a href="<?php echo $url ?>#comments" title="Comment on <?php echo $title ?>">
					<span class="leave-reply"><?php echo $comments ?></span>
				</a>
			</div>
		</footer><!-- #entry-meta -->

		<div class="clear"></div>
	</article><!-- #post-<?php echo $id ?> -->
	<?php endforeach; ?>
	<div class="clear"></div>
</div><!-- /.div-content -->

<div class="div-content">
	<?php $this->widget('application.components.widgets.AbLinkPager', array(
		'header' => '',
		'pages' => $pages,
	)); ?>
</div>