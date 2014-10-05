<?php 
  $id = $post->post_id;
  $this->pageTitle = $post->title;

  // Update view
  $post->viewArticle();
 
  $permalink = Yii::app()->baseUrl.'/'.$this->createPermalink($post->url, $post->created);
  $date = strtotime($post->created);
  $categories = $post->categories[0];
  $request = Yii::app()->request->requestUri;
  $content = $this->converShortCode($post->content);
?>

<style>
  #errorText{ color:red; text-align:center; }
  .banner-content{ margin: 20px auto 20px 0px; }
</style>

<div id="single-content" class="div-content">
  <?php $this->widget($this->bannerWidgetLocation, array(
    'posititon'=>1, 'width'=>572
  )) ?>

  <article id="post-<?php echo $post->post_id ?>" class="post-<?php echo $id ?> post type-post status-publish format-standard hentry">
    <header class="entry-header">
      <div class="entry-meta single-meta-above-title">
        posted on <span class="date">
          <a href="<?php echo $permalink ?>" title="<?php echo date('H:i a', $date) ?>" rel="bookmark">
            <time class="entry-date" datetime="<?php echo date('c', $date) ?>" pubdate="pubdate"><?php echo date('F d, Y', $date) ?></time>
          </a>
        </span>
      </div>
      <h1 class="entry-title"><?php echo $post->title ?></h1>
      <div class="border clearfix">
        <div class="entry-meta single-meta-below-title alignleft">
          Filed under 
          <?php $this->widget('application.components.widgets.AbGetCategoriesWidget', array(
            'categories'=>$categories
          )) ?>
        </div>                            
        <div class="comments-link alignright entry-meta">
          <a href="<?php echo $permalink ?>#comments" title="Comment on <?php echo $post->title ?>">
            <span class="leave-reply"><?php echo $post->commentCount ?></span>
          </a>
        </div>
      </div>
      <div class="share"></div>
    </header><!-- .entry-header -->

    <div class="entry-content">
      <?php echo $content ?>
      <div class="clear"></div>      
    </div><!-- .entry-content -->
  </article><!-- #post-<?php echo $id ?> -->

  <?php $this->widget($this->bannerWidgetLocation, array(
    'posititon'=>3, 'width'=>572
  )) ?>

  <?php $this->widget($this->commentWidgetLocation, array(
    'postId'=>$id
  )) ?>

  <div id="comments">
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
          <label for="author">Name</label> <span class="required">*</span>
          <input id="author" name="author" type="text" value="<?php echo $_POST['author'] ?>" size="30" required="true">
        </p>
        <p class="comment-form-email">
          <label for="email">Email</label> <span class="required">*</span>
          <input id="email" name="email" type="text" value="<?php echo $_POST['email']  ?>" size="30" required="true">
        </p>
        <p class="comment-form-website">
          <label for="website">Website</label>
          <input id="website" name="website" type="text" value="<?php echo $_POST['website']  ?>" size="30">
        </p>
        <p class="comment-form-comment">
          <label for="comment">Comment</label> <span class="required">*</span>
          <textarea id="comment" name="comment" cols="45" rows="8" required="true"><?php echo $_POST['comment']  ?></textarea>
        </p>                       

        <div class="form-allowed-tags">
          You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:  
          <code>&lt;a href="" title="" rel=""&gt; &lt;abbr title=""&gt; &lt;acronym title=""&gt; &lt;b&gt; &lt;blockquote cite=""&gt; &lt;cite&gt; &lt;code&gt; &lt;del datetime=""&gt; &lt;em&gt; &lt;i&gt; &lt;q cite=""&gt; &lt;strike&gt; &lt;strong&gt; </code>
        </div>                     

        <p class="form-submit">
          <input name="submit" type="submit" id="submit" value="Post Comment">
          <input type="hidden" name="comment_post_ID" value="<?php echo $id ?>" id="comment_post_ID">
          <input type="hidden" name="comment_parent" id="comment_parent" value="<?php echo $parentId ?>">
          <input type="hidden" name="post_url" value="<?php echo $permalink ?>" id="post_url">
        </p>
      <?php $this->endWidget(); ?>
    </div><!-- #respond -->             
  </div><!-- #comments -->
</div><!-- #content -->