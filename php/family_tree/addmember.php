<?php
	include '../util.php';
	include 'sbutil.php';
	$curLang = "en";
	if(isSet($_GET["locale"]))
		$curLang = "jp";
	
	if(strcmp($curLang, "jp") === 0)
		changeLanguage();
		
	printPageDec(__FILE__);
?>

<title><?php echo _("Spencer Bartz - Portfolio Website"); ?></title>
<?php sbIncludes(); ?>
</head>
<body>
<!-- header starts here -->
<div id="header">
  <div id="header-content">
  <?php
  	printHeader(__FILE__);
  ?>
  </div>
</div>
<!-- navigation starts here -->
<div id="nav-wrap">
  <div id="nav">
<?php
	printNav(__FILE__);
?>
  </div>
</div>
<!-- content-wrap starts here -->
<div id="content-wrap">
  <div id="content">
    <div id="sidebar" >
      <div class="sep"></div>
      <div class="sidebox">
      </div>
      <div class="sidebox">
        <ul class="sidemenu">
          <li></li>
        </ul>
      </div>
    </div>
    
    <!-- Left Side (Main Content)-->
    <div id="main">
      <div class="box">
      <?php $curDB = getCurDB(); ?>
        <div style="float:left"><h1><?php echo _('Add New {' . $curDB . '} <span class="white">Family Member</span>'); ?></h1></div>
        	<?php 
        		if($curDB !== "none")
        		{
				echo '<div class="dropdown" style="float:right">';
				printMenu($_SERVER['PHP_SELF'], $curDB);
				echo '</div>';
        		}
        		else
        		{
        			echo "Family Line: None selected";
        			echo _('<meta http-equiv="refresh" content="0; url=error.php?errmsg=' . urlencode("No Family Line Selected.") . '">');
        			die();
        		}
        	?>
        <div class="blurb">
        <div id="errormsg"></div>
   	<form action="addmembersubmit.php?dbname=<?php echo getCurDB(); ?>" id="addnewform" onsubmit="return checkFormFields('addnewform', 'errormsg', ['mother', 'father', 'maidenname', 'middlename', 'dob', 'dod'])" method="post">
   	<div id="errfirstname" style="float:left"><?php echo _("<strong>First Name: </strong>"); ?><input name="firstname" class="search" type="text" /></div>
   	<div id="errlastname"><?php echo _("&nbsp;&nbsp;<strong>Last Name: </strong>"); ?><input name="lastname" class="search" type="text" /></div>
   	<br/>
   	<div id="errmiddlename" style="float:left"><?php echo _("<strong>Middle Name: </strong>"); ?><input name="middlename" class="search" type="text" /></div>
   	<div id="errmaidenname"><?php echo _("&nbsp;&nbsp;<strong>Maiden Name: </strong>"); ?><input name="maidenname" class="search" type="text" /></div>
   	<br/>
   	<div id="errmother" style="float:left"><?php echo _("<strong>Mother: </strong>"); ?><input name="mother" class="search" type="text" /></div>
        <div id="errfather"><?php echo _("&nbsp;&nbsp;<strong>Father: </strong>"); ?><input name="father" class="search" type="text" /></div>
   	<br/>
   	<div id="sextext" style="float:left"><?php echo _("<strong>Sex:</strong>&nbsp;&nbsp;"); ?></div>
   	
   	<div class="mainselection"><select name="sex"><option value="Male"><?php echo _("Male"); ?></option><option value="Female"><?php echo _("Female"); ?></option></select></div>
   	<br/>
   	
   	<div id="errdob">
   	<div style="float:left"><?php echo _("<strong>Born:&nbsp;(mm/dd/yyyy)&nbsp;</strong>"); ?></div>
   	<div class="mainselection-small" style="float:left">
   	<select name="dobmonth">
   	<?php
   		for($i = 0; $i <= 12; $i++)
   		{
   			echo '<option value="' . $i . '">' . $i . '</option>';
   		}
   	?>
   	</select>
   	</div>
   	<div class="mainselection-small" style="float:left">
  	<select name="dobday">
   	<?php
   		for($i = 0; $i <= 31; $i++)
   		{
   			echo '<option value="' . $i . '">' . $i . '</option>';
   		}
   	?>
   	</select>
   	</div>
   	<div class="mainselection-small">
  	<select name="dobyear">
  	<option value="0000">0000</option>
   	<?php
   		$curYear = intval(date("Y"));
   		for($i = 1500; $i <= $curYear; $i++)
   		{
   			echo '<option value="' . $i . '">' . $i . '</option>';
   		}
   	?>
   	</select>
   	</div>
   	</div>
   	<br/>
   	
   	<div id="errdod" style="float:left">
   	<div style="float:left"><?php echo _("<strong>Deceased:&nbsp;(mm/dd/yyyy)&nbsp;</strong>"); ?></div>
   	
   	<div class="mainselection-small" style="float:left">
   	<select name="dodmonth">
   	<?php
   		for($i = 0; $i <= 12; $i++)
   		{
   			echo '<option value="' . $i . '">' . $i . '</option>';
   		}
   	?>
   	</select>
   	</div>
   	
   	<div class="mainselection-small" style="float:left">
  	<select name="dodday">
   	<?php
   		for($i = 0; $i <= 31; $i++)
   		{
   			echo '<option value="' . $i . '">' . $i . '</option>';
   		}
   	?>
   	</select>
   	</div>
   	<div class="mainselection-small" style="float:left">
  	<select name="dodyear">
   	<option value="0000">0000</option>
   	<?php
   		$curYear = intval(date("Y"));
   		for($i = 1500; $i <= $curYear; $i++)
   		{
   			echo '<option value="' . $i . '">' . $i . '</option>';
   		}
   	?>
   	</select>
   	</div>
   	</div>
   	<br/>  
   	<br/>
   	<div style="clear:both"></div>
   	<div id="errdescription"><?php echo _("<strong>Description:</strong>"); ?><textarea name="description" rows="50" cols="100" class="stammbaum"></textarea></div>
	<br/>
	<div id="errcreatedby"><?php echo _("&nbsp;&nbsp;<strong>Created by (your name):</strong>"); ?><input name="createdby" class="search" type="text" /></div>
	<br/>
        <input name="submit" class="button" value="<?php echo _('Submit'); ?>" type="submit" /><br/>
          
        </form>
        </div>
        <p class="post-footer align-right"><span class="date"><?php lastUpdated(__FILE__); ?></span></p>
      </div>
    </div>

    <!-- content-wrap ends here -->
  </div>
</div>
<!-- footer starts here-->
<div id="footer-wrap">
  <div id="footer-columns">
  	<?php
  		printFooter(__FILE__);
  	?>
  </div>
  <!-- footer ends-->
</div>
</body>
</html>
