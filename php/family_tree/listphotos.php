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
      	<?php $curDB = getCurDB(); ?>
        <div style="float:left"><h1><?php echo _('{' . $curDB . '} Family <span class="white">Photos</span>'); ?></h1></div>
        	<?php 
        		echo '<div class="dropdown" style="float:right">';
        		printMenu($_SERVER['PHP_SELF'], $curDB);
        		echo '</div>';
        		
        		/*
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
        		*/
        	?>
        <div class="blurb">
	
	<?php
		include 'dbconnect.php';
	
		$sql = "SELECT * FROM " . $curDB . "_photos";
		
		$res = $mysqli->query($sql);
		        
		if($res->num_rows > 0)
		{
			$rowSwitch = 0;
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
        		
        		while($row = $res->fetch_assoc())
			{	
				if($rowSwitch % 2 == 0)
					echo '<tr class="row-a">';
				else
    					echo '<tr class="row-b">';
    				
    				$rowSwitch++;
				
				echo "<td>" . //$row['id'] . "</td><td>" . 
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
		else
		{
			echo _("There are currently no photos uploaded to the " . $curDB . " family tree"); 
		}
	
	
		/*
		$dir = dirname(__FILE__);
		$uploadDir = "uploads";
		chdir($uploadDir);
    		if($dh = opendir(getcwd())) 
    		{
        		while(($file = readdir($dh)) !== false) 
        		{	
        			if(is_dir($file) && $file != "." && $file != "..")
        			{
        				echo "Family Line: " . $file . "<br/>"	;
        				if($dh2 = opendir($file))
        				{
        					while(($file2 = readdir($dh2)) !== false)
        					{
        						if(!is_dir($file2) && endsWith($file2, ".jpg"))
        						{
        							echo '<a href="' . $uploadDir . "/" . $file . "/" . $file2 . '" target="new">' . $file2 . '</a><br/>';
        						}
        					}
        					closedir($dh2);
        				}
        			}
            		//echo "filename: $file : filetype: " . filetype($dir . $file) . "<br/>";
        		}
        		closedir($dh);
    		}
    		*/
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
