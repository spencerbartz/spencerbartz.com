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
       <div style="float:left"><h1><?php echo _('{' . $curDB . '} Family Tree <span class="white">Search Results</span>'); ?></h1></div>
 
  	<?php
        	if($curDB !== "none")
        	{
        	        echo '<div class="dropdown" style="float:right">';
			printMenu($_SERVER['PHP_SELF'], $curDB);
        		echo '</div>';
        	}
        	else
        	{
        		echo _('<meta http-equiv="refresh" content="0; url=error.php?errmsg=' . urlencode("No Family Line Selected.") . '">');
        		die();
        	}
  	
  		include 'dbconnect.php';
  		
  		$keyword = "";
  		$photos = "";
  		$profiles = "";
  		
  		//Process required elements from form
        	$reqKeys = array("keyword");
        	
        	for($i = 0; $i < count($reqKeys); $i++)
        	{
        		if(isset($_POST[$reqKeys[$i]]))
        		{
        			eval('$' . $reqKeys[$i] . ' = ' . ' $mysqli->real_escape_string($_POST["' . $reqKeys[$i] . '"]);');
			}
			else
			{
				echo _('<meta http-equiv="refresh" content="0; url=error.php?errmsg=No keyword entered&redirct=search.php?dbname=' . $curDB . '">');
				die();
			}
        	}
        	
        	//Process optional elements from form
        	$optKeys = array("photos", "profiles");
        	
        	for($i = 0; $i < count($optKeys); $i++)
        	{
         		if(isset($_POST[$optKeys[$i]]))
        		{
        			eval('$' . $optKeys[$i] . ' = ' . ' $mysqli->real_escape_string($_POST["' . $optKeys[$i] . '"]);');
        		}
        	}
        	
        	if($photos === "1")
        	{
			echo '<div class="blurb">';

			$sql = "SELECT * FROM " . $curDB . "_photos WHERE filename LIKE '%" . $keyword . "%' OR description LIKE '%" . $keyword . "%'";

			if(!$res = $mysqli->query($sql))
			{
				echo "ERROR: Query failed";
				alert("Query Failed");
			}
			else
				echo "Returned " . $res->num_rows . " result(s) from " . $curDB . " photos.<br/>";

			if(!printPhotoTable($res, $curDB))
				echo _("No photo names or descriptions contained keyword <strong>" . $keyword . "</strong>"); 

			echo "</div>";
		}
		
		if($profiles === "1")
		{
			echo '<div class="blurb">';

			$sql = "SELECT * FROM " . $curDB . "_people WHERE lastname LIKE '%" . $keyword . "%' OR firstname LIKE '%" . $keyword . "%' OR description LIKE '%" . $keyword . "%'";

			if(!$res = $mysqli->query($sql))
			{
				echo "ERROR: Query failed";
				alert("Query Failed");
			}
			else
				echo "Returned " . $res->num_rows . " result(s) from " . $curDB . " profiles.<br/>";

			if(!printProfileList($res, $curDB))
				echo _("No profile names or descriptions contained keyword <strong>" . $keyword . "</strong>"); 

			echo "</div>";	
		}
		
		
		
  	?>
        
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
