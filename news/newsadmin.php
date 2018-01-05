<?php
	include '../util/util.php';
	print_page_dec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
<script type="text/javascript">
	function deleteWarning(postid)
	{
		if(confirm("Are you sure you want to delete post: " + postid + "?"))
		{
			window.location.replace("newsadmin.php?deleteid=" + postid);
		}
	}
</script>
</head>

	<div id="overlay"></div>

	<!-- header starts here -->
	<div id="header">
		<div id="header-content">
		<?php print_header(__FILE__); ?>
		</div>
	</div>

<!-- navigation starts here -->
<div id="nav-wrap">
	<div id="nav">
		<?php print_nav(__FILE__); ?>
	</div>
</div>

<!-- content-wrap starts here -->
<div id="content-wrap">
	<div id="content">
    	<!-- Right side search box area -->
    	<div id="sidebar">
      		<div class="sep"></div>
    	</div>

    	<!-- Left Side (Main Content)-->
    	<div id="main">
      		<div class="box">
      			<?php process_params(); ?>
      			<h1><?php echo _('Welcome to <span class="white">News Admin</span>'); ?></h1>
      			<?php currently_editing(); ?>
      			<?php delete_post(); ?>
        		<p>
          		<form action="newsadmin.php" method="post">
            		<textarea style="width: 550px; height: 300px" name="posttext"><?php news_post_text(); ?></textarea><br />
            		<input type="hidden" name="postid" value="<?php news_post_id(); ?>" />
            		<input type="submit" value="submit"/>
         			</form>

							<table>
								<th class="first">ID</th>
								<th>Time Stamp</th>
								<th>Preview</th>
								<th>Action</th>
								<tr class="row-a">
									<td>N/A</td>
									<td>N/A</td>
									<td><a href="newsadmin.php">CREATE NEW NEWS STORY</a></td>
									<td>N/A</td>
								</tr>
							</table>
        		</p>
      		</div>
    	</div>
	</div>
</div>

<div id="footer-wrap">
	<div id="footer-columns"><?php print_footer(__FILE__); ?></div>
</div>

</body>
</html>
