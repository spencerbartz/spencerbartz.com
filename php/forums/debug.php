<html>
<head>
<title>
Forum Debug
</title>
</head>

<?php
include 'dbconnect.php';

function printTable($conn, $table_name)
{
	$qhandle = mysql_query("SELECT * FROM " . $table_name);
	
	if(!$qhandle)
		Die(mysql_error($conn));

	if(mysql_num_rows($qhandle) > 0)
	{
		echo $table_name . "<br>\n";
		echo "<table border=1>";
		
		//$row is an associative array
		$row = mysql_fetch_array($qhandle, MYSQL_ASSOC);
		
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
		while($row = mysql_fetch_array($qhandle, MYSQL_ASSOC));
	}
	echo "</table>";
}

printTable($conn, "forums");
printTable($conn, "topics");
printTable($conn, "posts");
printTable($conn, "users");

?>

</html>