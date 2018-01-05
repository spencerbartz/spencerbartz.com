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
			<h1>Log in</h1>
		</div>
		<br>
		<div class="form_container">

		<form id="login_form" method="post" action="process_login.php">
		<table>
		<tr><td>user name</td><td><input type="text" name="username" class="forum-rounded"></td></tr>
		<tr><td>password</td><td><input type="password" name="password" class="forum-rounded" onKeyPress="return submitenter(this,event)"></td></tr>
		<tr><td><a href="javascript:;" onclick="document.getElementById('login_form').submit();" class="forumbutton">Log in</a></td></tr>
		</table>
		</form>
                Not a member? <a href = "createuser.php">Sign up today!</a>
		</div>

		<?php include 'footer.php';?>
	</body>

</html>
