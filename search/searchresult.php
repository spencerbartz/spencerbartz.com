<?php
	include '../util/util.php';
	print_page_dec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
</head>
<body>
	<div id="overlay"></div>
<!-- header starts here -->
<div id="header">
  <div id="header-content">
	<?php print_header(__FILE__); ?>
  </div>
</div>
<!-- navigation starts here -->
<div id="nav-wrap">
  <div id="nav">
	<?php print_nav(__FILE__); ?>
  </div>
</div>
<!-- content-wrap starts here -->
<div id="content-wrap">
  <div id="content">
  
  
    <!-- Right side search box area -->
    <div id="sidebar" >
      <div class="sidebox" id="searchbox">
	<?php print_search_box(__FILE__) ?>
      </div>
      <div class="sep"></div>
    </div>
    
    <!-- Left Side (Main Content)-->
    <div id="main">
    	<div class="box">
	
	<?php
		$searchStr = "";
		
		if(isset($_POST['search_query']))
		{
			$searchStr = $_POST['search_query'];
			$sql = "select * from pages where pagetext like '%" . $searchStr . "%'";
			$mysqli =  get_mysqli_connection("searchdb");
			if(!$mysqli)
				die("DIE IN A FIRE!");
		
			if(!$res = $mysqli->query($sql)) 
			{
			    echo "Search Query Failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			else
			{
				println("<h1>(" . $res->num_rows . ") Results found for search query <span class=\"white\">\"" . $_POST['search_query'] . "\"</span>" . "</h1>");
				
				if($res->num_rows > 0)
				{
					//print table header
					echo '<table>';
					echo '<tr>';
					echo '<th class="first">id</th>';
					echo '<th>URL</th>';
					echo '<th>Last Updated</th>';
					echo '</tr>';
					
					$rowSwitch = 0;
					
					while($row = $res->fetch_assoc())
					{
						//Output a row in the table
						if($rowSwitch % 2 == 0)
							echo '<tr class="row-a">';
						else
							echo '<tr class="row-b">';
						
						$rowSwitch++;
						
						//TODO check this href to see if it has any parameters (? and &)
						echo "<td>" . $row["id"] . '</td><td><a href="' . $row["url"] . '?searchstr=' . $searchStr . '">' . $row["url"] . '</a></td><td>' . $row["lastupdated"] . "</td></tr>";
						//echo '<tr><td class="pagetext">' . $row["pagetext"] . '</td></tr';
					}
					
					echo "</table>";
				}
			}			
		}
	?>

	</div>
    </div>

    <!-- content-wrap ends here -->
  </div>
</div>
<!-- footer starts here-->
<div id="footer-wrap">
  <div id="footer-columns">
  	<?php
  		print_footer(__FILE__);
  	?>

  </div>
  <!-- footer ends-->
</div>
</body>
</html>
