<?php 
	
	$db_host = "spencerbartzcom1.ipagemysql.com";
	//$db_host = "localhost";
	$db_user = "stammbaum";
	$db_pass = "kakeizu";
	$db_name= "stammbaumdb";

	
	//$db_host = "localhost";
	//$db_user = "spencer";
	//$db_pass = "wewewe99";
	//$db_name= "stammbaum";
	
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	
	if($mysqli->connect_errno) 
	{
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	//echo $mysqli->host_info . "\n";

?>
