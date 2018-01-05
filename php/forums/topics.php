<?php 
	include 'util.php';
	include 'dbconnect.php';
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
	
	//retrieve forum name from parameters in URL
	$forumname = $_GET["forum"];
	
	//print welcome message for this forum	
	echo '<div class="header">';
	echo '<h1>Welcome to the <font color="blue">'. $forumname . ' </font>Forum</h1>';
	echo '</div>';
	
	//display the number of topics in this forum	
	echo '<div id="topiccount" class="header">';
	$qhandle = mysql_query("select count(*) as topiccount from topics where forum = '$forumname';");
	
	$row = mysql_fetch_array($qhandle);
	$topiccount = $row["topiccount"];
	
	if($topiccount == 1)
		echo 'Currently displaying <font class="number" color="blue">' . $topiccount . '</font> topic.';
	else
		echo 'Currently displaying <font class="number" color="blue">' . $topiccount . '</font> topics.';
	echo '</div>';


	echo '<br>';
	
	//give option to start a new topic for this forum
	echo '<div><a href="newtopic.php?forum=' . urlencode($forumname) . '">Create a new topic</a></div>';
	//echo '<a href="javascript:;" class="forumbutton" onclick="toggleVisible(\'comment_field\')">Make a new post</a>';

	//query database for table of topics
	$qhandle = mysql_query("select * from topics where forum = '$forumname' order by date_created;");
	
	if (!$qhandle)
	 	Die(mysql_error($conn));
	 
	 //display all topics in a table
	echo '<div class="table_container">';
	echo '<table class="forum_table">';
	
	//table header
  	echo '<tr><th align = "left" width = "20%">Topic</th>';
  	echo '<th align = "left" width = "60%">Started By</th>';
  	echo '<th align = "center" width = "10%"># Posts</th>';
  	echo '<th align = "center" width = "10%">Last Post</tr>';
	
	//print all rows in the table
	while($row = mysql_fetch_array($qhandle))
	{
		$topicname = $row["topicname"];
		$owner = $row["user"];
		$forumname = $row["forum"];
		
		//get the date this topic was started, in a nice format 
		$datestarted = convert_date($row["date_created"]);
		
		//if the topic name has quotes in it, it will not be safe as a query so we must escape them
		$querySafeTopicName = addslashes($topicname);
		  
		 //obtain the total number of posts in this topic
		$qhandle2 = mysql_query("select count(*) as postcount from posts where topic = '$querySafeTopicName' and forum = '$forumname';");
		
		if (!$qhandle2)
	 		Die(mysql_error($conn));
		
		$row2 = mysql_fetch_array($qhandle2);  
		$postCount = $row2["postcount"];
		
		$qhandle3 = mysql_query("select max(postdate) as lastpost from posts where topic = '$querySafeTopicName';");
		$row3 = mysql_fetch_array($qhandle3);
		$lastpost = $row3["lastpost"];
		
		//print out three rows with the topicname (as a hyper link), the date started, and the number of posts
		echo '<tr><td><b><a href="posts.php?forum='. urlencode($forumname) . '&topic=' .  htmlentities($topicname, ENT_COMPAT) . '">' . $topicname . '</b></td>';
		echo '<td><font size="-1">' . $owner . ' on ' . $datestarted . '</font></td>';
		echo '<td align = "center"><font size="-2"> <font class="number" color="blue">' . $postCount . '</font></font></td>';
		
		//check to see if there has ever been a post
		if($lastpost != "")
		{
			echo '<td>' . convert_date($lastpost)  .'</td></tr>';
		}
		else
		{
			echo '<td> No posts have been made yet </td></tr>';
		}
	}
	
	echo '</table>';
	echo '</div>';
	echo '<br>';
	//empty forum name and topic name so they do not get shown in footer (the last topic and forum that were displayed on this page would erroneously be shown)
 	$forumname = "";
 	$topicname = "";
	include 'footer.php';
?>

</body>
</html>
