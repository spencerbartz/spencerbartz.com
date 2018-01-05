<?php

function printMenu($curPage, $curDB = "")
{
	//prevent form "submit" pages from being refreshed without correct GET/POST data
	//Any link to page "blahsubmit.php" should be replaced by "blah.php" to avoid this.
	if(strpos($curPage, "submit.php") > 0)
	{
		$curPage = substr($curPage, 0, strpos($curPage, "submit.php")) . ".php";
	}
	
	//Switching family line while on an "edit" page will cause problems when the "id" for 
	//the id for photo or family member being edited is passed to the edit page with a different family line.
	//New family line will be selected and the user will be redirected to stammbaum main
	if(strpos($curPage, "edit") > 0)
	{
		$curPage = "index.php";	
	}
	
	if(strlen($curDB) > 0)
	{
		if($curDB === "none")
			$curDB = "";
		else
			$curDB = "?dbname=" . $curDB;	
	}		
?>
<div class="cssmenu" id="cssmenu">

<ul>
   <li class="active has-sub"><a href="#"><span><?php echo ("Menu"); ?></span></a>
      <ul>
         <li class="last"><a href="index.php<?php echo $curDB; ?>"><span><?php echo _("Stammbaum Main"); ?></span></a></li>
         <li class="has-sub"><a href="search.php<?php echo $curDB; ?>"><span><?php echo _("Select Family Line"); ?></span></a>
            <ul>
            <?php
            	include "dbconnect.php";
		
		$sql = "SELECT familyname FROM familynames"; 
        	
        	if(!$res = $mysqli->query($sql))
        	{
        		echo "<li><span><a>No lines created yet.</a></span></li>";
        	}
        	else
        	{
        		$res = $mysqli->query($sql);
        	
        		while($row = $res->fetch_array(MYSQLI_NUM))
        		{
        		?>
        			<li><a href="<?php echo $curPage . "?dbname=" . $row[0]; ?>&lineselect=1"><span><?php echo $row[0]; ?></span></a></li>
        		<?php
        		}
        	}
        	
            
            ?>
               <!-- <li><a href="<?php echo $curPage . "?dbname=Bartz"; ?>"><span>Bartz</span></a></li> 
               <li><a href="#"><span></span></a></li>-->
               <li class="last"><a href="newline.php"><span><?php echo _("Create New Family Line"); ?></span></a></li>
            </ul>
         </li>
         <li><a href="addmember.php<?php echo $curDB; ?>"><span><?php echo _("Add new Family Member"); ?></span></a></li>
         <li><a href="addphoto.php<?php echo $curDB; ?>"><span><?php echo _("Upload new Family Photo"); ?></span></a></li>
         <li><a href="listmembers.php<?php echo $curDB; ?>"><span><?php echo _("List All Family Members"); ?></span></a></li>
         <li><a href="listphotos.php<?php echo $curDB; ?>"><span><?php echo _("List All Photos"); ?></span></a></li>
         <li><a href="search.php<?php echo $curDB; ?>"><span><?php echo _("Search photos and people"); ?></span></a></li>
      </ul>
   </li>
</ul>
</div>

<?php
}

function sbIncludes()
{
?>
   <link rel="stylesheet" href="styles.css" />
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="script.js" type="text/javascript"></script>
<?php
}

function getCurDB()
{
	$dbname = "";
	
	if(isset($_GET["dbname"]))
		$dbname .= $_GET["dbname"];
	else 
		$dbname .= "none";
	
	return $dbname;
}

function createDB($dbname)
{
	include 'dbconnect.php';
	$familyname = $_POST["familyname"];
	
	$sql = "CREATE TABLE IF NOT EXISTS familynames(id int not null AUTO_INCREMENT, familyname varchar(255), datecreated DATE, PRIMARY KEY(id))";
	
	if(!$mysqli->query($sql))
	{ 
		echo _('<meta HTTP-EQUIV="refresh" content="0; url=error.php?errmsg=' . urlencode("Failed to create family line. Redirecting..." . "(" . $mysqli->errno . ") " . $mysqli->error) . '">');
	}
	
	$sql = "INSERT INTO familynames VALUES(NULL, '" . $familyname . "', NOW())";
	
	if(!$mysqli->query($sql))
	{ 
		echo _('<meta HTTP-EQUIV="refresh" content="0; url=error.php?errmsg=' . urlencode("Failed to create family line. Redirecting..." . "(" . $mysqli->errno . ") " . $mysqli->error) . '">');
	}
	else
	{
		echo "Successfully created family line: " . $familyname . "<br/>";
	}
	
	$sql = "create table " . $familyname . "_people(id int not null AUTO_INCREMENT, familyname varchar(255) default '" . $familyname . "', lastname varchar(255) not null, firstname varchar(255) not null," .
	"middlename varchar(255) default '', maidenname varchar(255) default '', sex varchar(255), dob DATE default '0000-00-00'," . 
	"dod DATE default '0000-00-00', description varchar(10000), mother varchar(255), father varchar(255), children varchar(1000) default 'none', datecreated TIMESTAMP," . 
	"datemodified TIMESTAMP, editedby varchar(255) not null, PRIMARY KEY(id))";
	
	if(!$mysqli->query($sql))
	{
		echo _('<meta HTTP-EQUIV="refresh" content="0; url=error.php?errmsg=' . urlencode("Failed to create people table. " . "(" . $mysqli->errno . ") " . $mysqli->error) . '">');
	}
	else
	{
		echo "Successfully created table: People<br/>";
	}
	
	$sql = "create table " . $familyname . "_photos(id int not null AUTO_INCREMENT, filename varchar(2048), datetaken DATE, description varchar(10000)," .
	"peopleshown varchar (4096), datemodified TIMESTAMP, editedby varchar(255) not null, PRIMARY KEY(id))";
	
	if(!$mysqli->query($sql))
	{
		echo _('<meta HTTP-EQUIV="refresh" content="0; url=error.php?errmsg=' . urlencode("Failed to create photos table. " . "(" . $mysqli->errno . ") " . $mysqli->error) . '">');
	}
	else
	{
		echo "Successfully created table: Photos<br/>";
	}
	
        if(!mkdir("uploads/" . $_POST["familyname"], 0777, true)) 
        	die('Failed to create upload folder...');
	else
		echo "Created photo folder Successfully<br/>";
        		
        if(!mkdir("uploads/" . $_POST["familyname"] . "/thumbnails", 0777, true)) 
        	die('Failed to create thumbnails folder...');
	else
		echo "Created thumbnail folder Successfully<br/>";
	
	//TODO: Add a foreign key to a "comments" or "activity" table (maybe split that into 2 ?)
	/*
	$sql = "create table sb" . $familyname . ".users(id int not null AUTO_INCREMENT, username varchar(255) not null, firstname varchar(255) not null, lastname varchar(255) not null," .
	"datejoined TIMESTAMP, peopleshown varchar (4096),  PRIMARY KEY(id))";

	if(!$mysqli->query($sql))
	{
		echo _('<meta HTTP-EQUIV="refresh" content="0; url=error.php?errmsg=' . urlencode("Failed to create users table. " . "(" . $mysqli->errno . ") " . $mysqli->error) . '">');
	}
	else
	{
		echo "Successfully created table: Users<br/>";
	}
	*/
}

function getThumbFromPath($imgPath)
{
	$ext = substr($imgPath, strlen($imgPath) - 4);
	$dir = dirname($imgPath) . "/thumbnails/";
	$img = basename($imgPath, $ext) . "-tn" . $ext;
	return $dir . $img;
}

function printPhotoTable($res, $curDB)
{
	if($res->num_rows > 0)
	{
		$rowSwitch = 0;
		echo "<table>";
		echo '<tr>';
		echo '<th class="first">id</th>';
		echo '<th class="first">Filename</th>';
		echo '<th>Date taken</th>';
		echo '<th>Description</th>';
		echo '<th>People Tagged</th>';
		echo '<th>Date Modified</th>';
		echo '<th>Edited By</th>';
		echo '<th>Thumbnail</th>';
		echo '</tr>';
        	
        	while($row = $res->fetch_assoc())
		{	
			if($rowSwitch % 2 == 0)
				echo '<tr class="row-a">';
			else
    				echo '<tr class="row-b">';
    			
    			$rowSwitch++;
			
			echo "<td>" . $row['id'] . "</td><td>" . 
			basename($row['filename']) . "</td><td>" . 
			$row['datetaken'] . "</td><td>" . 
			$row['description'] . "</td><td>" . 
			$row['peopleshown'] . "</td><td>" . 
			$row['datemodified'] . "</td><td>" . 
			$row['editedby'] . "</td><td>" . 
			'<a href="' . $row['filename'] . '" target="new"><img src="' . getThumbFromPath($row['filename']) . '" /></a><br/><a href="editphoto.php?dbname=' . $curDB . '&id=' . $row['id'] . '">Edit</a><br/><a onclick="promptDeletePhoto(' . "'" . $curDB  . "', '" . $row['id'] . "'" . ')">Delete</a></td></tr>';
		}
		echo "</table>";
		return true;
	}
	else
	{
		return false;
	}
}

function printProfileList($res, $curDB)
{

	if($res->num_rows > 0)
	{		
		$cols = 1;
		$maxcols = 5;
		
		while($row = $res->fetch_assoc())
		{

			if($cols % $maxcols == 0)
			{
				$cols = 1;
				echo '<div id="' . $row["id"] . '" class="person" style="clear:left;float:left">';
			}
			else
			{
				$cols++;
				echo '<div id="' . $row["id"] . '" class="person" style="float:left">';
			}
			echo $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "<br/>";
			echo "Sex: " . $row["sex"] . "<br/>";
			echo "Date of birth: " . $row["dob"] . "<br/>";
			
			if($row["dod"] !== "0000-00-00")
				echo "Date of death: " . $row["dod"] . "<br/>";
			
			echo "Description:<br/>" . $row["description"] . "<br/>";
			echo "Last Edited By: " . $row["editedby"];
			echo '</div>';
		}
		
		return true;
	}
	else
	{
		return false;
	}


}
?>