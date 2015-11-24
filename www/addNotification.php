<?php

include 'config.php';

$jsonPostData =  file_get_contents('php://input');
$notification = json_decode($jsonPostData, true);

$connection =  mysql_connect($database_url, $username, $password);
if (!$connection)
{
	http_response_code(500);
	header('Content-type: application/json');
	exit("{'error':'Could not connect to the database. Please try again'}");
}
if (!mysql_select_db($database, $connection))
{
	http_response_code(500);
	header('Content-type: application/json');
	exit("{'error':'Could not select the database. Please try again'}");
}

$guid = uniqid(); // Not cryptographically secure
$query = sprintf('INSERT INTO notifications VALUES (\'%s\', \'%s\', \'%s\', \'%s\', \'none\')', 
       	 		$guid,	
			mysql_real_escape_string($notification['name']),
			mysql_real_escape_string($notification['email']),
			mysql_real_escape_string($notification['url']));

$result = mysql_query($query, $connection);
//TODO: error handling
if (!$result)
{
	http_response_code(500);
	header('Content-type: application/json');
	exit("{'error':'Could not query the database. Please try again'}");
}

//TODO: send a success email
//with link: <url>/removeNotification.php?guid=$guid

mysql_close($connection);
?>