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
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/style.min.css" />
<link rel='stylesheet' href='<?php echo Yii::app()->theme->baseUrl ?>/assets/css/custom-styles.css' />
<!-- <link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/custom-style.less"> -->

<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>

<!--[if lt IE 9]>
<script src="/assets/js/vendor/html5.js" type="text/javascript"></script>
<![endif]-->
<!-- <script src="/assets/js/vendor/less-1.3.3.min.js"></script> -->