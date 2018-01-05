<?php
	include '../../util/util.php';
	include 'sbutil.php';
	print_page_dec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
<?php sbIncludes(); ?>
</head>
<body>

<!-- header starts here -->
<div id="header">
  <div id="header-content">
  <?php
  	print_header(__FILE__);
  ?>
  </div>
</div>

<!-- navigation starts here -->
<div id="nav-wrap">
  <div id="nav">
<?php
	print_nav(__FILE__);
?>
  </div>
</div>
<!-- content-wrap starts here -->
<div id="content-wrap">
  <div id="content">
    <div id="sidebar" >
      <div class="sep"></div>
    </div>
    
    <!-- Left Side (Main Content)-->
    <div id="main">
      <div class="box">
        <h1><?php echo _('Welcome to <span class="white">The Family Tree Photo Database</span>'); ?></h1>
			<h4>The Family Tree Photo Database App is temporarily unavailable for infrastructure updates. Sorry for the inconvenience.</h4>
      </div>
    </div>

    <!-- content-wrap ends here -->
  </div>
</div>
<!-- footer starts here-->
<div id="footer-wrap">
  <div id="footer-columns">
  	<?php
  		print_footer(__FILE__);
  	?>
  </div>
  <!-- footer ends-->
</div>
</body>
</html>
