<?php
	/********************* STRING HELPER FUNCTIONS *********************/
	function starts_with($haystack, $needle)
	{
		return $needle === "" || strpos($haystack, $needle) === 0;
	}

	function ends_with($haystack, $needle)
	{
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}

	function println($text, $webmode = FALSE)
	{
		if($webmode)
			echo $text . "<br/>";
		else
			echo $text . PHP_EOL;	
	}
?>