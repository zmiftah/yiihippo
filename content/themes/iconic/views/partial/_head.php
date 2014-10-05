<meta charset="UTF-8" />
<title><?php echo $this->pageTitle ?></title>
<meta name="title" content="<?php echo $this->metaTitle ?>" />
<meta name="description" content="<?php echo $this->metaDesc ?>" />
<meta name="keywords" content="<?php echo $this->metaKeyword ?>" />
<meta name="viewport" content="width=device-width">
<!-- <meta name="robots" content="noodp,noydir"/> -->
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

<?php if (!empty($this->favicon)): ?>
<link rel="shortcut icon" href="<?php echo /*Yii::app()->baseUrl.'/'.*/$this->favicon ?>" >
<?php endif ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="canonical" href="<?php echo $this->siteAddress ?>" />
<!-- <link rel="publisher" href="103739627521132563552"/> -->
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Ubuntu:400,700&#038;subset=latin,latin-ext' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo Yii::app()->theme->baseUrl ?>/assets/css/style.css?ver=3.4.1' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo Yii::app()->theme->baseUrl ?>/assets/css/custom.css?ver=3.4.1' type='text/css' media='all' />
<!--[if lt IE 9]>
<link rel='stylesheet' href='<?php echo Yii::app()->theme->baseUrl ?>/assets/css/ie.css?ver=20130305' type='text/css' media='all' />
<![endif]-->

<!--[if lt IE 9]>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->
<script type='text/javascript' src='<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.js?ver=1.7.2'></script>

<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
<style type="text/css" id="custom-background-css">body.custom-background { background-color: #e8e8e8; }</style>