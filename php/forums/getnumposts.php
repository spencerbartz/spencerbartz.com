<?php
	include 'dbconnect.php';
	
	$topicname = $_POST["topicname"];
	$forumname = $_POST["forumname"];	

	//display the number of posts in this topic	
	$qhandle = mysql_query("select count(*) as postcount from posts where topic = '$topicname' and forum = '$forumname';");
	
	$row = mysql_fetch_array($qhandle);
	$postcount = $row["postcount"];
	
	if($postcount == 1)
		echo 'Currently displaying <font class="number" color="blue">' . $postcount . '</font> post. ';
	else
		echo 'Currently displaying <font class="number" color="blue">' . $postcount . '</font> posts. ';
?>