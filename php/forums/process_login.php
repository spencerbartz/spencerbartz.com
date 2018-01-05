<?php setcookie ("secure", "");

include 'dbconnect.php';

//note to self, if the thing from $_POST isn't found, then it returns the empty string

$username = $_POST["username"];
$password = $_POST["password"];


$qhandle = mysql_query("select * from users u where u.username = '$username' and u.password = '$password'");

if (!$qhandle)
	Die(mysql_error($conn));

$found = False;

if (mysql_num_rows($qhandle) > 0)
{
	$cookieval = md5($username);
	setcookie ("secure", $cookieval);
	$ret = mysql_query("update users u set cookie = '$cookieval' where u.username = '$username'");
	
	if (!$ret)
		Die(mysql_error($conn));
	
	$found = True;
}

?>

<html>
	<head>
		<title><?php include 'util.php'; echo $title; ?></title>
		<?php print_includes(); ?>
	</head>

<body><div class="header"><h1>log in</h1></div><div class="body">
<?php
	if($found == True)
		echo "Login successful!<meta HTTP-EQUIV=refresh content=1;url=index.php>";
        else
		echo "The user name and password combination you entered was not found in the database <meta HTTP-EQUIV=refresh content=4;url=login.php>";
?></div>
	<br>
	<?php include 'footer.php';?>
</body>

</html>
