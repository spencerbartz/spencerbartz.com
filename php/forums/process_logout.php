<?php setcookie("secure", "");
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

	//check to see if the user was logged in
	$username = retrieve_user();
	
	if($username == -1 || $username == "")
	{
		//echo "username: " . $username . "<br>";
	
		echo "You weren't logged in anyway.<meta HTTP-EQUIV=refresh content=3;url=index.php>";
	}
	else
	{
		$qhandle = mysql_query("update users u set u.cookie = '' where u.username = '$username'");
			
		if (!$qhandle)
  			Die(mysql_error($qhandle));
  				
  		//setcookie("secure", "");
		echo "Logged out successfully.<meta HTTP-EQUIV=refresh content=3;url=index.php>";
	}

?>
<br>
<?php include 'footer.php'; ?>
</body>
</html>