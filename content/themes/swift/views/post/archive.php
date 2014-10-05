<div id="blog-wrapper" class="div-content clearfix" style="padding-top: 20px;">
	<?php if (count($posts)>0): ?>
		<ul class="post-listing">
	  	<?php $siteUrl = Yii::app()->baseUrl ?>
	  	<?php foreach( $posts as $article ): ?>
		  	<?php 
					$id 		  = $article->post_id;
					$url      = $siteUrl.'/'.$this->createPermalink($article->url, $article->created);
					$title    = $article->title;
					$datetime = date('c', strtotime($article->created));
					$date     = date('F d, Y', strtotime($article->created));
					$time     = date('g:i a', strtotime($article->created));
					$featured = ( $article->featured ) 
						? Yii::app()->baseUrl . $article->featured->url 
						: Yii::app()->theme->baseUrl . '/assets/img/default.png';
				?>
				<li class="clearfix">
					<a href="<?php echo $url ?>" title="<?php echo $title ?>">
						<img src="<?php echo $featured ?>" class="alignleft thumb" width="48" height="48" title="#post_<?php echo $id ?>">
					</a>		
					<a href="<?php echo $url ?>" title="<?php echo $title ?>"><?php echo $title ?></a>
					<br>
					
					<!-- <span class="meta">Written by 
						<a href="http://localhost/wordpress/archives/author/zein-miftah" rel="author">Zein Miftah</a>
					</span> -->
					<span class="meta alignright">
						<a href="<?php echo $url ?>" title="<?php echo $time ?>" rel="bookmark">
							<time class="entry-date" datetime="<?php echo $datetime ?>"><?php echo $date ?></time>
						</a>
					</span>
					<div class="clear"></div>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title">Nothing Found</h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
			</div><!-- .entry-content -->
		</article>
	<?php endif ?>
	<div class="clear"></div>
</div>
<!-- /.div-content -->