<?php

include 'config.php';

$guid = $_GET['guid'];

if (!$guid)
{
    exit("{'error':'Must pass a guid'}");	
}

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

$query = sprintf('DELETE FROM notifications WHERE guid=%s',
       mysql_real_escape_string($guid));

$result = mysql_query($query, $connection);

mysql_close($connection);

?>