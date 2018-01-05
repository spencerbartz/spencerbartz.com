<html>
<head>
<title>
Forum Debug
</title>
</head>

<?php


function printTable($table_name)
{
	include 'dbconnect.php';
	$res = $mysqli->query("SELECT * FROM " . $table_name);
	
	if(!$res)
		die($mysqli->error);

	if($res->num_rows > 0)
	{
		echo $table_name . "<br>\n";
		echo "<table border=1>";
		
		//$row is an associative array
		$row = $res->fetch_assoc();
		
		//get the array keys, which will be the names of the column headers
		$keys = array_keys($row);
		
		foreach($keys as $key)
			echo "<th>" . $key . "</th>";
		
		do
		{
			echo "<tr>\n";
			foreach($row as $field)
				echo "<td>" . $field . "</td>\n";
			echo "</tr>\n";

		}
		while($row = $res->fetch_assoc());
	}
	echo "</table>";
}

include 'dbconnect.php';

printTable("familynames");

$res = $mysqli->query("SELECT familyname FROM familynames");

while($row = $res->fetch_assoc())
{
	echo "<h1>The " . $row["familyname"] . " family</h1>";
	printTable($row["familyname"] . "_people");
	printTable($row["familyname"] . "_photos");
}

?>

</html>