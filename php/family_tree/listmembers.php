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
        <div style="float:left"><h1><?php echo _('{' . $curDB . '} Family <span class="white">Members</span>'); ?></h1></div>
        	<?php 
        		if($curDB !== "none")
        		{
				echo '<div class="dropdown" style="float:right">';
				printMenu($_SERVER['PHP_SELF'], $curDB);
				echo '</div>';
        		}
        		else
        		{
        			echo "Family Line: None selected";
        			echo _('<meta http-equiv="refresh" content="0; url=error.php?errmsg=' . urlencode("No Family Line Selected.") . '">');
        			die();
        		}
        	?>
        	
        <div class="blurb" style="clear:both">
	<?php
		include 'dbconnect.php';
		
		//List all family members in a table
		if($res = $mysqli->query("SELECT * FROM " . $curDB . "_people"))
		{
			echo "<table>";
			echo '<tr>';
			//echo '<th class="first">id</th>';
			echo '<th class="first">Filename</th>';
			echo '<th>Date taken</th>';
			echo '<th>Description</th>';
			echo '<th>People Shown</th>';
			echo '<th>Date Modified</th>';
			echo '<th>Edited By</th>';
			echo '<th>Thumbnail</th>';
			echo '</tr>';
			
			//START CODING HERE
		
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
		}
		
		//Create little squares to hold entry info
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
        </div>
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
