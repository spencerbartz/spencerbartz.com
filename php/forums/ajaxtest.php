<?php
	//xmlhttp.send('posttext=' + posttext + '&forumname=' + forum + '&topicname=' + topic +  '&username=' + username);
	
	$posttext = $_POST["posttext"];
	$forumname = $_POST["forumname"];
	$topicname = $_POST["topicname"];
	$username = $_POST["username"];
	
	echo "Post Text: " . $posttext . "<br>";
	echo "Forum Name: " . $forumname . "<br>";
	echo "Topic Name: " . $topicname . "<br>";
	echo "User Name: " . $username . "<br>";
	
?>