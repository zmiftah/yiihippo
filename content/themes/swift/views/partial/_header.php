<header id="header">
	<div id="above-logo-container">
		<nav id="above-logo" class="hybrid navigation clearfix" role="navigation">
			<ul class="nav clearfix"></ul>
			<!-- <ul id="rss-links">
				<li>
					<a href="http://localhost/wordpress/feed/" class="posts-feed" title="Posts feed">Posts</a>
				</li>
				<li>
					<a href="http://localhost/wordpress/comments/feed/" class="comments-feed" title="Comments feed">Comments</a>
				</li>
			</ul>			 -->
		 </nav>
	</div>
	<div id="branding-container">
		<div id="branding" class="clearfix hybrid">
			<div class="div-content clearfix">
				<hgroup class="alignleft">
					<h1 id="site-title">
						<a href="<?php echo $this->siteAddress ?>" title="<?php echo $this->siteTitle ?>" rel="home">
							<?php echo $this->siteTitle ?>
						</a>
					</h1>
				</hgroup>
			</div>
		</div><!-- /branding -->
	</div>
	<div class="clear"></div>
	<div id="below-logo-container">
		<nav id="below-logo" class="hybrid navigation clearfix" role="navigation">

			<?php $this->widget('application.components.widgets.AbNavMenuTopWidget', array(
				'orderBy'=>'post_id DESC',
				'ulClass'=>'nav clearfix',
				'liClass'=>'menu-item menu-item-type-custom menu-item-object-custom'
			)) ?>

			<form method="get" action="<?php echo Yii::app()->baseUrl.'/search/' ?>" id="navsearch">
				<?php $value = empty($_GET['s'])?'Type and hit enter to Search':$_GET['s'] ?>
				<input type="text" value="<?php echo $value ?>" name="s" onfocus="if (this.value == 'Type and hit enter to Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Type and hit enter to Search';}" class="textfield">
				<input type="hidden" value="GO">
			</form>
    </nav>
	</div>
</header>