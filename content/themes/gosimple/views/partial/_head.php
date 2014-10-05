<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->pageTitle ?></title>
<meta name="title" content="<?php echo $this->metaTitle ?>" />
<meta name="description" content="<?php echo $this->metaDesc ?>" />
<meta name="keywords" content="<?php echo $this->metaKeyword ?>" />
<meta name="generator" content="BrainHippo Media" />
<?php if (!empty($this->webmasterId)): ?>
<meta name="google-site-verification" content="<?php echo $this->webmasterId ?>" />
<?php endif ?>

<!-- FB OpenGraph -->
<meta property='og:locale' content='en_US'/>
<meta property='og:type' content='website'/>
<meta property='og:title' content='<?php echo $this->siteTitle ?>'/>
<meta property='og:url' content='<?php echo $this->siteAddress ?>'/>
<meta property='og:site_name' content='<?php echo $this->siteName ?>'/>

<!-- Stylesheet & Favicon -->
<?php if (!empty($this->favicon)): ?>
<link rel="shortcut icon" href="<?php echo /*Yii::app()->baseUrl.'/'.*/$this->favicon ?>" >
<?php endif ?>
<link rel="canonical" href="<?php echo $this->siteAddress ?>" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/styles.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/symple_shortcodes_styles.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/font.css" type="text/css" media="all">

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery-migrate.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.superfish.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.slides.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.init.js"></script>

<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>