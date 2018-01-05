<?php

	include 'dbconnect.php';
	include 'sbutil.php';
	
	$family = "Simpson";
	
	echo "Removing table " . $family . "_photos " . "<br/>\n";
	$sql = "drop table " . $family . "_photos";
	if(!$mysqli->query($sql))
		echo "ERROR could not delete table " . $family . "_photos" . "<br/>\n";
	
	echo "Removing table " . $family . "_people" . "<br/>\n";
	$sql = "drop table " . $family . "_people";	
	if(!$mysqli->query($sql))
		echo "ERROR could not delete table " . $family . "_people" . "<br/>\n";
	
	echo "Removing " . $family . " from familynames" . "<br/>\n";
	$sql = "delete from familynames where familyname = '" . $family . "'";
	if(!$mysqli->query($sql))
		echo "ERROR could not " . $family . " from familynames" . "<br/>\n";
		
	echo "Removing uploads/" . $family . "/_thumbnails" . "<br/>\n";
	if(!deleteDirectory("uploads/" . $family . "/thumbnails"))
		echo "ERROR could not delete uploads/" . $family . "/_thumbnails" . "<br/>\n";
	
	echo "Removing uploads/" . $family . "<br/>\n";
	if(!deleteDirectory("uploads/" . $family))
		echo "ERROR could not delete uploads/" . $family . "<br/>\n";
?>