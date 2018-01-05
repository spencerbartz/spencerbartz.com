<?php
	//UTILITY FUNCTIONS

	function print_includes()
	{
		echo '<script src="js/forum_util.js"></script>';
		echo '<script>';
		echo 'var BrowserDetect = getBrowserInfo();';
		echo 'if(BrowserDetect.browser == "Explorer")';
		echo '{';
		echo 'document.write(\'<link rel="stylesheet" href="css/forum_style_ie8.css" type="text/css">\');';
		echo '}';
		echo 'else';
		echo '{';
		echo 'document.write(\'<link rel="stylesheet" href="css/forum_style.css" type="text/css">\');';
		echo '}';
		echo '</script>';
	}

	function convert_date($datestr)
	{
		//convert date from 24 hour  mysql format to correct American format
		//example date string 2007-01-07 22:25:27
		
		$year = strval(substr($datestr, 0, 4));
		$month = strval(substr($datestr, 5, 2));
		$day = strval(substr($datestr, 8, 2));
		
		//cut up string into 2 strings.  1 for 12/24 hour conversion, 2 for mins & seconds
		$time = strval(substr($datestr, 11, 8));
		$hour = strval(substr($time, 0, 2));
		$minsec = strval(substr($time, 2, 6));
		
		$ampm = "";
		
		//convert to 12 hour time
		if($hour > 12)
		{
			$hour = $hour - 12;
			$ampm = "pm";	
		}
		else
			$ampm = "am";
		
		//construct a time stamp string for when the topic was started
		$datestarted = $month . '/' . $day . '/' . $year . ' ' . $hour . $minsec  . ' ' . $ampm;
		
		return $datestarted;
	}
	
	//TODO make a cleaner return value
	//Check if the user is logged in, and if so get their username. If not, tell users they are not logged in
	function retrieve_user()
	{
		
		if(isset($_COOKIE["secure"]))
		{	
			$secure = $_COOKIE["secure"];
						
			$res = mysql_query("select * from users where cookie = '$secure'");
			
			if(mysql_num_rows($res) == 1)
			{
				//value in cookie is set and matches an entry in the database
				$row = mysql_fetch_array($res);
				$username = $row["username"];
			}
			else
			{
				//value in cookie is set but does not match anything in the database
				$username = -1;
			}
			
			return $username;
				
		}
		else
		{
			//value in cookie is not set at all
			echo '<font color="red">You are not logged in.  You must <a href = "login.php">log in</a> to make posts and create new topics</font><br><br>';
			return "";
		}
	}
	
	//This function has been targeted for termination
	function check_login($secure)
	{
		$qhandle = mysql_query("select * from users u where u.cookie = '$secure'");

		//if it is not set, give an error message	
		if($secure == "" || !$qhandle)
		{
			echo '<font color="red">You are not logged in.  You must <a href = "login.php">log in</a> to make posts and create new topics</font><br><br>';
			return "";
		}
		else
		{
			$row = mysql_fetch_array($qhandle);
			$username = $row["username"];
			return $username;
		}
	}
	
	//All pages use the same title.
	function get_page_title()
	{
		return "Spencer's Forums";
	}
	
	function get_forum_title()
	{
		return "Spencer's Forums";
	}
	
	function debug()
	{
		echo "forum is " . $forumname . "<br>";
		echo "topic is " . $topicname . "<br>";
		echo "postid is " . $postid . "<br>";
	}
	
	$forumname = "";
?>