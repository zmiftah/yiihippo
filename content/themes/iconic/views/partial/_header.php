<hgroup>
	<a href="<?php echo $this->siteAddress ?>" title="<?php echo $this->siteTitle ?>" rel="home">
		<?php echo $this->siteTitle ?>
	</a><br/> <a class="site-description"></a>
</hgroup>

<?php 
$facebook = Yii::app()->options->get('socmed_facebook');
$twitter = Yii::app()->options->get('socmed_twitter');
$googleplus = Yii::app()->options->get('socmed_googleplus');
$feed = Yii::app()->options->get('site_feed');
?>

<div class="socialmedia">
<?php if (!empty($facebook)): ?>
	<a href="<?php echo $facebook ?>" target="_blank">
		<img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/img//facebook.png" alt="Follow us on Facebook"/></a>
<?php endif ?>
<?php if (!empty($twitter)): ?>
	<a href="<?php echo $twitter ?>" target="_blank">
		<img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/img/twitter.png" alt="Follow us on Twitter"/></a>
<?php endif ?>
<?php if (!empty($googleplus)): ?>
	<a href="<?php echo $googleplus ?>" rel="author" target="_blank">
		<img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/img//gplus.png" alt="Follow us on Google Plus"/></a>
<?php endif ?>
<?php if (!empty($feed)): ?>
	<a href="<?php echo Yii::app()->baseUrl ?>" target="_blank">
		<img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/img//rss.png" alt="Follow us on rss"/></a>
<?php endif ?>
</div>

<nav id="site-navigation" class="themonic-nav" role="navigation">
	<a class="assistive-text" href="#content" title="Skip to content">Skip to content</a>
	<div class="menu-header-link-container">
		<?php $this->widget('application.components.widgets.AbNavMenuTopWidget', array(
				'orderBy'=>'post_id DESC',
				'ulID'=>'menu-top',
				'ulClass'=>'nav-menu',
				'liClass'=>'menu-item menu-item-type-custom menu-item-object-custom'
			)) ?>
	</div>		
</nav><!-- #site-navigation -->

<div class="clear"></div>