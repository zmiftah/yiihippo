<?php 
    $this->pageTitle = $post->title;
    $permalink       = Yii::app()->baseUrl . $post->url;
    $date            = strtotime($post->created);
?>

<style>
    .entry-header {
        margin: 20px auto;
    }
</style>

<div id="single-content" class="div-content">
    <div class="clear"></div>
    <article id="post-<?php echo $post->post_id ?>" class="post-<?php echo $post->post_id ?> post type-post status-publish format-standard hentry category-uncategorized">
        <header class="entry-header">
            <h1 class="entry-title"><?php echo $post->title ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php echo $post->content ?>
            <div class="clear"></div>      
        </div><!-- .entry-content -->
    </article><!-- #post-54 -->

    <div class="clear"></div>
</div><!-- #content -->