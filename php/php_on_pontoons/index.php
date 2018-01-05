<?php
	include '../../util/util.php';
	print_page_dec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
</head>

<?php
	//Check to see if this page is being searched for a string.
	//If so, call the js highlighting function after page loads.
	if(isset($_GET['searchstr']))
		echo '<body onload="selectSearchWords(\'' . $_GET['searchstr'] . '\')">';
	else
		echo '<body>';
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
    <div id="sidebar" >
		<div class="sidebox" id="searchbox">
			<?php print_search_box(__FILE__) ?>
		</div>
    </div>
    
    <!-- Left Side (Main Content)-->
    <div id="main">
	
      <div class="box">
        <h1><?php println(_('Welcome to <span class="white">spencerbartz.com</span>')); ?></h1>
        <p>
        <?php 
        	$desc = _("This is not a working app by itself, rather an MVC framework for creating web apps. Future PHP apps on this site will be written using this framework. To learn more ") .
							'<a href="https://github.com/spencerbartz/php_on_pylons">' . _("View the Git Repo." ) . "</a>";
			
			println($desc);
        ?>
        </p>
        <p class="post-footer align-right"><span class="date"><?php last_updated(__FILE__); ?></span> </p>
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
