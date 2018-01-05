<?php
	//This script prints the contents of the posts SQL table in an HTML table

	//query database for table of posts corresponding to this forum and topic
	$qhandle = mysql_query("select * from posts where forum = '$forumname' and topic = '$topicname' order by postdate;");
	
	if (!$qhandle)
	 	Die(mysql_error($link));
	 
	echo '<table class="forum_table">';
	
	//table header
  	echo '<tr><th align = "left" width = "15%">Author</th>';
  	echo '<th align = "center" width = "70%">Comment</th>';
  	echo '<th align = "center" width = "15%">Date Posted</tr>';

	$count = 0;
	
	//query database for table of posts corresponding to this forum and topic
	$qhandle = mysql_query("select * from posts where forum = '$forumname' and topic = '$topicname' order by postdate desc;");
	
	while($row = mysql_fetch_array($qhandle))
	{
		$author = $row["author"];
		$postdate = $row["postdate"];
		$posttext = $row["posttext"];
		$postid = $row["postid"];
		
		//color every other post
		$trclass = "";
		if($count % 2 == 0)
			$trclass = ' class="colorpost"';
		
		echo '<tr ' . $trclass . '><td>' . $author . '</td>';
		echo '<td>' . $posttext; '</td>';	
		
		if(strcmp($author, $username) == 0)
		{
			echo ' <br><a href="javascript:deletePrompt(\'' . urlencode($forumname) . '\' , \'' . urlencode($topicname) . '\',  \'' . urlencode($postid) . '\')">Delete this post</a>';
		}
		
		echo '<td>' . $postdate . '</td></tr>';
		
		$count++;
	}
	echo '</table>';
?>