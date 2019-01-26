<?php
	include '../util/util.php';
	print_page_dec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
</head>

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
    	<!-- Left Side (Main Content)-->
    	<div id="main">
      		<div class="box">
      			<h1><?php echo _('Welcome to <span class="white">News Admin</span>'); ?></h1>

        		<p>
          		<form action="preview_new_news_story.php" method="post">
								<h3>Enter News Story Text</h3>
            		<textarea style="width: 775px; height: 300px" name="posttext"></textarea><br />
            		<input type="hidden" name="postid" value="" />
            		<input type="submit" value="Submit and Preview"/>
         			</form>

							<table>
								<thead>
									<th class="first">ID</th>
									<th>Time Stamp</th>
									<th>Preview</th>
									<th>Action</th>
								</thead>
								<tbody>
									<?php print_admin_news_list() ?>
								</tbody>
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
