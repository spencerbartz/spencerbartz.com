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
       <div style="float:left"><h1><?php echo _('{' . $curDB . '} Family Photo <span class="white">upload complete</span>'); ?></h1></div>
 
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
  		
  		$filename = "";
  		$day = "";
  		$month = "";
  		$year = "";
  		$description = "";
  		$peopleshown = "";
  		$createdby = "";
  		
  		//Process required elements from form
        	$reqKeys = array("filename", "day", "month", "year", "description", "createdby");
        	
        	for($i = 0; $i < count($reqKeys); $i++)
        	{
        		if(isset($_POST[$reqKeys[$i]]))
        		{
        			eval('$' . $reqKeys[$i] . ' = ' . ' $mysqli->real_escape_string($_POST["' . $reqKeys[$i] . '"]);');
			}
			else
			{
				echo _('<meta http-equiv="refresh" content="0; url=error.php?errmsg=The required HTTP parameters were not found&redirect=addphoto.php?dbname=' . $curDB . '">');
				die();
			}
        	}
        	
        	//Process optional elements from form
        	$optKeys = array("peopleshown");
        	
        	for($i = 0; $i < count($optKeys); $i++)
        	{
         		if(isset($_POST[$optKeys[$i]]))
        		{
        			eval('$' . $optKeys[$i] . ' = ' . ' $mysqli->real_escape_string($_POST["' . $optKeys[$i] . '"]);');
        		}
        	}
        	
        	if(intval($day) % 10 != 0)
        		$day = "0" . $day;
        	
        	if(intval($month) % 10 != 0)
        		$month = "0" . $month;
        	
        	$dateTaken = $year . "-" . $month . "-" . $day;
        	
        	$filename = strtolower($filename);
        	
        	$sql = "SELECT * FROM " . $curDB . "_photos WHERE filename='" . $filename . "'";
        	
        	$res = $mysqli->query($sql);
        	
        	if($row = $res->fetch_assoc())
        	{
        
			echo _('<meta http-equiv="refresh" content="0; url=error.php?errmsg=That photo has already been uploaded to Stammbaum&redirect=addphoto.php?dbname=' . $curDB . '">');
        	}
        	else
        	{
        		$sql = "INSERT INTO " . $curDB . "_photos VALUES(NULL, '" . $filename . "', DATE('" . $dateTaken . "'), '" . $description . "', '" . $peopleshown . "', NOW(), '" . $createdby . "')";
        	
        		if(!$mysqli->query($sql)) 
        		{
			    echo "Insertion Failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			else
			{
				echo "<div class=\"blurb\">Succesfully uploaded " . basename($filename) . " on " . date ("F d, Y H:i:s") . " PST<br/>";
				echo '<div style="text-align:center"><img src="' . $filename . '" /></div></div>'; 
			}
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
