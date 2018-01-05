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
<link rel="stylesheet" href="http://github.com/joshuaclayton/blueprint-css/raw/master/blueprint/screen.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="http://github.com/joshuaclayton/blueprint-css/raw/master/blueprint/print.css" type="text/css" media="print">
<!--[if IE]><link rel="stylesheet" href="http://github.com/joshuaclayton/blueprint-css/raw/master/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
<!--[if lte IE 7]>
	<script type="text/javascript" src="http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js"></script>
<![endif]-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.2/mootools.js"></script>
<script type="text/javascript" src="source/Swiff.Uploader.js"></script>
<script type="text/javascript" src="source/Fx.ProgressBar.js"></script>
<script type="text/javascript" src="source/FancyUpload2.js"></script>

<script src="source/script.js" type="text/javascript"></script>
<link rel="stylesheet" href="source/style.css" type="text/css" />

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
        <div style="float:left"><h1><?php echo _('Edit a {' . $curDB . '} <span class="white">Family Photo</span>'); ?></h1></div>
	<?php
        	echo '<div class="dropdown" style="float:right">';
        	printMenu($_SERVER['PHP_SELF'], $curDB);
        	echo '</div>';
        	
        	if(!isset($_GET["id"]))
        	{
			echo _('<meta HTTP-EQUIV="refresh" content="0; url=error.php?errmsg=' . urlencode("No photo id selected.") . '&redirect=listphotos.php?dbname=' . $curDB . '">');	        	
			die();
		}
		
		include 'dbconnect.php';
		
		$sql = "SELECT * FROM " . $curDB . "_photos where id=" . $_GET["id"];
				
		$res = $mysqli->query($sql);
		
		if($row = $res->fetch_assoc())
		{
			$thumbnail = getThumbFromPath($row["filename"]);
			$datetaken = $row["datetaken"];
			$year = date("Y", strtotime($datetaken));
			$month = date("m", strtotime($datetaken));
			$day = date("d", strtotime($datetaken));
			$description = $row["description"];
			$peopleshown = $row["peopleshown"];
			$editedby = $row["editedby"];
		}
		
		
        	
        ?>
        
	<div class="blurb">
   	<form action="editphotosubmit.php?dbname=<?php echo getCurDB(); ?>" id="addnewform" onsubmit="return checkFormFields('addnewform', 'errormsg', ['peopleshown'])" style="display:inline-block;" method="post">   	
   	<input name="id" id="id" type="hidden" value="<?php echo $_GET["id"]; ?>" />
   	<div id="errdate" style="display:inline-block">
   	<div style="float:left"><?php echo _("<strong>Date taken:&nbsp;(mm/dd/yyyy)&nbsp;</strong>"); ?></div><br/>
   	<div class="mainselection-small" style="float:left;display:inline-block">
   	<select name="month">
   	<?php
   		for($i = 1; $i <= 12; $i++)
   		{
   			if($i == $month)
   				echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
   			else
   				echo '<option value="' . $i . '">' . $i . '</option>';
   		}
   	?>
   	</select>
   	</div>
   	<div class="mainselection-small" style="float:left">
  	<select name="day">
   	<?php
   		for($i = 1; $i <= 31; $i++)
   		{
   			if($i == $day)
   				echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
   			else
   				echo '<option value="' . $i . '">' . $i . '</option>';
   		
   		}
   	?>
   	</select>
   	</div>
   	<div class="mainselection-small" style="float:left">
  	<select name="year">
   	<?php
   		$curYear = intval(date("Y"));
   		for($i = $curYear; $i > 1800; $i--)
   		{
   			if($i == $year)
   				echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
   			else
   				echo '<option value="' . $i . '">' . $i . '</option>';
   		}
   	?>
   	</select>
   	</div>
   	</div>
   	<br/>
   	
   	<div style="clear:right"></div>
   	<div id="errdescription" style="display:inline-block"><?php echo _("<strong>Description:</strong>"); ?><textarea name="description" class="sbphoto"><?php echo $description; ?></textarea></div>
	<br/>
	<br/>
	<div id="errpeopleshown"><?php echo _("&nbsp;&nbsp;<strong>People pictured:</strong>"); ?><input name="peopleshown" class="search" type="text" value="<?php echo $peopleshown; ?>"/></div>
	<br/>
	<div id="errcreatedby"><?php echo _("&nbsp;&nbsp;<strong>Edited by (your name):</strong>"); ?><input name="createdby" class="search" type="text" /></div>
	<br/>
        <input name="submit" class="button" value="<?php echo _('Submit'); ?>" type="submit" /><br/>
        </form>
        
               	<div id="thumbnail" style="display:none;float:right" class="tn"></div>
        </div>
        
        <div id="thumbnail" class="blurb" style="float:left"><img src="<?php echo $thumbnail; ?>" /></div>
        
        <div id="errormsg"></div>
	<div id="curdb" style="display:none"><?php echo $curDB; ?></div>
			

        
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
