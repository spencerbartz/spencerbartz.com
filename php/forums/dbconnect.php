<?php 
	
	$db_host = "spencerbartzcom1.ipagemysql.com";
	$db_user = "forumuser";
	$db_pass = "wewewe99";
	$db_name= "forumdb";

	/*
	$db_host = "localhost";
	$db_user = "spencer";
	$db_pass = "wewewe99";
	$db_name= "forumdb";
	*/
	//connect to db
	
	//$conn = mysql_connect("127.0.0.1", "805308_horrie", "wewewe99");
	$conn = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_name, $conn);

?>
