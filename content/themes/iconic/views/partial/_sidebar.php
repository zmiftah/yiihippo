<?php $this->widget('application.components.widgets.AbBannerWidget', array(
  'posititon'=>2
)) ?>

<aside id="search-2" class="widget widget_search">
	<form role="search" method="get" id="searchform" action="<?php echo Yii::app()->baseUrl.'/search/' ?>">
	<div>
		<label class="screen-reader-text" for="s">Search for:</label>
		<input type="text" value="<?php echo $_GET['s'] ?>" name="s" id="s">
		<input type="submit" id="searchsubmit" value="Search">
	</div>
	</form>
</aside>

<?php $this->widget('application.components.widgets.AbAllSidebarWidget') ?>
    
<?php $this->widget('application.components.widgets.AbBannerWidget', array(
  'posititon'=>4
)) ?>