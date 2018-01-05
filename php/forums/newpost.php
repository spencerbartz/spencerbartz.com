<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
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

	//retrieve forum name from parameters in URL
	$forumname = $_GET["forum"];
		
	//retrieve topic name from parameters in URL
	$topicname=$_GET["topic"];
	
	//connect to mysql databse
	include 'dbconnect.php';
	
	$qhandle = mysql_query("select * from users u where u.cookie = '$secure'");

	//if it is not set, give an error message	
	if($secure == "" || !$qhandle)
	{
		echo "<font color=red>";
		echo "<h1>You need to be logged in to make a post</h1>";
		echo "</font>";
	}
	else
	{
		//extract username from query
		$row = mysql_fetch_array($qhandle);
		$username = $row["username"];
?>

<h1>Create a new post in the <font color="blue"> <?php echo stripslashes($topicname); ?></font> Topic</h1>
<form method="post" action="process_newpost.php">
Enter your post text: <br>
<textarea rows="4" cols='42' name="usrtext"></textarea>

<!--<input type="submit" name="submit" value="Post!">-->
<a href = "process_newpost.php">Post</a>
<input type="hidden" name="forum" value="<?php echo $forumname; ?>">
<input type="hidden" name="topic" value="<?php echo stripslashes(htmlentities($topicname, ENT_COMPAT)); ?>">
<input type="hidden" name="author" value="<?php echo $username; ?>">
</form>

<?php
	}
?>

<div class="footer">
<?php include 'footer.php'; ?>
</div>

</body>
</html>
