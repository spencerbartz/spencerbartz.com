<?php

	echo '<br>';
	echo '<hr>';
	
	echo '<div class="footer">';
	echo '<a class="footer" href="index.php">Forums Main</a> | ';
	
	//Which forum are we in?
	if(isset($forumname) && $forumname != "")
		echo '<a class ="footer" href="topics.php?forum=' . urlencode($forumname) . '">Back to ' . $forumname . ' forum</a> | ';	
	
	//Which topic are we in?
	if(isset($topicname) && $topicname != "")
		echo '<a class="footer" href="posts.php?forum=' . urlencode($forumname) . '&topic=' . stripslashes($topicname) . '">Back to ' . stripslashes($topicname) . ' topic</a> | ';
	
	echo '<a class="footer" href="login.php">Log In</a> | ';
	echo '<a class="footer" href="logout.php">Log Out</a> | ';
	echo '<a class="footer" href="../../index.php">Back to spencerbartz.com</a>';
	echo '</div>';
	
	echo '<div class="footer">';
	echo 'Spencer Bartz Copyright &copy; 2015. This site is best viewed with <a href="http://www.mozilla.org/en-US/firefox/new/">Mozilla Firefox</a> or <a href="https://www.google.com/chrome/">Google Chrome</a><br>';
	echo '</div>';
?>
