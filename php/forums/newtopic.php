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
	
	//check to see if the user has logged in
	$username = retrieve_user();
	
	$forumname = $_GET["forum"];
	
	if($username != "")
	{
		//print greeting
		echo "Hello " . $username . " !<br>";
		
		echo '<h1>Create a new topic in the <font color="blue">' .  $forumname  . '</font> Forum</h1>';
		echo '<form id="newtopic_form" method="post" action="process_newtopic.php">';
		echo 'New Topic Name: <br>';
		echo '<input type="text" name="topic" class="forum-rounded"><br><br>';
		echo '<a href="javascript:;" onclick="document.getElementById(\'newtopic_form\').submit();" class="forumbutton">New Topic</a>';
		//echo '<input type="submit" name="submit" value="Create New Topic">';
		echo '<input type="hidden" name="forum" value="' .  $forumname . '">';
		echo '<input type="hidden" name="owner" value="' . $username . '">';
	}
	else
	{
		echo "<font color=red>";
		echo "<h1>You need to be logged in to start a new topic</h1>";
		echo "</font>";
	}
	

?>

<div class="footer">
<?php include 'footer.php'; ?>
</div>
</body>
</html>
