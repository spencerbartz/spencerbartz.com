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
      </div>
      <div class="sidebox">
        <ul class="sidemenu">
          <li></li>
        </ul>
      </div>
    </div>
    
    <!-- Left Side (Main Content)-->
    <div id="main">
      <div class="box">
        <?php $curDB = getCurDB(); ?>
        <div style="float:left"><h1><?php echo _('Search the {' . $curDB . '} <span class="white">Family Tree</span>'); ?></h1></div>
	<?php
        	echo '<div class="dropdown" style="float:right">';
        	printMenu($_SERVER['PHP_SELF'], $curDB);
        	echo '</div>';
        ?>
     
        <div class="blurb" style="clear:right;float:left">

        <form action="searchsubmit.php?dbname=<?php echo $curDB ?>" id="contactform" onsubmit="return checkFormFields('contactform', 'errormsg')" method="post">
        <div id="errkeyword"><?php echo _("<strong>Keyword: </strong>"); ?></div><input name="keyword" class="search" type="text" /><br/><br/>
        <?php echo _("<strong>Search in: </strong>"); ?><div id="errormsg" class="errormsg"></div><br/>
	<input type="checkbox" name="photos" value="1"><?php echo _('Photos'); ?></input><br/>
	<input type="checkbox" name="profiles" value="1"><?php echo _('Profiles'); ?></input><br/>
	        
        <input name="advsearch" value="advanced" type="checkbox" /> <?php echo _('Advanced Search'); ?><br/><br/>
        <input name="submit" class="button" value="<?php echo _('Submit'); ?>" type="submit" /><br/>      
        </form>
   	</div>
  
        <p style="clear:left" class="post-footer align-right"><span class="date"><?php lastUpdated(__FILE__); ?></span></p>
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
