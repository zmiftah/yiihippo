<div id="header" class="clearfix">
	<div id="header-top" class="clearfix">
  	<div id="logo" style="margin-top: 15px;">
  	  <a href="<?php echo $this->siteAddress ?>" title="<?php echo $this->siteTitle ?>"><?php echo $this->siteTitle ?></a>          
  	</div>
    <div id="header-banner">&nbsp;</div>
	</div>
	<div id="site-description">&nbsp;</div>        
</div>
<div id="navigation" class="clearfix">
  <div class="menu-main-container">
		<?php $this->widget('application.components.widgets.AbNavMenuTopWidget', array(
			'orderBy'=>'post_id DESC',
			'ulID'=>'menu-main',
			'ulClass'=>'sf-menu sf-js-enabled sf-shadow',
			'liClass'=>'menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home'
		)) ?>
	</div>        
</div>