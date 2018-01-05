<?php

	$db_host = "localhost";
	$db_user = "spencer";
	$db_pass = "wewewe99";
	$db_name= "forumdb";

	//$db_host = "spencerbartzcom1.ipagemysql.com";
	//$db_user = "forumuser";
	//$db_pass = "wewewe99";
	//$db_name= "forumdb";
	//$web_user = "spencer";

	//include 'dbconnect.php';


	//connect to db
	$conn = mysql_connect($db_host, $db_user, $db_pass);

	if(!$conn) 
	{
		die('Failed to connect: ' . mysql_error());
	}
	else
	{
		echo "Connected<br>";
	}


	//create database
	if(mysql_query("CREATE DATABASE IF NOT EXISTS " . $db_name, $conn))
	{
		echo "Database Created \n";
	}
	else
	{
		echo "Error creating database: " . mysql_error() . "\n";
	}
	
	$db_selected = mysql_select_db($db_name, $conn);
	
	if(!$db_selected)
	{
		echo "Error selecting database." . mysql_error() . "\n";
		die ("Error" . " File: " . __FILE__ . " on line: " . __LINE__);
	}
	else
	{
		echo "Selected " . $db_name . "\n";
	}
	
	//create users table
	if(mysql_query("CREATE TABLE IF NOT EXISTS users  (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(26), firstname VARCHAR(50), lastname VARCHAR(50), email VARCHAR(50), cookie VARCHAR(256))", $conn)) 
	{
		echo "Created table: users \n";
	}
	else
	{
		echo "Error creating table: users " . mysql_error() . "\n";
	}
	
	//create the forum table
	if(mysql_query("CREATE TABLE IF NOT EXISTS forums(forumname VARCHAR(128), description VARCHAR(256))", $conn))
	{
		echo "Created table: forums \n";
	}
	else
	{
		echo "Error creating table: forums" . mysql_error() . "\n";
	}		
	
	if(mysql_query("INSERT INTO forums(forumname, description) VALUES ('General Discussion', 'Talk about whatever you want!')", $conn))
	{
		echo "Created general discussion \n";
	}
	else
	{
		echo "Error seeding forums table" . mysql_error() . "\n";
	}
	
	if(mysql_query("INSERT INTO forums(forumname, description) VALUES ('Fine Dining', 'For the gourmand, glutton, and those who wish to avoid paying too much.')", $conn))
	{
		echo "Created fine dining \n";
	}
	else
	{
		echo "Error seeding forums table" . mysql_error() . "\n";
	}

	if(mysql_query("INSERT INTO forums(forumname, description) VALUES ('Relationship Advice', 'Q & A for your love life.')", $conn))
	{
		echo "Created relationship advice \n";
	}
	else
	{
		echo "Error seeding forums table" . mysql_error() . "\n";
	}
	
	//create the topics table
	if(mysql_query("CREATE TABLE IF NOT EXISTS topics (topicname VARCHAR(128), user VARCHAR(50), date_created TIMESTAMP, forum VARCHAR(128))", $conn))
	{
		echo "Created table: topics \n";
	}
	else
	{
		echo "Error creating table: topics" . mysql_error() . "\n";
	}
	
	if(mysql_query("CREATE TABLE IF NOT EXISTS posts (postid INT NOT NULL AUTO_INCREMENT PRIMARY KEY, postdate TIMESTAMP, posttext VARCHAR(512), forum VARCHAR(128), topic VARCHAR(128), author VARCHAR(50))", $conn))
	{
		echo "Created table: posts \n";
	}
	else
	{
		echo "Error creating table: posts" . mysql_error() . "\n";
	}

	//grant privileges -> GRANT SELECT, INSERT, DELETE on forumdb.* to spencer@'localhost' IDENTIFIED BY 'wewewe': 
	/*
	if(mysql_query("GRANT SELECT, INSERT, DELETE, UPDATE, DROP on ". $db_name . ".* to " . $web_user . "@'" . $db_host . "' IDENTIFIED BY 'wewewe'", $conn))
	{
		echo "User " . $web_user . " now has privileges on " . $db_host . ".*\n"; 
	}
	else
	{
		echo "Error granding privileges. " . mysql_error() . "\n"; 
	}
	*/
?>