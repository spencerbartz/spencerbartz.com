<?php 
	include 'util.php';
	include 'dbconnect.php';
?>
<html>
<head>
	<title><?php echo get_page_title(); ?></title>
	<?php print_includes(); ?>
</head>
<body><div class="header"><h1>create user</h1></div>
<div class="body"><?php

$username = $_POST["username"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];

$qhandle = mysql_query("select * from users u where u.username = '$username'");
if (mysql_num_rows($qhandle) > 0)
{
	echo "Sorry, that username is taken, please choose another<meta HTTP-EQUIV=refresh content=4;url=createuser.php>";
}
else
{
	$qhandle = mysql_query("insert into users (username, password, firstname, lastname, email, cookie) values ('$username','$password','$firstname','$lastname','$email', '')");

	if (!$qhandle)
  		Die(mysqli_error($chandle));
	echo "User created successfully! <meta HTTP-EQUIV=refresh content=2;url=login.php>";
}
?></div>
<br>
	<div class="footer">	
		<?php include 'footer.php';?>
	</div>

</body>
</html>
