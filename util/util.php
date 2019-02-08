<?php
	include "string_util.php";
	include "path_util.php";
	include "news_util.php";
	include "dbconnect.php";

	$default_locale = "en_US";
	date_default_timezone_set("America/Los_Angeles");
	set_language();

	function set_language()
	{
		$locale = isSet($_GET["locale"]) ? $_GET["locale"] : $GLOBALS["default_locale"];
		$locale = $locale . ".UTF-8";

		putenv("LC_ALL=$locale");
		setlocale(LC_ALL, $locale);
		bindtextdomain("messages", "./locale");
		textdomain("messages");
	}

	function print_header($file)
	{
		$path = get_relative_root_path($file);

		println('<h1 id="logo-text"><a href="' . $path . 'index.php">' . _("Spencer") . "<span>" . _("Bartz") . '</span></a></h1>');
		println('<h2 id="slogan">' .  _("Portfolio Website") . '</h2>');
		println('<div id="header-links">');
		println(
			'<p> <a href="' . $path . 'index.php">' . _("Home") .
			'</a> | <a href="' . $path . 'contact' . DIRECTORY_SEPARATOR .
			'contactresume.php">' . _("Contact / Resume") /*. '</a> | <a href="' .
			$path . 'index.php?locale=ja_JP" class="japanese">' . _("Japanese") .
			'</a> | <a href="' . $path . 'index.php" class="english">English</a></p>'*/
		);
		println('</div>');
	}

	function print_page_dec($file)
	{
		$DS = DIRECTORY_SEPARATOR;
		println('<!doctype html>');
		println('<html xmlns="http://www.w3.org/1999/xhtml">');
		println('<head>');
		println('<meta name="Description" content="Information architecture, Web Design, Web Standards." />');
		println('<meta name="Keywords" content="spencer, bartz, portfolio, software development, software engineering, programming, IT" />');
		println('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />');
		println('<meta name="Distribution" content="Global" />');

		$path =  get_relative_root_path($file);

		println('<link rel="stylesheet" href="' . $path . 'css' . $DS . 'BluePigment.css" type="text/css" />');
		println('<link rel="shortcut icon" href="' . $path . 'images' . $DS . 'favicon.ico" />');
		println('<script type="text/javascript" src="' . $path . 'js' . $DS . 'jquery-1.11.2.min.js"></script>');
		println('<script type="text/javascript" src="' . $path . 'js' . $DS . 'util.js"></script>');
	}

	//Print the navigation bar at the top of the page with links to all project categories
	//depending on the location of $file - The file that invoked this function
	function print_nav($file)
	{
		$DS = DIRECTORY_SEPARATOR;
		//Parallel Arrays to hold user names and internal names
		$fileNames = array("index.php", "js" . $DS . "jsindex.php", "php" .  $DS . "phpindex.php", "applications" . $DS . "applicationindex.php", "python" . $DS . "pyindex.php",  "c" . $DS . "cindex.php");
		$dispNames = array(_("Home"), _("JavaScript"), _("PHP"), _("Java"), _("Python"), _("C"));

		$path = get_relative_root_path($file);
		$parts = explode($DS, $file);

		$thisFile = $parts[count($parts) - 1];
		println('<ul>');

		for($i = 0; $i < count($fileNames); $i++)
		{
			//Just get the file name, not the folder it might be in
			$fileName = explode($DS, $fileNames[$i]);
			$fileName = $fileName[count($fileName) - 1];
			$li = "<li>";

			//We want to highlight the menu item associated with the current page
			if(strcmp($thisFile, $fileName) == 0)
				$li = '<li id="current">';

			println($li . '<a href="' . $path  . $fileNames[$i] . '">');
			println($dispNames[$i]);
			println('</a></li>');
		}

		println('</ul> ');
	}

	//Print a form allowing the user to search pages
	function print_search_box($file)
	{
		$path = get_relative_root_path($file);
		println('<div id="close-button" onclick="deactivateSearch();">' . _("Close") . ' [X]</div>');
		println("<h3>" . _("Search spencerbartz.com") . "</h3>");
		println('<form id="searchform" action="' . $path . 'search/searchresult.php" class="searchform" method="post">');
		println("<p>");
		println('<input id="searchquery" name="search_query" class="textbox" type="text" onfocus="activateSearch()" onblur=""/>');
		println('<input name="search" class="button" value="' . _('Search') . '" type="submit" />');
		println("</p>");
		println("</form>");
	}

	//For building links from folder names that are stored in
	//unix-safe formats (i.e. all lowercase with underscores instead of spaces. "my_project" -> "My Project")
	//Receives: String - Text (a folder name)
	//Returns: String - Final text to be displayed as link
	function format_link($link_text)
	{
		//replace underscores with spaces
		$link_text = str_replace("_", " ", $link_text);

		//capitalize the first letter of each word
		$pieces = explode(" ", $link_text);

		for($i = 0; $i < count($pieces); $i++)
			$pieces[$i] = strtoupper($pieces[$i][0]) . substr($pieces[$i], 1);

		return implode(" ", $pieces);
	}

	//Print out a table with links and information about each project
	function print_project_links()
	{
		$dir = ".";
		if (is_dir($dir))
		{
			if ($dh = opendir($dir))
				{
					//print table header
					println('<table>');
					println('<tr>');
					println('<th class="first">Last Updated</th>');
					println('<th>Link</th>');
					println('<th>Description</th>');
					println('</tr>');

					$rowSwitch = 0;
					$ignoreDirs = array(".", "..", "server", "assets", "source");

					//print links to projects
					while(($file = readdir($dh)) !== false)
					{
						$lastUpdated = "12/29/2014";

						if(is_dir($file) && !in_array($file, $ignoreDirs) && !ends_with($file, "_bak"))
						{
							$lastUpdated = date ("m/d/Y", filemtime($file . "/index.php"));
							$desc = fopen($file . "/desc.txt", "r");
							$descText = "";

							if($desc)
							{
								while(($buffer = fgets($desc, 4096)) !== false)
									$descText .= $buffer;

								if (!feof($desc))
									$descText = "No description available";
								fclose($desc);
							}
							else
							{
								$desc = "No description available";
							}

							//Output a row in the table
							if($rowSwitch % 2 == 0)
								echo '<tr class="row-a">';
							else
								echo '<tr class="row-b">';

							$rowSwitch++;

							echo '<td class="first">' . $lastUpdated . '</td>';
							echo '<td><a  href ="' . $file . '/index.php"><strong>' .  format_link($file) . '</strong></a></td>';
							echo '<td>' .  $descText . '</td>';
							echo '</tr>';
						}
					}
					echo '</table>';
					closedir($dh);
				}
		}
	}

	function print_footer($file)
	{
		println('<div class="col3">');
		println('<h2>' . _("Programming Languages") . '</h2>');
		println('<ul>');
		println('<li><a href="http://www.php.net/downloads.php">' . _("Download PHP") . '</a></li>');
		println('<li><a href="https://java.com/getjava">' . _("Download the Java Runtime Environment (JRE)") . '</a></li>');
		println('<li><a href="http://www.oracle.com/technetwork/java/javase/downloads/jdk7-downloads-1880260.html">' . _("Download Java Development Kit (JDK)") . '</a></li>');
		println('<li><a href="http://www.python.org/getit/">' . _("Download Python") . '</a></li>');
		println('</ul>');
		println('</div>');
		println('<div class="col3-center">');
		println('<h2>' . _("Programming Help / Tutorials") . '</h2>');
		println('<ul>');
		println('<li><a href="http://stackoverflow.com/">' . _("Stack Overflow") . '</a></li>');
		println('<li><a href="http://www.w3schools.com/">' . _("W3Schools") . '</a></li>');
		println('<li><a href="https://developer.mozilla.org/en-US/docs/AJAX/Getting_Started">' . _("AJAX Tutorial") . '</a></li>');
		println('<li><a href="http://www.tutorialspoint.com/python/python_cgi_programming.htm">' . _("CGI Programming in Python") . '</a></li>');
		println('<li><a href="http://www.mkyong.com/java">' . _('Java Tutorials at mykyong.com') . '</a></li>');
		println('<li><a href="http://mel.melaxis.com/devblog/2005/08/06/localizing-php-web-sites-using-gettext/">' . _("PHP gettext tutorial") . '</a></li>');
		println('</ul>');
		println('</div>');
		println('<div class="col3">');
		println('<h2>' . _("Software Downloads") . '</h2>');
		println('<ul>');
		println('<li><a href="http://www.mozilla.org/">' . _("Mozilla Firefox") . '</a></li>');
		println('<li><a href="http://httpd.apache.org/download.cgi">' . _("Apache HTTP Server") . '</a></li>');
		println('<li><a href="http://dev.mysql.com/downloads/">' . _("MySQL Server") . '</a></li>');
		println('<li><a href="http://www.textpad.com/">' . _("TextPad") . '</a></li>');
		println('<li><a href="http://www.eclipse.org/downloads/">' . _("Eclipse IDE") . '</a></li>');
		println('<li><a href="http://www.poedit.net/download.php">' . _("Localization Tool PO Edit") . '</a></li>');
		println('</ul>');
		println('</div>');
		println('<!-- footer-columns ends -->');
		println('</div>');
		println('<div id="footer-bottom">');
		println('<p>');
		println('| <a href="http://www.spencerbartz.com">' . _('Home') . '</a> |');
		println('</p>');
		println('<p> &copy; ' . date("Y") . ' <strong>' . _("Spencer Bartz") . '</strong> | ');
		println('CSS layout by: <a href="http://www.styleshout.com/">styleshout</a> |');
		println('<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> |');
		println('</p>');
		println('<p>');
		println('XHTML validated by: <br/><a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>');
		println('</p>');
	}

	function last_updated($filename) {
		if (file_exists($filename))
			println( _("Last updated: ") . date ("F d, Y H:i:s", filemtime($filename)) . " PST");
	}

	function create_thumbnail($imgFile, $tnPath, $thumbWidth = 100)
	{
		$info = pathinfo($imgFile);

		if(strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'jpeg')
		{
			$img = imagecreatefromjpeg($imgFile);
			$width = imagesx($img);
			$height = imagesy($img);

			// calculate thumbnail size
			$new_width = $thumbWidth;
			$new_height = floor( $height * ( $thumbWidth / $width ) );

			// create a new temporary image
			$tmp_img = imagecreatetruecolor( $new_width, $new_height );

			// copy and resize old image into new image
			imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

			// save thumbnail into a file
			imagejpeg($tmp_img, $tnPath . basename($imgFile, ".jpg") . "-tn.jpg");
		}
		else if(strtolower($info['extension']) == 'gif')
		{
			$img = imagecreatefromgif($imgFile);
			$width = imagesx($img);
			$height = imagesy($img);

			// calculate thumbnail size
			$new_width = $thumbWidth;
			$new_height = floor( $height * ( $thumbWidth / $width ) );

			// create a new temporary image
			$tmp_img = imagecreatetruecolor( $new_width, $new_height );

			// copy and resize old image into new image
			imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

			// save thumbnail into a file
			imagegif($tmp_img, $tnPath . basename($imgFile, ".gif") . "-tn.gif");
		}
		else if(strtolower($info['extension']) == 'png')
		{
			$img = imagecreatefrompng($imgFile);
			$width = imagesx($img);
			$height = imagesy($img);

			// calculate thumbnail size
			$new_width = $thumbWidth;
			$new_height = floor( $height * ( $thumbWidth / $width ) );

			// create a new temporary image
			$tmp_img = imagecreatetruecolor( $new_width, $new_height );

			// copy and resize old image into new image
			imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

			// save thumbnail into a file
			imagepng($tmp_img, $tnPath . basename($imgFile, ".png") . "-tn.png");
		}
	}

	function delete_directory($dir)
	{
		if (!file_exists($dir))
			return true;

		if (!is_dir($dir))
			return unlink($dir);

		foreach (scandir($dir) as $item)
		{
			if ($item == '.' || $item == '..')
				continue;

			if (!delete_directory($dir . DIRECTORY_SEPARATOR . $item))
				return false;
		}

		return rmdir($dir);
	}

	// Instead of a captcha, let them do arithmetic!
	function generate_bot_check()
	{
		$operands  = array(rand(1, 10), rand(1, 8), rand(1, 10));
		$challenge = $operands[0] . " * " . $operands[1] . " - " . $operands[2] . " = ";
		$result    = $operands[0] * $operands[1] - $operands[2];
		return array($challenge, $result);
	}

	// Debug Functions
	function alert($str) {
		echo '<script type="text/javascript">alert("' . $str . '");</script>';
	}

	function console_log($str) {
		echo 'console.log("' . $str . '");';
	}
?>
