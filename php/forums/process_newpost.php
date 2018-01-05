<?php
	include 'dbconnect.php';

	$postdate  =  date("Y-m-d H:i:s");
	$posttext = $_POST["posttext"];
	$forumname = $_POST["forumname"];
	$topicname = $_POST["topicname"];
	$username = $_POST["username"];
	
	$qhandle = mysql_query("insert into posts (postdate, posttext, forum, topic, author) values ('$postdate', '" . nl2br(addslashes($posttext)) . "', '$forumname', '$topicname', '$username');");

	if (!$qhandle)
	 	Die(mysql_error($conn));
	 else
	 	include 'post_list.php';
?>

