<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title><?php include 'util.php'; echo $title; ?></title>
	<?php print_includes(); ?>
</head>

<body>

<?php
	include 'dbconnect.php';
	
	$forumname = $_POST["forum"];
	$topicname = $_POST["topic"];
	$user = $_POST["owner"];
	$date_created  = date("Y-m-d H:i:s");
	
	//check if this topicname - forum pair already exists in the database
	$qhandle = mysql_query("select * from topics where topicname = '" . $topicname . "' and forum = '" . $forumname . "';");
	
	if(mysql_num_rows($qhandle) > 0)
		echo '<h1><font color = "red"> Error:</font> Topic '. stripslashes($topicname)  . ' already exists in the <font color = "blue">' . $forumname . ' </font>Forum</h1>';
	else
	{
		$qhandle = mysql_query("insert into topics (topicname, user, date_created, forum) values ('$topicname', '$user', '$date_created', '$forumname');");
		
		if(!$qhandle)
			 Die(mysql_error($conn));
		else
			echo '<h1>Topic '. stripslashes($topicname)  . ' Created Successfully on ' . convert_date($date_created) . '</h1>';
	}
?>

<div class="footer">
<?php include 'footer.php'; ?>
</div>
</body>
</html>
