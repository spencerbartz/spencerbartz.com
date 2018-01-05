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
 
      </div>
    </div>
    
    <!-- Left Side (Main Content)-->
    <div id="main">
    
      <div class="box">
        <div style="float:left"><h1><?php echo _('Welcome to Stammbaum: <span class="white">The Family Tree Database</span>'); ?></h1></div>
        	<?php 
        		$curDB = getCurDB();
        		echo '<div class="dropdown" style="float:right">';
        		printMenu($_SERVER['PHP_SELF'], $curDB);
        		echo '</div>';
        		echo '<div class="familyname" style="clear:left">Family Line: ';
        		
        		if($curDB !== "none")
        		{
        			echo $curDB;
        		}
        		else
        		{
        			echo "None Selected";
        		}
        		
        		echo "</div>";
        	?>
        <div class="blurb">
	
	<?php
		include 'dbconnect.php';
	
		if(!isset($_GET["id"]))
		{
			echo _('<meta HTTP-EQUIV="refresh" content="0; url=error.php?errmsg=' . urlencode("No photo ID selected") . '&redirect=' . urlencode("listphotos.php?dbname=" . $curDB) . '">');
			die();
		}
	
		$sql = "SELECT * FROM " . $curDB . "_photos where id=" . $_GET["id"];
		
		$res = $mysqli->query($sql);
		        
		if($res->num_rows > 0)
		{	
			$row = $res->fetch_assoc();
			$filename = $row["filename"];
			
			if(unlink($filename))
				echo _("Successfully deleted " . basename($filename) . "<br/>");
			
			
			$sql = "DELETE FROM " . $curDB . "_photos where id=" . $_GET["id"];
			
			if($mysqli->query($sql))
				echo _("Successfully removed " . basename($filename) . " from the database.<br/>");
		}
		else
		{
			echo _("Could not locate photo in database.<br/>"); 
		}
	?>
        
        </div>
        <p></p>
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
