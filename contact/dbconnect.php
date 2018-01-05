<?php
	function get_mysqli_connection($db_name)
	{
		$files = scandir(".");
		$config_file =  dirname(__FILE__) . DIRECTORY_SEPARATOR . "config.json";
		$json_obj = json_decode(file_get_contents($config_file), true);
		$db_host = $json_obj["app_info"]["db_host"];
		$db_user = $json_obj["app_info"]["db_user"];
		$db_pass = $json_obj["app_info"]["db_pass"];	
		return new mysqli($db_host, $db_user, $db_pass, $db_name);
	}
?>