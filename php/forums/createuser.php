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
  			<h1>sign up</h1>
  		  </div>
  		  
  		 <div class="body">
			
		<form id="createuser_form" method="post" action="process_createuser.php">		
		<table class="oioi">
		<tr><td>user name</td><td><input type="text" name="username" class="forum-rounded"></td></tr>
		<tr><td>password</td><td><input type="password" name="password" class="forum-rounded"></td></tr>
		<tr><td>first name</td><td><input type="text" name="firstname" class="forum-rounded"></td></tr>
		<tr><td>last name</td><td><input type="text" name="lastname" class="forum-rounded"></td></tr>
		<tr><td>email</td><td><input type="text" name="email" class="forum-rounded"></td></tr>
		<tr><td><a href="javascript:;" onclick="document.getElementById('createuser_form').submit();" class="forumbutton">Enter User</a></td></tr>
		</table>
		
		<!--<a href="process_createuser.php" class="forumbutton">Enter User</a>-->
		
		
		
		<!-- <input type="submit" name="submit" value="Enter User"> -->
		</form>
		</div>
		<div class="footer">
		<?php include 'footer.php';?>
		</div>
	</body>
</html>
