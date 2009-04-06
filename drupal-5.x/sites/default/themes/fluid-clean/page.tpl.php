<?php // $Id: page.tpl.php,v 1.1.2.3 2008/09/12 15:55:42 psynaptic Exp $ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language ?>" lang="<?php print $language ?>">

<head>
  <title><?php print $head_title ?></title>
  <meta http-equiv="content-language" content="<?php print $language ?>" />
  <?php print $meta ?>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
  <!--[if IE]>
    <link rel="stylesheet" href="<?php print $path ?>ie.css" type="text/css">
  <![endif]-->
  <!--[if lte IE 6]>
    <link rel="stylesheet" href="<?php print $path ?>ie6.css" type="text/css">
  <![endif]-->
</head>

<body class="layout-<?php print $layout ?>">
  <div id="page">

    <div id="header">
      <?php if ($header || $search_box): ?>
        <div id="header-right">
          <?php print $header ?>
          <?php print $search_box ?>
        </div>
      <?php endif; ?>
<?php
/*
      <a id="logo" href="<?php print url(); ?>"><span id="site-name"><?php print $site_name ?></span></a>
      <span id="slogan"><?php print $site_slogan ?></span>
      */
?>
    </div>

    <?php if (isset($primary_links)): ?>
      <div id="navigation">
          <?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
        <?php if (isset($secondary_links)) : ?>
          <?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php
    // Display an empty breadcrumb div so the layout of the site is consistent.
    if ($breadcrumb && $breadcrumb != '<div class="breadcrumb"></div>'): ?>
      <?php print $breadcrumb; ?>
      <?php else: ?>
        <div class="breadcrumb"><a href='/'>Home</a> <?php print ' &rsaquo; '.$title;?></div>
	<?php endif; 
    
    //print $breadcrumb ?>

    <?php print $left ?>

    <div id="centre">
      <?php print $messages ?>

      <?php if ($tabs): ?>
        <div class="tabs"><?php print $tabs ?></div>
      <?php endif; ?>

      <?php if ($title): ?>
        <h1 class="page-title"><?php print $title ?></h1>
      <?php endif; ?>

      <?php print $help ?>
      <?php print $content ?>
      <?php print $feed_icons ?>

    </div><!--// centre -->

    <?php print $right; ?>

    <?php if ($footer_message): ?>
      <div id="footer"><?php print $footer_message ?></div>
    <?php endif; ?>

    <?php print $closure ?>
  </div><!--// page -->
</body>
</html>
