<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->bootstrap->register(); ?>

	<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsBase; ?>/css/styles.css">
	<script src="<?php echo $this->assetsBase ?>/js/less-1.3.3.min.js"></script>
	<script src="<?php echo $this->assetsBase ?>/js/bootstrap-filestyle.js"></script>

	<?php echo $this->clips['javascript']; ?>
</head>
<body>
	<div class="container" id="page">
		<div class="row fluid" id="header-row">
			<div id="header-content" class="clearfix">
				<div id="left-side" class="span2">
					<strong>v<?php echo APP_VERSION ?></strong>
				</div>
				<div id="right-side" class="span2">
				<?php if( !Yii::app()->user->isGuest ): ?>
					<i class="icon-user icon-white"></i> 
					<a href="<?php echo $this->createUrl('site/account') ?>">
						My Account
					</a>
					&nbsp;
					<i class="icon-remove-circle icon-white"></i> 
					<a href="<?php echo $this->createUrl('site/logout') ?>">
						Logout
					</a>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<!--div id="notif-row" class="row">
		<?php
			/*Yii::app()->user->setFlash('success', '<span class="label label-success">Update</span> Ayo silakan download BrainHippo terbaru disini.');
			$this->widget('bootstrap.widgets.TbAlert', array(
			    'block' => true,
			    'fade' => true,
			    'closeText' => '×',
			    'alerts' => array(
				    'success' => array(
							'block' => true, 
							'fade' => true, 
							'closeText' => '×', 
							'htmlOptions' => array(
								'style' => 'margin:6px auto; padding:10px'
							)
				    ),
			    )
			));*/
		?>
		</div-->
		<div class="row fluid" id="content-row">
			<?php echo $content; ?>
		</div>

		<div class="row fluid" id="footer-row">
			<div class="clear"></div>
			<div id="footer">
				<div id="copyright">
					Copyright &copy; 2005-<?php echo date('Y') ?> PT.Asian Brain Internet Marketing Center
				</div>
				<div id="siup-address">
					<p>
						SIUP : 01177/10-12/PK/VII/2005. No.TDP : 102415122216 <br>
						Nama "Anne Ahira" dan semua Pelatihan Internet Marketing di Asian Brain dilindungi oleh Direktorat Jendral HAKI (Hak Kekayaan Intelektual) Republik Indonesia No.Agenda J00-2007027969
					</p>
					<p>
						Kantor pusat : Buah Batu Regency Blok A2 No.9 Bandung Jawa Barat - INDONESIA <br>
						Telepon: (+6222) 8752-0003 Fax: (+6222) 8779-8300
					</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>