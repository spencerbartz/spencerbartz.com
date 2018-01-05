<?php
	// Find out the app root path from any file path
	function get_relative_root_path($file_path)
	{
		$DS = DIRECTORY_SEPARATOR;
		$path_parts = explode($DS, dirname($file_path));
		$config_file = dirname(__FILE__) . $DS . "config.json";
		$json_obj = json_decode(file_get_contents($config_file), true);
		$root_path = $json_obj["app_info"]["root_dir"];
		$relative_path = "";
		
		// Need to search for root from end of path, not  beginning.
		$path_parts = array_reverse($path_parts);
		
		foreach($path_parts as $part)
			if(!strcmp($part, $root_path))
				break;
			else	
				$relative_path = ".." . $DS . $relative_path ;
		
		return $relative_path ;
	}
?>