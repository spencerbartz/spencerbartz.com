<?php
	include '../util.php';
	include 'sbutil.php';
	$curLang = "en";
	if(isSet($_GET["locale"]))
		$curLang = "jp";
	
	if(strcmp($curLang, "jp") === 0)
		changeLanguage();
		
	printPageDec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
<?php sbIncludes(); ?>
</head>
<body>
<!-- header starts here -->
<div id="header">
  <div id="header-content">
  <?php
  	printHeader(__FILE__);
  ?>
  </div>
</div>
<!-- navigation starts here -->
<div id="nav-wrap">
  <div id="nav">
<?php
	printNav(__FILE__);
?>
  </div>
</div>
<!-- content-wrap starts here -->
<div id="content-wrap">
  <div id="content">
    <div id="sidebar" >
      <div class="sep"></div>
      <div class="sidebox">
        <h1><?php echo _("Search Box") ?></h1>
        <form action="" class="searchform">
          <p>
            <input name="search_query" class="textbox" type="text" />
            <input name="search" class="button" value="<?php echo _('Search'); ?>" type="submit" />
          </p>
        </form>
      </div>
      <div class="sidebox">
        <h1><?php echo _("Sidebar Menu"); ?></h1>
        <ul class="sidemenu">
          <li></li>
        </ul>
      </div>
    </div>
    
    <!-- Left Side (Main Content)-->
    <div id="main">
    
      <div class="box">
      <h1>
      <?php
      	//Try to print a more helpful error message if one was provided
      	$errmsg = "";
      	if(isset($_GET["errmsg"]))
      		$errmsg = $_GET["errmsg"];
      		
      	//Get the redirect location if one was provided
      	$url = "index.php";
      	if(isset($_GET["redirect"]))
      		$url = $_GET["redirect"];
      	
      	echo _('Error: <span class="white">' . $errmsg .  '</span>');
      ?>
      </h1>
        <img src="error.jpg" />
	<meta HTTP-EQUIV="refresh" content="3; url=<?php echo $url; ?>">
        <p>
  
        </p>
        <p class="post-footer align-right"><span class="date"><?php lastUpdated(__FILE__); ?></span></p>
      </div>
    </div>

    <!-- content-wrap ends here -->
  </div>
</div>
<!-- footer starts here-->
<div id="footer-wrap">
  <div id="footer-columns">
  	<?php
  		printFooter(__FILE__);
  	?>
  </div>
  <!-- footer ends-->
</div>
</body>
</html>
