<?php 
	include 'util.php';
	include 'dbconnect.php';
?>
<html>
	<head>
		<title><?php echo get_page_title(); ?></title>
		<?php print_includes(); ?>
	</head>
	
	<body>
		<div class="header">
		<h1>Log out</h1>
		</div>
		
		<div class="body">
		<form id="logout_form" method="post" action="process_logout.php">
 		<a href="javascript:;" onclick="document.getElementById('logout_form').submit();" class="forumbutton">Log out</a>
 		
 		<!--<input type="submit" name="submit" value="Log out">-->
 		</form>
 		
 		
		</div>	
	
		
		<?php include 'footer.php';?>
		
	</body>
	
</html>
