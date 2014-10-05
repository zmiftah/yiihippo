<?php 
	$id    = $post->post_id;
	$title = $post->title;
  $this->pageTitle = $title;

  // Update view
  $post->viewArticle();
 
  $permalink = Yii::app()->baseUrl.'/'.$this->createPermalink($post->url, $post->created);
  $date = strtotime($post->created);
  $request = Yii::app()->request->requestUri;
  $related = $post->getRelatedArticle();
  $content = $this->converShortCode($post->content);
?>
<?php $this->widget($this->bannerWidgetLocation, array(
  'posititon'=>1, 'width'=>670
)) ?>

<article id="post-<?php echo $id ?>" class="post-<?php echo $id ?> post type-post status-publish format-standard hentry">
	<header class="entry-header">
		<h1 class="entry-title"><?php echo $title ?></h1>			
		<div class="below-title-meta">
			<div class="adt">
       <?php echo date('F d, Y', $date) ?>
      </div>
	 		<div class="adt-comment">
	 			<a class="link-comments" href="<?php echo $permalink ?>#comments"><?php echo $post->commentCount ?> Comment</a></span> 
      </div>       
   	</div><!-- below title meta end -->					
	</header><!-- .entry-header -->

	<div class="entry-content">
		<p>
			<?php echo $content ?>
		</p>
	</div><!-- .entry-content -->
		
	<footer class="entry-meta">
		<span>Category: <?php $this->widget('application.components.widgets.AbGetCategoriesWidget', array(
      'categories'=>$post->categories[0]
    )) ?></span>
    <span>Tag: <?php $this->widget('application.components.widgets.AbGetTagsWidget', array(
      'tags'=>$post->tags[0]
    )) ?></span>
  </footer><!-- .entry-meta -->
</article><!-- #post -->

<?php $this->widget($this->bannerWidgetLocation, array(
  'posititon'=>3, 'width'=>670
)) ?>

<nav class="nav-single">
	<div class="assistive-text">Post navigation</div>
	<span class="nav-previous">
		<?php if ($related['prev'] != null): ?>
		<a href="<?php echo $related['prev']['url'] ?>" rel="prev"><span class="meta-nav">&larr;</span> <?php echo $related['prev']['title'] ?></a>
		<?php endif ?>
	</span>
	<span class="nav-next">
		<?php if ($related['next'] != null): ?>
		<a href="<?php echo $related['next']['url'] ?>" rel="next"><?php echo $related['next']['title'] ?> <span class="meta-nav">&rarr;</span></a>
		<?php endif ?>
	</span>
</nav><!-- .nav-single -->

<?php $this->widget($this->commentWidgetLocation, array(
  'postId'=>$id
)) ?>

<div id="comments" class="comments-area">
	<div id="respond">
		<h3 id="reply-title">
			<?php $errorText = Yii::app()->user->getFlash('error') ?>
      <?php if (!empty($errorText)): ?>
        <div class="errorText"><?php echo $errorText ?></div>
      <?php else: ?>
        Leave a Reply
      <?php endif ?>
		</h3>
		<?php $form = $this->beginWidget('CActiveForm', array(
      'id'=>'commentform',
      'action'=>$request,
    )); ?>
			<p class="comment-notes">
				<?php $message = Yii::app()->user->getFlash('message') ?>
        <?php if (empty($message)): ?>
          Your email address will not be published. Required fields are marked <span class="required">*</span>
        <?php else: ?>
          <strong><?php echo $message ?></strong>
        <?php endif ?>
			</p>
			<p class="comment-form-author">
				<label for="author">Name <span class="required">*</span></label>
				<input id="author" name="author" type="text" value="<?php echo $_POST['author'] ?>" size="30" required />
			</p>
			<p class="comment-form-email">
				<label for="email">Email <span class="required">*</span></label>
				<input id="email" name="email" type="text" value="<?php echo $_POST['email']  ?>" size="30" required />
			</p>
			<p class="comment-form-url">
				<label for="website">Website</label>
				<input id="website" name="website" type="text" value="<?php echo $_POST['website']  ?>" size="30" />
			</p>
			<p class="comment-form-comment">
				<label for="comment">Comment</label>
				<textarea id="comment" name="comment" cols="45" rows="8" required><?php echo $_POST['comment']  ?></textarea>
			</p>
			<p class="form-submit">
				<input name="submit" type="submit" id="submit" value="Post Comment" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id ?>" id="comment_post_ID">
          <input type="hidden" name="comment_parent" id="comment_parent" value="<?php echo $parentId ?>">
          <input type="hidden" name="post_url" value="<?php echo $permalink ?>" id="post_url">
			</p>
		<?php $this->endWidget(); ?>
	</div><!-- #respond -->				
</div><!-- #comments .comments-area -->