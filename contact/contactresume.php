<?php
	include '../util/util.php';
	print_page_dec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
</head>
<?php
	//Check to see if this page is being searched for a string.
	//If so, call the js highlighting function after page loads.
	if(isset($_GET['searchstr']))
		echo '<body onload="selectSearchWords(\'' . $_GET['searchstr'] . '\')">';
	else
		echo '<body>';

	$botCheck = generate_bot_check();
?>
	<div id="overlay"></div>
<!-- header starts here -->
<div id="header">
  <div id="header-content">
  <?php
  	print_header(__FILE__);
  ?>
  </div>
</div>
<!-- navigation starts here -->
<div id="nav-wrap">
  <div id="nav">
<?php
	print_nav(__FILE__);
?>
  </div>
</div>
<!-- content-wrap starts here -->
<div id="content-wrap">
  <div id="content">

    <!-- Right side search box area -->
    <div id="sidebar" >
      <div class="sidebox" id="searchbox">
	<?php print_search_box(__FILE__) ?>
      </div>
      <div class="sep"></div>
    </div>

    <!-- Left Side (Main Content)-->
    <div id="main">
      <div class="box">
        <h1><?php echo _('Contact Information <span class="white">and Résumé</span>'); ?></h1>
        <p>
        <?php
        	echo _("<strong>");
        	echo _("Spencer P. Bartz<br/>");
        	echo _("Phone: (805) 886-2293<br/>");
        	echo _('Email: <a href="mailto:spencerbartz@gmail.com">spencerbartz@gmail.com</a><br/>');
        	echo _('Skype: <a href="skype:spencerpbartz?call">spencerpbartz</a><br/>');
        	echo _('Résumé: <a href="spencer_bartz_resume.pdf" download="spencer_bartz_resume.pdf">Download in .pdf format</a><br/>');
        	echo _('View my repositories on <a href="https://github.com/spencerbartz?tab=repositories">Git Hub</a>');
        	echo _('</strong>');
        ?>
        </p>
        <p>

        <form action="confirmmsgsent.php" id="contactform" onsubmit="return checkFormFields('contactform', 'errormsg')" method="post">
        <?php echo _("<strong>Send me a message: </strong>"); ?><div id="errormsg" class="errormsg"></div><br/><br/>

        <div id="errname"><?php echo _("Name: "); ?></div><input name="name" class="textbox" type="text" /><br/><br/>
        <div id="erremail"><?php echo _("Email: "); ?></div><input name="email" class="textbox" type="text" /><br/><br/>
        <div id="errsubject"><?php echo _("Subject: "); ?></div><input name="subject" class="textbox" type="text" /><br/><br/>
        <div id="errmessage"><?php echo _("Message: "); ?></div><textarea name="message" rows="50" cols="100"></textarea><br/>
		<div id="erruserresult"><?php echo _("Prove you're a human (negative numbers are OK): "); ?></div><?php echo $botCheck[0]; ?><input name="userresult" class="textbox" type="text" /><br/><br/>
        <input name="result" type="hidden" value="<?php echo $botCheck[1]; ?>">
		<input name="txtmsg" value="txtmsg" type="checkbox" /> <?php echo _('Send me a text message'); ?><br/><br/>
        <input name="submit" class="button" value="<?php echo _('Submit'); ?>" type="submit" /><br/>

        </form>

        </p>
        <p class="post-footer align-right"><span class="date"><?php last_updated(__FILE__); ?></span> </p>
      </div>
    </div>

    <!-- content-wrap ends here -->
  </div>
</div>
<!-- footer starts here-->
<div id="footer-wrap">
  <div id="footer-columns">
  	<?php
  		print_footer(__FILE__);
  	?>
  </div>
  <!-- footer ends-->
</div>
</body>
</html>
