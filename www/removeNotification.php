<?php

include 'config.php';

$guid = $_GET['guid'];

if (!$guid)
{
    exit("Must pass a guid");	
}

$connection =  mysql_connect($database_url, $username, $password);
if (!$connection)
{
	http_response_code(500);
	header('Content-type: application/json');
	exit("Could not connect to the database. Please try again");
}

if (!mysql_select_db($database, $connection))
{
	http_response_code(500);
	header('Content-type: application/json');
	exit("Could not select the database. Please try again");
}

$query = sprintf('DELETE FROM notifications WHERE guid=\'%s\'',
       mysql_real_escape_string($guid));

$result = mysql_query($query, $connection);
if (!$result)
{
	http_response_code(500);
	header('Content-type: text/html');
	exit("Could not query the database. Please try again");
}


mysql_close($connection);

exit ("Notification deleted successfully")
?>