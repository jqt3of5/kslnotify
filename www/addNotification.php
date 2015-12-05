<?php
include 'config.php';
include 'log.php';

$jsonPostData =  file_get_contents('php://input');
$notification = json_decode($jsonPostData, true);

$connection =  mysql_connect($database_url, $username, $password);
if (!$connection)
{
	log("Could not connect to database");
	http_response_code(500);
	header('Content-type: application/json');
	exit("{'error':'Could not connect to the database. Please try again'}");
}
if (!mysql_select_db($database, $connection))
{
	log("Could not select database");
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
if (!$result)
{
	log("Could not execute insert query");
	http_response_code(500);
	header('Content-type: application/json');
	exit("{'error':'Could not query the database. Please try again'}");
}

$emailBody = "You just added a new notification! It will expire after 30 days.  <br><br> Click to <a href='$url/removeNotification.php?guid=$guid'>remove notification</a>"
$mailResult = mail("$notification[email]", "New Notification Added: " . $notification['name'], $emailBody, "From:noreply@jqt3of5.com \r\nContent-Type: text/html\r\n");

if (!$mailResult)
{
	log("Could not send email");
}

mysql_close($connection);
?>