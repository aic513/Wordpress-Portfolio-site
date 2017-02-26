<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/liSlidik.css">
<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/liSlidik.blackClasic.css">

<!--[if gte IE 9]>
  <style type="text/css">
    body {
       filter: none;
    }
  </style>
<![endif]-->
        
<!--[if lt IE 9]>
  <style type="text/css">
    body {
       background:url(<?php bloginfo('template_url') ?>/images/body-bg-ie.png) 0 730px repeat-x;
    }
    .menu, .elastislide-wrapper{
    	background:url(<?php bloginfo('template_url') ?>/images/opacity.png)
    }
  </style>
<![endif]-->
        
<title><?php bloginfo('name') ?><?php wp_title() ?></title>
<?php wp_head(); ?>
</head>

<body>
<div class="karkas">
	<div class="header">
    	<a href="/"><img src="<?php bloginfo('template_url') ?>/images/logo.png" class="logo" alt="Fashion photographer" /></a>

<?php wp_nav_menu( array( 'theme_location' => 'menu', 'container' => '' ) ); ?>
    </div>