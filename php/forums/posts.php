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
		
	//retrieve topic name from parameters in URL
	$topicname = $_GET["topic"];

	echo '<div class="header">';
	//display welcome message	
	echo '<h1>Welcome to the <font color="blue">' . stripslashes($topicname) .'</font> Topic in the <font color="blue">'. $forumname . ' </font>Forum</h1>';
	echo "</div>";
	
	echo '<div id="postcount" class="header">';	
	//display the number of posts in this topic	
	$qhandle = mysql_query("select count(*) as postcount from posts where topic = '$topicname' and forum = '$forumname';");
	
	$row = mysql_fetch_array($qhandle);
	$postcount = $row["postcount"];
	
	if($postcount == 1)
		echo 'Currently displaying <font class="number" color="blue">' . $postcount . '</font> post. ';
	else
		echo 'Currently displaying <font class="number" color="blue">' . $postcount . '</font> posts. ';
	echo "</div>";

	echo '<div class="table_container">';
	echo '<div id="post_list">';
	include 'post_list.php';
	echo '</div>';
	echo '</div>';
	echo '<br>';

	//display the "Make new Post" button to any user. Contents of 'comment_field' will differ if not logged in
	echo '<a href="javascript:;" class="forumbutton" onclick="toggleVisible(\'comment_field\')">Make a new post</a>';
	echo '<br>';
	//this text area will appear once a logged-in user presses the "Make new Post field"
	echo '<div  id="comment_field"  class="new_post" style="visibility:hidden">';
	
	//have this update the posts database via ajax, then reload the list of posts only. Do not display if user isn't logged in
	if($username != "")
	{
		//javascript signature: updatePostList(posttext, forum, topic, username)
		echo '<form method="post" id="comment_form">';
		echo 'Enter your post text: <br>';
		echo '<textarea rows="4" cols="42" id="posttext" class="forum-rounded"></textarea>';
		echo '<a class="forumbutton" onclick="JavaScript:updatePostList(\'posttext\', \'' . $forumname . '\', \'' . $topicname . '\', \'' . $username . '\');clearTextArea(\'posttext\');">Submit</a>';
		echo '</form>';
	}
	else
		echo 'You aren\'t logged in. You must log in to make posts.';
	
	echo '</div>';

	//set $topicname to the empty string so that footer does not make a link to it
	$topicname = "";
	include 'footer.php';
?>

</body>
</html>
