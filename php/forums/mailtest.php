
<?php
	$to      = 'spencerbartz@gmail.com';
	$subject = 'Test';
	$message = 'hello';
	$headers = 'From: webmaster@example.com' . "\r\n" .
	    'Reply-To: webmaster@example.com' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	if(!mail($to, $subject, $message, $headers))
	{
		echo "Delivery Failed";
	}
	else
	{
		echo "Delivery Success";
	}

?>
