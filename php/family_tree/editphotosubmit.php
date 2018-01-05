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
       <div style="float:left"><h1><?php echo _('Edit Photo Complete <span class="white">{' . $curDB . '}</span>'); ?></h1></div>
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
  		
  		$id = "";
  		$day = "";
  		$month = "";
  		$year = "";
  		$description = "";
  		$peopleshown = "";
  		$createdby = "";
  		
  		//Process required elements from form
        	$reqKeys = array("id", "day", "month", "year", "description", "createdby");
        	
        	for($i = 0; $i < count($reqKeys); $i++)
        	{
        		if(isset($_POST[$reqKeys[$i]]))
        		{
        			eval('$' . $reqKeys[$i] . ' = ' . ' $mysqli->real_escape_string($_POST["' . $reqKeys[$i] . '"]);');
			}
			else
			{
				echo "ERROR. Required parameters not passed to HTTP request.";
				echo _('<meta http-equiv="refresh" content="0; url=editphoto.php?dbname=' . $curDB . '&id=' . $_POST["id"] . '">');
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
        	
        
        	$sql = "UPDATE " . $curDB . "_photos SET datetaken=DATE('" . $dateTaken . "'), description='" . $description . 
        	"', peopleshown='" . $peopleshown . "', datemodified=NOW(), editedby='" . $createdby . "' WHERE id='" . $id . "'";
        	
        	//echo $sql . "<br/>";
        	
        	if(!$mysqli->query($sql)) 
        	{
			echo "ERROR: Edit Failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		else
		{
			echo "<div class=\"blurb\">Photo id#" . $id . " successfully edited on " . date ("F d, Y H:i:s") . " PST</div>";
			//echo '<div style="text-align:center"><img src="' . $filename . '" /></div></div>'; 
		}
	
		$sql = "SELECT * FROM " . $curDB . "_photos where id='" . $id . "'";
		
		$res = $mysqli->query($sql);
		        
		if($res->num_rows > 0)
		{
			$rowSwitch = 0;
			echo "<table>";
			echo '<tr>';
			echo '<th class="first">id</th>';
			echo '<th>Filename</th>';
			echo '<th>Date taken</th>';
			echo '<th>Description</th>';
			echo '<th>People Shown</th>';
			echo '<th>Date Modified</th>';
			echo '<th>Edited By</th>';
			echo '<th>Thumbnail</th>';
			echo '</tr>';
        		
        		if($row = $res->fetch_assoc())
			{	
				echo '<tr class="row-a">';
				echo "<td>" . $row['id'] . "</td><td>" . 
				basename($row['filename']) . "</td><td>" . 
				$row['datetaken'] . "</td><td>" . 
				$row['description'] . "</td><td>" . 
				$row['peopleshown'] . "</td><td>" . 
				$row['datemodified'] . "</td><td>" . 
				$row['editedby'] . "</td><td>" . 
				'<a href="' . $row['filename'] . '" target="new"><img src="' . getThumbFromPath($row['filename']) . '" /></a><br/><a href="editphoto.php?dbname=' . $curDB . '&id=' . $row['id'] . '">Edit</a><br/><a onclick="promptDeletePhoto(' . "'" . $curDB  . "', '" . $row['id'] . "'" . ')">Delete</a></td></tr>';
			}
			echo "</table>";
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
