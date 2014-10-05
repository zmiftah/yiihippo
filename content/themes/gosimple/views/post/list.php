<div id="slider-wrap">
	<div id="home-slides" class="slides clearfix">
		<div class="slides_container" style="overflow: hidden; position: relative; display: block;">
      <div class="slides_control" style="position: relative; width: 2760px; height: 343px; left: -920px;">
      	<div class="slide" style="position: absolute; top: 0px; left: 920px; z-index: 0; height: auto;">
        	<img src="./GoPress_files/houses-slide-660x343.jpg" alt="Slide 3" width="660" height="343">
        </div>
        <div class="slide" style="position: absolute; top: 0px; left: 920px; z-index: 0; height: auto; display: none;">
        	<img src="./GoPress_files/boat-slide-660x343.jpg" alt="Slide 2" width="660" height="343">
        </div>
        <div class="slide" style="position: absolute; top: 0px; left: 920px; z-index: 0; height: auto; display: none;">
        	<img src="./GoPress_files/balloon-slide-660x343.jpg" alt="Slide 1" width="660" height="343">
        </div>
      </div>
  	</div>
  	<a href="http://wpexplorer-demos.com/gopress/#" class="prev">Prev</a>
  	<a href="http://wpexplorer-demos.com/gopress/#" class="next">Next</a>
		<ul class="pagination">
			<li class="current"><a href="http://wpexplorer-demos.com/gopress/#0">1</a></li>
			<li class=""><a href="http://wpexplorer-demos.com/gopress/#1">2</a></li>
			<li class=""><a href="http://wpexplorer-demos.com/gopress/#2">3</a></li>
		</ul>
	</div>
</div>

<?php $num = 0; ?>
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
	$num++;
	$addClass = ($num % 2)==0? 'remove-margin': '';
?>

<div class="loop-entry clearfix <?php echo $addClass ?>">
  <div class="loop-entry-thumbnail">
		<a href="<?php echo $url ?>" title="<?php echo $title ?>">
			<img width="315" height="252" src="<?php echo $featured ?>" class="attachment-post-image wp-post-image" alt="<?php echo $title ?>">
		</a>
	</div>
	<h2>
		<a href="<?php echo $url ?>" title="<?php echo $title ?>"><?php echo $title ?></a>
	</h2>
	<div class="post-meta">
		Posted On <?php echo $date ?> - <a href="<?php echo $url ?>#comments" title="Comment on <?php echo $title ?>"><?php echo $comments ?> Comments</a>
	</div>
	<p><?php echo $excerpt.' ...' ?></p>
</div>

<?php if (!empty($addClass)): ?>
<div class="clear"></div> 	
<?php endif ?>

<?php endforeach; ?>