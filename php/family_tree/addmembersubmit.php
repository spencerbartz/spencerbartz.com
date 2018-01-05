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
      <div style="float:left"><h1><?php echo _('New {' . $curDB . '} family member <span class="white">entry complete</span>'); ?></h1></div>
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
  		
  		$lastname = "";
  		$firstname = "";
  		$middlename = "";
  		$maidenname = "";
  		$mother = "";
  		$father = "";
  		$sex = "";
  		$dobday = "";
  		$dobmonth = "";
  		$dobyear = "";
  		$dodday = "";
  		$dodmonth = "";
  		$dodyear = "";
  		$description = "";
  		$createdby = "";
  		
  		//Process required elements from form
        	$reqKeys = array("lastname", "firstname", "middlename", "sex", "description", "createdby");
        	
        	for($i = 0; $i < count($reqKeys); $i++)
        	{
        		//echo '$' . $keys[$i] . ' = ' . '$_POST["' . $keys[$i] . '"];';
        		if(isset($_POST[$reqKeys[$i]]))
        		{
        			eval('$' . $reqKeys[$i] . ' = ' . ' $mysqli->real_escape_string($_POST["' . $reqKeys[$i] . '"]);');
			}
			else
			{
				echo "ERROR";
				echo _('<meta http-equiv="refresh" content="2; url=http://localhost/php/stammbaum/addnew.php">');
			}
        	}
        	
        	//Process optional elements from form
        	$optKeys = array("mother", "father", "maidenname", "dobday", "dobmonth", "dobyear", "dodday", "dodmonth", "dodyear", "createdby");
        	
        	for($i = 0; $i < count($optKeys); $i++)
        	{
         		if(isset($_POST[$optKeys[$i]]))
        		{
        			eval('$' . $optKeys[$i] . ' = ' . ' $mysqli->real_escape_string($_POST["' . $optKeys[$i] . '"]);');
        		}
        	}
        	
        	if(intval($dobday) % 10 != 0)
        		$dobday = "0" . $dobday;
        	
        	if(intval($dobmonth) % 10 != 0)
        		$dobmonth = "0" . $dobmonth;
        		
        	if(intval($dodday) % 10 != 0)
        		$dodday = "0" . $dodday;
        	
        	if(intval($dodmonth) % 10 != 0)
        		$dodmonth = "0" . $dodmonth;
        	
        	$dob = $dobyear . "-" . $dobmonth . "-" . $dobday;
        	$dod = $dodyear . "-" . $dodmonth . "-" . $dodday;
        	
        	$sql = "INSERT INTO " . $curDB . "_people VALUES(NULL, '" . $curDB . "', '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $maidenname . "', '" . $sex . "', DATE('" . $dob . "'), DATE('" . $dod . "'), '" . $description . "', '" . $mother . "', '" . $father . "', 'none', NOW(), NOW(), '" . $createdby . "')";
        	
        	//echo $sql . "<br/>";
        	
        	if(!$mysqli->query($sql)) 
        	{
		    echo "Insertion Failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		else
		{
			if(strlen($middlename) > 0)
				$middlename = $middlename . " ";
			
			echo '<div class="blurb">';
			echo "Succesfully created " . $firstname . " " . $middlename . $lastname . " on " . date ("F d, Y H:i:s") . " PST";;
			echo '</div>';
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
