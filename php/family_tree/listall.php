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
        <h1><a href="index.html"><?php echo _('List <span class="white">All</span>'); ?></a></h1>
        <p>
        	<?php 
        		$curDB = getCurDB();
        		if($curDB !== "none")
        		{
        			echo "Family Line: " . $curDB;
        			printMenu($_SERVER['PHP_SELF'], $curDB); 
        		}
        		else
        		{
        			echo _('<meta http-equiv="refresh" content="0; url=error.php?errmsg=' . urlencode("No Family Line Selected.") . '">');
        			die();
        		}
        	?>
        </p>
        <p>
	<?php
		include 'dbconnect.php';
		
		$res = $mysqli->query("SELECT * FROM " . $curDB . "_people");
		
		while($row = $res->fetch_assoc())
		{
			echo '<div id="' . $row["id"] . '" class="person">';
			echo $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "<br/>";
			echo "Sex: " . $row["sex"] . "<br/>";
			echo "Date of birth: " . $row["dob"] . "<br/>";
			
			if($row["dod"] !== "0000-00-00")
				echo "Date of death: " . $row["dod"] . "<br/>";
			
			echo "Description:<br/>" . $row["description"] . "<br/>";
			echo "Last Edited By: " . $row["editedby"];
			echo '</div>';
		}
		
	?>
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
