<?php
	include '../util/util.php';
	print_page_dec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
</head>
<body>
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
        <h1><?php echo _('Welcome to <span class="white">spencerbartz.com</span>'); ?></h1>
        <p>
        <?php
			function check_input($data) 
			{
				return  filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES | FILTER_FLAG_STRIP_HIGH);
			}
			
        	$to = "spencerbartz@gmail.com";
        	$keys = array("name", "email", "subject", "message", "userresult");
			$post_params = array();
        	
        	//Make sure contents of msg are not empty (i.e. a request was made to this page without posting the form)
        	foreach($keys as $key)
        	{
        		if(isset($_POST[$key]))
        		{
					$post_params[$key] = check_input($_POST[$key]);
				}
				else
				{
					echo _('ERROR: No input provided');
					echo _('<meta HTTP-EQUIV="refresh" content="0; url=http://www.spencerbartz.com/contact/contactresume.php">');
					die();
				}
        	}
		
			if($_POST["result"] !== $_POST["userresult"])
			{
				echo _('ERROR: Incorrect answer. Are you really human?');
				echo _('<meta HTTP-EQUIV="refresh" content="2; url=http://www.spencerbartz.com/contact/contactresume.php">');
				die();
			}
			
			$headers = "From:" . "automailer@spencerbartz.com";
			$ip = $_SERVER["REMOTE_ADDR"];
			$browser = $_SERVER["HTTP_USER_AGENT"];
			$referer = $_SERVER["HTTP_REFERER"];
			
			//If the text message checkbox was checked, send the message to my phone as well.
			if(isset($_POST["txtmsg"]))
				$to .= ",8058862293@txt.att.net";
			
			if ($referer == "")
				$referer = "NONE";
			
			$message = "EMAIL: " . $post_params["email"] . "\n" . "NAME: " . $post_params["name"] . "\n" . "IP: " . $ip . "\n" . "BROWSER: " . $browser . "\n" . "REFERER: " . $referer . "\n" . "MESSAGE BODY:\n" . $post_params["message"];
			
			if(mail($to, $post_params["subject"], $message, $headers))
			{
				echo _("<strong>Message sent successfully!</strong><br/>");
				echo _("<strong>Redirecting...</strong><br/>");
				echo _('<meta HTTP-EQUIV="refresh" content="2; url=http://www.spencerbartz.com/contact/contactresume.php">');
			}
			else
			{
				echo _("<strong>Failed to send message.</strong><br/>");
			}
        ?>
        </p>
        <p>
        </p>
        <p class="post-footer align-right"><span class="date"><?php last_updated(__FILE__); ?></span></p>
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
