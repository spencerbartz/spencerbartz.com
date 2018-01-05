<?php
	include '../util/util.php';
	print_page_dec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
</head>
<?php
	//Check to see if this page is being searched for a string.
	//If so, call the js highlighting function after page loads.
	if(isset($_GET['searchstr']))
		println('<body onload="selectSearchWords(\'' . $_GET['searchstr'] . '\')">');
	else
		println('<body>');
?>
	<div id="overlay"></div>
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

    <!-- Right side search box area -->
    <div id="sidebar">
      <div class="sidebox" id="searchbox">
	<?php print_search_box(__FILE__) ?>
      </div>
      <div class="sep"></div>
    </div>

    <!-- Left Side (Main Content)-->
    <div id="main">
      <div class="box">
        <h1><?php echo _('JavaScript <span class="white">Projects</span>'); ?></h1>
        <p>
        <?php
		echo _('This page contains projects I have programmed in JavaScript. ' .
					'Many projects on this site use JavaScript, but this section is intended for projects focusing on UI/UX and aesthetics, '.
					'as well taking advantage of the fun and entertainment possible through HTML5 and JavaScript.');
        ?>
        </p>
        <p class="post-footer align-right"><span class="date"><?php last_updated(__FILE__); ?></span> </p>
      </div>

      <div class="box">
        <h1><?php echo _('Latest <span class="white">Projects</span>'); ?></h1>
        <?php
        	print_project_links();
        ?>
      </div>
      <br/>
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
