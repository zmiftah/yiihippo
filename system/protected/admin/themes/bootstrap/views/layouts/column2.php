<?php $this->beginContent('//layouts/main'); ?>
    <div class="span3" id="mainmenu">
        <div class="navmenu">
            <?php $this->widget('admin.components.AbMenuWidget'); ?>
        </div>
        <div class="navwidget" style="background-color:#F7F7F7">
            <?php $this->widget('admin.components.AbNavWidget'); ?>
        </div>
    </div>
    <div class="span9" id="maincontent">
        <?php echo $content; ?>
    </div>
<?php $this->endContent(); ?>