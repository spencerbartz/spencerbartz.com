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

	//check to see if log in cookie is set
	$secure = $_COOKIE["secure"];
	
	//check to see if the user has logged in
	$username = retrieve_user();
	
	//print greeting
	echo "Hello " . $username . " !<br>";
	
	//retrieve forum name from parameters in URL
	$forumname = $_GET["forum"];
		
	//retrieve topic name from parameters in URL
	$topicname = $_GET["topic"];

	//retrieve postid from parameters in URL
	$postid = $_GET["postid"];
	
	//query database for table of forums ( forumname, description )
	$qhandle = mysql_query("delete from posts where forum='$forumname' and topic='$topicname' and author='$username' and postid='$postid'");	 	
	
	//print delete message
	echo "<h1>Post Deleted</h1>";
?>

<div class="footer">
	<?php include 'footer.php'; ?>
</div>

</body>
</html>
