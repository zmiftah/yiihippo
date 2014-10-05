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

<div class="entry clearfix">
	<div id="post-nextprev" class="clearfix">
		<div id="post-next" class="one-half">
			<?php if ($related['prev']['title']): ?>
			<a href="<?php echo $related['prev']['url'] ?>" rel="prev"><?php echo $related['prev']['title'] ?></a> &larr;
			<?php endif ?>
		</div>
  	<div id="post-prev" class="one-half remove-margin">
  		<?php if ($related['next']['title']): ?>
  		<a href="<?php echo $related['next']['url'] ?>" rel="next"><?php echo $related['next']['title'] ?></a> &rarr;
  		<?php endif ?>
  	</div>
  </div>
      
	<h1 class="single-title"><?php echo $title ?></h1>
  <div class="post-meta single-meta">
    Posted On <?php echo date('F d, Y', $date) ?> - 
    With <a href="<?php echo $permalink ?>#comments" title="Comment on <?php echo $title ?>"><?php echo $post->commentCount ?> Comments</a>
  </div>
  
	<article>
		<?php echo $content ?>
	</article>
  <div class="clear"></div>
  
  <div class="post-bottom">
    <div class="post-tags">
    	<?php $this->widget('application.components.widgets.AbGetTagsWidget', array(
	      'tags'=>$post->tags[0]
	    )) ?>
    </div>
  </div>
</div>

<?php $this->widget($this->bannerWidgetLocation, array(
  'posititon'=>3, 'width'=>670
)) ?>

<!-- You can start editing here. -->
<div id="commentsbox">
  <h3 id="comments">This Post Has <?php echo $post->commentCount ?> Comments</h3>

	<ol class="commentlist">
		<li class="comment even thread-even depth-1" id="comment-17">
			<div id="div-comment-17" class="comment-body">
				<div class="comment-author vcard">
					<img alt="" src="http://1.gravatar.com/avatar/f7465506d98bace66ec6ed488a1f24ad?s=40&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D40&amp;r=G" class="avatar avatar-40 photo" height="40" width="40">
					<cite class="fn">Anonim</cite>
					<span class="says">says:</span>
				</div>
				<em class="comment-awaiting-moderation">Your comment is awaiting moderation.</em><br>
				<div class="comment-meta commentmetadata">
					<a href="http://wpexplorer-demos.com/gopress/2013/06/24/santorini-blue/#comment-17">January 15, 2014 at 3:26 am</a>
				</div>
				<p>Test</p>
				<div class="reply">
					<a class="comment-reply-link" href="/gopress/2013/06/24/santorini-blue/?replytocom=17#respond" onclick="return addComment.moveForm(&quot;div-comment-17&quot;, &quot;17&quot;, &quot;respond&quot;, &quot;3848&quot;)">Reply</a>
				</div>
			</div>
		</li><!-- #comment-## -->
		<li class="comment odd alt thread-odd thread-alt depth-1" id="comment-18">
			<div id="div-comment-18" class="comment-body">
				<div class="comment-author vcard">
					<img alt="" src="http://1.gravatar.com/avatar/f7465506d98bace66ec6ed488a1f24ad?s=40&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D40&amp;r=G" class="avatar avatar-40 photo" height="40" width="40">
					<cite class="fn">Anonim</cite>
					<span class="says">says:</span>
				</div>
				<em class="comment-awaiting-moderation">Your comment is awaiting moderation.</em><br>
				<div class="comment-meta commentmetadata">
					<a href="http://wpexplorer-demos.com/gopress/2013/06/24/santorini-blue/#comment-18">January 15, 2014 at 7:44 am</a>
				</div>
				<p>Testing</p>
				<div class="reply">
					<a class="comment-reply-link" href="/gopress/2013/06/24/santorini-blue/?replytocom=18#respond" onclick="return addComment.moveForm(&quot;div-comment-18&quot;, &quot;18&quot;, &quot;respond&quot;, &quot;3848&quot;)">Reply</a>
				</div>
			</div>
		</li><!-- #comment-## -->
	</ol>

	<div class="comment-nav">
		<div class="alignleft"></div>
		<div class="alignright"></div>
	</div>

	<div id="comment-form">
		<div id="respond">
			<h3 id="comments-respond">
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
				<input type="text" name="author" id="author" value="<?php echo $_POST['author'] ?>" onfocus="if(this.value=='Username*')this.value='';" onblur="if(this.value=='')this.value='Username*';" size="22" tabindex="1">
				<br>
				<input type="text" name="email" id="email" value="<?php echo $_POST['email'] ?>" onfocus="if(this.value=='Email*')this.value='';" onblur="if(this.value=='')this.value='Email*';" size="2" tabindex="2">
				<br>
				<input type="text" name="url" id="url" value="<?php echo $_POST['website'] ?>" onfocus="if(this.value=='Website')this.value='';" onblur="if(this.value=='')this.value='Website';" size="2" tabindex="3">
				<br>
				<textarea name="comment" id="comment" rows="10" tabindex="4"><?php echo $_POST['comment'] ?></textarea><br>
				<button type="submit" id="commentSubmit" class="button light-gray">
					<span>Add Comment</span>
				</button>

				<input type="hidden" name="comment_post_ID" value="3848" id="comment_post_ID">
				<input type="hidden" name="comment_parent" id="comment_parent" value="0">
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>