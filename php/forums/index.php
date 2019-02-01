<?php
	include 'util.php';
	include '../util/dbconnect.php';
?>
<html>
<head>
	<title><?php echo get_page_title(); ?></title>
	<?php print_includes(); ?>

</head>

<body>
<?php

	//check to see if the user has logged in
	$username = retrieve_user();

	if($username != "")
	{
		//print greeting
		echo "Hello " . $username . " !<br>";
	}

	//print welcome message
	echo '<div class="header"><h1>Welcome to ' .  get_forum_title() . '</h1></div>';
	echo '<br>';

	//query database for table of forums ( forumname, description )
	$qhandle = mysql_query("select * from forums;");

	if (!$qhandle)
 		Die(mysql_error());

 	echo '<div class="table_container">';
 	//display all forums in a table with the forum name, number of topics, and description
	echo '<table class="forum_table">';

	//table header
  	echo '<tr><th align = "left" width = "30%">Forum</th>';
  	echo '<th align = "left" width = "50%">Description</th>';
  	echo '<th align = "center" width = "10%"># Topics</th>';
  	echo '<th align = "center" width = "10%"># Posts</th></tr>';

	while($row = mysql_fetch_array($qhandle))
	{
		//get the name and description of this forum from the table
		$forumname = $row['forumname'];
	  	$description = $row['description'];

		//count the number of topics for this forum, store in $topiccount
	 	$qhandle2 = mysql_query("select count(*) as topiccount from topics where forum = '$forumname';");
		$row2 = mysql_fetch_array($qhandle2);
		$topiccount = $row2["topiccount"];


		//count the number of posts for this forum, store in $postcount
		$qhandle3 = mysql_query("select count(*) as postcount from posts where forum = '$forumname';");
		$row3 = mysql_fetch_array($qhandle3);
		$postcount = $row3["postcount"];


		//print the forum name, description, number of topics, and number of posts as a row in the table
		echo '<tr><td><b><font size="+1"><a color = "blue" href="topics.php?forum=' . urlencode($forumname)  . '">'. $forumname .'</a></font></b></td>'; echo "\n";
		echo '<td><font size="-1">' . $description. '</font></td>'; echo "\n";
		echo '<td align = "center"><font class="number" color="blue">' . $topiccount . '</font></td>'; echo "\n";
		echo '<td align = "center"><font class="number" color="blue">' . $postcount . '</font></td></tr>'; echo "\n";
 	}
	echo '</table>';
	echo '</div>';
	echo '<br>';
	//set $forumname to the empty string so that footer does not make a link to it
	$forumname = "";
?>
<?php include 'footer.php'; ?>

</body>
</html>
