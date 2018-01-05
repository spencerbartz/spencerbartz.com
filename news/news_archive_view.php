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
		<div class="sidebox box" id="newsarchive">
			<div class="box-title">News Archives<br/>
				<?php print_news_archive_links(); ?>
			</div>
		</div>
    </div>

    <!-- Left Side (Main Content)-->
    <div id="main">

      <div class="box">
        <h1><?php println(_('Archived <span class="white">News Story</span>')); ?></h1>
        <p>
        <?php
			print_archived_story($_GET["id"]);
        ?>
        </p>
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
