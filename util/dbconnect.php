<?php
	function get_json_config()
	{
		$config_file =  dirname(__FILE__) . DIRECTORY_SEPARATOR . "config.json";
		return json_decode(file_get_contents($config_file), true);
	}

	function get_mysqli_connection($db_name = NULL)
	{
		$json_obj = get_json_config();
		$db_host = $json_obj["app_info"]["db_host"];
		$db_user = $json_obj["app_info"]["db_user"];
		$db_pass = $json_obj["app_info"]["db_pass"];	
		return new mysqli($db_host, $db_user, $db_pass, $db_name);
	}
?>
