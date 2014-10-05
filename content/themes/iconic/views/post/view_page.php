<?php $this->pageTitle = $post->title ?>

<style>
  .site-content{ width: 96%; }
</style>

<article id="post-<?php echo $post->post_id ?>" class="post-<?php echo $post->post_id ?> page type-page status-publish hentry">
  <header class="entry-header">
    <h1 class="entry-title"><?php echo $post->title ?></h1>
  </header>

  <div class="entry-content">
    <?php echo $post->content ?>     
  </div><!-- .entry-content -->
  
  <footer class="entry-meta"></footer><!-- .entry-meta -->
</article>