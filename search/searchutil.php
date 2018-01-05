<?php
/*
	searchutil.php
	This tool reads all php files on the site, stores path + filename, page title, and rendered text
	in the database so that the search function returns useful results.

*/

	include '../util/util.php';

	/*
	* Extract a string between two other strings. The text in between will be in $matches[1]
	*/	
	function getStringBetween($string, $start, $finish, $flags = "")
	{
		$regex = "/" . $start . "(.*)" . $finish . "/" . $flags;
	
		if(preg_match($regex, $string, $matches))
			return $matches[1];
		else
			return FALSE;
	}
	
	/*
	* Extract the title from the <title></title> tag (if it exists)
	* Receives: $file (string) - file name
	* Returns: (string) - the text inside the <title> tag (if applicable inside gettext _() function)
	*/
	function extractPageTitle($ftext)
	{		
		$between = "";
		
		if($between = getStringBetween($ftext, "<title>", "<\/title>", "s"))
		{
			//handle gettext string, if present
			if($between2 = getStringBetween($between, "_\(\"", "\"\)", "s"))
				return trim($between2);
			
			return trim($between);
		}
		else
		{
			return "Untitled";
		}		
		
	}
	
	function myCurl($url, $space)
	{
		println($space . "Attempting CURL on " . $url);
		
		//Obtain our curl handle for request
		$ch = $GLOBALS['curl_handle'];
		
		// set target URL,  other options, then fire request
		curl_setopt($ch, CURLOPT_URL, $url);
		$output = curl_exec($ch);

		// Check for errors and display the error message
		if($errno = curl_errno($ch)) 
		{
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
			die();
		}
		else
		{
			return $output;
		}
	}
	
	function resolvePath($pageUrl, $linkUrl)
	{
		$pageUrlParts = parse_url($pageUrl);
		$linkUrlParts = parse_url($linkUrl);
		$resolvedUrl = Array();	
		
		//break up links into arrays
		//remove the page name from the path of the current page (the one we are searching for links)
		$origPath = explode("/", substr($pageUrlParts['path'], 1));
		array_pop($origPath);
		
		$linkPath = explode("/", substr($linkUrlParts['path'], 1));
		$page = array_pop($linkPath);
		
		//println($page);
		//print_r($origPath);
		//print_r($linkPath);
		
		//copy the path parts of the current page to start out our resolved path
		for($i = 0; $i < count($origPath); $i++)
		{		
			$resolvedUrl[] = $origPath[$i];
		}
		
		//build the resolved path from the aforementioned copied parts, and the
		//link path from the link we found on the current page. If we run into a 
		// ".." then we should pop the previous directory. If we reach NULL then
		//we have tried to access a directory above the root directory and the link is bogus
		for($i = 0; $i < count($linkPath); $i++)
		{
			if(!strcmp($linkPath[$i], ".."))
			{
				$popped = array_pop($resolvedUrl);
				
				if($popped == NULL)
				{
					return NULL;					
				}
			}
			else
			{
				$resolvedUrl[] = $linkPath[$i];
			}
		}
		
		$resolvedUrl[] = $page;
		//print_r($resolvedUrl);
		
		if(!isset($linkUrlParts['scheme']))
		{
			$linkUrlParts['scheme'] = $GLOBALS['scheme'];
		}
		
		return $linkUrlParts['scheme'] . "://" . $linkUrlParts['host'] . "/" . implode("/", $resolvedUrl);
	}
	
	function createFullUrl($urlParts)
	{
		$fullUrl = "";
		
		if(!isset($urlParts['scheme']))
			$fullUrl .= $GLOBALS['scheme'] . "://";
			
		if(!isset($urlParts['host']))
			$fullUrl .= $GLOBALS['host'];
		
		if(isset($urlParts['path']))
			$fullUrl .= starts_with($urlParts['path'], "/") ? $urlParts['path'] : "/" . $urlParts['path'];
		
		if(isset($urlParts['query']))
			$fullUrl .= "?" . $urlParts['query'];
			
		if(isset($urlParts['fragment']))
			$fullUrl .= $urlParts['fragment'];
			
		return $fullUrl;
	}
	
	function crawl($url, $space)
	{		
		$urlParts = parse_url($url);
		$links = array();
		$badlinks = array();
		
		//Get the HTML from the url
		$output = myCurl($url, $space);
		
		$title = extractPageTitle($output);
		println($space . "Title: " . $title);

		//Find all anchor tags on this page
		if(preg_match_all("/<a [^<>]*>/", $output, $matches))
		{			
			for($i = 0; $i < count($matches[0]); $i++)
			{
				//"(.*?(\s)*?)*?"
				//extract the href="path/to/page.php" part from each anchor tag
				if(preg_match_all("/href\s*=\s*\"(.*?)\"/", $matches[0][$i], $hrefMatches))
				{
					//obtain the value of the href attribute of the <a> tag.
					$href = $hrefMatches[1][0];
					
					//Process all the URLs we got from the href="url.php" parts of the <a> tags
					
					//Skip if href of link is empty (tsk tsk)
					if(strlen($href) <= 0)
						continue;
					
					$hrefParts = parse_url($href);
					
					//print_r($hrefParts);
					
					//Skip if there is no path to any page in this url
					if(!isset($hrefParts['path']))
						continue;

					//Check that we are only following links we want
					if(!(ends_with($hrefParts['path'], ".php") || ends_with($hrefParts['path'], ".html")))
						continue;
						
					//Relative internal Link with no host specified (this should even handle links with ../ in them!)
					if(!isset($hrefParts['host']))
					{
						$fullUrl = createFullUrl($hrefParts);
						
						//println("FULL URL: " . $fullUrl);
						
						if(!in_array($fullUrl, $GLOBALS['links']))
						{
							if(strpos($fullUrl, "..") >= 0)
							{
								$fullUrl = resolvePath($url, $fullUrl);
								//println("Resolved Link " . $fullUrl . ".");
								
								if($fullUrl === NULL)
								{
									println($space . "Error: Bad Link: " . $href);
									$badlinks[] = $href;
								}
								else if(!in_array($fullUrl, $GLOBALS['links']))
								{										
									$GLOBALS['links'][] = $fullUrl;
									$links[] = $fullUrl;
								}
								else 
								{
									//println($space . "Resolved Link Duplicate found: " . $fullUrl . ". ignoring");
								}
							}
						}
						else
						{
							//println($space . "Duplicate found: " . $fullUrl . ". ignoring");
						}
					}
					else
					{
						//Host is set, determine if it is an external link or not
						if(strcmp($hrefParts['host'], $GLOBALS['host']))
						{
							//println($space . "External Link Found: " . $href);
						}
						else
						{
							//rare case, a fully qualified internal link
							$fullUrl = createFullUrl($hrefParts);
							
							if(!in_array($fullUrl, $GLOBALS['links']))
							{
								$GLOBALS['links'][] = $fullUrl;
								$links[] = $fullUrl;
							}
							else
							{
								//println($space . "Duplicate found: " . $fullUrl . ". ignoring");
							}						
						}	
					}
				}
				else
				{
					println($space . "ERROR: Incorrect href link format: " . $matches[0][$i]);
					$badlinks[] = $matches[0][$i];
				}
			}
		}
		else
		{
			println($space . "No links");
		}
		
		//TODO: Get rid of the whole head tag and any scripts / css that might be in it
		//$output = preg_replace("", "", $output);
		
		//Get rid of html comments
		$output = preg_replace("/<!--.*?-->/s", "", $output);
		
		//Get rid of all html tags
		$output = preg_replace("/<[^ ](\/?|\!)?.*?>/", "", $output);
		
		//try to get rid of empty lines
		$output = preg_replace("/\s+\n/", " ", $output);
		$output = trim($output);
		
		
		println($space . "***PAGE TEXT: " . $output);
		
		/*
		if(strpos(strtolower($output), strtolower($GLOBALS['keyword'])) != FALSE)
			println($space . "FOUND WORD [" . $GLOBALS['keyword'] . "] !\n***************************************************");
		else
			println($space . "\nWORD [" . $GLOBALS['keyword'] . "] NOT FOUND\n***************************************************");
		
		*/
		println("");
		
		//round up all the bad links
		$badlinks = "Bad Links" . implode(";", $badlinks);
		
		$mysqli = get_mysqli_connection("searchdb");
		$sql = "insert into pages values(NULL, '" . $url . "', '" . $mysqli->real_escape_string($title) . "', '" . $mysqli->real_escape_string($output) . "', '" . $badlinks . "', NOW())";
		
        if(!$mysqli->query($sql)) 
        {
		    println("Insertion Failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		else
		{
			println("Successfully logged ". $url. "\n");
		}
		
		for($i = 0; $i < count($links); $i++)
		{
			if(count($links) > 0)
				crawl($links[$i], $space . "   ");
		}
	}
        
        function clearDatabase()
        {
			$mysqli = get_mysqli_connection("searchdb");
            
            $sql = "truncate table pages";
            if(!$mysqli->query($sql)) 
            {
                println("Truncation Failed: (" . $mysqli->errno . ") " . $mysqli->error);
            }
            else
            {
                println("Successfully truncated table: pages ". $url. "\n");
            }
        }


	/*----------------------------- MAIN -------------------------------------*/

        clearDatabase();
        
	//$startUrl = "http://localhost/test/index.php";
	//echo parse_url($startUrl
	$keyword = "test";
	$startUrl = "http://www.spencerbartz.com/index.php";
	
	if(count($argv) == 3)
	{
		$startUrl = $argv[1];
		$keyword = $argv[2];
	}

	$GLOBALS['keyword'] = $keyword;

	$startUrlParts = parse_url($startUrl);

	if(isset($startUrlParts['scheme']))
		$GLOBALS['scheme'] = $startUrlParts['scheme'];
	else
	{
		$GLOBALS['scheme'] = "http";
		$startUrl = "http://" . $startUrl;
	}

	if(isset($startUrlParts['host']))
		$GLOBALS['host'] = $startUrlParts['host'];
	else
		$GLOBALS['host'] = "localhost";
		
	$GLOBALS['links'] = array();
	$GLOBALS['links'][] = $startUrl;
	$GLOBALS['startUrl'] = $startUrl;

	// create a new cURL resource
	$ch = curl_init();
	$GLOBALS['curl_handle'] = $ch;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	crawl($startUrl, "");
	
	println("");
	print_r($GLOBALS['links']);
	
	curl_close($ch);
?>